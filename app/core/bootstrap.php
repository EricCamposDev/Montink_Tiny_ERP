<?php


@session_start();

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . '/../config/config.php';

require_once __DIR__ . '/UI.php';
require_once __DIR__ . '/Cart.php';
require_once __DIR__ . '/Mail.php';
require_once __DIR__ . '/Notify.php';
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Database.php';

require_once __DIR__ . '/../traits/DatabaseSetupTrait.php';

require_once __DIR__. '/../enums/Freight.php';
require_once __DIR__. '/../enums/OrderStatus.php';

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Sku.php';
require_once __DIR__ . '/../models/Inventory.php';
require_once __DIR__ . '/../models/Coupon.php';
require_once __DIR__ . '/../models/Order.php';

require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/SkuController.php';
require_once __DIR__ . '/../controllers/StoreController.php';
require_once __DIR__ . '/../controllers/CartIOController.php';
require_once __DIR__ . '/../controllers/CheckoutController.php';
require_once __DIR__ . '/../controllers/CouponController.php';
require_once __DIR__ . '/../controllers/OrderController.php';