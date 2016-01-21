<?php
// класс работы в БД
class DB{
	
	protected $connection;
	
	protected static $obj;
    
	public static function getInstance($host, $user, $password, $db_name) {
        if ( !self::$obj ) {
            self::$obj = new DB($host, $user, $password, $db_name);
        }
        return self::$obj;
    }
	
	protected function __construct($host, $user, $password, $db_name) {
  		
		$this->connection = new mysqli($host, $user, $password, $db_name);
		
		if ( !$this->connection ) {
			throw new Exception('Could not connect to DB');		
		}
	}
	
	public function query($sql) {
		
		if ( !$this->connection ) {
			return false;
		}
		
		$result = $this->connection->query($sql);
		
		if ( mysqli_error($this->connection) ) {
			throw new Exception(mysqli_error($this->connection));	
		}
		
		if ( is_bool($result) ) {
			return $result;			
		}
		$data = array();
		while ( $row = mysqli_fetch_assoc($result) ) {
			$data[] = $row;
		}
		return $data;
	}
	
	public function escape($str) {
		return mysqli_escape_string($this->connection, $str);
	}
}