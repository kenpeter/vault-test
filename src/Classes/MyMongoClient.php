<?php

class MyMongoClient
{
	private static $_client;

	private function __construct(){}
	private function __clone(){}

	public static function get()
	{
		if(!isset(self::$_client))
		{
			self::$_client = new \MongoDB\Client("mongodb://localhost:27017");;
		}

		return self::$_client;
	}

}
