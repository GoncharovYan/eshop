<?php

namespace Models;

class Image extends Relation {
	public $id;

	public $path;

	public $height;

	public $width;

	public $is_main;

	public function items(){
		return $this->belongsToMany(Item::class);
	}
}