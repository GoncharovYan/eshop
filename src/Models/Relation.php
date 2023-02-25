<?php

namespace Models;

use Services\DatabaseServices;

abstract class Relation
{
	protected static $db = null;

	public function __construct()
	{
		self::setConnect();
	}

	private static function setConnect()
	{
		if (self::$db === null) {
			try {
				self::$db = DatabaseServices::getPdoConnection();
			} catch (\Exception $e) {
				throw new \Exception('Error creating a database connection ');
			}
		}
	}

	public function save()
	{
		$class = new \ReflectionClass($this);

		$tableName = strtolower($class->getShortName());

		$propsToImplode = [];
		if ($this->id) {
			foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
				$propertyName = $property->getName();
				$propsToImplode[] = '`' . $propertyName . '` = "' . $this->{$propertyName} . '"';
			}

			$setClause = implode(',', $propsToImplode);

			$sqlQuery = 'UPDATE `' . $tableName . '` SET ' . $setClause . ' WHERE id = ' . $this->id;

			self::$db->exec($sqlQuery);

			$result = $this;
		} else {
			foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
				$propertyName = $property->getName();
				if ($propertyName !== 'date_created' && $propertyName !== 'date_updated') {
					$propertyToImplode[] = $propertyName;
					$namesToImplode[] = '"' . $this->{$propertyName} . '"';
				}
			}

			array_shift($propertyToImplode);
			array_shift($namesToImplode);

			$setClause = implode(',', $propertyToImplode);
			$setNames = implode(',', $namesToImplode);

			$sqlQuery = 'INSERT INTO `' . $tableName . '`(' . $setClause . ') VALUES (' . $setNames . ')';

			self::$db->exec($sqlQuery);

			$query = 'SELECT * FROM ' . $tableName . ' ORDER BY ID DESC LIMIT 1';
			$raw = self::$db->query($query)->fetch(\PDO::FETCH_ASSOC);
			if ($raw !== false) {
				$result = self::morph($raw);
			}
		}

		//$result = self::$db->exec($sqlQuery);

		return $result;
	}

	public function delete()
	{
		$class = new \ReflectionClass($this);

		$tableName = strtolower($class->getShortName());

		if ($this->id) {
			$sqlQuery = 'DELETE FROM `' . $tableName . '`' . 'WHERE id=' . $this->id;
		} else {
			throw new \Exception('Не указан id для удаления');
		}

		self::$db->exec($sqlQuery);
	}

	public static function morph(array|bool $object)
	{
		$class = new \ReflectionClass(get_called_class());

		$entity = $class->newInstance();

		foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
			if (isset($object[strtoupper($prop->getName())])) {
				$prop->setValue($entity, $object[strtoupper($prop->getName())]);
			}
		}

		return $entity;
	}

	public static function find($options = [])
	{

		$result = [];

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$whereClause = "";
		$orderClause = "";
		$groupByClause = "";
		$limit = "";

		self::setConnect();

		if (is_array($options)) {
			foreach ($options as $key => $value) {
				if ($key === 'conditions') {
					$whereClause = " WHERE " . trim(self::$db->quote($value), '\'"');
				}
				if ($key === 'order') {
					$orderClause = " ORDER BY " . trim(self::$db->quote($value), '\'"');
				}
				if ($key === 'limit') {
					$limit = " LIMIT " . trim(self::$db->quote($value), '\'"');
				}
			}
			$optionsSql = $whereClause . $orderClause . $limit;
		} else {
			throw new \Exception('Неверный тип входного аргумента');
		}

		$query = "SELECT * FROM " . $tableName . $optionsSql;

		$raw = self::$db->query($query);
		foreach ($raw as $rawRow) {

			$result[] = self::morph($rawRow);
		}

		return $result;
	}

	/**
	 * @param $options
	 * Принимает массив имён, по которым идёт условие where. Например ['ID' => 1, '%NAME' => 'Телефоны', 'ID => [1,2]
	 * @param $logic_filters
	 * логические операторы между where конструкциями. Например ['OR'] или ['OR', 'AND'].
	 * Их число должно быть меньше на 1 количества options
	 * @param $order_filters
	 * конструкция order. В нем находится список имён OrderList, по которым идёт сортировка
	 * и значение OrderDesc, сортировать ли возр/убыв. Например ['OrderList' => ['ID'], 'OrderDesc' => 'Desc']
	 * @param $limit
	 * @return array
	 * @throws \Exception
	 */
	public static function findd($options = [], $logic_filters = [], $order_filters = [], $limit = 100)
	{

		$result = [];

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());
		$whereClause = "";
		$orderClause = "";
		if(!empty($options)) {
			$whereClause = " WHERE ";
			if(is_array($options)) {
				foreach($options as $key => $value) {

					if($key[0] === "%") {
						$key = substr($key, 1);
						if($class->hasProperty(strtolower($key))) {
							$whereClause = $whereClause . ' ' . $key . " LIKE ? ";
						}
					}
					else {
						if($class->hasProperty(strtolower($key))) {
							if(is_array($value)) {
								$whereClause = $whereClause . ' ' . $key . ' IN (' . implode(',', $value) . ')';
							}
							else {
								$whereClause = $whereClause . ' ' . $key . ' = ? ';
							}
						}

					}
					$whereClause = $whereClause . array_shift($logic_filters);
				}

			}
			else {
				throw new \Exception('Неверный тип входного аргумента');
			}
		}

		if(!empty($order_filters)){
			if(is_array($order_filters)){
				$orderClause = " ORDER BY ";

				if(array_key_exists('OrderList', $order_filters))
					$orderClause = $orderClause . implode(',', $order_filters['OrderList']);
				if(array_key_exists('OrderDesc', $order_filters))
					$orderClause = $orderClause . ' ' .$order_filters['OrderDesc'];

			} else {
				throw new \Exception('Неверный тип входного аргумента');
			}
		}
		$limit = ' LIMIT ' . (int)$limit;
		$optionsSql = $whereClause . $orderClause . $limit;
		$query = "SELECT * FROM " . $tableName . $optionsSql;
		var_dump($query);die;

		self::setConnect();

		$sth = self::$db->prepare($query);

		$bindCount = 1;
		foreach ($options as $key => $value) {

			if($key[0] === "%") {
				$key = substr($key, 1);
				if($class->hasProperty(strtolower($key))){
					$sth->bindValue($bindCount, '%' . $value . '%' );
				}
			} else {
				if($class->hasProperty(strtolower($key))) {
					if(!is_array($value)) {
						$sth->bindValue($bindCount, $value);
					} else {
						$bindCount -= 1;
					}
				}
			}
			$bindCount += 1;
		}

		$sth->execute();


		$raw = $sth->fetchAll();
		foreach ($raw as $rawRow) {
			$result[] = self::morph($rawRow);
		}

		return $result;
	}

	public static function findById($id)
	{

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$query = "SELECT * FROM " . $tableName . " WHERE ID = ?";
		self::setConnect();
		$sth = self::$db->prepare($query);
		$sth->bindParam(1, $id);
		$sth->execute();
		$raw = $sth->fetch();
		if ($raw !== false) {
			return self::morph($raw);
		}
	}

	/**
	 * @param array $ids
	 *
	 * Возвращает массив объектов по массиву id
	 */
	public static function findByIdArr(array $ids)
	{
		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$id = implode(',', $ids);

		$query = "SELECT * FROM " . $tableName . " WHERE ID IN (" . $id . ")";

		self::setConnect();

		$raw = self::$db->query($query);
		foreach ($raw as $rawRow) {
			$result[] = self::morph($rawRow);
		}

		return $result;
	}

	public static function findAll()
	{

		$result = [];

		$class = new \ReflectionClass(static::class);

		$tableName = strtolower($class->getShortName());

		$query = "SELECT * FROM " . $tableName;

		self::setConnect();

		$raw = self::$db->query($query);
		foreach ($raw as $rawRow) {
			$result[] = self::morph($rawRow);
		}

		return $result;
	}

	public static function executeQuery(string $query)
	{
		$result = [];
		self::setConnect();
		$raw = self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($raw as $key => $rawRow) {
			$result[] = self::morph($rawRow);
		}
		return $result;
	}

	public function hasMany($classRelated)
	{
		return $this->relateManyToMany($classRelated);
	}

	public function belongsToMany($classRelated)
	{
		return $this->relateManyToMany($classRelated);
	}

	private function relateManyToMany($classRelated)
	{
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		foreach ($class1->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$class1Id = $property->getName();
			break;
		}
		foreach ($class2->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$class2Id = $property->getName();
			break;
		}

		$tableName = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		try {
			$MiddleTable = $tableName . "_" . $RelatedtableName;

			$query = "SELECT $tableName.*, $MiddleTable.* FROM " . $tableName . " INNER JOIN " . $MiddleTable . " ON " .
				$tableName . "." . $class1Id . "=" . $MiddleTable .
				"." . strtoupper($tableName) . "_ID" . " INNER JOIN " .
				$RelatedtableName . " ON " . $MiddleTable . "." . strtoupper($RelatedtableName) . "_ID=" .
				$RelatedtableName . "." . $class2Id;

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$MiddleTable = $RelatedtableName . "_" . $tableName;

			$query = "SELECT $tableName.*, $MiddleTable.* FROM " . $tableName . " INNER JOIN " . $MiddleTable . " ON " .
				$tableName . "." . $class1Id . "=" . $MiddleTable .
				"." . strtoupper($tableName) . "_ID" . " INNER JOIN " .
				$RelatedtableName . " ON " . $MiddleTable . "." . strtoupper($RelatedtableName) . "_ID=" .
				$RelatedtableName . "." . $class2Id;
		}

		return new Pivot($query);
	}

	public function deleteRelation($classRelated)
	{
		$this->deleteManyToMany($classRelated);
	}

	private function deleteManyToMany($classRelated)
	{
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		$tableName = strtolower($class1->getShortName());
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

	public function addRelation($classRelated)
	{
		$this->addManyToMany($classRelated);
	}

	private function addManyToMany($classRelated)
	{
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelated);

		$tableName = strtolower($class1->getShortName());
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

	public function addRelationArr(array $classRelatedArr, $extraRelationDataType = null, array $extraRelationData = [])
	{
		$this->addManyToManyArr($classRelatedArr, $extraRelationDataType, $extraRelationData);
	}

	/**
	 * @param array $classRelatedArr
	 * @param $extraRelationDataType
	 * @param array $extraRelationData
	 *
	 * Принимает:
	 *    массив объектов, связи к которым нужно образовать;
	 *    название дополнительного столбца (например, 'ITEM_COUNT')
	 *    массив дополнительных данных для внесения в таблицу связей, [id связаного объекта] => [значение в дополнительном столбце];
	 */
	private function addManyToManyArr(array $classRelatedArr, $extraRelationDataType, array $extraRelationData)
	{
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelatedArr[0]);

		$tableName = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		foreach ($classRelatedArr as $classRelated) {
			if (isset($extraRelationDataType)) {
				$values[] = "(" . $this->id . ", " . $classRelated->id . ", " . $extraRelationData[$classRelated->id] . ")";
			} else {
				$values[] = "(" . $this->id . ", " . $classRelated->id . ")";
			}
		}

		if (isset($extraRelationDataType)) {
			$extraRelationDataType = ", " . $extraRelationDataType;
		} else {
			$extraRelationDataType = "";
		}

		try {
			$query = "INSERT INTO " . $tableName . "_" . $RelatedtableName .
				" (" . strtoupper($tableName) . "_ID, " . strtoupper($RelatedtableName) . "_ID" . $extraRelationDataType . ")" .
				"VALUES " . implode(',', $values);

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$query = "INSERT INTO " . $RelatedtableName . "_" . $tableName .
				" (" . strtoupper($tableName) . "_ID, " . strtoupper($RelatedtableName) . "_ID" . $extraRelationDataType . ")" .
				"VALUES " . implode(',', $values);

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		}
	}

	public function updateRelationArr($classRelatedArr, $relationDataType, array $relationData)
	{
		$this->updateManyToManyArr($classRelatedArr, $relationDataType, $relationData);
	}

	/**
	 * @param $classRelatedArr
	 * @param $relationDataType
	 * @param array $relationData
	 *
	 * Принимает:
	 *    класс, связи к которому нужно изменить;
	 *    название дополнительного столбца (например, 'ITEM_COUNT')
	 *    массив дополнительных данных для изменения таблицы связей, [id связаного объекта] => [значение в дополнительном столбце];
	 */
	private function updateManyToManyArr($classRelatedArr, $relationDataType, array $relationData)
	{
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelatedArr);

		$tableName = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		var_dump($relationData);

		foreach ($relationData as $key => $value) {
			$values[] = "(" . $this->id . ", " . $key . ", " . $value . ")";
		}

		try {
			$query = "INSERT INTO " . $tableName . "_" . $RelatedtableName .
				" (" . strtoupper($tableName) . "_ID, " . strtoupper($RelatedtableName) . "_ID, " . $relationDataType . ")" .
				"VALUES " . implode(',', $values) .
				"ON DUPLICATE KEY UPDATE " . $relationDataType . "= VALUES(" . $relationDataType . ")";

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$query = "INSERT INTO " . $RelatedtableName . "_" . $tableName .
				" (" . strtoupper($tableName) . "_ID, " . strtoupper($RelatedtableName) . "_ID, " . $relationDataType . ")" .
				"VALUES " . implode(',', $values) .
				"ON DUPLICATE KEY UPDATE " . $relationDataType . "= VALUES(" . $relationDataType . ")";

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		}
	}

	public function deleteRelationArr(array $classRelatedArr)
	{
		$this->deleteManyToManyArr($classRelatedArr);
	}

	/**
	 * @param array $classRelatedArr
	 *
	 * Принимает массив объектов, связи к которым нужно удалить
	 */
	private function deleteManyToManyArr(array $classRelatedArr)
	{
		$class1 = new \ReflectionClass(static::class);
		$class2 = new \ReflectionClass($classRelatedArr[0]);

		$tableName = strtolower($class1->getShortName());
		$RelatedtableName = strtolower($class2->getShortName());

		foreach ($classRelatedArr as $classRelated) {
			$classRelatedId[] = $classRelated->id;
		}

		try {
			$query = "DELETE FROM " . $tableName . "_" . $RelatedtableName . " WHERE " .
				strtoupper($tableName) . "_ID" . "=" . $this->id . " AND " .
				strtoupper($RelatedtableName) . "_ID IN (" . implode(',', $classRelatedId) . ")";

			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$query = "DELETE FROM " . $RelatedtableName . "_" . $tableName . " WHERE " .
				strtoupper($tableName) . "_ID" . "=" . $this->id . " AND " .
				strtoupper($RelatedtableName) . "_ID IN (" . implode(',', $classRelatedId) . ")";
			self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		}
	}
}