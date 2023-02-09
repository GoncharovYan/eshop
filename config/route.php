<?php

\Core\Routing\Router::get('/catalog/:id/', [new \Controller\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/test/', [new \Controller\TestController(), 'testPage']);
\Core\Routing\Router::get('/admin/', [new \Controller\admin\AdminController(), 'adminPage']);