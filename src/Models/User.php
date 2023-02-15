<?php

namespace Models;

class User extends Relation {
	public $id;

	public $email;

	public $login;

	public $password;

	public $role;

	public function __construct() {
		parent::__construct();
	}

	public static function createNewUser($login = 'login', $password = 'password') {
		$query =
			"INSERT INTO user (LOGIN, PASSWORD)
				VALUES ('$login', '$password')";
		self::executeQuery($query);
	}
}