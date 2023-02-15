<?php

namespace Controller\admin\objects;

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
		}
		else {
			$image = Image::findById($id);

			echo $this->render('admin/layoutView.php', [
				'content' => $this->render('admin/public/adminImageView.php', [
					'image' => $image,
				]),
			]);
		}
	}
}