<?php


    namespace App\Models;

    use App\Core\Database;

    class Order
    {
        private $db;

        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function all(): array
        {
            $stmt = $this->db->query("SELECT * FROM orders ORDER BY order_created_in DESC");
            return $stmt->fetchAll();
        }

        public function getByCode(string $code): array|null
        {
            $stmt = $this->db->prepare("SELECT * FROM orders INNER JOIN order_items ON orders.id_order = order_items.order_id INNER JOIN skus ON order_items.sku_id = skus.id_sku INNER JOIN products ON skus.product_id = products.id_product WHERE order_code = :code");
            $stmt->execute(['code' => $code]);
            return $stmt->fetchAll() ?: null;
        }

        public function create($order): bool|string 
        {
            $stmt = $this->db->prepare("INSERT INTO orders (
                order_client_name, 
                order_client_email, 
                coupon_id, 
                order_code, 
                order_total_discount, 
                order_total_freight, 
                order_value_total, 
                order_status
            ) VALUES(
                :order_client_name, 
                :order_client_email, 
                :coupon_id, 
                :order_code, 
                :order_total_discount, 
                :order_total_freight, 
                :order_value_total, 
                :order_status
            )
            ");
            if( $stmt->execute($order) ){
                return $this->db->lastInsertId();
            }

            return false;
        }

        public function createItem(array $item): bool | int
        {
            $stmt = $this->db->prepare("INSERT INTO order_items(order_id, sku_id, order_item_quantity) VALUES (:order_id, :sku_id, :order_item_quantity)");
            if( $stmt->execute($item) ){
                return $this->db->lastInsertId();
            }

            return false;
        }

        public function delete($id): bool|null
        {
            $stmt = $this->db->prepare("DELETE FROM orders WHERE id_order = :id");
            return $stmt->execute(['id' => $id]) ?: null;
        }

        public function changeStatus($id, $status)
        {
            $stmt = $this->db->prepare("UPDATE orders SET order_status = :status WHERE id_order = :id");
            return $stmt->execute(['id' => $id, 'status' => $status]) ?: null;
        }
    }