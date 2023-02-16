<?php

namespace Models;

class Image extends Relation {
	public $id;

	public $path;

	public $height;

	public $width;

	public $item_id;

	public static function createNewImage(){
		$query =
			"INSERT INTO image (PATH, HEIGHT, WIDTH)
				VALUE ('', 0, 0)";
		self::executeQuery($query);
	}
}