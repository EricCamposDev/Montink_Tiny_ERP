<?php


    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\Coupon;
    use App\Core\Cart;
    use App\Enums\Freight;

    class CartIOController extends Controller
    {
        private $couponRepository;
        public function __construct()
        {
            $this->couponRepository = new Coupon();
        }
        public function addItem()
        {
            Cart::add($_POST['cart'], 1);
            return json_encode(Cart::insights(), true);
        }

        public function clear(): void
        {
            Cart::destroy();
            $this->redirect("/store");
        }

        public function removeCoupon()
        {
            $_SESSION['cart']['discount'] = [];
            $_SESSION['cart']['totals']['discount'] = 0;
            $this->redirect("/checkout");
        }

        public function applyFreight()
        {
            $totals = Cart::insights();
            $freight = Freight::calculate($totals['subtotal']);

            Cart::addFreight($_POST['zipcode'], $_POST['address'], $freight->value, $freight->freightValue());
            
            return $this->jsonResponse([
                'method' => $freight->value,
                'value' => $freight->freightValue()
            ]);

        }

        public function applyCoupon()
        {
            $cart = Cart::all();
            $coupon = $this->couponRepository->getByCode($_POST['code']);

            if( !$coupon ){
                return $this->jsonResponse([
                    'error' => true,
                    'message' => 'Cupom inválido.'
                ]);
            }

            if( !Cart::couponIsNotExpired($coupon['coupon_expire_at']) ){
                return $this->jsonResponse([
                    'error' => true,
                    'message' => 'Cupom Expirado.'
                ]);
            }

            $apply = Cart::addCoupon($coupon);

            // return $this->jsonResponse($cart);
            return $this->jsonResponse($apply);
        }
    }