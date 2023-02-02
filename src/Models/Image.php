<?php

namespace Models;

class Image extends Dto\Relation {
	public $id;

	public $path;

	public $height;

	public $width;

	public $is_main;

	public function __construct() {
		parent::__construct();
	}
}