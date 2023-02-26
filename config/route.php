<?php

\Core\Routing\Router::get('/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/:tag/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/:tag/:page/', [new \Controller\public\CatalogController(), 'catalogPage']);
\Core\Routing\Router::get('/catalog/:tag/:page/change/', [new \Controller\public\CatalogController(), 'changePage']);

\Core\Routing\Router::get('/product/:id/', [new \Controller\public\DetailsController(), 'detailsPage']);

\Core\Routing\Router::get('/order/', [new \Controller\public\OrderController(), 'orderPage']);
\Core\Routing\Router::post('/order/', [new \Controller\public\OrderController(), 'checkout']);
\Core\Routing\Router::post('/order/modify/', [new \Controller\public\OrderController(), 'modifyCart']);
\Core\Routing\Router::post('/order/delete/', [new \Controller\public\OrderController(), 'deleteFromCart']);

\Core\Routing\Router::get('/auth/', [new \Controller\private\AuthController(), 'authPage']);
\Core\Routing\Router::post('/auth/',[new \Controller\private\AuthController(), 'authUser']);

\Core\Routing\Router::get('/registration/', [new \Controller\private\AuthController(), 'registerPage']);
\Core\Routing\Router::post('/registration/',[new \Controller\private\AuthController(), 'registerUser']);

\Core\Routing\Router::get('/logout/',[new \Controller\private\AuthController(), 'logOutUser']);

\Core\Routing\Router::get('/admin/:class/', [new \Controller\admin\AdminListController(), 'adminListPage']);
\Core\Routing\Router::get('/admin/item/:id/', [new \Controller\admin\objects\AdminItemController(), 'adminItemPage']);
\Core\Routing\Router::post('/admin/item/:id/', [new \Controller\admin\objects\AdminItemController(), 'adminItemEdit']);
\Core\Routing\Router::get('/admin/tag/:id/', [new \Controller\admin\objects\AdminTagController(), 'adminTagPage']);
\Core\Routing\Router::post('/admin/tag/:id/', [new \Controller\admin\objects\AdminTagController(), 'adminTagEdit']);
\Core\Routing\Router::get('/admin/orders/:id/', [new \Controller\admin\objects\AdminOrdersController(), 'adminOrdersPage']);
\Core\Routing\Router::post('/admin/orders/:id/', [new \Controller\admin\objects\AdminOrdersController(), 'adminOrdersEdit']);
\Core\Routing\Router::get('/admin/user/:id/', [new \Controller\admin\objects\AdminUserController(), 'adminUserPage']);
\Core\Routing\Router::post('/admin/user/:id/', [new \Controller\admin\objects\AdminUserController(), 'adminUserEdit']);
\Core\Routing\Router::get('/admin/image/:id/', [new \Controller\admin\objects\AdminImageController(), 'adminImagePage']);
\Core\Routing\Router::post('/admin/image/:id/', [new \Controller\admin\objects\AdminImageController(), 'adminImageEdit']);

\Core\Routing\Router::get('/product/', [new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/product', [new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/order',[new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/order/:tag', [new \Controller\public\ErrorController(), 'pageNotFound']);
\Core\Routing\Router::get('/product/order/:id', [new \Controller\public\ErrorController(), 'pageNotFound']);