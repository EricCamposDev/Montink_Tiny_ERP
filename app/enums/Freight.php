<?php

    namespace App\Enums;

    enum Freight: string {
        case FREE = 'Frete Grátis';
        case ESPECIAL = 'Frete Especial';
        case CONVENTIONAL = 'Frete Convencional';

        // Propriedade com valor de frete
        public function freightValue(): float {
            return match($this) {
                self::FREE => 0.0,
                self::ESPECIAL => 15.00,
                self::CONVENTIONAL => 20.00,
            };
        }

        public static function calculate(float $valueOrder): self {
            if ($valueOrder >= 200) {
                return self::FREE;
            } elseif ($valueOrder >= 52 && $valueOrder <= 166.59) {
                return self::ESPECIAL;
            } else {
                return self::CONVENTIONAL;
            }
        }
    }  
