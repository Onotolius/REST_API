<?php

namespace App;

use App\Controller;

class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function dispatch(string $uri, string $method)
    {
        if (isset($this->routes[$method][$uri])) {
            [$controller, $action] = $this->routes[$method][$uri];

            if (!class_exists($controller)) {
                return (new Controller())->notFound();
            }

            $controllerInstance = new $controller();

            if (!method_exists($controllerInstance, $action)) {
                return (new Controller())->notFound();
            }

            return $controllerInstance->$action();
        }
        foreach ($this->routes[$method] as $routeUri => $handler) {
            if (str_contains($routeUri, '{id}')) {
                $pattern = '#^' . preg_replace('/\{id\}/', '(\d+)', $routeUri) . '$#';
                if (preg_match($pattern, $uri, $matches)) {
                    [$controller, $action] = $handler;

                    if (!class_exists($controller)) {
                        return (new Controller())->notFound();
                    }

                    $controllerInstance = new $controller();

                    if (!method_exists($controllerInstance, $action)) {
                        return (new Controller())->notFound();
                    }
                    return $controllerInstance->$action((int)$matches[1]);
                }
            }
        }
        return (new Controller())->notFound();
    }
}