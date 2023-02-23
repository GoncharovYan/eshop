<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\User;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\UserServices;

class AdminUserController extends BaseController
{
	public function adminUserPage(int|string $id)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if ($id === 'new') {
			$user = new User();
		} else {
			$user = User::findById($id);
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminUserView.php', [
				'user' => $user,
			]),
		]);
	}

	public function adminUserEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		if ($data['action'] !== 'edit') {
			echo 'Wrong action';
			exit();
		}
		AdminValidateServices::adminUserEditValidate($data);
		AdminServices::adminEditAction('user', $id, $data);
	}
}