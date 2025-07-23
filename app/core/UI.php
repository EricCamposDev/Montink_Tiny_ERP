<?php

    namespace App\Core;

    use Exception;

    class UI
    {
        public static function currencyToFloat($valor): float
        {
            $valor = preg_replace('/[^\d,]/', '', $valor);

            // Substitui vírgula por ponto
            $valor = str_replace(',', '.', $valor);

            // Verifica se é um número válido antes de converter
            return is_numeric($valor) ? (float) $valor : 0.0;
        }

        public static function encrypt($value): string
        {
            return base64_encode(APP_KEY.":".$value);
        }

        public static function decrypt($hash): string
        {
            $data = base64_decode($hash);
            return explode(":", $data)[1];
        }

        public static function lastSegmentUri($uri = null): string
        {
            if (!$uri) {
                $uri = $_SERVER['REQUEST_URI'];
            }

            $path = parse_url($uri, PHP_URL_PATH);
            $segmentos = explode('/', trim($path, '/'));
            return end($segmentos);

        }

        public static function partial($partial): void
        {
            $path = __DIR__ . './../views/layouts/' . $partial . '.php';
            include $path ?? throw new Exception("File not found");
        }

        public static function thumb($image): string
        {
            $filepath = __DIR__ . '/../../public/images/products/' . $image . '.png';
            return (file_exists($filepath)) ? APP_PATH_INDEX . '/public/images/products/' . $image .'.png' : APP_PATH_INDEX . '/public/images/products/default.png';
        }

        public static function hasPost(array $keys): bool
        {
            foreach($keys as $key){
                if( !in_array($key, array_keys($_POST)) ){
                    return false;
                }
            }

            return true;
        }

        public static function groupProduct(array $productsAndSkus): array
        {
            $output = [];
            $id_product_running = 0;
            $counter_products_with_skus = 0;

            $map_keys = [
                'product' => ['id_product', 'product_name', 'product_describe', 'product_created_in', 'product_updated_in'],
                'skus' => ['sku_name','sku_describe','sku_price','sku_image','sku_created_in','sku_updated_in'],
                'inventory' => ['id_inventory', 'inventory_quantity', 'inventory_created_in', 'inventory_ updated_in']
            ];

            foreach($productsAndSkus as $product){

                $itemSku = [];
                foreach($map_keys['skus'] as $key){
                    if(isset($product[$key])){
                        $itemSku[$key] = $product[$key];
                    }
                }


                if($product['id_product'] != $id_product_running){

                    foreach($map_keys['product'] as $key){
                        if(isset($product[$key])){
                            $output[$counter_products_with_skus][$key] = $product[$key];
                        }
                    }

                    $output[$counter_products_with_skus]['skus'][] = $itemSku;
                    // echo "novo registro<br>";
                    $id_product_running = $product['id_product'];

                    $counter_products_with_skus++;

                }else{
                    // echo "novo sku em registro existente<br>";
                    $output[$counter_products_with_skus]['skus'][] = $itemSku;
                }
            }

            return $output;
        }
    }