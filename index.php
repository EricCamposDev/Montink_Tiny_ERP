<?php

require_once __DIR__ . '/app/core/bootstrap.php';

use App\Controllers\ProductController;

$controller = new ProductController();

$request = $_SERVER['REQUEST_URI'];
switch (parse_url($request, PHP_URL_PATH)) {
    case '/products':
        $controller->index();
        break;

    case '/products/create':
        $controller->create();
        break;

    case '/products/delete':
        $controller->delete();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/app/views/errors/404.php';
        break;
}