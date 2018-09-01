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

// actual upload
$app->post('/uploadReal', function (Request $request, Response $response) {
    $dbClient = $this->dbClient;

	// from index, actual dir 
	$directory = $this->get('upload_directory');

	// file in mem
    $uploadedFiles = $request->getUploadedFiles();

	// file key
    $uploadedFile = $uploadedFiles['file'];

	// ok
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
		// move file
        $filename = moveUploadedFile($directory, $uploadedFile);
		// result
        $response->write('uploaded ' . $filename . '<br/>');
    } else {
		// err
		echo "<pre>";
		var_dump($uploadedFile->getError());	
		echo "</pre>";
		die('die');
	}


});


function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
	// ext
    $path_parts = pathinfo($uploadedFile->getClientFilename());
	$filename = $path_parts['filename']. '.'. $path_parts['extension'];

	// move file
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}
