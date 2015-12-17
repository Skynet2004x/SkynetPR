<?php

class ContactsController extends Controller{
	
	public function index(){						
//			$l = Session::get('login');			
//			echo $l;
			if( !is_null($_POST['name']) && !is_null($_POST['email']) && !is_null($_POST['message']) && strlen($_POST['name']) > 0 && strlen($_POST['email']) > 0 && strlen($_POST['message']) > 0 ){					
				if($this->model->save($_POST)){
					Session::setFlash('OK. Message was sent');
				}
			}
	}

	public function __construct(){
		parent::__construct($data);
		$this->model = new Message();
		
	}

	public function admin_index(){
		$this->data = $this->model->getList();		
	}
	public function user(){
		
	}
	
}