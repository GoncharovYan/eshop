<?php

const ROOT = __DIR__;

require_once ROOT . '/autoloader.php';
require_once ROOT . '/config/route.php';

$cache = new \Cache\FileCache();
$cache->clearExpiedData();
