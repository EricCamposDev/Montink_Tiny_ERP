<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Core\Notify;
use App\Core\UI;

class ProductController extends Controller {
    private $model;
    
    public function __construct() {
        $this->model = new Product();
    }
    
    public function index() {
        $products = $this->model->all();
        $this->view('products/index', ['products' => $products]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'describe' => $_POST['describe'] ?? null
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('/products?success=produto_cadastrado');
            }else{
                $this->redirect('/products?failed=produto_nao_cadastrado');
            }
        }
        
        $this->view('products');
    }

    public function store()
    {
        if(UI::hasPost(['name','describe'])){

            if ($this->model->create($_POST)) {
                Notify::add([
                    'request' => true,
                    'statusCode' => 201,
                    'message' => $_POST['name'] . ' registrado.',
                    'metadata' => ''
                ]);

                $this->redirect("/products");
            }
        }

        Notify::add([
            'request' => false,
            'statusCode' => 200,
            'message' => $_POST['name'] . ' não foi registrado.',
            'metadata' => ''
        ]);

        $this->redirect("/products");
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = UI::decrypt($_POST['product_id']);
            if( $this->model->destroy($id) ){
                $this->redirect('/products?success=produto_deletado');
            }
        }

        $this->redirect('/products?failed=produto_nao_deletado');
    }
}