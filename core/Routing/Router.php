<?php

namespace Core\Routing;

use Core\Routing\Route;

class Router
{

    private static array $routes = [];

    public static function add(string $method, string $uri, callable $action)
    {
        self::$routes[] = new Route($method, $uri, \Closure::fromCallable($action));
    }

    public static function get(string $uri, callable $action)
    {
        self::add("GET", $uri, $action);
    }

    public static function post(string $uri, callable $action)
    {
        self::add("POST", $uri, $action);
    }

    public static function find($method, $uri): Route|false
    {
        [ $path ] = explode('?', $uri);

        foreach (self::$routes as $route)
        {
            if ($route->match($path) && $route->method === $method)
            {
                return $route;
            }
        }

        return false;
    }


}