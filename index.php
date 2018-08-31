<?php
// request
use \Psr\Http\Message\ServerRequestInterface as Request;
// res
use \Psr\Http\Message\ResponseInterface as Response;

// autoload
require 'vendor/autoload.php';

$config = include_once 'config/config.php';

// slim app
$app = new \Slim\App(['settings' => $config]);




$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Home page");
    return $response;
});

// run it
$app->run();
