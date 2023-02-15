<?php

namespace Models;

class Tag extends Relation {

	public $id;

	public $tag_name;

	public $alias;

	public function items(){
		return $this->belongsToMany(Item::class);
	}

	public static function createNewTag(){
		$query =
			"INSERT INTO tag (TAG_NAME, ALIAS)
				VALUES ('Новый тег', 'Новая ссылка')";
		self::executeQuery($query);
	}
}