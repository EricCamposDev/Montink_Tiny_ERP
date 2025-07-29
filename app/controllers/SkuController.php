<?php

    namespace App\Controllers;

    use App\Core\Controller;
    use App\Core\Notify;
    use App\Models\Sku;
    use App\Models\Product as ProductModel;
    use App\Models\Inventory as InventoryModel;
    use App\Core\UI;
    use Exception;

    class SkuController extends Controller
    {
        private $productRepository;
        private $inventoryRepository;
        private $repository;
        public function __construct()
        {
            $this->repository = new Sku();
            $this->productRepository = new ProductModel();
            $this->inventoryRepository = new InventoryModel();
        }

        public function index($id)
        {
            $id_product = (int) UI::decrypt($id);
            $product = $this->repository->getByIdProduct($id_product);
            $this->view("skus/index", ['skus' => $product]);
        }

        public function edit($id)
        {
            $sku = $this->repository->getById(UI::decrypt($id));
            $this->view("skus/update", ['sku_edit' => $sku]);
        }

        public function update()
        {
            try {

                $this->inventoryRepository->update([
                    'id' => UI::decrypt($_POST['inventory_id']), 
                    'quantity' => $_POST['quantity']
                ]);
                
                $this->repository->update([
                    'id' => UI::decrypt($_POST['id_sku']),
                    'name' => $_POST['name'], 
                    'price' => UI::currencyToFloat($_POST['price']), 
                    'describe' => $_POST['describe'], 
                    'image' => $_POST['image']
                ]);

                Notify::add([
                    'request' => true,
                    'sttausCode' => 200,
                    'message' => 'SKU atualizado..',
                    'metadata' => ''
                ]);

            } catch(Exception $e) {

                Notify::add([
                    'request' => false,
                    'sttausCode' => 200,
                    'message' => 'Falha ao atualizar SKU.',
                    'metadata' => json_encode($e)
                ]);
            }

            $this->redirect("/products/skus/manager/" . $_POST['product_id']);
        }

        public function create(string $id): void
        {
            $product = $this->productRepository->getById(UI::decrypt($id));
            if( !$product ){
                $this->redirect("/404");
            }

            $this->view("skus/create", ['id_product' => $id, 'product_name' => $product['product_name']]);
        }

        public function store()
        {
            if( !UI::hasPost(['name', 'describe', 'price', 'image', 'quantity', 'product_id']) ){
                $this->redirect("/products/skus/create/" . $_POST["product_id"]."?error=invalid_inputs");
            }

            try {

                $id_inventory = $this->inventoryRepository->create($_POST['quantity']);
                unset($_POST['quantity']);

                $_POST['price'] = UI::currencyToFloat($_POST['price']);
                $_POST['inventory_id'] = $id_inventory;
                $_POST['product_id'] = UI::decrypt($_POST['product_id']);

                $this->repository->create($_POST);

                Notify::add([
                    'request' => true,
                    'sttausCode' => 201,
                    'message' => 'SKU registrado.',
                    'metadata' => ''
                ]);

            }catch(Exception $e){

                Notify::add([
                    'request' => false,
                    'statusCode' => 200,
                    'message' => 'SKU registrado.',
                    'metadata' => json_encode($e)
                ]);
            }

            $this->redirect("/products/skus/manager/" . UI::encrypt($_POST['product_id']));
        }

        public function delete($id)
        {
            if( $this->repository->delete(UI::decrypt($id)) ){

                Notify::add([
                    "request" => true,
                    "httpCode" => 200,
                    "message" => "SKU Deletado.",
                    "metadata" => ""
                ]);
            }

            Notify::add([
                "request" => false,
                "httpCode" => 200,
                "message" => "Falha ao deletar SKU.",
                "metadata" => ""
            ]);

            $this->redirect("/products/skus/manager/" . $_POST['uri_response']);
        }
    }