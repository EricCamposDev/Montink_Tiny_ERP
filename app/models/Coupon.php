<?php

    namespace App\Models;

    use App\Core\Database;

    class Coupon
    {
        private $db;

        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function all()
        {
            $stmt = $this->db->query("SELECT * FROM coupons");
            return $stmt->fetchAll();
        }

        public function getById($id): array | null
        {
            $stmt = $this->db->prepare("SELECT * FROM coupons WHERE id_coupon = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch() ?: null;
        }

        public function getByCode(string $code): array | null
        {
            $stmt = $this->db->prepare("SELECT * FROM coupons WHERE coupon_code = :code  LIMIT 1");
            $stmt->execute(['code' => $code]);
            return $stmt->fetch() ?: null;
        }

        public function create(array $data): bool | int
        {
            $stmt = $this->db->prepare("INSERT INTO coupons (
                `coupon_name`, 
                `coupon_code`, 
                `coupon_quantity`,
                `coupon_expire_at`,
                `coupon_describe`, 
                `coupon_rule_min_value`,
                `coupon_rule_min_quantity`,
                `coupon_rule_method_discount`, 
                `coupon_rule_value_discount`
            ) VALUES (
                :name, 
                :code, 
                :quantity,
                :expire_at,
                :describe,
                :rule_min_value,
                :rule_min_quantity,
                :discount_method, 
                :discount_value
            )");

            if ($stmt->execute($data)) {
                return (int) $this->db->lastInsertId();
            }

            return false;
        }

        public function update($data)
        {
            $stmt = $this->db->prepare("UPDATE coupons SET coupon_name = :name, coupon_code = :code, coupon_quantity = :quantity, coupon_expire_at = :expire_at, coupon_describe = :describe, coupon_rule_min_value = :rule_min_value, coupon_rule_min_quantity = :rule_min_quantity, coupon_rule_method_discount = :discount_method, coupon_rule_value_discount = :discount_value WHERE id_coupon = :id");
            return $stmt->execute($data) ?: null;
        }

        public function destroy(int $id): bool 
        {
            $stmt = $this->db->prepare("DELETE FROM coupons WHERE id_coupon = :id");
            if( $stmt->execute(['id' => $id]) ){
                return true;
            }

            return false;
        }
    }