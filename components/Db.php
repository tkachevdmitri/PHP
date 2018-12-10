<?php

class Db {
	public static function getConnection()
	{
		// connect bd
		$host = 'localhost';
		$login = 'root';
		$password = '';
		$db_name = 'BD_myShopMVC';

		$db = new PDO("mysql:host=$host;dbname=$db_name", $login, $password);

		return $db;

	}
}

