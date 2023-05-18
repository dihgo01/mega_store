<?php
require '../vendor/autoload.php';
require 'routes/routes.php';
require 'routes/Router.php';

try{
    $router = new Router\Router($routes);

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    $request = $_SERVER['REQUEST_METHOD'];

    $router->verify_request($uri, $request);

}catch(Exception $e){
   echo $e->getMessage(); http_response_code(404); 
}