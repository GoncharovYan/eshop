<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Tag;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\TokenServices;
use Services\UserServices;

class AdminTagController extends BaseController
{
	public function adminTagPage(int|string $id)
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
				$tag = new Tag();
			}
			else
			{
				echo 'tag not found';
				exit;
			}
		}
		else
		{
			$tag = Tag::findById($id);
			if (is_null($tag))
			{
				echo 'tag not found';
				exit;
			}
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/objects/adminTagView.php', [
				'tag' => $tag,
				'token' => TokenServices::createToken(),
			]),
		]);
	}

	public function adminTagEdit($id, $data)
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
				AdminValidateServices::adminTagEditValidate($data);
				break;
			case "delete":
				break;
			default:
				echo 'Wrong action';
				exit();
		}

		AdminServices::adminEditAction('tag', $id, $data);
	}
}