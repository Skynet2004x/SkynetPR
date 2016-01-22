<?php

class UsersController extends Controller{
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->model = new User();		
	}
	
	
	public function registration() {
        
    }

	public function profile() {
		$params = App::getRouter()->getParams();
		if ( $params[0] == null ) {
			Router::redirect('/'); 
		}		
				
		if( count($_POST) ) {
			$hash = md5(Config::get('salt').$_POST['password']);				
			if ( $_POST['password'] === $_POST['password2'] ) {		
				$res_post = $_POST;
				$this->model->save($res_post);																									
			}
			
			Router::redirect('/');																	
		}
				
		if( $_POST['back'] ) {			
			Router::redirect('/');
		}
		
		if ( isset($this->params[0]) ) {
			$this->data['users'] = $this->model->getUsersById($this->params[0]);
		} else {
			Session::setFlash( __('Wrong_page_id','Wrong page id'));
			Router::redirect('/');
		}		
		
		
	}
		
	////// админская часть
    public function admin_index() {
		
		if ( Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		} 
		$this->data['allusers'] =  $this->model->getListByLogin();	   
    }

    public function admin_login() {
		$sess = session::get('login'); // проверим на сессию ... если есть, то не пускать в админку пока есть живая сессия
		if ( isset($sess ) != null) { 
			Router::redirect('/');
		}
		
		if ( $_POST && isset($_POST['login']) && isset($_POST['password']) ) {
            $login = $_POST['login'];
			$user = $this->model->getByLogin($login);
            $hash = md5(Config::get('salt').$_POST['password']);
			
            if ( $user && $user['is_active'] && $hash == $user['password'] ) {
                Session::set('id', $user['id']);
				Session::set('login', $user['login']);
                Session::set('role', $user['role']);
				Session::set('email', $user['email']);				
            }
            Router::redirect('/admin/users/');
        }		
    }
	
    public function admin_logout() {
        Session::destroy();
        Router::redirect('/');
    }
	
	public function admin_unactive() {
		//($this->params[0]); // параметр т.е. ИД пользователя на удаление		
		if( isset($this->params[0]) ) {
			$result = $this->model->unactive($this->params[0]);
			if ( $result ) {				
				Session::setFlash(__('user_was_hide','User was hide'));
				
			} else {
				Session::setFlash( __('user_was_not_hide','User was not hide'));
			}			
		}
		Router::redirect('/admin/users/');
	}

	public function admin_active() {
		//($this->params[0]); // параметр т.е. ИД пользователя на удаление		
		if( isset($this->params[0]) ) {
			$result = $this->model->active($this->params[0]);
			if ( $result ) {				
				Session::setFlash(__('user_was_show','User was show'));
				
			} else {
				Session::setFlash( __('user_was_not_show','User was not show'));
			}			
		}
		Router::redirect('/admin/users/');
	}

	
	public function admin_delete() {
		//($this->params[0]); // параметр т.е. ИД пользователя на удаление		
		if( isset($this->params[0]) ) {
			$result = $this->model->delete($this->params[0]);
			if ( $result ) {				
				Session::setFlash(__('user_was_delete','User was delete'));
				
			} else {
				Session::setFlash( __('user_was_not_delete','User was not delete'));
			}			
		}
		Router::redirect('/admin/users/');
	}

	public function admin_edit() {
		
		if ( Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if( count($_POST) ) {
			$hash = md5(Config::get('salt').$_POST['password']);				
			if ($_POST['password'] === $_POST['password2']) {		
				$this->model->save($_POST);																									
			}			
			Router::redirect('/admin/users/');																	
		}
				
		if( $_POST['back'] ) {			
			Router::redirect('/admin/users/');
		}
		
		if ( isset($this->params[0]) ) {
			$this->data['params'] = $this->model->getUsersById($this->params[0]);
		} else {
			Session::setFlash( __('Wrong_page_id','Wrong page id'));
			Router::redirect('/admin/users/');
		}
	}
	
	public function admin_add() {
		
		if ( Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		if( count($_POST) > 0) {
			$hash = md5(Config::get('salt').$_POST['password']);				
			if ( $_POST['password'] === $_POST['password2'] ) {						
				$res_post = $_POST;
				$this->model->save($res_post);																									
			}
			
			Router::redirect('/admin/users/');																	
		}
				
		if( $_POST['back'] ) {			
			Router::redirect('/admin/users/');
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