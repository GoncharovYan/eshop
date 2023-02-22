<?php

namespace Controller\admin;
use Services\AdminServices;

class AdminController
{
	public function adminEdit($class, $id, $data)
	{
		AdminServices::adminEditAction($class, $id, $data);
	}
}