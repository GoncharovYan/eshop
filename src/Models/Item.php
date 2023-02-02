<?php

namespace App\Models;

use App\Dto\Relation;

use App\Model\Tag;


class Item extends Relation {

	public $id;

	public $name;

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