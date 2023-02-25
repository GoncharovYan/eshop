<?php

namespace Models;

use Services\DatabaseServices;

class Pivot {
	private $sqlQuery;

	private static $db;
	public function __construct(string $sqlInnerJoinQuery) {
		self::setConnect();
		$this->sqlQuery = $sqlInnerJoinQuery;
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

	public function findAll(): array {
		self::setConnect();
		$raw = self::$db->query($this->sqlQuery)->fetchAll(\PDO::FETCH_ASSOC);
		foreach($raw as $rawRow) {
			$result[] = $rawRow;
		}
		return $result;
	}

	public function find(array $options){
		$result = [];

		$whereClause   = "";
		$orderClause   = "";
		$groupByClause = "";
		$limit         = "";

		self::setConnect();

		if(is_array($options)) {
			foreach($options as $key => $value) {
				if($key === 'conditions') {
					$whereClause = " WHERE " . trim(self::$db->quote($value), '\'"');
				}
				if($key === 'order') {
					$orderClause = " ORDER BY " . trim(self::$db->quote($value), '\'"');
				}
				if($key === 'limit') {
					$limit = " LIMIT " . trim(self::$db->quote($value), '\'"');
				}
			}
			$optionsSql = $whereClause . $orderClause . $limit;
		}
		else {
			throw new \Exception('Неверный тип входного аргумента');
		}

		$query = $this->sqlQuery . $optionsSql;

		$raw = self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		foreach($raw as $key => $rawRow) {
			$rawRow = array_change_key_case($rawRow);
			$result[] = $rawRow;
		}

		return $result;
	}
}