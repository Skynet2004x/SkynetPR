<?php
class Router{

	protected $uri;
	protected $controller;
	protected $action;
	protected $params;
	
	protected $route;
	protected $method_prefix;
	protected $language;
	
	protected static $settings = array();
	
	public function getUri(){
		return $this->uri;
	}
	
	public function getController(){
		return $this->controller;
	}
	
	public function getAction(){
		return $this->action;
	}
	
	public function getParams(){
		return $this->params;
	}
	
	public function getRoute(){
		return $this->route;
	}
	
	public function getLanguage(){
		return $this->language;
	}
	
	public function getMethod_prefix(){
		return $this->method_prefix;
	}
	
	public function __construct($uri){
		
		$this->uri = urldecode(trim($uri, '/'));
		
		// get default
		$routes = Config::get('routes');
		$this->route = Config::get('default_route');
		$this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
		$this->language = Config::get('default_languages');
		$this->controller = Config::get('default_controller');
		$this->action = Config::get('default_action');
		$uri_parts = explode('?', $this->uri);		
		// get part 
		
		$path = $uri_parts[0];
		$path_parts = explode('/', $path);	
		if (count($path_parts)){
			
			// get route of language
			if (in_array(strtolower(current($path_parts)),array_keys($routes)) ){
					$this->route = strtolower(current($path_parts));
					$this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
					array_shift($path_parts);
			} elseif ( in_array(strtolower(current($path_parts)), Config::get('languages')) ) {
				$this->language = strtolower(current($path_parts));
					array_shift($path_parts);				
			}		
			// get controller
			if (current($path_parts)){
				$this->controller = strtolower(current($path_parts));
				array_shift($path_parts);				
			}
			// get action
			if (current($path_parts)){
				$this->action = strtolower(current($path_parts));
				array_shift($path_parts);				
			}
			// get params		
			$this->params = $path_parts;
			
		}
		
		// посмотрим что после ? если он есть
		if(strlen($uri_parts[1])>0){
			$path = $uri_parts[1]; 	
			$path_parts = explode('&', $path); // разобьем еще и по параметрам &&
			foreach($path_parts as $val){				
				$this->params[] = $val;
			}			
		}		
	}
	
	public static function redirect($location){
		header("Location: $location");
	}

}	
	