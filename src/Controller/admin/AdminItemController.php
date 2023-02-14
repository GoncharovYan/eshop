<?php

namespace Controller\admin;

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

	public function adminItemEdit($className ,$id, $action, $data)
	{
		$class = "\Models\\" . ucfirst($className);
		$class = new $class();

		if($action === 'delete-tag')
		{
			$tag = Tag::findById($data['tag_id']);
			$obj = $class::findById($id);
			$obj->deleteRelation($tag);
		}

		if($action === 'add-tag')
		{
			$tag = Tag::findById($data['tag_id']);
			$obj = $class::findById($id);
			$obj->addRelation($tag);
		}

		if($action === 'delete')
		{
			$obj = $class::findById($id);
			$obj->delete();
		}

		if($action === 'edit')
		{
			$obj = $class::findById($id);
			foreach ($data as $key => $value)
			{
				$obj->$key = $value;
			}
			$obj->save();
		}

		header("Location: /admin/$className/$id/");
	}
}