<?php

namespace App;

use Core\Database\Migration\Migrator;
use Controller\CatalogController;

class Kernel
{
    public function run()
    {
		$environment = 'nodev';
		// DROP ALL TABLES BEFORE START MIGRATION!
		if($environment === 'dev')
		{
			Migrator::migrate();
		}

        $app = new CatalogController();
        $app->catalogPage();
    }
}
