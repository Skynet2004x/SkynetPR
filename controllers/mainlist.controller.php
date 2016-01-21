<?php

class MainlistController extends Controller{
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->model = new Main_list();	
	}
	
	
	public function index() {
		
		$params = App::getRouter()->getParams();

		$this->data['mainlist'] =  $this->model->getList(true);
		
	}

	
	public function myads() {
		$params = App::getRouter()->getParams();
		if ( $params[0] == null ) {
			Router::redirect('/'); 
		}		
		$this->data['mainlist'] = $this->model->getListForUser($params[0]);
	}

	public function edit() {	
	
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		
		if( !$_POST['back'] ) {
			$params = App::getRouter()->getParams();
			
			if($params[0]==null || $params[1]==null) {
				Router::redirect('/');	
			}
			
			$this->data['mainlist']	 = $this->model->getGood($params);
			
		} else { 
			if ( getId() != null ) {
				Router::redirect('/mainlist/myads/'.getId()); 
				} else {
				Router::redirect('/mainlist/'); 
			}
		}			
	}
	
	public function edit_confirm() {	
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		
		
		if( !$_POST['back'] ) {
			
			if( count($_POST)>0 ) {
				$goods_id = $_POST['goods_id'];					
				$result = $this->model->save($goods_id);
				
				if ( $result ) {
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			} 
		} 
		Router::redirect('/mainlist/myads/'.getId());		
	}	
	
	public function update_price() {			
		$this->model->updateCurrentPrice();
	}
	
	public function byestep() {			
		$res = $this->model->byeStep();

		// если вернулось "продано" то шлем письма
		if ( $res == "sold" ) {
			if ( (int)Config::get('sendemail') == 1 ) {									
				self::sendEmail(Session::get('email'),Session::get('login'),"Congratulations! You win");
				self::sendEmail($this->getEmailByUserId($user_id),$user_id,"Congratulations! You sold");
			}			
		}
	}

	public function soldmaxprice() {
		$res = $this->model->soldMaxPrice();
		// если вернулось "продано" то шлем письма
		if ( $res == "sold" ) {
			if ( (int)Config::get('sendemail') == 1 ) {									
					self::sendEmail(Session::get('email'),Session::get('login'),"Congratulations! You win");
					self::sendEmail($this->getEmailByUserId($user_id),$user_id,"Congratulations! You sold");
				}			
		}
	}
	public function rating() {		
		$this->model->rating();		
	}

	
	public function view() {		
		$params = App::getRouter()->getParams();		
		if ( isset($params[0]) ) {			
			$this->data['mainlist'] = $this->model->getDetail($params);
		}		
	}
	
	public function add() {
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		

		if( $_POST ) {
			if ( !isset($_POST['back']) ) {
				$res_post = $_POST;				
				$result = $this->model->save($res_post);
				if ( $result ) {
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}				
			} else {
				Router::redirect('/mainlist/myads/'.getId());
			}			
		}
	}

	
	public function delete() {
		if( isset($this->params[0]) ) {
			$result = $this->model->delete($this->params[0]);
			if ( $result ) {				
				Session::setFlash(__('page_was_delete','Page was delete'));				
			} else {
				Session::setFlash( __('page_was_not_delete','Page was not delete'));
			}			
		}
		Router::redirect('/mainlist/userprofile/');
	}
/////////////////////// cart //////////////////////////

	public function cart() {
		if ( getId() == null ) {
			Router::redirect('/'); 
		}		
		
		if( $_POST ) {
			
		} else {
			if ( !isset($_POST['back']) ) {					
				$this->data['mainlist']	 = $this->model->getCart((int)getId());
			} else {
				Router::redirect('/mainlist/userprofile/');	
			}
			
		}
	}	
	
	public function update_cart() {			
		$this->model->updateCart();
	}

	public function clear_cart() {			
		$this->model->cartClear();
		Router::redirect('/');
	}
	
/////////////////////////////admin ///////////////////////////
	public function admin_index() {
		
		$this->data['pages'] = $this->model->getList();
	}
	
	public function admin_view() {

		$params = App::getRouter()->getParams();

		if ( $params[0] == null && Session::get('role') != 'admin' ) {
			Router::redirect('/'); 
		}		
		$this->data['mainlist'] =  $this->model->getListForUser($params[0]);		
	}
	
	public function admin_add() {
		if( isset($_POST) ) {
			if ( !isset($_POST['back']) ) {
				$res_post = $_POST;				
				$result = $this->model->save($res_post);
				if ( $result ) {
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			}
			Router::redirect('/admin/pages/');
		}
	}
	
	public function admin_edit() {

		if ( getId() == null ) {
			Router::redirect('/'); 
		}
		
		if( !$_POST['back'] ) {
			$params = App::getRouter()->getParams();			
			if( $params[0]==null || $params[1]==null ) {
				Router::redirect('/');	
			}
			$result = $this->model->getGood($params);
			
			$cur_goods = $result[0];
				
			if ( ($cur_goods['goods_active'] == 1 || (int)$cur_goods['goods_days_left'] > 0) && $cur_goods['goods_start_time'] < date('Y-m-d H:m:s', time()) ) {				
				Session::setFlash( __('page_was_not_saved','Page was not saved'));
				Router::redirect('/admin/users/');
			} else {	
				$this->data['mainlist']	 = $result;
			}
				
			
		} else { 
			if ( getId() != null ) {
				Router::redirect('/admin/users/'); 
				} else {
				Router::redirect('/admin/users/'); 
			}
		}	
	}
	
	public function admin_delete() {
		if ( isset($this->params[0]) ) {
			$result = $this->model->delete($this->params[0]);
			if ( $result ) {				
				Session::setFlash(__('page_was_delete','Page was delete'));
				
			} else {
				Session::setFlash( __('page_was_not_delete','Page was not delete'));
			}			
		}
		Router::redirect('/admin/pages/');
	}
	
	public function admin_back() {		
		if( $_POST['back'] ) {			
			Router::redirect('/admin/pages/');
		}
	}
	
	
	
}