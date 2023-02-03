<?php

\Core\Routing\Router::get('/catalog/:id/', [new \Controller\CatalogController(), 'catalogPage']);