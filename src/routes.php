<?php

// request
use Slim\Http\Request;
// res
use Slim\Http\Response;

// {name}, var
// [], optional
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // log serivce 
    $this->logger->info("Slim-Skeleton '/' route");

	// test
	$dbClient = $this->dbClient; 

    // render service 
    return $this->renderer->render($response, 'index.phtml', $args);
});
