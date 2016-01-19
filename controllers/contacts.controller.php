<?php

class ContactsController extends Controller{
	
	public function index(){						
			if( !is_null($_POST['name']) && !is_null($_POST['email']) && !is_null($_POST['message']) && strlen($_POST['name']) > 0 && strlen($_POST['email']) > 0 && strlen($_POST['message']) > 0 ){					
				if($this->model->save($_POST)){
					Session::setFlash('OK. Message was sent');
				}
			}
		if($_POST['back']){			
			Router::redirect('/');
		}
	}

	public function __construct(){
		parent::__construct($data);
		$this->model = new Message();
		
	}

	public function admin_index(){
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		$params = $this->getParams();
		$this->data = $this->model->getList();	


		
	}
	
	
	public function admin_view(){
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		$params = $this->getParams();		
		$this->data = $this->model->getList($params[0]);		
	}	
	
	
	public function admin_back(){
		
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		if($_POST['back']){			
			Router::redirect('/admin/contacts/');
		}
	}
	
}