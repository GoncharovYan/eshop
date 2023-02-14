<?php

namespace Models;

class Item extends Relation {

	public $id;

	public $item_name;

	public $short_desc;

	public $full_desc;

	public $count;

	public $price;

	public $sort_order;

	public $is_active;

	public $date_created;

	public $date_updated;

	public function tags(){
		return $this->hasMany(Tag::class);
	}

	public function images(){
		return $this->hasMany(Image::class);
	}

	public function deleteRelation($objRelate){
		return $this->deleteManyToMany($objRelate);
	}

	public function addRelation($objRelate){
		return $this->addManyToMany($objRelate);
	}

	public static function createNewItem(){
		$query =
			"INSERT INTO item (ITEM_NAME)
				VALUE ('Новый товар')";
		self::executeQuery($query);
	}
}