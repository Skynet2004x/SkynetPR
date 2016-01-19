<?php

class LoginController extends Controller{
	
	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new User();		
	}
	
   public function index(){

		if ( $_POST && isset($_POST['login']) && isset($_POST['password']) ){
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt').$_POST['password']);
            if ( $user && $user['is_active'] && $hash == $user['password'] ){
                Session::set('login', $user['login']);
				Session::set('id', $user['id']);
                Session::set('role', $user['role']);
				Session::set('email', $user['email']);
				if($user['role'] = 'admin'){
					Router::redirect('/admin/params/');
				}
				Router::redirect('/');
            } else {
				Session::setFlash('&#1053;&#1077; &#1074;&#1077;&#1088;&#1085;&#1099;&#1081; &#1083;&#1086;&#1075;&#1080;&#1085; &#1080;&#1083;&#1080; &#1087;&#1072;&#1088;&#1086;&#1083;&#1100;');
			}
            //
        }
    }


    public function login(){			
    }

	public function registration(){ 
		
		if(count($_POST)){
			if(preg_match("/^[\da-zA-Z_]{3,10}$/", trim($_POST['password']))){
				$user = $this->model->getByEmail($_POST['email']);
				$hash = md5(Config::get('salt').$_POST['password']);
				
				if ($user['email'] != $_POST['email'] ) {
					$user = $this->model->getByLogin($_POST['login']);
					If($user['login'] != $_POST['login'] ) {
				
						if( !is_null($_POST['login']) && !is_null($_POST['password']) && !is_null($_POST['email']) && strlen($_POST['login']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['email']) > 0 ){					
							if ($_POST['password'] === $_POST['password1']){		
							//	$user = $this->model->save($_POST);				
								Session::set('login', $_POST['login']);
								Session::set('role', $_POST['role']);
								Session::set('email', $_POST['email']);
								
								if ((int)Config::get('sendemail') == 1) {									
									$this->model->sendEmail($_POST['email'],$_POST['login'],"Congratulations! You was register successfull. Your login - ".$_POST['login'].", password - ".$_POST['password']);
								}
							}			
							Router::redirect('/');								
						} else {
							Session::setFlash('Пароли не совпадают');
						}
					
					} else {
						if ($_POST['login'] != ''){
							Session::setFlash('Пользователь с таким Логином существует');
							unset($_POST);
						}
					}
				} else {				
					if ($_POST['login'] != ''){
						Session::setFlash('Пользователь с таким Email существует');
						unset($_POST);
					}
				}		
			} else {
				Session::setFlash('Введенный пароль не подходи. Введите более надежный пароль');
			}
		}
		if($_POST['back']){
			
			Router::redirect('/login/');
		}
	}	

	public function logout(){
	
		Session::destroy();
		Router::redirect('/');
	}
}