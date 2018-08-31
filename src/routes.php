<?php

// request
use Slim\Http\Request;
// res
use Slim\Http\Response;

// {name}, var
// [], optional
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // write to log 
    $this->logger->info("Slim-Skeleton '/' route");

    // response, html, args into it 
    return $this->renderer->render($response, 'index.phtml', $args);
});
