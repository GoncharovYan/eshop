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
}