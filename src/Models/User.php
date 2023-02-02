<?php

namespace Models;

use Dto\Relation;

class User extends Relation {
	public $id;

	public $email;

	public $login;

	public $password;

	public $role;

	public function __construct() {
		parent::__construct();
	}
}