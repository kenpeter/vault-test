<?php

namespace Vault;

class Validator {

	public function __construct() {

	}

	public function isFieldEmpty($field) {
		if(empty($field))
			return true;
		else
			return false;
	}

	public function myvardump($input) {
		echo "<pre>";
		var_dump('----');
		var_dump($input);
		echo "</pre>";
	}
}
