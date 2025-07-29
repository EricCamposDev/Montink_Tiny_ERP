<?php


    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\Coupon;
    use App\Core\Cart;

    class CheckoutController extends Controller 
    {
        public function index(): void 
        {
            $cart = Cart::all();
            $freight = Cart::freight();
            $discount = Cart::discount();

            if($cart == null){
                $this->redirect("/store");
            }

            $insights = cart::insights();

            $this->view("checkout/index", [
                'cart' => $cart, 
                'insights' => $insights, 
                'freight' => $freight,
                'discount' => $discount
            ]);
        }
    }