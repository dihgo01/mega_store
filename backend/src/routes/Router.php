<?php

namespace Router;

use Exception;

use Factory\CreateSessionFactory;

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
     * @return modules\Factory
     */
    protected function load($class, $action, $request)
    {
        $classNameSpace = 'Modules\\' . $class;

        if (!class_exists($classNameSpace)) {
            return throw new Exception("Namespace {$classNameSpace} not found.");
        }

        $instance = new $classNameSpace();

        if (!method_exists($instance, $action)) {
            return throw new Exception('No route defined for this URI.');
        }

        return $instance->$action($request);
    }

    /**
     * Load a routes array veriable
     * 
     * @param string $uri
     * @param string $requestType
     * @return $this->load()
     */
    public function verify_request($request)
    {
        if (!isset($this->routes[$request['method']])) {
            return throw new Exception('No http method found.');
        }

        if (!array_key_exists($request['uri'], $this->routes[$request['method']])) {
            return throw new Exception('No route defined for this URI.');
        }

       foreach($this->routes[$request['method']][$request['uri']]['middlewares'] as $middleware){
            if(isset($middleware) && !empty($middleware)){
                $middleware = 'Middlewares\\' . $middleware;
                $instance = new $middleware($request['authorization']);
                $request = $instance->handle($request);
            }
        } 
      
        return $this->load(
            $this->routes[$request['method']][$request['uri']]['class'],
            $this->routes[$request['method']][$request['uri']]['action'],
            $request,
        );
    }
}
