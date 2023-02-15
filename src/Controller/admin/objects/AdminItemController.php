<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Tag;

class AdminItemController extends BaseController
{
	public function adminItemPage(int|string $id)
	{
		if ($id === 'new') {
			Item::createNewItem();
			header("Location: /admin/item/");
		}

		$item = Item::findById($id);

		$image = new Image();
		$images = $image->items()->find([
			'conditions' => "ITEM_ID = $id"
		]);

		$tag = new Tag();
		$tags = $tag->items()->find([
			'conditions' => "ITEM_ID = $id"
		]);

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminItemView.php', [
				'item' => $item,
				'images' => $images,
				'tags' => $tags,
			]),
		]);
	}
}