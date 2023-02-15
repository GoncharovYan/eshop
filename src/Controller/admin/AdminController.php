<?php

namespace Controller\admin;
use Services\AdminServices;

class AdminController
{
	public function adminPage($class, $id)
	{
		$controllerName = '\\Controller\\admin\\objects\\Admin' . ucfirst($class) . 'Controller';
		$controllerFunc = 'admin' . ucfirst($class) . 'Page';
		$controller = new $controllerName();
		$controller->$controllerFunc($id);
	}

	public function adminEdit($class, $id, $data)
	{
		AdminServices::adminEditAction($class, $id, $data);
	}
}