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

\Core\Routing\Router::get('/admin/product-list/:id/', [new \Controller\admin\AdminListController(), 'adminItemListPage']);
\Core\Routing\Router::get('/admin/tag-list/:id/', [new \Controller\admin\AdminListController(), 'adminTagListPage']);
\Core\Routing\Router::get('/admin/image-list/:id/', [new \Controller\admin\AdminListController(), 'adminImageListPage']);
\Core\Routing\Router::get('/admin/order-list/:id/', [new \Controller\admin\AdminListController(), 'adminOrderListPage']);
\Core\Routing\Router::get('/admin/user-list/:id/', [new \Controller\admin\AdminListController(), 'adminUserListPage']);

\Core\Routing\Router::get('/admin/product/:id/', [new \Controller\admin\AdminItemController(), 'adminItemPage']);
\Core\Routing\Router::post('/admin/product/:id/edit/', [new \Controller\admin\AdminItemController(), 'adminItemEdit']);
\Core\Routing\Router::post('/admin/product/:id/delete-tag/', [new \Controller\admin\AdminItemController(), 'adminItemDeleteTag']);
\Core\Routing\Router::post('/admin/product/:id/add-tag/', [new \Controller\admin\AdminItemController(), 'adminItemAddTag']);
\Core\Routing\Router::post('/admin/product/:id/delete-image/', [new \Controller\admin\AdminItemController(), 'adminItemDeleteImage']);
\Core\Routing\Router::post('/admin/product/:id/add-image/', [new \Controller\admin\AdminItemController(), 'adminItemAddImage']);
\Core\Routing\Router::post('/admin/product/:id/delete/', [new \Controller\admin\AdminItemController(), 'adminItemDelete']);

\Core\Routing\Router::get('/admin/tag/:id/', [new \Controller\admin\AdminTagController(), 'adminTagPage']);
\Core\Routing\Router::post('/admin/tag/:id/edit/', [new \Controller\admin\AdminTagController(), 'adminTagEdit']);
\Core\Routing\Router::post('/admin/tag/:id/delete/', [new \Controller\admin\AdminTagController(), 'adminTagDelete']);

\Core\Routing\Router::get('/admin/image/:id/', [new \Controller\admin\AdminImageController(), 'adminImagePage']);
\Core\Routing\Router::post('/admin/image/:id/edit/', [new \Controller\admin\AdminImageController(), 'adminImageEdit']);
\Core\Routing\Router::post('/admin/image/:id/delete/', [new \Controller\admin\AdminImageController(), 'adminImageDelete']);
\Core\Routing\Router::post('/admin/image/add/', [new \Controller\admin\AdminImageController(), 'adminImageAdd']);

\Core\Routing\Router::get('/admin/user/:id/', [new \Controller\admin\AdminUserController(), 'adminUserPage']);
\Core\Routing\Router::post('/admin/user/:id/edit/', [new \Controller\admin\AdminUserController(), 'adminUserEdit']);
\Core\Routing\Router::post('/admin/user/:id/delete/', [new \Controller\admin\AdminUserController(), 'adminUserDelete']);

\Core\Routing\Router::get('/admin/order/:id/', [new \Controller\admin\AdminOrderController(), 'adminOrderPage']);
\Core\Routing\Router::post('/admin/order/:id/edit/', [new \Controller\admin\AdminOrderController(), 'adminOrderEdit']);
\Core\Routing\Router::post('/admin/order/:id/add-product/', [new \Controller\admin\AdminOrderController(), 'adminOrderAddProduct']);
\Core\Routing\Router::post('/admin/order/:id/delete-product/', [new \Controller\admin\AdminOrderController(), 'adminOrderDeleteProduct']);
\Core\Routing\Router::post('/admin/order/:id/delete/', [new \Controller\admin\AdminOrderController(), 'adminOrderDelete']);