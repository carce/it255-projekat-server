<?php

class Router {
    private $routes = array();
    private $authFunc;

    public function __construct(Closure $authFunc) {
        $this->authFunc = $authFunc;
    }

    public function addRoute(String $method, String $route, bool $needsAuth, Closure $func) {
        $authFunc = $this->authFunc;
        $this->routes[strtoupper($method) . " " . $route] = function() use ($needsAuth, $func, $authFunc) {
            if (!$needsAuth || (isset($_SERVER['HTTP_TOKEN']) && $authFunc($_SERVER['HTTP_TOKEN']))) {
                return $func();
            }
            else {
                http_response_code(403);
                return json_encode(array(
                    'error' => 'User is not authenticated'
                ));
            }

        };
    }

    public function run() {
        $current_route = $_SERVER['REQUEST_METHOD'] . ' ' . strtok($_SERVER['REQUEST_URI'], '?');

        if (isset($this->routes[$current_route])) {
            return $this->routes[$current_route]();
        }
        else {
            return '404 Page Not Found';
        }
    }
}