<?php

namespace App\Models;

class Image extends \App\Dto\Relation {
	public $id;

	public $path;

	public $height;

	public $width;

	public $is_main;

	public function __construct() {
		parent::__construct();
	}
}