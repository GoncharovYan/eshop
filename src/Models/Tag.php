<?php

namespace Models;

class Tag extends Relation {

	public $id;

	public $tag_name;

	public function items(){
		return $this->belongsToMany(Item::class);
	}

}