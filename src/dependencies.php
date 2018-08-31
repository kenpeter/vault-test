<?php
// DIC configuration

// container
$container = $app->getContainer();

// assign func to var 
$container['renderer'] = function ($c) {
	// $c is config

    $settings = $c->get('settings')['renderer'];

	// new displayer
	// with setting
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
	// settings => logger => name 
    $settings = $c->get('settings')['logger'];
  	// logger 
	$logger = new Monolog\Logger($settings['name']);
   
	// processor 
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	// handler, log path, debug level
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	// logger obj
    return $logger;
};
