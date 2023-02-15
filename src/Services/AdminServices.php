<?php

namespace Services;

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
		header("Location: /admin/$className/");
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
		$obj->deleteManyToMany($relatedObj);
		header("Location: /admin/$className/$id/");
	}

	public static function adminAddRelation($className, $obj ,$id, $data)
	{
		$relatedClass = "\Models\\" . ucfirst($data['relation']);
		$relatedObj = $relatedClass::findById($data['id']);
		$obj->addManyToMany($relatedObj);
		header("Location: /admin/$className/$id/");
	}

	public static function adminEditOrderCount($className, $obj ,$id, $data)
	{
		$obj->editItemCount($data['id'], $data['item_count']);
		header("Location: /admin/$className/$id/");
	}
}