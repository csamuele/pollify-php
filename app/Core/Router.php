<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|string $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|string $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo '<h1>404 Not Found</h1>';
            return;
        }

        $handler = $this->routes[$method][$path];

        if (is_callable($handler)) {
            $handler();
            return;
        }

        if (is_string($handler)) {
            $this->dispatchController($handler);
            return;
        }

        http_response_code(500);
        echo '<h1>Invalid route handler</h1>';
    }

    private function dispatchController(string $handler): void
    {
        [$controllerName, $methodName] = explode('@', $handler);

        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "<h1>Controller not found: {$controllerName}</h1>";
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            http_response_code(500);
            echo "<h1>Method not found: {$methodName}</h1>";
            return;
        }

        $controller->$methodName();
    }
}