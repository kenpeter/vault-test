<?php
// request
use \Psr\Http\Message\ServerRequestInterface as Request;
// res
use \Psr\Http\Message\ResponseInterface as Response;

// autoload
require 'vendor/autoload.php';

// slim app
$app = new \Slim\App;

// hit hi
// callback, req, res, args (in url)
$app->get('/hi/{name}/{extra}', function (Request $request, Response $response, array $args) {
	// name
	$name = $args['name'];
	$extra = $args['extra'];

	// get body and write
	$res = $name. " | ". $extra;
    $response->getBody()->write("Hello, $res");

	// return res
    return $response;
});

// run it
$app->run();
