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
		if (!UserServices::isAdmin())
		{
			header("Location: /catalog/all/1/");
			exit;
		}

		if (!is_numeric($id))
		{
			if ($id === 'new')
			{
				$user = new User();
			}
			else
			{
				echo 'User not found';
				exit;
			}
		}
		else
		{
			$user = User::findById($id);
			if (is_null($user))
			{
				echo 'User not found';
				exit;
			}
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
		if (!UserServices::isAdmin())
		{
			header("Location: /catalog/all/1/");
			exit;
		}

		session_start();
		TokenServices::checkToken($data['token'], $_SESSION['token'], "Bad token");

		switch ($data['action'])
		{
			case "edit":
				AdminValidateServices::adminUserEditValidate($data);
				break;
			case "delete":
				break;
			default:
				echo 'Wrong action';
				exit();
		}

		AdminServices::adminEditAction('user', $id, $data);
	}
}