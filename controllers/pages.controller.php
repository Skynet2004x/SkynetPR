<?php

class PagesController extends Controller{
	
	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new Page();		
	}
	
	
	public function index(){
		$this->data['pages'] =  $this->model->getList();
	}
	public function view(){
		$params = App::getRouter()->getParams();
		if (isset($params[0])){
			$alias = strtolower($params[0]);
			$this->data['page'] = $this->model->getByAlias($alias );
		}		
	}
	
	public function profileview(){
		$params = App::getRouter()->getParams();
		if (isset($params[0])){
			$user_id = strtolower($params[0]);
			$this->data['page'] = $this->model->getByUserId($user_id );
		}		
	}	
	
	public function addpage(){
		if (Session::get('id') == '' ) {
			Router::redirect('/'); 
		}				
		if($_POST){			
			if (!isset($_POST['back'])){					
				$result = $this->model->save($_POST);
				if ($result){
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			}
			Router::redirect('/pages/');
			
		}
	}

	public function edit(){
		if (Session::get('id') == '' ) {
			Router::redirect('/'); 
		}		
		if($_POST){
			if (!isset($_POST['back'])){					
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$result = $this->model->save($_POST, $id);
				if ($result){
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			}
			Router::redirect('/pages/profileview/'.Session::get('id'));
		}
		
		if (isset($this->params[0])){
			$this->data['pages'] = $this->model->getById($this->params[0]);
		} else {
			Session::setFlash( __('Wrong_page_id','Wrong page id'));
			Router::redirect('/pages/');
		}
	}	
//////////////////////////////////////////////////////	
	public function admin_view(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		$params = App::getRouter()->getParams();							
		$this->data['page'] = $this->model->getList($params[0]);
				
	}	
	
	public function admin_index(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}
		$params = App::getRouter()->getParams();
		print_r($params);
		$this->data['pages'] = $this->model->getList($params[0]);
	}

	public function admin_add(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if($_POST){
			if (!isset($_POST['back'])){					
				$result = $this->model->save($_POST);
				if ($result){
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			}
			Router::redirect('/admin/allusers/');
		}
	}
	
	public function admin_edit(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if($_POST){
			if (!isset($_POST['back'])){					
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$result = $this->model->save($_POST, $id);
				if ($result){
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			}
			Router::redirect('/admin/allusers/');
		}
		
		if (isset($this->params[0])){
			$this->data['pages'] = $this->model->getById($this->params[0]);
		} else {
			Session::setFlash( __('Wrong_page_id','Wrong page id'));
			Router::redirect('/admin/allusers/');
		}
	}
	
	public function admin_delete(){
		if (Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if(isset($this->params[0])){
			$result = $this->model->delete($this->params[0]);
			if ($result){				
				Session::setFlash(__('page_was_delete','Page was delete'));
				
			} else {
				Session::setFlash( __('page_was_not_delete','Page was not delete'));
			}			
		}
		Router::redirect('/admin/allusers/');
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