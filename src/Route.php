<?php

namespace App;

class Route
{
    private static array $routes = [];

    public static function get(string $uri, array $action)
    {
        self::$routes["GET"][$uri] = $action;
    }

    public static function post(string $uri, array $action)
    {
        self::$routes["POST"][$uri] = $action;
    }

    public static function put(string $uri, array $action)
    {
        self::$routes["PUT"][$uri] = $action;
    }

    public static function delete(string $uri, array $action)
    {
        self::$routes["DELETE"][$uri] = $action;
    }
    /**
     * @return array
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }
}