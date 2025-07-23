<?php

    namespace App\Controllers;

    use App\Core\Controller;

    class DashboardController extends Controller
    {
        public function index(): void
        {
            $this->view("dashboard/index");
        }
    }