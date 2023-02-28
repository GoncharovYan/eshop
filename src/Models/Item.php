<?php

namespace Models;

class Item extends Relation {

	public $id;

	public $item_name;

	public $short_desc;

	public $full_desc;

	public $price;

	public $is_active;

	public $sort_order;

	public $date_created;

	public $date_updated;

	public $main_image_id;

	public function tags(){
		return $this->hasMany(Tag::class);
	}


	public function orders(){
		return $this->hasMany(Orders::class);
	}

}