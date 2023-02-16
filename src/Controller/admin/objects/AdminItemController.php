<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Tag;
use mysql_xdevapi\Exception;

class AdminItemController extends BaseController
{
	public function adminItemPage(int|string $id)
	{
		if ($id === 'new') {
			Item::createNewItem();
			header("Location: /admin/item/");
		}

		$item = Item::findById($id);

		$mainImage = Image::findById($item->main_image_id);
		if($mainImage->path === null)
		{
			$mainImage = Image::findById(1);
		}

		$image = new Image();
		$images = $image::find([
			'conditions' => "ITEM_ID = $id"
		]);

		$tag = new Tag();
		$tags = $tag->items()->find([
			'conditions' => "ITEM_ID = $id"
		]);


		$allTags = Tag::findAll();

		// Удаление текущих тегов товара из массива всех тегов
		$tagsID = [];
		foreach ($tags as $itemTag) {
			$tagsID[] = $itemTag['id'];
		}
		foreach ($allTags as $key => $otherTag) {
			if(in_array($otherTag->id, $tagsID, true)) {
				unset($allTags[$key]);
			}
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminItemView.php', [
				'item' => $item,
				'mainImage' => $mainImage,
				'images' => $images,
				'tags' => $tags,
				'allTags' => $allTags,
			]),
		]);
	}
}