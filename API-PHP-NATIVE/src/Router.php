<?php
class Router {
    private $routes = [];

    public function add($method, $route, $callback) {
        $this->routes[] = compact('method', 'route', 'callback');
    }

    public function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $r) {
            if ($r['method'] === $method && preg_match("#^{$r['route']}$#", $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($r['callback'], $matches);
            }
        }

        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Route not found", "uri" => $uri, "method" => $method]);
    }
}
?>
