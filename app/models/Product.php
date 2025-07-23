<?php


namespace App\Models;

use App\Core\Database;

class Product
{
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all(): array {
        $stmt = $this->db->query("SELECT products.* , COUNT(skus.id_sku) AS total_skus FROM products LEFT JOIN skus ON skus.product_id = products.id_product GROUP BY products.id_product, products.product_name;");
        return $stmt->fetchAll();
    }
    
    public function create(array $data): bool | int {
        $stmt = $this->db->prepare(
            "INSERT INTO products (`product_name`, `product_describe`)
             VALUES (:name, :describe)"
        );
        
        if ($stmt->execute($data)) {
            return (int) $this->db->lastInsertId();
        }

        return false;
    }
    
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM products LEFT JOIN skus ON skus.product_id = products.id_product LEFT JOIN inventories ON inventories.id_inventory = skus.inventory_id WHERE id_product = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    
    public function destroy(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        if( $stmt->execute(['id' => $id]) ){
            return true;
        }
        return false;
    }
}