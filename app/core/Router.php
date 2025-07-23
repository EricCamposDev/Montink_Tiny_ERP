<?php
    class Router {
    private $routes = [];

    public function add(string $method, string $pattern, callable $callback) {
        $this->routes[] = [
        'method' => strtoupper($method),
        'pattern' => $this->convertPattern($pattern),
        'callback' => $callback,
        'original' => $pattern
        ];
    }

    public function dispatch(string $uri, string $method) {
        foreach ($this->routes as $route) {
        if ($route['method'] !== strtoupper($method)) continue;

        if (preg_match($route['pattern'], $uri, $matches)) {
            array_shift($matches); // remove full match
            return call_user_func_array($route['callback'], $matches);
        }
        }

        http_response_code(404);
        echo "404 - Rota não encontrada";
    }

    private function convertPattern(string $pattern): string {
        $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $pattern);
        return '#^' . $pattern . '$#';
    }

    public function render()
    {
        $resultado = $this->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        if ($resultado) echo $resultado;
    }
}
