<?php

\Core\Routing\Router::get('/catalog/all/:id/', [new \Controller\CatalogController(), 'catalogPage']);

\Core\Routing\Router::get('/auth/', [new \Controller\private\AuthController(), 'authPage']);
\Core\Routing\Router::post('/auth/auth/',[new \Controller\private\AuthController(), 'authUser']);

\Core\Routing\Router::get('/register/', [new \Controller\private\AuthController(), 'registerPage']);
\Core\Routing\Router::post('/register/register/',[new \Controller\private\AuthController(), 'registerUser']);

\Core\Routing\Router::get('/logout/',[new \Controller\private\AuthController(), 'logOutUser']);