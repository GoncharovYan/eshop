<?php

namespace Models;

use Services\DatabaseServices;

class Pivot {
	private $sqlQuery;

	private static $db;
	public function __construct(string $sqlInnerJoinQuery) {
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
		$raw = self::$db->query($this->sqlQuery);
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

		$query = $this->sqlQuery . $optionsSql;
		var_dump($query);

		self::setConnect();

		$raw = self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		foreach($raw as $rawRow) {

			$result[] = $rawRow;
		}

		return $result;
	}

//	public function findById(){
//
//	}

}