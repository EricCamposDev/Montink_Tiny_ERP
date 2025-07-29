-- Active: 1753204894979@@127.0.0.1@3306@mk_tiny_erp
DROP TABLE IF EXISTS order_items, inventories, skus, coupons, orders, products;

CREATE TABLE inventories (
  id_inventory INT(8) AUTO_INCREMENT PRIMARY KEY,
  inventory_quantity INT(8) NOT NULL,
  inventory_created_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  inventory_updated_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id_product INT(8) AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  product_describe VARCHAR(255),
  product_created_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  product_updated_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE coupons (
  id_coupon INT(8) AUTO_INCREMENT PRIMARY KEY,
  coupon_name VARCHAR(50) NOT NULL,
  coupon_describe VARCHAR(255),
  coupon_code VARCHAR(10) NOT NULL,
  coupon_quantity INT(8) DEFAULT 0,
  coupon_rule_min_quantity INT(8),
  coupon_rule_min_value FLOAT,
  coupon_rule_method_discount VARCHAR(10),
  coupon_rule_value_discount FLOAT,
  coupon_expire_at TIMESTAMP NULL,
  coupon_created_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  coupon_updated_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id_order INT(8) AUTO_INCREMENT PRIMARY KEY,
  coupon_id INT(8),
  order_code VARCHAR(14) UNIQUE,
  order_client_name VARCHAR(100),
  order_client_email VARCHAR(100),
  order_total_discount FLOAT DEFAULT 0,
  order_total_freight FLOAT DEFAULT 0,
  order_value_total FLOAT DEFAULT 0,
  order_status VARCHAR(20) NOT NULL,
  order_created_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  order_updated_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE skus (
  id_sku INT(8) AUTO_INCREMENT PRIMARY KEY,
  product_id INT(8) NOT NULL,
  sku_name VARCHAR(255) NOT NULL,
  sku_describe VARCHAR(255),
  sku_price FLOAT DEFAULT 0,
  sku_image INT(1),
  inventory_id INT(8),
  sku_created_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  sku_updated_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id_product)  ON DELETE CASCADE,
  FOREIGN KEY (inventory_id) REFERENCES inventories(id_inventory)
);

CREATE TABLE order_items (
  id_order_item INT(8) AUTO_INCREMENT PRIMARY KEY,
  order_id INT(8) NOT NULL,
  sku_id INT(8) NOT NULL,
  order_item_quantity INT(8) DEFAULT 0,
  order_item_created_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  order_item_updated_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id_order),
  FOREIGN KEY (sku_id) REFERENCES skus(id_sku) ON DELETE CASCADE
);