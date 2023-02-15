<?php

//require_once $_SERVER['DOCUMENT_ROOT'] . "/../boot.php";
require_once "../boot.php";

use App\Kernel;
$app = new Kernel();
$app->run();

