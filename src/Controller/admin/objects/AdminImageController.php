<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Image;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\UserServices;

class AdminImageController extends BaseController
{
	public function adminImagePage(int|string $id)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if ($id === 'new') {
			$image = new Image();
		} else {
			$image = Image::findById($id);
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminImageView.php', [
				'image' => $image,
			]),
		]);
	}

	public function adminImageEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if ($data['action'] !== 'edit') {
			echo 'Wrong action';
			exit();
		}
		AdminValidateServices::adminImageEditValidate($data);
		AdminServices::adminEditAction('image', $id, $data);
	}
}