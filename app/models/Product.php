<?php
// app/models/ProdutoModel.php
namespace App\Models;

use App\Core\Database;

class Product
{
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }
    
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO products (`name`, `price`, `describe`) 
             VALUES (:name, :price, :describe)"
        );
        
        return $stmt->execute($data);
    }
    
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
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