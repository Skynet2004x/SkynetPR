<?php
//класс конфига для сбора параметров системы перед началом работы
class Config{
	
	protected static $settings = array();
	
	public static function get($key) {
		return isset(self::$settings[$key]) ? self::$settings[$key] : null;
	}
	
	public static function set($key, $value) {
		self::$settings[$key] = $value;
	}

	public static function connect() {
		$sql = "SELECT * FROM config";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);
		array_shift($res[0]);
		foreach( $res[0] as $key => $value ) {
			self::set($key, $value);
		}
	}	
}	
	