<?php

    namespace App\Models;

    use App\Core\Database;

    class Sku {
        private $db;

        public function __construct()
        {
           $this->db = Database::getInstance();
        }

        public function all(): array {
            $stmt = $this->db->query("SELECT * FROM products LEFT JOIN skus ON skus.product_id = products.id_product LEFT JOIN inventories ON inventories.id_inventory = skus.inventory_id");
            return $stmt->fetchAll();
        }

        public function getById($id): array | bool
        {
            $stmt = $this->db->prepare("SELECT * FROM skus INNER JOIN inventories ON skus.inventory_id = inventories.id_inventory WHERE id_sku = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        }

        public function getByIdProduct(int $id): array
        {
            $stmt = $this->db->prepare("SELECT * FROM products LEFT JOIN skus ON skus.product_id = products.id_product LEFT JOIN inventories ON inventories.id_inventory = skus.inventory_id WHERE id_product = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll() ?: null;
        }

        public function create(array $data): bool | int {

            $stmt = $this->db->prepare(
                "INSERT INTO skus (`product_id`, `sku_name`, `sku_price`, `sku_describe`, `sku_image`, `inventory_id`)
                VALUES (:product_id, :name, :price, :describe, :image, :inventory_id)"
            );
            
            if ($stmt->execute($data)) {
                return (int) $this->db->lastInsertId();
            }

            return false;
        }

        public function update(array $data): bool
        {
            $stmt = $this->db->prepare("UPDATE skus SET `sku_name` = :name, `sku_describe` = :describe, `sku_price` = :price, `sku_image` = :image WHERE id_sku = :id ");
            if( $stmt->execute($data) ){
                return true;
            }

            return false;
        }

        public function delete($id): bool
        {
            $stmt = $this->db->prepare("DELETE FROM skus WHERE id_sku = :id");
            if( $stmt->execute(['id' => $id]) ){
                return true;
            }

            return false;
        }
    }