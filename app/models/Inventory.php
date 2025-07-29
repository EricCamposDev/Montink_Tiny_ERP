<?php

    namespace App\Models;

    use App\Core\Database;

    class Inventory {
        private $db;

        public function __construct()
        {
           $this->db = Database::getInstance();
        }

        public function create(int $quantity): bool | int {

            $stmt = $this->db->prepare(
                "INSERT INTO inventories (`inventory_quantity`)
                VALUES (:quantity)"
            );
            
            if ($stmt->execute(['quantity' => $quantity])) {
                return (int) $this->db->lastInsertId();
            }

            return false;
        }

        public function update(array $data):bool
        {
            $stmt = $this->db->prepare("UPDATE inventories SET `inventory_quantity` = :quantity WHERE id_inventory = :id");
            if( $stmt->execute($data)){
                return true;
            }

            return false;
        }

        public function delete($id): bool
        {
            $stmt = $this->db->prepare("DELETE FROM inventories WHERE id_inventory = :id");
            if( $stmt->execute($id) ){
                return true;
            }

            return false;
        }

        public function getById(int $id): array | null
        {
            $stmt = $this->db->prepare("SELECT * FROM inventories WHERE id_inventory = :id LIMIT 1");
            if( $stmt->execute(['id' => $id]) ){
                return $stmt->fetch();
            }

            return null;
        }
    }