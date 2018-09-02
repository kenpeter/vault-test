<?php

namespace Vault;

class Sanitizer {

	public function __construct() {

	}

	public function replaceNewLine($field) {
		return str_replace('\r\n', '', $field);	
	}

	public function mytrim($field) {
		return trim($field); 
	}

	public function destill($field) {
		$field = $this->replaceNewLine($field);
		$field = $this->mytrim($field);
		return $field;
	}

	public function myvardump($input) {
		echo "<pre>";
		var_dump('----');
		var_dump($input);
		echo "</pre>";
	}
}
