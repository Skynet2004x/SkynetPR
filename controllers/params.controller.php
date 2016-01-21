<?php

class ParamsController extends Controller{
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->model = new Parameters();		
	}
	
	
	public function admin_index() {
		if ( Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}
		if( count($_POST) ) {
			$res_post = $_POST;
			$this->model->setConfig($res_post);
			Router::redirect('/admin/users/');			
		} else {	
			$this->data['params'] = $this->model->getConfig();		
		}
		
	}

	public function admin_back() {
		if ( Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if( $_POST['back'] ) {			
			Router::redirect('/admin/users/');
		}
	}		
	

}