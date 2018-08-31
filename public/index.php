<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

// auto load
require __DIR__ . '/../vendor/autoload.php';

session_start();

// setting, later get from container
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// render, logger
require __DIR__ . '/../src/dependencies.php';

// other lib 
require __DIR__ . '/../src/middleware.php';

// routes
require __DIR__ . '/../src/routes.php';

// run
$app->run();
