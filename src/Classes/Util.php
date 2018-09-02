<?php

namespace Vault;

require_once('Sanitizer.php');

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
		$san = new \Vault\Sanitizer();

		foreach($arr as $k => $t) {
			// ignore the csv names
			if($k == 0) {
				continue;
			}

			$firstName = $san->destill($t[0]);
			$lastName = $san->destill($t[1]);
			$gender = $san->destill($t[2]);
			$favActivity = $san->destill($t[3]);
			$birthday = $san->destill($t[4]);
	
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


	// e.g. currDate = 2018-09-02
	// Assume dateNum e.g. 30, 60, 90 days
	public function getUsersFilter($currDate, $dateNum) {
		$startUnix = strtotime($currDate);
		$endUnix = $startUnix + $dateNum * 60 * 60 * 24;

		$startYear = date('Y', $startUnix);
		$endYear = date('Y', $endUnix);
		return $userArr = $this->getUsersAsArrParam($startYear, $endYear, $startUnix, $endUnix);	
	}


	public function getUsersAsArrParam($startYear, $endYear, $startUnix, $endUnix) {
		$allUserArr = $this->getUsersAsArr();
		$buf = [];
		if($endYear == $startYear) {
			foreach($allUserArr as $user) {
				$bDay = $user['birthday'];
				$bDaySub = $startYear. '-'. date('m-d', strtotime($bDay));			
				$bDaySubUnix = strtotime($bDaySub);

				if($bDaySubUnix >= $startUnix && $bDaySubUnix <= $endUnix) {
					$buf[] = $user;
				} else {
					// ignore
				}
			} // end loop
		} else {
			foreach($allUserArr as $user) {
                $bDay = $user['birthday'];

                $bDaySub1 = $startYear. '-'. date('m-d', strtotime($bDay));
                $bDaySub1Unix = strtotime($bDaySub1);
				
				$bDaySub2 = $endYear. '-'. date('m-d', strtotime($bDay));
                $bDaySub2Unix = strtotime($bDaySub2);               

                if($bDaySub1Unix >= $startUnix && $bDaySub1Unix <= $endUnix) {
                    $buf[] = $user;
					continue;
				}
				else if($bDaySub2Unix >= $startUnix && $bDaySub2Unix <= $endUnix) {
					$buf[] = $user;
                    continue;
                } 
				else {

                }
            } // end loop
		}

		return $buf;
	}


	public function getUsersAsArr() {
		$db = $this->db;

		$sql = "select * from user";	
		try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
			$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $res;
        }   
        catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }	
	}


	public function myvardump($input) {
		echo "<pre>";
		var_dump('----');
		var_dump($input);
		echo "</pre>";
	}
}
