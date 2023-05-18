<?php

namespace Router;

use Exception;

class Router
{
    protected $routes = [];

    /**
     * Constructor
     * 
     * @param array $routes
     */
    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    /**
     * Load a routes array veriable
     * 
     * @param string $action
     * @param string $class
     * @return Controller
     */
    protected function load($class, $action)
    {
        $classNameSpace = 'Controllers\\' . $class;

        if (!class_exists($classNameSpace)) {
            return throw new Exception("Namespace {$classNameSpace} not found.");
        }

        $instance = new $classNameSpace();

        if (!method_exists($instance, $action)) {
            return throw new Exception('No route defined for this URI.');
        }

        return $instance->$action();
    }

    /**
     * Load a routes array veriable
     * 
     * @param string $uri
     * @param string $requestType
     * @return $this->load()
     */
    public function verify_request($uri, $requestType)
    {
        if (!isset($this->routes[$requestType])) {
            return throw new Exception('No http method found.');
        }

        if (!array_key_exists($uri, $this->routes[$requestType])) {
            return throw new Exception('No route defined for this URI.');
        }
        return $this->load(
            $this->routes[$requestType][$uri]['class'],
            $this->routes[$requestType][$uri]['action']
        );
    }
}
