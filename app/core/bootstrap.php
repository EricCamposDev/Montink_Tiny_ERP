<?php


session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/UI.php';
require_once __DIR__ . '/Notify.php';
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Database.php';

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Sku.php';
require_once __DIR__ . '/../models/Inventory.php';

require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/SkuController.php';