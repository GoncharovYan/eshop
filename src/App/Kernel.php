<?php

namespace App;

use Core\Database\Migration\Migrator;
use Controller\CatalogController;
use Core\Routing\Router;
use Services\ConfigurationServices;

class Kernel
{
    public function run()
    {
        $route = Router::find($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

		if(ConfigurationServices::option('ENVIRONMENT') === 'dev')
		{
			Migrator::migrate();
		}

        if ($route)
        {
            $action = $route->action;
            $variables = $route->getVariables();
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $variables[]= $_POST;
            }

            $action(...$variables);
        }
    }
}