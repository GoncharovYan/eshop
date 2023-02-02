<?php

namespace App;

use Core\Database\Migration\Migrator;

class Kernel
{
    public function run()
    {
		$environment = 'notdev';
		// DROP ALL TABLES BEFORE START MIGRATION!
		if($environment === 'dev')
		{
			Migrator::migrate();
		}
        echo 'Page not found';
    }
}
