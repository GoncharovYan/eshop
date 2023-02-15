<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Tag;

class AdminTagController extends BaseController
{
	public function adminTagPage(int|string $id)
	{
		if ($id === 'new') {
			Tag::createNewTag();
			header("Location: /admin/tag/");
		}

		$tag = Tag::findById($id);

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminTagView.php', [
				'tag' => $tag,
			]),
		]);
	}
}