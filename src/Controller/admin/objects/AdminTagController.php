<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Tag;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\UserServices;

class AdminTagController extends BaseController
{
	public function adminTagPage(int|string $id)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if ($id === 'new') {
			$tag = new Tag();
		} else {
			$tag = Tag::findById($id);
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminTagView.php', [
				'tag' => $tag,
			]),
		]);
	}

	public function adminTagEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if ($data['action'] !== 'edit') {
			echo 'Wrong action';
			exit();
		}
		AdminValidateServices::adminTagEditValidate($data);
		AdminServices::adminEditAction('tag', $id, $data);
	}
}