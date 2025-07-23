<?php

require_once __DIR__ . '/app/core/bootstrap.php';

$product   = new App\Controllers\ProductController();
$dashboard = new App\Controllers\DashboardController();
$sku = new App\Controllers\SkuController();


$router = new Router();
$router->add('GET', '/', fn() => $dashboard->index());
$router->add("GET", "/products", fn() => $product->index());
$router->add("POST", "/products/store", fn() => $product->store());
$router->add("GET", "/products/skus/create/{id}", fn($id) => $sku->create($id));
$router->add("GET", "/products/sku/edit/{id}", fn($id) => $sku->edit($id));
$router->add("PUT", "/products/sku/edit", fn($id) => $sku->update());
$router->add("GET", "/products/skus/manager/{id}", fn($id) => $sku->index($id));
$router->add("POST", "/products/skus/store", fn() => $sku->store());
$router->render();