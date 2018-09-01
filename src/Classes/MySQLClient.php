<?php

namespace Vault;

class MySQLClient {
	// database
	private $_connection;

	// this class instance	
	private static $_instance;
	
	private $_host = "localhost";
	private $_user = "vault";
	private $_pass = "vault";
	private $_db = "vault";

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// Constructor
	private function __construct() {
		try {
            $this->_connection = new \PDO("mysql:host=$this->_host;dbname=$this->_db", 
            	"$this->_user", "$this->_pass");

        } catch (PdoException $e) {
            echo 'Hata: '.$e->getMessage();
        }	
	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}
