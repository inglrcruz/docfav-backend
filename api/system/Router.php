<?php

/**
 * The Router class for handling HTTP route management and dispatching to controllers.
 *
 * This class allows you to define routes for different HTTP methods (GET, POST, PUT, DELETE) and associate them with
 * specific controller methods. It also provides the ability to dispatch incoming requests to the appropriate controller
 * method based on the requested route.
 */

namespace System;

class Router
{
    protected $routes = [];

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }

    /**
     * Adds a route for handling GET requests.
     *
     * @param string $path The route path
     * @param string $controller The controller to be called for the route
     */
    public function get($path, $controller)
    {
        $this->routes['GET'][$path] = $controller;
    }

    /**
     * Adds a route for handling POST requests.
     *
     * @param string $path The route path
     * @param string $controller The controller to be called for the route
     */
    public function post($path, $controller)
    {
        $this->routes['POST'][$path] = $controller;
    }

    /**
     * Adds a route for handling PUT requests.
     *
     * @param string $path The route path
     * @param string $controller The controller to be called for the route
     */
    public function put($path, $controller)
    {
        $this->routes['PUT'][$path] = $controller;
    }

    /**
     * Adds a route for handling DELETE requests.
     *
     * @param string $path The route path
     * @param string $controller The controller to be called for the route
     */
    public function delete($path, $controller)
    {
        $this->routes['DELETE'][$path] = $controller;
    }

    /**
     * Dispatches the HTTP request to the appropriate controller based on the route.
     */
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        foreach ($this->routes[$method] as $route => $controller) {
            $pattern = preg_replace('/\{([^\/]+)\}/', '([^/]+)', $route);
            if (preg_match("#^$pattern$#", $path, $matches)) {
                $this->callController($controller, $matches);
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    /**
     * Calls the specified controller's method.
     *
     * @param string $controller The controller to be called
     * @param array $matches An array of route parameter matches
     */
    protected function callController($controller, $matches)
    {
        list($class, $method) = explode('@', $controller);
        $controllerInstance = new $class();
        $controllerInstance->$method((!empty($matches[1])) ? $matches[1] : "");
    }
}
