<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\Tag;

class AdminTagController extends BaseController
{
	public function adminTagPage(int|string $id)
	{
		if ($id === 'new') {
			$query =
				"INSERT INTO tag (TAG_NAME, ALIAS)
				VALUES ('Новый тег', 'Новая ссылка')";
			Tag::executeQuery($query);
			$id = Tag::executeQuery(
				"SELECT ID FROM tag ORDER BY ID DESC LIMIT 1;"
			)[0]->id;
			header("Location: /admin/tag-list/1/");
		}

		$tag = Tag::findById($id);
		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminTagView.php', [
				'tag' => $tag,
			]),
		]);
	}

	public function adminTagEdit($id, $data)
	{
		$name = $data['tag_name'];
		$alias = $data['alias'];
		$query =
			"UPDATE tag
			SET TAG_NAME = '$name',
				ALIAS = '$alias'
			WHERE ID = $id";
		Tag::executeQuery($query);
		header("Location: /admin/tag/$id/");
	}

	public function adminTagDelete($id)
	{
		$query =
			"DELETE FROM item_tag
			WHERE TAG_ID = $id";
		Tag::executeQuery($query);
		$query =
			"DELETE FROM tag
			WHERE ID = $id";
		Tag::executeQuery($query);
		header("Location: /admin/tag-list/1/");
	}
}