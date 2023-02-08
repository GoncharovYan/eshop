<?php

namespace Dto;

abstract class Relation {
	protected static $db = null;

	public function __construct() {
		self::setConnect();
	}

	private static function setConnect() {
		if(self::$db === null) {
			try {
				self::$db = new \PDO('mysql:host=localhost;dbname=eshop', 'root', '');
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
		}
		else {
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
		}

		$result = self::$db->exec($sqlQuery);

		if (self::$db->errorCode()) {
			throw new \Exception(self::$db->errorInfo()[2]);
		}

		return $result;
	}

	public static function morph(array $object) {

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

		$query         = "";
		$whereClause   = "";
		$orderClause   = "";
		$groupByClause = "";
		$limit         = "";
		$optionsSql    = "";

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
		return self::morph($raw);
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
		$raw = self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);;
		foreach($raw as $key => $rawRow) {
			// $result[$key] = $rawRow;
			$result[] = self::morph($rawRow);
		}
		return $result;
	}

	public function hasToMany($classRelated) {

		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		$tableName        = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		$query = "SELECT * FROM " . $tableName . " INNER JOIN " . $tableName . "_" . $RelatedtableName . " ON " .
			$tableName . ".ID=" . strtoupper($tableName) . "_ID" . " INNER JOIN " .
			$RelatedtableName . " ON " . strtoupper($RelatedtableName) . "_ID=" . $RelatedtableName . ".ID";

		self::setConnect();
		$raw = self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);;
		foreach($raw as $key => $rawRow) {
			$result[$key] = $rawRow;
		}
		echo '<pre>';
		echo '</pre>';
		return $result;
	}
}