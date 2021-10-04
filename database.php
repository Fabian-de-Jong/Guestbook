<?php
/*
* Mysql database class - to showcase a singleton pattern
*/

class Database {
	private $connection;
	private static $instance; //The single instance

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$instance) { // If no instance then make one
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$configs = include('config.php');
		$this->connection = new mysqli($configs['host'], $configs['username'],  $configs['password'], $configs['database']);
	
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
		}
	}

	// Magic method clone is empty to prevent dupllicate connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->connection;
	}
}