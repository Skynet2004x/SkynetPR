<?php
// класс моделей
class Model{
	
	protected $db;
	
	public function __construct() {
		$this->db = App::$db;
	}

	public function convertStr($stringFrom) {
		
		if ( preg_match("/[а-яА-Я]+/u",$stringFrom) ) {
			
			$name = explode('.',$stringFrom);					
			return getId().'-'.time().'.'.$name[1];
		}
		return $stringFrom;
	} 
}