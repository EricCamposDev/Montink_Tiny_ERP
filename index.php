<?php


    require_once __DIR__ . '/app/core/bootstrap.php';

    if( APP_ENV == "DEV" ){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $sku = new App\Controllers\SkuController;
    $order = new App\Controllers\OrderController;
    $store = new App\Controllers\StoreController;
    $coupom = new App\Controllers\CouponController;
    $cartIO = new App\Controllers\CartIOController;
    $checkout = new App\Controllers\CheckoutController;
    $product   = new App\Controllers\ProductController;
    $dashboard = new App\Controllers\DashboardController;

    $router = new Router();
    $router->add('GET', '/', fn() => $dashboard->index());
    $router->add("GET", "/products", fn() => $product->index());
    $router->add("POST", "/products/store", fn() => $product->store());
    $router->add("POST", "/products/delete/{id}", fn($id) => $product->delete($id));
    $router->add("POST", "/products/update/{id}", fn($id) => $product->update($id));
    $router->add("GET", "/products/skus/create/{id}", fn($id) => $sku->create($id));
    $router->add("GET", "/products/sku/edit/{id}", fn($id) => $sku->edit($id));
    $router->add("POST", "/products/sku/edit", fn() => $sku->update());
    $router->add("GET", "/products/skus/manager/{id}", fn($id) => $sku->index($id));
    $router->add("POST", "/products/skus/store", fn() => $sku->store());
    $router->add("POST", "/products/skus/delete/{id}", fn($id) => $sku->delete($id));
    $router->add("GET", "/store", fn() => $store->index());
    $router->add("GET", "/store/cart/clear", fn() => $cartIO->clear());
    $router->add("POST","/store/cart/add-item", fn() => $cartIO->addItem());
    $router->add("GET", "/checkout", fn() => $checkout->index());
    $router->add("GET", "/checkout/remove-coupon", fn() => $cartIO->removeCoupon());
    $router->add("POST", "/checkout/apply-coupon", fn() => $cartIO->applyCoupon());
    $router->add("POST", "/checkout/apply-freight", fn() => $cartIO->applyFreight());
    $router->add("POST", "/checkout/create-order", fn() => $order->create());
    $router->add("GET", "/coupons", fn() => $coupom->index());
    $router->add("GET", "/coupons/create", fn() => $coupom->create());
    $router->add("GET", "/coupons/edit/{id}", fn($id) => $coupom->edit($id));
    $router->add("POST", "/coupons/edit/{id}", fn($id) => $coupom->update($id));
    $router->add("GET", "/coupons/delete/{id}", fn($id) => $coupom->delete($id));
    $router->add("POST", "/coupons/store", fn() => $coupom->store());
    $router->add("GET", "/orders", fn() => $order->index());
    $router->add("GET", "/orders/invoice/{code}", fn($code) => $order->invoice($code));
    $router->add("POST", "/api/order/tracking", fn() => $order->tracking());
    $router->render();