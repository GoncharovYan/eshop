<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\Item;
use Models\Tag;
use Services\PageServices;

class AdminController extends BaseController {
	public function adminPage(int $curPage = null)
	{
		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminView.php', [

			]),
		]);
	}
}