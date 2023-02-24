<?php

namespace Services;

use Models\Image;

class AdminServices
{
	public static function adminEditAction($className, $id, $data)
	{
		$class = "\Models\\" . ucfirst($className);
		if ($id === 'new') {
			$obj = new $class;
		} else {
			$obj = $class::findById($id);
			if (!isset($obj)) {
				echo 'Неверный id';
				exit();
			}
		}

		$actionFunction = 'admin' . ucfirst($data['action']);
		self::$actionFunction($className, $obj, $id, $data);
	}

	public static function adminEdit($className, $obj, $id, $data)
	{
		foreach ($data as $key => $value) {
			$obj->$key = $value;
		}
		$obj = $obj->save();
		header("Location: /admin/$className/$obj->id/");
	}

	public static function adminDelete($className, $obj, $id, $data)
	{
		$obj->delete();
		header("Location: /admin/$className/");
	}

	public static function adminDeleteRelation($className, $obj, $id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedObj = $relatedClass::findById($data['id']);
		$obj->deleteRelation($relatedObj);
		header("Location: /admin/$className/$id/");
	}

	public static function adminDeleteRelations($className, $obj, $id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedObjectArr = $relatedClass::findByIdArr($data['id']);
		$obj->deleteRelationArr($relatedObjectArr);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddRelation($className, $obj, $id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedObj = $relatedClass::findById($data['id']);
		$obj->addRelation($relatedObj);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddRelations($className, $obj, $id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedClassArr = $relatedClass::findByIdArr($data['id']);
		$obj->addRelationArr($relatedClassArr);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddOrderItemRelation($className, $obj, $id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedClassArr = $relatedClass::findByIdArr($data['id']);
	}

	public static function adminUpdateItemCount($className, $obj, $id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$obj->updateRelationArr($relatedClass, 'ITEM_COUNT', $data['relationData']);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddImage($className, $obj, $id, $data)
	{
		$imageInfo = getimagesize($_FILES["image"]["tmp_name"]);
		$fileName = md5(uniqid('', true)) . '.jpg';
		$uploadDir = '/resources/objects/itemImages/';
		$path = $uploadDir . $fileName;

		$newImage = new Image();
		$newImage->path = $path;
		$newImage->item_id = $id;
		$newImage->width = $imageInfo[0];
		$newImage->height = $imageInfo[1];

		if (isset($_FILES) && $_FILES['image']['error'] === 0) {
			$destiation_dir = ROOT . '/objects' . $path;
			move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir);
			$newImage->save();
		}

		header("Location: /admin/$className/$id/");
	}

	public static function adminDeleteImage($className, $obj, $id, $data)
	{
		$image = Image::findById($data['id']);
		unlink(ROOT . '/objects' . $image->path); // Delete image file
		$image->delete();

		header("Location: /admin/$className/$id/");
	}
}