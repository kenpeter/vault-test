<?php

namespace Vault;

class Util {

	// Constructor
	public function __construct() {
        
	}

	public function moveUploadedFile($directory, \Slim\Http\UploadedFile $uploadedFile)
	{
    	// ext
    	$path_parts = pathinfo($uploadedFile->getClientFilename());
    	$filename = $path_parts['filename']. '.'. $path_parts['extension'];

    	// move file
    	$uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    	return $directory . DIRECTORY_SEPARATOR . $filename;
	}
}
