<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Core\Notify;
use App\Core\UI;

class ProductController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = new Product();
    }

    public function index()
    {
        $products = $this->repository->all();
        $this->view('products/index', ['products' => $products]);
    }

    public function create()
    {
        $this->view('products');
    }

    public function store()
    {
        if (UI::hasPost(['name', 'describe'])) {

            if ($this->repository->create($_POST)) {
                Notify::add([
                    'request' => true,
                    'statusCode' => 201,
                    'message' => $_POST['name'] . ' registrado.',
                    'metadata' => ''
                ]);
            } else {

                Notify::add([
                    'request' => false,
                    'statusCode' => 400,
                    'message' => $_POST['name'] . ' não foi registrado.',
                    'metadata' => ''
                ]);
            }
        }


        $this->redirect("/products");
    }

    public function update($id)
    {
        $_POST['id'] = UI::decrypt($id);
        if ($this->repository->update($_POST)) {
            Notify::add([
                'request' => true,
                'statusCode' => 200,
                'message' => $_POST['name'] . ' atualizado.',
                'metadata' => ''
            ]);
        } else {
            Notify::add([
                'request' => false,
                'statusCode' => 400,
                'message' => $_POST['name'] . ' não atualizado.',
                'metadata' => ''
            ]);
        }

        $this->redirect("/products");
    }

    public function delete($id): void
    {
        $id = UI::decrypt($id);
        if ($this->repository->destroy($id)) {
            Notify::add([
                'request' => true,
                'statusCode' => 200,
                'message' => 'Produto deletado.',
                'metadata' => ''
            ]);
        } else {
            Notify::add([
                'request' => false,
                'statusCode' => 400,
                'message' => 'Falha ao deletar produto.',
                'metadata' => ''
            ]);
        }

        $this->redirect('/products');
    }
}