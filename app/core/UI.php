<?php

    namespace App\Core;

    class UI
    {
        static function currencyToFloat($valor): float
        {
            $valor = preg_replace('/[^\d,]/', '', $valor);

            // Substitui vírgula por ponto
            $valor = str_replace(',', '.', $valor);

            // Verifica se é um número válido antes de converter
            return is_numeric($valor) ? (float) $valor : 0.0;
        }

        static function encrypt($value): string
        {
            return base64_encode(APP_KEY.":".$value);
        }

        static function decrypt($hash): string
        {
            $data = base64_decode($hash);
            return explode(":", $data)[1];
        }
    }