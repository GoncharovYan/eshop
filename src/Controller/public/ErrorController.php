<?php

namespace Controller\public;

use Controller\BaseController;

class ErrorController extends BaseController
{
	public function pageNotFound()
	{
		echo $this->render('layoutView.php', [
			'content' => $this->render('public/pageNotFoundView.php', [

			]),
		]);
	}
}