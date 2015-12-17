<?php
class Controller{
	protected $data;
	protected $model;
	protected $params;
	
	public function getModel(){
		return $this->model;
	}
	
	public function getData(){
		return $this->data;
	}

	public function getParams(){
		return $this->params;
	}
	
	public function __construct($data = array()){
	
	//session_start();
	if(isset($_SESSION['time'])&&(time()-$_SESSION['time'])>3600) {
        session_destroy();
		Router::redirect('/');
       // session_start();
	}
		$_SESSION['time']=time();	
		
		$this->data = $data;
		$this->params = App::getRouter()->getParams();
	}
}