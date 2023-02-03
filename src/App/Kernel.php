<?php

namespace App;

use Core\Database\Migration\Migrator;
use Controller\CatalogController;
use Core\Routing\Router;

class Kernel
{
    public function run()
    {
        $route = Router::find($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

		$environment = 'dev';
		// DROP ALL TABLES BEFORE START MIGRATION!
		if($environment === 'dev')
		{
			Migrator::migrate();
		}

        if ($route)
        {
            $action = $route->action;
            $variables = $route->getVariables();

            $action(...$variables);
        }
    }
}