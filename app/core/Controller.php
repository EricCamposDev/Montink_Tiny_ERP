<?php
namespace App\Core;

abstract class Controller {
    protected function view(string $view, array $data = []) {
        extract($data);
        require __DIR__ . "/../views/pages/{$view}.php";
    }
    
    protected function redirect(string $url) {
        header("Location: {$url}");
        exit();
    }
    
    protected function jsonResponse(array $data, int $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}