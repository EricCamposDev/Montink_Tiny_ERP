<?php


    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\Sku;

    class StoreController extends Controller
    {
        private $skuRepository;

        public function __construct()
        {
            $this->skuRepository = new Sku();
        }

        public function index(): void
        {
            $products = $this->skuRepository->all();
            $this->view("store/index", ['products' => $products]);
        }
    }