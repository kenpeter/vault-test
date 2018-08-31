<?php
return [
 	'settings' => [
		// display error
        'displayErrorDetails' => true,
		// Allow the web server to send the content-length header 
        'addContentLengthHeader' => false,

        // render html 
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // need to set up log 
        'logger' => [
            'name' => 'vault',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
