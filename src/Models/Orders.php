<?php

namespace Models;

class Orders extends Relation {
	public $id;

	public $customer_name;

	public $c_phone;

	public $c_email;

	public $comment;

	public $status;

	public $price;

	public $address;

	public $date_created;

	public function __construct() {
		parent::__construct();
	}

	public static function createNewOrder() {
		$query =
			"INSERT INTO orders (CUSTOMER_NAME, PRICE, ADDRESS)
				VALUE ('Новый заказ', 0, 'адрес')";
		self::executeQuery($query);
	}

	public function editItemCount($itemID, $count){
		$query =
			"UPDATE IGNORE item_orders
		SET ITEM_COUNT = $count
		WHERE ITEM_ID = $itemID AND ORDERS_ID = $this->id";
		self::executeQuery($query);
	}
}