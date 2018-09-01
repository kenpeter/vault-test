<?php

class MySQLClient {
	// database
	private $_connection;

	// this class instance	
	private static $_instance;
	
	private $_host = "";
	private $_user = "";
	private $_pass = "";
	private $_db = "";

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
	private function __construct($host, $user, $pass, $db) {
		$this->_host = $host;
    	$this->_user = $user;
    	$this->_pass = $pass;
    	$this->_db = $db;

		try {
            $this->_connection = new PDO("mysql:host=$this->_host;dbname=$this->_db", 
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
