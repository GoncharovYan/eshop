<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\Image;

class AdminImageController extends BaseController
{

	public function adminImagePage(int|string $id)
	{
		if($id === 'new')
		{
			echo $this->render('admin/layoutView.php', [
				'content' => $this->render('admin/public/adminNewImageView.php', [
				]),
			]);
		} else {
			$image = Image::findById($id);
			echo $this->render('admin/layoutView.php', [
				'content' => $this->render('admin/public/adminImageView.php', [
					'image' => $image,
				]),
			]);
		}
	}

	public function adminImageAdd($data)
	{
		echo 'work in progress';
	}

	public function adminImageEdit($id, $data)
	{
		$width = $data['tag_name'];
		$height = $data['alias'];
		$path = $data['path'];
		$query =
			"UPDATE image
			SET PATH = '$path',
				HEIGHT = '$height',
				WIDTH = '$width'
			WHERE ID = $id";
		Image::executeQuery($query);
		header("Location: /admin/image/$id/");
	}

	public function adminImageDelete($id)
	{
		$query =
			"DELETE FROM item_image
			WHERE IMAGE_ID = $id";
		Image::executeQuery($query);
		$query =
			"DELETE FROM image
			WHERE ID = $id";
		Image::executeQuery($query);
		header("Location: /admin/image-list/1/");
	}
}