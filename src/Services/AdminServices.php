<?php

namespace Services;

use Models\Image;

class AdminServices
{
	public static function adminEditAction($className, $id, $data)
	{
		$class = "\Models\\" . ucfirst($className);
		$obj = $class::findById($id);

		$actionFunction = 'admin' . ucfirst($data['action']);
		self::$actionFunction($className, $obj ,$id, $data);
	}

	public static function adminEdit($className, $obj ,$id, $data)
	{
		foreach ($data as $key => $value)
		{
			$obj->$key = $value;
		}
		$obj->save();
		header("Location: /admin/$className/$id/");
	}

	public static function adminDelete($className, $obj ,$id, $data)
	{
		$obj->delete();
		header("Location: /admin/$className/");
	}

	public static function adminDeleteRelation($className, $obj ,$id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedObj = $relatedClass::findById($data['id']);
		$obj->deleteRelation($relatedObj);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddRelation($className, $obj ,$id, $data)
	{
		// $obj = $item
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		// Tag
		$relatedObj = $relatedClass::findById($data['id']);
		// $relatedObj = Tag::findById($data['id']);
		$obj->addRelation($relatedObj);
		// $item->addManyToMany($tag);
		header("Location: /admin/$className/$id/");
	}

	public static function adminEditOrderCount($className, $obj ,$id, $data)
	{
		$obj->editItemCount($data['id'], $data['item_count']);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddImage($className, $obj ,$id, $data)
	{
		$path = '/resources/public/itemImages/'.$_FILES['image']['name'];
		$image_info = getimagesize($_FILES["image"]["tmp_name"]);

		$newImage = new Image();
		$newImage->path = $path;
		$newImage->item_id = $id;
		$newImage->width = $image_info[0];
		$newImage->height = $image_info[1];
		$newImage->save();

		if(isset($_FILES) && $_FILES['image']['error'] === 0){
			$destiation_dir = ROOT . '/public' . $path;
			move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir );
		}
		var_dump($destiation_dir);

		header("Location: /admin/$className/$id/");
	}

	public static function adminDeleteImage($className, $obj ,$id, $data)
	{
		$image = Image::findById($data['id']);
		unlink(ROOT . '/public' . $image->path); // Delete image file
		$image->delete();

		header("Location: /admin/$className/$id/");
	}
}