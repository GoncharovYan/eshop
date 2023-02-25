<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\User;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\TokenServices;
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
			'content' => $this->render('admin/objects/adminUserView.php', [
				'user' => $user,
				'token' => TokenServices::createToken(),
			]),
		]);
	}

	public function adminUserEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		session_start();
		TokenServices::checkToken($data['token'], $_SESSION['token'], "Bad token");

		if ($data['action'] !== 'edit') {
			echo 'Wrong action';
			exit();
		}
		AdminValidateServices::adminUserEditValidate($data);
		AdminServices::adminEditAction('user', $id, $data);
	}
}