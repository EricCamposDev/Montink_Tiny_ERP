<?php

    namespace App\Controllers;

    use App\Models\Coupon;
    use App\Core\Notify;
    use APp\Core\UI;
    use App\Core\Controller;


    class CouponController extends Controller
    {
        private $repository;
        public function __construct()
        {
            $this->repository = new Coupon();
        }
        public function index()
        {
            $coupons = $this->repository->all();
            $this->view("coupons/index", ["coupons" => $coupons]);
        }

        public function create()
        {
            $this->view("coupons/create");
        }

        public function edit($id)
        {
            $coupon = $this->repository->getById(UI::decrypt($id));
            if(!$coupon){
                Notify::add([
                    'response' => false,
                    'statusCode' => 200,
                    'message' => 'Cupom não encontrado...',
                    'metadata' => ''
                ]);

                $this->redirect("/coupons");
            }

            $this->view("coupons/edit", ['coupon' => $coupon]);
        }

        public function delete($id)
        {
            if( $this->repository->destroy(UI::decrypt($id)) ){
                Notify::add([
                    'request' => true,
                    'statusCode' => 200,
                    'message' => 'Cupom deletado.',
                    'metadata' => ''
                ]);
            }else{
                Notify::add([
                    'request' => false,
                    'statusCode' => 200,
                    'message' => 'Falha ao deletar cupom.',
                    'metadata' => ''
                ]);
            }

            $this->redirect("/coupons");
        }

        public function store()
        {
            unset($_POST['rule_method']);

            $_POST['code'] = strtoupper($_POST['code']);

            if( !isset($_POST['rule_min_value']) or $_POST['rule_min_value'] == null ){
                $_POST['rule_min_value'] = 0;
            }else{
                $_POST['rule_min_value'] = UI::currencyToFloat($_POST['rule_min_value']);
            }

            if( !isset($_POST['rule_min_quantity']) or $_POST['rule_min_quantity'] == null ){
                $_POST['rule_min_quantity'] = 0;
            }

            if( $_POST['discount_method'] == "value" ){
                $_POST['discount_value'] = UI::currencyToFloat($_POST['discount_value']);
            }

            if(  $this->repository->create($_POST) ){

                Notify::add([
                    'request' => true,
                    'statusCode' => 201,
                    'message' => 'Cupom registrado.',
                    'metadata' => ''
                ]);

            }else {

                Notify::add([
                    'request' => false,
                    'statusCode' => 200,
                    'message' => 'Falha ao registrar cupom',
                    'metadata' => ''
                ]);
            }

            $this->redirect("/coupons");
        }

        public function update($id)
        {
            unset($_POST['rule_method']);

            $_POST['code'] = strtoupper($_POST['code']);

            if( !isset($_POST['rule_min_value']) or $_POST['rule_min_value'] == null ){
                $_POST['rule_min_value'] = 0;
            }else{
                $_POST['rule_min_value'] = UI::currencyToFloat($_POST['rule_min_value']);
            }

            if( !isset($_POST['rule_min_quantity']) or $_POST['rule_min_quantity'] == null ){
                $_POST['rule_min_quantity'] = 0;
            }

            if( $_POST['discount_method'] == "value" ){
                $_POST['discount_value'] = UI::currencyToFloat($_POST['discount_value']);
            }

            $_POST['id'] = UI::decrypt($id);

            if(  $this->repository->update($_POST) ){

                Notify::add([
                    'request' => true,
                    'statusCode' => 200,
                    'message' => 'Cupom atualizado.',
                    'metadata' => ''
                ]);

            }else {

                Notify::add([
                    'request' => false,
                    'statusCode' => 200,
                    'message' => 'Falha ao atualizar cupom',
                    'metadata' => ''
                ]);
            }

            $this->redirect("/coupons");
        }
    }