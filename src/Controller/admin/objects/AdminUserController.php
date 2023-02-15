<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\User;

class AdminUserController extends BaseController
{
	public function adminUserPage(int|string $id)
	{
		if ($id === 'new') {
			User::createNewUser();
			header("Location: /admin/user/");
		}

		$user = User::findById($id);

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminUserView.php', [
				'user' => $user,
			]),
		]);
	}
}