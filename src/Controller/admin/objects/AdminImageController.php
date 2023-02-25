<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Image;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\TokenServices;
use Services\UserServices;

class AdminImageController extends BaseController
{
	public function adminImagePage(int|string $id)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if (!is_numeric($id)){
			if($id === 'new'){
				$image = new Image();
			} else {
				echo 'image not found';
				exit;
			}
		} else {
			$image = Image::findById($id);
			if(is_null($image)){
				echo 'image not found';
				exit;
			}
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/objects/adminImageView.php', [
				'image' => $image,
				'token' => TokenServices::createToken(),
			]),
		]);
	}

	public function adminImageEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		session_start();
		TokenServices::checkToken($data['token'], $_SESSION['token'], "Bad token");

		switch ($data['action']) {
			case "edit":
				AdminValidateServices::adminImageEditValidate($data);
				break;
			case "delete":
				break;
			default:
				echo 'Wrong action';
				exit();
		}

		AdminServices::adminEditAction('image', $id, $data);
	}
}