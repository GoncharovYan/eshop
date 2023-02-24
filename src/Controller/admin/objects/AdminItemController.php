<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Tag;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\TokenServices;
use Services\UserServices;

class AdminItemController extends BaseController
{
	public function adminItemPage(int|string $id)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		$allTags = Tag::findAll();
		if ($id === 'new') {
			$item = new Item();
			$mainImage = Image::findById(1);
			$images = [];
			$tags = [];
		} else {
			$item = Item::findById($id);
			if (!isset($item)) {
				echo 'Товар не найден';
				exit();
			}

			$mainImage = Image::findById($item->main_image_id) ?? Image::findById(1);

			$image = new Image();
			$images = $image::find([
				'conditions' => "ITEM_ID = $id"
			]);

			$tag = new Tag();
			$tags = $tag->items()->find([
				'conditions' => "ITEM_ID = $id"
			]);

			// Удаление текущих тегов товара из массива всех тегов
			$tagsID = [];
			foreach ($tags as $itemTag) {
				$tagsID[] = $itemTag['id'];
			}
			foreach ($allTags as $key => $otherTag) {
				if (in_array($otherTag->id, $tagsID, true)) {
					unset($allTags[$key]);
				}
			}
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminItemView.php', [
				'item' => $item,
				'mainImage' => $mainImage,
				'images' => $images,
				'tags' => $tags,
				'allTags' => $allTags,
				'token' => TokenServices::createToken(),
			]),
		]);
	}

	public function adminItemEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		session_start();
		TokenServices::checkToken($data['token'], $_SESSION['token'], "Bad token");

		switch ($data['action']) {
			case "edit":
				AdminValidateServices::adminItemEditValidate($data);
				break;
			case "deleteRelations":
			case "addRelations":
				AdminValidateServices::adminRelationsValidate($data);
				break;
			case "addImage":
				AdminValidateServices::adminItemAddImageValidate($data);
				break;
			case "editMainImage":
				AdminValidateServices::adminItemEditMainImageValidate($data);
				$data['action'] = "edit";
				break;
			default:
				echo 'Wrong action';
				exit();
		}
		AdminServices::adminEditAction('item', $id, $data);
	}
}