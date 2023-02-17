<?php

namespace Models;
use Services\DatabaseServices;

abstract class Relation {
	protected static $db = null;

	public function __construct() {
		self::setConnect();
	}

	private static function setConnect() {
		if(self::$db === null) {
			try {
				self::$db = DatabaseServices::getPdoConnection();
			} catch(\Exception $e) {
				throw new \Exception('Error creating a database connection ');
			}
		}
	}

	public function save() {
		$class = new \ReflectionClass($this);

		$tableName = strtolower($class->getShortName());

		$propsToImplode = [];
		if($this->id) {
			foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
				$propertyName        = $property->getName();
				$propsToImplode[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
			}

			$setClause = implode(',',$propsToImplode);

			$sqlQuery = 'UPDATE `' . $tableName . '` SET ' . $setClause . ' WHERE id = ' . $this->id;

			self::$db->exec($sqlQuery);

			$result = $this->id;
		} else {
			foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
				$propertyName = $property->getName();
				$propertyToImplode[] = $propertyName;
				$namesToImplode[]    = '"' . $this->{$propertyName} . '"';
			}

			array_shift($propertyToImplode);
			array_shift($namesToImplode);

			$setClause = implode(',', $propertyToImplode);
			$setNames = implode(',', $namesToImplode);

			$sqlQuery = 'INSERT INTO `' . $tableName . '`(' . $setClause . ') VALUES (' . $setNames . ')';

			self::$db->exec($sqlQuery);

			$query = 'SELECT * FROM ' . $tableName . ' ORDER BY ID DESC LIMIT 1';
			$raw = self::$db->query($query)->fetch(\PDO::FETCH_ASSOC);
			if ($raw !== false)
			{
				$result = self::morph($raw);
			}
		}

		//$result = self::$db->exec($sqlQuery);

		return $result;
	}

	public function delete(){
		$class = new \ReflectionClass($this);

		$tableName = strtolower($class->getShortName());

		if($this->id){
			$sqlQuery = 'DELETE FROM `' . $tableName . '`'. 'WHERE id=' . $this->id;
		}
		else {
			throw new \Exception('Не указан id для удаления');
		}

		self::$db->exec($sqlQuery);
	}

	public static function morph(array|bool $object) {
		$class = new \ReflectionClass(get_called_class());

		$entity = $class->newInstance();

		foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
			if(isset($object[strtoupper($prop->getName())])) {
				$prop->setValue($entity, $object[strtoupper($prop->getName())]);
			}
		}

		return $entity;
	}

	public static function find($options = []) {

		$result = [];

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$whereClause   = "";
		$orderClause   = "";
		$groupByClause = "";
		$limit         = "";

		if(is_array($options)) {
			foreach($options as $key => $value) {
				if($key === 'conditions') {
					$whereClause = " WHERE " . $value;
				}
				if($key === 'order') {
					$orderClause = " ORDER BY " . $value;
				}
				if($key === 'limit') {
					$limit = " LIMIT " . $value;
				}
			}
			$optionsSql = $whereClause . $orderClause . $limit;
		}
		else {
			throw new \Exception('Неверный тип входного аргумента');
		}

		$query = "SELECT * FROM " . $tableName . $optionsSql;

		self::setConnect();

		$raw = self::$db->query($query);
		foreach($raw as $rawRow) {

			$result[] = self::morph($rawRow);
		}

		return $result;
	}

	public static function findById($id){

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$query = "SELECT * FROM " . $tableName . " WHERE ID=" . $id;

		self::setConnect();

		$raw = self::$db->query($query)->fetch(\PDO::FETCH_ASSOC);
		if ($raw !== false)
		{
			return self::morph($raw);
		}
	}

	public static function findAll() {

		$result = [];

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$query = "SELECT * FROM " . $tableName;

		self::setConnect();

		$raw = self::$db->query($query);
		foreach($raw as $rawRow) {
			$result[] = self::morph($rawRow);
		}

		return $result;
	}

	public static function executeQuery(string $query){
		$result = [];
		self::setConnect();
		$raw = self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		foreach($raw as $key => $rawRow) {
			$result[] = self::morph($rawRow);
		}
		return $result;
	}

	public function hasMany($classRelated) {
		return $this->relateManyToMany($classRelated);
	}
	public function belongsToMany($classRelated){
		return $this->relateManyToMany($classRelated);
	}

	private function relateManyToMany($classRelated){
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		foreach($class1->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$class1Id = $property->getName();
			break;
		}
		foreach($class2->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$class2Id = $property->getName();
			break;
		}

		$tableName        = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		try {
			$MiddleTable = $tableName . "_" . $RelatedtableName;

			$query = "SELECT $tableName.*, $MiddleTable.* FROM " . $tableName . " INNER JOIN " . $MiddleTable . " ON " .
				$tableName . ".". $class1Id . "=" . $MiddleTable .
				"." . strtoupper($tableName) . "_ID" . " INNER JOIN " .
				$RelatedtableName . " ON " . $MiddleTable . "." . strtoupper($RelatedtableName) . "_ID=" .
				$RelatedtableName . "." .$class2Id;

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$MiddleTable = $RelatedtableName . "_" . $tableName;

			$query = "SELECT $tableName.*, $MiddleTable.* FROM " . $tableName . " INNER JOIN " . $MiddleTable . " ON " .
				$tableName . ".". $class1Id . "=" . $MiddleTable .
				"." . strtoupper($tableName) . "_ID" . " INNER JOIN " .
				$RelatedtableName . " ON " . $MiddleTable . "." . strtoupper($RelatedtableName) . "_ID=" .
				$RelatedtableName . "." .$class2Id;
		}

		return new Pivot($query);
	}

	public function deleteRelation($classRelated) {
		$this->deleteManyToMany($classRelated);
	}

	private function deleteManyToMany($classRelated){
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		$tableName        = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		try {
			$query = "DELETE FROM " . $tableName . "_" . $RelatedtableName . " WHERE " .
				strtoupper($tableName) . "_ID" . "=" . $this->id . " AND " .
				strtoupper($RelatedtableName) . "_ID" . "=" . $classRelated->id;

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$query = "DELETE FROM " . $RelatedtableName . "_" . $tableName . " WHERE " .
				strtoupper($tableName) . "_ID" . "=" . $this->id . " AND " .
				strtoupper($RelatedtableName) . "_ID" . "=" . $classRelated->id;
			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		}
	}

	public function addRelation($classRelated) {
		$this->addManyToMany($classRelated);
	}

	private function addManyToMany($classRelated){
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		$tableName        = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		try {
			$query = "INSERT INTO " . $tableName . "_" . $RelatedtableName .
				" (" . strtoupper($tableName) . "_ID, " . strtoupper($RelatedtableName) . "_ID) " .
				"VALUE (" . $this->id . ", " . $classRelated->id . ")";

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$query = "INSERT INTO " . $RelatedtableName . "_" . $tableName .
				" (" . strtoupper($tableName) . "_ID, " . strtoupper($RelatedtableName) . "_ID) " .
				"VALUE (" . $this->id . ", " . $classRelated->id . ")";
			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		}
	}
}