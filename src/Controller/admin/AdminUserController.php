<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\User;

class AdminUserController extends BaseController
{
	public function adminUserPage(int|string $id)
	{
		if ($id === 'new') {
			$query =
				"INSERT INTO user (LOGIN, PASSWORD)
				VALUES ('login', 'password')";
			User::executeQuery($query);
			header("Location: /admin/user-list/1/");
		}

		$user = User::findById($id);
		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminUserView.php', [
				'user' => $user,
			]),
		]);
	}

	public function adminUserEdit($id, $data)
	{
		$email = $data['email'];
		$login = $data['login'];
		$password = $data['password'];
		$role = ($data['role'] === 'on') ? 0 : 1;
		$query =
			"UPDATE user
			SET EMAIL = '$email',
				LOGIN = '$login',
				PASSWORD = '$password',
				ROLE = '$role'
			WHERE ID = $id";
		User::executeQuery($query);
		header("Location: /admin/user/$id/");
	}

	public function adminUserDelete($id)
	{
		$query =
			"DELETE FROM user
			WHERE ID = $id";
		User::executeQuery($query);
		header("Location: /admin/user-list/1/");
	}
}