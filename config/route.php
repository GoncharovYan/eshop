<?php

\Core\Routing\Router::get('/catalog/:tag/:id/', [new \Controller\CatalogController(), 'catalogPage']);

\Core\Routing\Router::get('/product/:id/', [new \Controller\DetailsController(), 'detailsPage']);

\Core\Routing\Router::get('/order/', [new \Controller\OrderController(), 'orderPage']);
\Core\Routing\Router::get('/product/order/:id/', [new \Controller\OrderController(), 'addToCart']);

\Core\Routing\Router::get('/auth/', [new \Controller\private\AuthController(), 'authPage']);
\Core\Routing\Router::post('/auth/',[new \Controller\private\AuthController(), 'authUser']);

\Core\Routing\Router::get('/register/', [new \Controller\private\AuthController(), 'registerPage']);
\Core\Routing\Router::post('/register/',[new \Controller\private\AuthController(), 'registerUser']);

\Core\Routing\Router::get('/logout/',[new \Controller\private\AuthController(), 'logOutUser']);

\Core\Routing\Router::get('/admin/:class/', [new \Controller\admin\AdminListController(), 'adminListPage']);
\Core\Routing\Router::get('/admin/:class/:id/', [new \Controller\admin\AdminController(), 'adminPage']);
\Core\Routing\Router::post('/admin/:class/:id/', [new \Controller\admin\AdminController(), 'adminEdit']);
