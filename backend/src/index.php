<?php
require '../vendor/autoload.php';
require 'routes/routes.php';
require 'routes/Router.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
try{
    $router = new Router\Router($routes);

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    $method = $_SERVER['REQUEST_METHOD'];

    $body = $_REQUEST;

    $request = [
        'uri' => $uri,
        'method' => $method,
        'body' => $body,
        'authorization' => isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : null
    ];

    $router->verify_request($request);

}catch(Exception $e){
    http_response_code(404);

    $response = [
        'message' => $e->getMessage(),
    ];

    echo json_encode($response); 
}