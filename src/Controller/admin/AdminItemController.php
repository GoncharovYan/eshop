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
			$query =
				"INSERT INTO item (ITEM_NAME)
				VALUE ('Новый товар')";
			Item::executeQuery($query);
			$id = Item::executeQuery(
				"SELECT ID FROM item ORDER BY ID DESC LIMIT 1;"
			)[0]->id;
			header("Location: /admin/product-list/1/");
		}

		$item = Item::findById($id);
		$itemImageList = Image::executeQuery(
			"SELECT image.ID, PATH, IS_MAIN FROM item
				INNER JOIN item_image on item.ID = ITEM_ID
				INNER JOIN image on IMAGE_ID = image.ID
				WHERE item.ID = $id"
		);
		$itemTagList = Tag::executeQuery(
			"SELECT tag.ID, TAG_NAME FROM item
				INNER JOIN item_tag ON item.ID = ITEM_ID
				INNER JOIN tag on item_tag.TAG_ID = tag.ID
				WHERE item.ID = $id"
		);

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminItemView.php', [
				'product' => $item,
				'productImageList' => $itemImageList,
				'productTagList' => $itemTagList,
			]),
		]);
	}

	public function adminItemEdit($id, $data)
	{
		$item_name = $data['item_name'];
		$short_desc = $data['short_desc'];
		$full_desc = $data['full_desc'];
		$count = $data['count'];
		$price = $data['price'];
		$is_active = ($data['is_active'] === 'on') ? 1 : 0;

		$query =
			"UPDATE item
			SET ITEM_NAME = '$item_name',
				SHORT_DESC = '$short_desc',
				FULL_DESC = '$full_desc',
				COUNT = '$count',
				PRICE = '$price',
				IS_ACTIVE = $is_active
			WHERE ID = $id";
		Item::executeQuery($query);

		header("Location: /admin/product/$id/");
	}

	public function adminItemDeleteTag($id, $data)
	{
		$tag_id = $data['tag_id'];
		$query =
			"DELETE FROM item_tag
			WHERE ITEM_ID = $id AND TAG_ID = $tag_id";
		Item::executeQuery($query);
		header("Location: /admin/product/$id/");
	}

	public function adminItemAddTag($id, $data)
	{
		$tag_id = $data['tag_id'];
		$query =
			"INSERT IGNORE INTO item_tag (ITEM_ID, TAG_ID) 
			VALUE ($id, $tag_id)";
		Item::executeQuery($query);
		header("Location: /admin/product/$id/");
	}

	public function adminItemDeleteImage($id, $data)
	{
		$image_id = $data['image_id'];
		$query =
			"DELETE FROM item_image
			WHERE ITEM_ID = $id AND IMAGE_ID = $image_id";
		Item::executeQuery($query);
		header("Location: /admin/product/$id/");
	}

	public function adminItemAddImage($id, $data)
	{
		$image_id = $data['image_id'];
		$query =
			"INSERT IGNORE INTO item_image (ITEM_ID, IMAGE_ID) 
			VALUE ($id, $image_id)";
		Item::executeQuery($query);
		header("Location: /admin/product/$id/");
	}

	public function adminItemDelete($id)
	{
		$query =
			"DELETE FROM item_tag
			WHERE ITEM_ID = $id";
		Item::executeQuery($query);

		$query =
			"DELETE FROM item_image
			WHERE ITEM_ID = $id";
		Item::executeQuery($query);

		$query =
			"DELETE FROM item
			WHERE ID = $id";
		Item::executeQuery($query);
		header("Location: /admin/product-list/1/");
	}
}