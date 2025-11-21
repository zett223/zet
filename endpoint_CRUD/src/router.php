<?php
class Router {
    private $routes = [];

    public function add($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function run() {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        
        $basePath = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        if (!empty($basePath) && strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }
        $requestUri = '/' . ltrim($requestUri, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchRoute($route['path'], $requestUri, $params)) {
                $callback = $route['callback'];
                if (is_array($callback)) {
                    call_user_func_array($callback, $params);
                } else {
                    call_user_func($callback, ...$params);
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["message" => "Endpoint not found"]);
    }

    private function matchRoute($pattern, $uri, &$params) {
        $params = [];
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';
        if (preg_match($pattern, $uri, $matches)) {
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $params[$key] = $value;
                }
            }
            return true;
        }
        return false;
    }
}
?>