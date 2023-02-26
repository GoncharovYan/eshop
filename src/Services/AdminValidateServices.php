<?php

namespace Services;

use Validation\Validator;

class AdminValidateServices
{
	public static function adminItemEditValidate($data)
	{
		$val = new Validator();
		if (empty($data['main_image_id'])) {
			$data['main_image_id'] = 1;
		} else {
			$val->checkInt($data['main_image_id'], 'main_image_id', 1);
		}

		$val->checkText($data['item_name'], 'item_name', 511);
		$val->checkText($data['short_desc'], 'short_desc', 1023);
		$val->checkText($data['full_desc'], 'full_desc', 8191);

		if (empty($data['count'])) {
			$data['count'] = 0;
		} else {
			$val->checkInt($data['count'], 'count', 0);
		}

		if (empty($data['sort_order'])) {
			$data['sort_order'] = 0;
		} else {
			$val->checkInt($data['sort_order'], 'sort_order');
		}

		if (empty($data['price'])) {
			$data['price'] = 0;
		} else {
			$val->checkInt($data['price'], 'price', 0);
		}

		$val->checkBool($data['is_active'], 'is_active');

		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminItemEditMainImageValidate($data)
	{
		$val = new Validator();
		$val->checkInt($data['main_image_id'], 'main_image_id', 1);
		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminRelationsValidate($data)
	{
		$val = new Validator();

		foreach ($data['id'] as $id) {
			$val->checkInt($id, 'id', 1);
		}

		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminRelationValidate($data)
	{
		$val = new Validator();
		$val->checkInt($data['id'], 'id', 1);
		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminItemAddImageValidate($data)
	{
		if (isset($_FILES['image']['tmp_name'])) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
			$allowed = array('image/png', 'image/jpg', 'image/jpeg', 'image/webp');
			if (!in_array($mime, $allowed)) {
				echo 'Wrong file type';
				exit();
			}
			finfo_close($finfo);
		}
	}

	public static function adminImageEditValidate($data)
	{
		$val = new Validator();
		$val->checkInt($data['width'], 'width', 1);
		$val->checkInt($data['height'], 'height', 1);
		$val->checkInt($data['item_id'], 'item_id', 1);
		$val->checkPath($data['path']);
		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminUserEditValidate($data)
	{
		$val = new Validator();
		if(!empty($data['email'])) {
			$val->checkEmail($data['email']);
		}
		$val->checkLogin($data['login']);
		$val->checkBool($data['role'], 'role');
		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminTagEditValidate($data)
	{
		$val = new Validator();
		$val->checkText($data['tag_name'], 'name', 255);
		$val->checkEngText($data['alias'], 'alias', 255);
		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminOrderEditValidate($data)
	{
		$val = new Validator();
		$val->checkText($data['customer_name'], 'customer_name', 255, 1);
		$val->checkPhone($data['c_phone']);
		$val->checkEmail($data['c_email']);
		if (empty($data['comment'])) {
			$data['comment'] = '-';
		} else {
			$val->checkText($data['comment'], 'comment', 1023);
		}

		$val->checkText($data['address'], 'address', 511);
		if (empty($data['price'])) {
			$data['price'] = 0;
		} else {
			$val->checkInt($data['price'], 'price', 0);
		}
		if (empty($data['status'])) {
			$data['status'] = 0;
		} else {
			$val->checkBool($data['status'], 'status');
		}

		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}

	public static function adminUpdateRelationsValidate($data)
	{
		$val = new Validator();
		foreach ($data['relationData'] as $key => $value) {
			$val->checkInt($key, 'key', 1);
			$val->checkInt($value, 'value', 1);
		}

		if (!$val->isSuccess()) {
			foreach ($val->getErrors() as $error) {
				echo $error . "</br>";
			}
			exit;
		}
	}
}