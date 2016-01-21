<?php
// класс работы с языками
class Lang{
	
	protected static $data;
	
	public static function load($land_code) {
		$land_file_path = ROOT.DS.'lang'.DS.strtolower($land_code).'.php';		
		if ( file_exists($land_file_path) ) {
				self::$data = include($land_file_path);				
		} else {
			throw new Exception('Land not found'.$land_file_path);			
		}
	}
	
	public static function get($key, $default_value = '') {
		return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
	}	
}