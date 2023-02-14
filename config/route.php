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

\Core\Routing\Router::get('/admin/item/:id/', [new \Controller\admin\AdminItemController(), 'adminItemPage']);
\Core\Routing\Router::get('/admin/tag/:id/', [new \Controller\admin\AdminTagController(), 'adminTagPage']);
\Core\Routing\Router::get('/admin/image/:id/', [new \Controller\admin\AdminImageController(), 'adminImagePage']);
\Core\Routing\Router::get('/admin/user/:id/', [new \Controller\admin\AdminUserController(), 'adminUserPage']);
\Core\Routing\Router::get('/admin/orders/:id/', [new \Controller\admin\AdminOrderController(), 'adminOrderPage']);

\Core\Routing\Router::post('/admin/:class/:id/:edit/', [new \Controller\admin\AdminItemController(), 'adminItemEdit']);


\Core\Routing\Router::post('/admin/tag/:id/edit/', [new \Controller\admin\AdminTagController(), 'adminTagEdit']);
\Core\Routing\Router::post('/admin/tag/:id/delete/', [new \Controller\admin\AdminTagController(), 'adminTagDelete']);

\Core\Routing\Router::post('/admin/image/:id/edit/', [new \Controller\admin\AdminImageController(), 'adminImageEdit']);
\Core\Routing\Router::post('/admin/image/:id/delete/', [new \Controller\admin\AdminImageController(), 'adminImageDelete']);
\Core\Routing\Router::post('/admin/image/add/', [new \Controller\admin\AdminImageController(), 'adminImageAdd']);

\Core\Routing\Router::post('/admin/user/:id/edit/', [new \Controller\admin\AdminUserController(), 'adminUserEdit']);
\Core\Routing\Router::post('/admin/user/:id/delete/', [new \Controller\admin\AdminUserController(), 'adminUserDelete']);

\Core\Routing\Router::post('/admin/order/:id/edit/', [new \Controller\admin\AdminOrderController(), 'adminOrderEdit']);
\Core\Routing\Router::post('/admin/order/:id/add-product/', [new \Controller\admin\AdminOrderController(), 'adminOrderAddProduct']);
\Core\Routing\Router::post('/admin/order/:id/delete-product/', [new \Controller\admin\AdminOrderController(), 'adminOrderDeleteProduct']);
\Core\Routing\Router::post('/admin/order/:id/delete/', [new \Controller\admin\AdminOrderController(), 'adminOrderDelete']);