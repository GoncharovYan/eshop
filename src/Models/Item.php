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

	public $main_image_id;

	public function tags(){
		return $this->hasMany(Tag::class);
	}


	public function orders(){
		return $this->hasMany(Orders::class);
	}

}