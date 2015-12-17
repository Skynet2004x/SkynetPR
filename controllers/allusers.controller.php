<?php

class allUsersController extends Controller{
	
	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new allUser();		
	}
	
	
	public function index(){
		$this->data['allusers'] =  $this->model->getListByLogin();
	}
	public function admin_index(){
		$this->data['allusers'] =  $this->model->getListByLogin();
	}

	public function admin_unactive(){
		//($this->params[0]); // параметр т.е. ИД пользователя на удаление		
		if(isset($this->params[0])){
			$result = $this->model->unactive($this->params[0]);
			if ($result){				
				Session::setFlash(__('user_was_hide','User was hide'));
				
			} else {
				Session::setFlash( __('user_was_not_hide','User was not hide'));
			}			
		}
		Router::redirect('/admin/allusers/');
	}

	public function admin_active(){
		//($this->params[0]); // параметр т.е. ИД пользователя на удаление		
		if(isset($this->params[0])){
			$result = $this->model->active($this->params[0]);
			if ($result){				
				Session::setFlash(__('user_was_show','User was show'));
				
			} else {
				Session::setFlash( __('user_was_not_show','User was not show'));
			}			
		}
		Router::redirect('/admin/allusers/');
	}

	
	public function admin_delete(){
		//($this->params[0]); // параметр т.е. ИД пользователя на удаление		
		if(isset($this->params[0])){
			$result = $this->model->delete($this->params[0]);
			if ($result){				
				Session::setFlash(__('user_was_delete','User was delete'));
				
			} else {
				Session::setFlash( __('user_was_not_delete','User was not delete'));
			}			
		}
		Router::redirect('/admin/allusers/');
	}
		

}