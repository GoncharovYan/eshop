<?php

\Core\Routing\Router::get('/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/:tag/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/:tag/:page/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/:tag/:page/change/', [new \Controller\public\CatalogController(), 'changePage']);

\Core\Routing\Router::get('/product/:id/', [new \Controller\public\DetailsController(), 'detailsPage']);

\Core\Routing\Router::get('/order/', [new \Controller\public\OrderController(), 'orderPage']);
\Core\Routing\Router::post('/checkout/', [new \Controller\public\OrderController(), 'checkout']);
\Core\Routing\Router::get('/product/order/:id/', [new \Controller\public\OrderController(), 'addToCart']);

\Core\Routing\Router::get('/auth/', [new \Controller\private\AuthController(), 'authPage']);
\Core\Routing\Router::post('/auth/',[new \Controller\private\AuthController(), 'authUser']);

\Core\Routing\Router::get('/register/', [new \Controller\private\AuthController(), 'registerPage']);
\Core\Routing\Router::post('/register/',[new \Controller\private\AuthController(), 'registerUser']);

\Core\Routing\Router::get('/logout/',[new \Controller\private\AuthController(), 'logOutUser']);

\Core\Routing\Router::get('/admin/:class/', [new \Controller\admin\AdminListController(), 'adminListPage']);
\Core\Routing\Router::get('/admin/:class/:id/', [new \Controller\admin\AdminController(), 'adminPage']);
\Core\Routing\Router::post('/admin/:class/:id/', [new \Controller\admin\AdminController(), 'adminEdit']);

\Core\Routing\Router::get('/product/', [new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/product', [new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/order',[new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/order/:tag', [new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/product/order/:id', [new \Controller\public\ErrorController(), 'pageNotFound']);