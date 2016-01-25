<?php

class LoginController extends Controller{
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->model = new User();		
	}
	
   public function index() {

		if ( $_POST && isset($_POST['login']) && isset($_POST['password']) ) {
			$login = $_POST['login'];
            $user = $this->model->getByLogin($login);
            $hash = md5(Config::get('salt').$_POST['password']);
            if ( $user && $user['is_active'] && $hash == $user['password'] ) {
                Session::set('login', $user['login']);
				Session::set('id', $user['id']);
                Session::set('role', $user['role']);
				Session::set('email', $user['email']);
				if( $user['role'] = 'admin' ) {
					Router::redirect('/admin/params/');
				}
				Router::redirect('/');				
            } else {
				Session::setFlash('&#1053;&#1077; &#1074;&#1077;&#1088;&#1085;&#1099;&#1081; &#1083;&#1086;&#1075;&#1080;&#1085; &#1080;&#1083;&#1080; &#1087;&#1072;&#1088;&#1086;&#1083;&#1100;');
			}
        }
		if( $_POST['back'] ) {
			
			Router::redirect('/');
		}		
    }

	public function registration() { 
		if( $_POST['back'] ) {
			
			Router::redirect('/');
		}
		
		if( count($_POST) ) {
			if( preg_match("/^[\da-zA-Z_]{3,10}$/", trim($_POST['password'])) ) {
				$user = $this->model->getByEmail($_POST['email']);
				$hash = md5(Config::get('salt').$_POST['password']);
				
				if ( $user['email'] != $_POST['email'] ) {
					$login = $_POST['login'];
					$user = $this->model->getByLogin($login);
					If( $user['login'] != $_POST['login'] ) {
				
						if( !is_null($_POST['login']) && !is_null($_POST['password']) && !is_null($_POST['email']) && strlen($_POST['login']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['email']) > 0 ) {					
							if ( $_POST['password'] === $_POST['password1'] ) {		
										
								Session::set('login', $_POST['login']);
								Session::set('role', $_POST['role']);
								Session::set('email', $_POST['email']);
								
								if ( (int)Config::get('sendemail') == 1 ) {									
									// вот тут происходит отправка почты
									$login = $_POST['login'];
									$email = $_POST['email'];
									$password = $_POST['password'];									
									self::sendEmail($email,$login,"Congratulations! You was register successfull. Your login - ".$login.", password - ".$password);
								}
							}
							
							Router::redirect('/');							
						} else {
							Session::setFlash('Пароли не совпадают');
						}
					
					} else {
						if ( $_POST['login'] != '' ) {
							Session::setFlash('Пользователь с таким Логином существует');
							unset($_POST);
						}
					}
				} else {				
					if ( $_POST['login'] != '' ) {
						Session::setFlash('Пользователь с таким Email существует');
						unset($_POST);
					}
				}		
			} else {
				Session::setFlash('Введенный пароль не подходи. Введите более надежный пароль');
				unset($_POST);
			}
		}

	}	
	
	public function restore() {
		$params = App::getRouter()->getParams();
		if ( strlen($params[0]) > 0 ) { 
			$res = $this->model->getRestorePass($params[0]);

			if ( $params[0] == $res[0]['hash'] ) { // если хеш в базе найден - показать страницу с восстановлением и грохнуть записи из таблицы хеша				
				
				$this->model->delRestorePass($res[0]['email'] , $res[0]['hash']); // тут удалим из базы мыло и хеш логина при подтверждении
				$data = $res[0]['id_user'];
				$this->data['restore'] = $data;				
			}
		} else { // проверим ответ
			if( count($_POST) ) {
				if ( !is_null($_POST['password']) && !is_null($_POST['password1']) && ($_POST['password'] == $_POST['password1'] ) ) { // и если все получено ок
					$data = $_POST;												
					$this->model->saveNewPass($data);
					// записать новый пароль
					Router::redirect('/');	
				}
			}
		}
	}
	
	public function remember() {
		
		// count($_POST) = 0 - при заходе на страницу. но если нажата кн. Назад - то будет уже 2 и там уже надо проверять что именно заполнено а что нет
		if( count($_POST) ) {
			if( !is_null($_POST['email']) && strlen($_POST['email']) > 0 ) {					
				$email = $_POST['email'];
				$user = $this->model->getByEmail($email); // массив с рез. выборки пользователя								
				if ( !$user == false ) { // проверим а есть ли такой имеил воообще в базе
					$hash = md5(Config::get('salt').$user['login'].time()); // сгенерим хеш по логину для отправки пользователю в кач. ключа.
					$id = $user['id'];
					$this->model->setRestorePass($id, $email , $hash);// тут запишем в базу мыло и хеш логина
					
					if ( (int)Config::get('sendemail') == 1 ) {									
						self::sendemail($user['email'],$user['login'],"Your Login {$user['login']}. For change the password follow http://localhost/login/restore?"."{$hash}");				
					}			
					
					Router::redirect('/');
				} else {
					Session::setFlash( "Email указан не верно" );
					unset($_POST);
				} 
					
			}				
		}

		if( $_POST['back'] ) {
			
			Router::redirect('/login/');
		}

	}
	public function logout() {		
		$cur_lang = Session::get('languages'); 
		Session::destroy();
		Session::start();
		Session::set('languages',$cur_lang);
		Router::redirect('/');
	}
	
	public function changelang() {
		print_r($_POST);
		$lang=$_POST['lang'];
		Session::set('languages',$lang);
	}
	
}