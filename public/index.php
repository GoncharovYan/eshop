<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/../boot.php";

use App\Kernel;

$app = new Kernel();
$app->run();



