<?php

namespace Controller\admin;
use Services\AdminServices;
use Services\UserServices;

class AdminController
{
	public function adminPage($class, $id)
	{
        if(!UserServices::isAdmin())
        {
            header("Location: /catalog/all/1/");
            exit;
        }

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