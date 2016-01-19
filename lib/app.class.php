<?php

class App{
	
	protected static $router;
	
	public static $db;
	
	//public static $cart;
	
	public static function getRouter(){
		return self::$router;
	}
	
	public static function run($uri){
		self::$router = new Router($uri);

		self::$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		
		Lang::load(self::$router->getLanguage());
				
		$controller_class = ucfirst(self::$router->getController()).'controller';		
		$controller_method = strtolower(self::$router->getMethod_prefix().self::$router->getAction());
		$controller_parametr = (self::$router->getParams());
		
       $layout = self::$router->getRoute();
	   
        if ( $layout == 'admin' && Session::get('role') != 'admin' ){
            if ( $controller_method != 'admin_login' ){
                Router::redirect('/admin/users/login');
            }
		}
		//Calling conrollers method
		$controller_object = new $controller_class();
		if (method_exists($controller_object, $controller_method)){
			
			$view_path = $controller_object->$controller_method();	
			
			
			$view_object = new View($controller_object->getData(), $view_path);
			$content = $view_object->render();			
		} else {
			throw new Exception('Метод '.$controller_method.' в классе '.$controller_class.'не найден');
		}
		
		
		$layout_path = VIEW_PATH.DS.$layout.'.html';
		$layout_view_object = new View(compact('content'),$layout_path);
		
		echo $layout_view_object->render();

	}	
}