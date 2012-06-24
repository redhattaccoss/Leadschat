<?php
class Db_Mongo {
	const HOST = 'localhost';
	const PORT = 27017;
	const DBNAME = 'leadschat';
	private static $instance;
	public $connection;
	public $database;
	public function __construct() {
		$connectionString = sprintf('mongodb://%s:%d', Db_Mongo::HOST, Db_Mongo::PORT);
		try {
			$this -> connection = new Mongo($connectionString);
			$this -> database = $this -> connection -> selectDB(Db_Mongo::DBNAME);
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	static public function instantiate() {
		if (!isset(self::$instance)) {
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}

	public function getCollection($name) {
		return $this -> database -> selectCollection($name);
	}

}
