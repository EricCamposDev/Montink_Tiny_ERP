<?php


namespace App\Core;

use Datetime;

class Cart
{
    private static function init(): void
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [
                'start' => date('Y-m-d H:i:s'),
                'discount' => [],
                'freight' => [],
                'items' => [],
                'totals' => [
                    'subtotal' => 0,
                    'skus' => 0,
                    'products' => 0,
                    'freight' => 0,
                    'discount' => 0,
                    'total' => 0
                ]
            ];
        }
    }

    private static function recalc(): void
    {
        $sku = 0;
        $sub = 0;
        foreach ($_SESSION['cart']['items'] as $item) {
            $sku += $item['item_quantity'];
            $sub += $item['item_quantity'] * $item['item_value'];
        }

        $_SESSION['cart']['totals']['skus'] = $sku;
        $_SESSION['cart']['totals']['subtotal'] = $sub;

        $_SESSION['cart']['totals']['products'] = count($_SESSION['cart']['items']);
        $_SESSION['cart']['totals']['freight'] = $_SESSION['cart']['freight']['value'] ?? 0;
        $_SESSION['cart']['totals']['total'] = $_SESSION['cart']['totals']['subtotal'] - $_SESSION['cart']['totals']['discount'] - $_SESSION['cart']['totals']['freight'];
    }

    public static function add($item, $quantity)
    {
        Cart::init();

        $key = $item['id_sku'] ?? $item['meta-2'];

        if (!isset($_SESSION['cart']['items'][$key])) {

            $_SESSION['cart']['items'][$key] = [
                'id_product' => $item['id_product'] ?? $item['meta-1'],
                'id_sku' => $item['id_sku'] ?? $item['meta-2'],
                'item_image' => $item['sku_image'] ?? $item['meta-3'],
                'item_name' => $item['meta-4'] ?? ($item['product_name'] . ' - ' . $item['sku_name']),
                'item_value' => $item['sku_price'] ?? $item['meta-5'],
                'item_quantity' => $quantity
            ];

        } else {
            $_SESSION['cart']['items'][$key]['item_quantity'] += $quantity;
        }

        Cart::recalc();
    }

    public static function remove($id_sku)
    {
        Cart::init();

        unset($_SESSION['cart']['items'][$id_sku]);

        Cart::recalc();
    }

    public static function all()
    {
        return @$_SESSION['cart'] ?? null;
    }

    public static function freight(): array|null
    {
        if (isset($_SESSION['cart']) and !empty($_SESSION['cart']['freight'])) {
            return $_SESSION['cart']['freight'];
        }

        return null;
    }

    public static function discount()
    {
        if (isset($_SESSION['cart']) and !empty($_SESSION['cart']['discount'])) {
            return $_SESSION['cart']['discount'];
        }

        return null;
    }

    public static function addFreight($zipcode, $address, $method, $value): void
    {
        $_SESSION['cart']['freight'] = [
            'zipcode' => $zipcode,
            'address' => $address,
            'method' => $method,
            'value' => $value
        ];

        $_SESSION['cart']['totals']['freight'] = $value;
        Cart::recalc();
    }

    public static function addCoupon($coupon): array
    {
        $cart = Cart::insights();

        $criterias_to_apply = true;
        $criterias_failed_response = [];

        if ($coupon['coupon_rule_min_quantity']) {
            if ($cart['totals']['skus'] < $coupon['coupon_rule_min_quantity']) {
                $criterias_to_apply = false;
                $criterias_failed_response[] = 'a quantidade de itens deve ser igual ou superior a ' . $coupon['coupon_rule_min_quantity'] . ', quantidade atual: ' . $cart['totals']['skus'];
            }
        }

        if ($coupon['coupon_rule_min_value']) {
            if ($cart['subtotal'] < $coupon['coupon_rule_min_value']) {
                $criterias_to_apply = false;
                $criterias_failed_response[] = 'o valor minimo da compra deve ser R$ ' . number_format($coupon['coupon_rule_min_value'], 2) . ', valor atual: R$ ' . number_format($cart['totals']['subtotal'], 2);
            }
        }

        if ($criterias_to_apply) {

            if ($coupon['coupon_rule_method_discount'] == 'percent') {
                $value_discout = (float) ($cart['subtotal'] * $coupon['coupon_rule_value_discount']) / 100;
            } elseif ($coupon['coupon_rule_method_discount'] == 'value') {
                $value_discout = $coupon['coupon_rule_value_discount'];
            }

            $_SESSION['cart']['discount'] = $coupon;
            $_SESSION['cart']['totals']['discount'] = $value_discout;

            return [
                'error' => false,
                'value' => $value_discout,
                'message' => "desconto de R$ " . number_format($value_discout, 2) . " aplicado."
            ];

        } else {
            return [
                'error' => true,
                'value' => 0,
                'message' => implode('<br>', $criterias_failed_response)
            ];
        }
    }

    public static function insights()
    {
        Cart::init();
        Cart::recalc();

        if (isset($_SESSION['cart'])) {
            return $_SESSION['cart']['totals'];
        }

        return null;
    }

    public static function destroy(): void
    {
        unset($_SESSION['cart']);
    }

    public static function couponIsNotExpired($expireAt)
    {
        $expire = new DateTime($expireAt);
        $now = new DateTime();
        return $expire >= $now;
    }

    public static function storage($order_code): void {
        $path = __DIR__ . "/../storage/data/cart" . $order_code . ".json";
        file_put_contents($path, json_encode(Cart::all()));
    }
}