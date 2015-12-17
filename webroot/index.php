<?php
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)));
define('VIEW_PATH',ROOT.DS.'views');
	//die(ROOT.DS);
require_once(ROOT.DS.'lib'.DS.'init.php');
/*	App::run($_SERVER['REQUEST_URI']);
		Session::setFlash("Test message");
*/

try{
	session_start();
	App::run($_SERVER['REQUEST_URI']);
	
}
 catch(Exception $e) { 
  //echo $e;
  
}
