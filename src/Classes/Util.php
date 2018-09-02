<?php

namespace Vault;

class Util {

	private $db;	

	public function __construct($dbClient) {
        $this->db = $dbClient;
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

	public function purgeTable($name) {
		$db = $this->db;
		
		$sql = "TRUNCATE TABLE $name";
		try {
			// not statement
			$db->exec($sql);
		}
		catch(\Exception $e) {
			throw new Exception($e->getMessage());	
		}
	}

	public function insertDataReal(
		$firstName,
        $lastName,
        $gender,
        $favActivity,
        $birthday) 
	{
        $db = $this->db;

		$sql = "
			insert into user
			(
				firstName,
				lastName,
				gender,
				favActivity,
				birthday	
			)
			values
			(
				:firstName,
                :lastName,
                :gender,
                :favActivity,
                :birthday
			)
		";

        try {
			$stmt = $db->prepare($sql);
			$arr = [
				'firstName' => $firstName,
				'lastName' => $lastName,
				'gender' => $gender,
				'favActivity' => $favActivity, 	
				'birthday' => $birthday,
			];
            $stmt->execute($arr);
        }
        catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

	public function insertData($arr) {
		$this->purgeTable('user');

		foreach($arr as $k => $t) {
			// ignore the csv names
			if($k == 0) {
				continue;
			}

			$firstName = $t[0];
			$lastName = $t[1];
			$gender = $t[2];
			$favActivity = $t[3];
			$birthday = $t[4];
	
			// test
			//$this->myvardump('-- so --');
			//$this->myvardump($t);

			$this->insertDataReal($firstName, $lastName, $gender, $favActivity, $birthday);
		} // end loop

		// redirect
		
	}

	public function csvToArr($filename) {
		$buf = [];
		$csv = explode("\n", file_get_contents($filename));
        foreach ($csv as $key => $line)
		{
			if(empty($line))
				break;	
			$buf[$key] = str_getcsv($line);
		}

		return $buf;	
	}

	
	public function getUsers($currDate, $dateNum) {


	}

	public function myvardump($input) {
		echo "<pre>";
		var_dump('----');
		var_dump($input);
		echo "</pre>";
	}
}
