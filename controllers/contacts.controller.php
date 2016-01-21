<?php

class ContactsController extends Controller{

	public function __construct() {
		parent::__construct($data);
		$this->model = new Message();		
	}
	
	public function index() {						
		if( !is_null($_POST['name']) && !is_null($_POST['email']) && !is_null($_POST['message']) && strlen($_POST['name']) > 0 && strlen($_POST['email']) > 0 && strlen($_POST['message']) > 0 ) {					
			$res_post = $_POST;
			if($this->model->save($res_post) ) {
				Session::setFlash('OK. Message was sent');
			}
		}
		if( $_POST['back'] ) {			
			Router::redirect('/');
		}
	}

	public function admin_index() {
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		
		
		$params = $this->getParams();
		$this->data = $this->model->getList();	
		
	}
		
	public function admin_view() {
		
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		
		
		$params = $this->getParams();		
		$this->data = $this->model->getList($params[0]);		
	}	
		
	public function admin_back() {
		
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		
		if( $_POST['back'] ) {			
			Router::redirect('/admin/contacts/');
		}
	}
	
}