<?php

class ParamsController extends Controller{
	
	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new Opt();		
	}
	
	
	public function admin_index(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}
		if(count($_POST)){
			$this->model->setConfig($_POST);
			Router::redirect('/admin/allusers/');			
		} else {	
			$this->data['params'] = $this->model->getConfig();		
		}
		
	}

	public function admin_edit(){
		
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if(count($_POST)){
			$hash = md5(Config::get('salt').$_POST['password']);				
			if ($_POST['password'] === $_POST['password2']){		
				$this->model->save($_POST);																									
			}			
			Router::redirect('/admin/allusers/');																	
		}
				
		if($_POST['back']){			
			Router::redirect('/admin/allusers/');
		}
		
		if (isset($this->params[0])){
			$this->data['params'] = $this->model->getUsersById($this->params[0]);
		} else {
			Session::setFlash( __('Wrong_page_id','Wrong page id'));
			Router::redirect('/admin/allusers/');
		}
	}
	
	public function admin_add(){
		
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if(count($_POST)){
			$hash = md5(Config::get('salt').$_POST['password']);				
			if ($_POST['password'] === $_POST['password2']){		
				$this->model->save($_POST);																									
			}			
			Router::redirect('/admin/allusers/');																	
		}
				
		if($_POST['back']){			
			Router::redirect('/admin/allusers/');
		}		
	}
		
	
	public function admin_back(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if($_POST['back']){			
			Router::redirect('/admin/allusers/');
		}
	}
}