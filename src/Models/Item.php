<?php

namespace Models;

class Item extends Relation {

	public $item_id;

	public $item_name;

	public $short_desc;

	public $full_desc;

	public $count;

	public $price;

	public $sort_order;

	public $is_active;

	public $date_created;

	public $date_updated;

	public function __construct() {
		parent::__construct();
	}

	public function tag(){
		return $this->hasToMany(Tag::class);
	}


}