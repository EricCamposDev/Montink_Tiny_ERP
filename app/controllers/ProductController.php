<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Core\UI;

class ProductController extends Controller {
    private $model;
    
    public function __construct() {
        $this->model = new Product();
    }
    
    public function index() {
        $products = $this->model->getAll();
        $this->view('products/index', ['products' => $products]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'price' => UI::currencyToFloat($_POST['price']),
                'describe' => $_POST['describe'] ?? null
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('/products/create?success=produto_cadastrado');
            }else{
                $this->redirect('/products/create?failed=produto_nao_cadastrado');
            }
        }
        
        $this->view('products/create');
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
    
    // ... outros métodos (edit, update, delete)
}