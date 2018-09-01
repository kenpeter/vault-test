<?php
// DIC configuration

namespace Vault;

require_once('Classes/MySQLClient.php');
require_once('Classes/Util.php');

// service container
$container = $app->getContainer();

// upload
$container['upload_directory'] = dirname( dirname(__FILE__) ). '/uploads';

// render service 
$container['renderer'] = function ($c) {
	// $c is config

    $settings = $c->get('settings')['renderer'];

	// new displayer
	// with setting
    return new \Slim\Views\PhpRenderer($settings['template_path']);
};

// return log obj 
$container['logger'] = function ($c) {
	// settings => logger => name 
    $settings = $c->get('settings')['logger'];
  	// logger 
	$logger = new \Monolog\Logger($settings['name']);
   
	// processor 
	$logger->pushProcessor(new \Monolog\Processor\UidProcessor());
	// handler, log path, debug level
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	// logger obj
    return $logger;
};

// we return the obj 
$container['dbClient'] = function ($c) {
	$client = \Vault\MySQLClient::getInstance()->getConnection();
	return $client;
};


$container['util'] = function ($c) {
    $util = new \Vault\Util();
    return $util;
};

