<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

$app->get('/', function (Request $request, Response $response, array $args) {
    // render service 
    return $this->renderer->render($response, 'index.phtml', $args);
});


// upload page
$app->get('/upload', function (Request $request, Response $response, array $args) {

    // render service 
    return $this->renderer->render($response, 'upload.phtml', $args);
});

// in controller, we have diff services meet together 
$app->post('/uploadReal', function (Request $request, Response $response) {
	// from index, actual dir 
	$directory = $this->get('upload_directory');

	// file in mem
    $uploadedFiles = $request->getUploadedFiles();

	// file key
    $uploadedFile = $uploadedFiles['file'];

	// ok
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
		// move file
        $filename = $this->util->moveUploadedFile($directory, $uploadedFile);
		$arr = $this->util->csvToArr($filename);
		$condi = $this->util->insertData($arr);

    } else {
		// err
		echo "<pre>";
		var_dump($uploadedFile->getError());	
		echo "</pre>";
		die('die');
	}


});

