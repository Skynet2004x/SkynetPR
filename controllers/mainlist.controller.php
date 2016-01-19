<?php

class MainlistController extends Controller{
	
	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new Main_list();	
	}
	
	
	public function index(){
		$params = App::getRouter()->getParams();
/*		if (isset($params[1])) {
			$this->data['mainlist'] =  $this->model->getList(0,Config::get('adsperpage'),true);
			} else { */
				$this->data['mainlist'] =  $this->model->getList(true);
			//}
		
	}
	
	public function userprofile(){
			$params = App::getRouter()->getParams();
			if ($params[0] == null ) {
				Router::redirect('/'); 
			}		
		$this->data['mainlist'] =  $this->model->getListForUser($params[0]);
	}

	public function edit(){	
	
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		if(!$_POST['back']){
			$params = App::getRouter()->getParams();
			
			if($params[0]==null || $params[1]==null){
				Router::redirect('/');	
			}
			
			$this->data['mainlist']	 = $this->model->getGood($params);
			
				
			
		} else { 
			if (Session::get('id') != null ) {
				Router::redirect('/mainlist/userprofile/'.Session::get('id')); 
				} else {
				Router::redirect('/mainlist/'); 
			}
		}	
		
	}
	
	public function edit_confirm(){	
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		
		if(!$_POST['back']){
			
			if(count($_POST)>0){
									
				$result = $this->model->save($_POST['goods_id']);
				
				if ($result){
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			} 
		} 
		Router::redirect('/mainlist/userprofile/'.Session::get('id'));		
	}	
	
	public function update_price(){			
		$this->model->updateCurrentPrice();
	}
	
	public function byestep(){			
		$this->model->byeStep();		
	}

	public function soldmaxprice(){
		$this->model->soldMaxPrice();
	}
	public function rating(){		
		$this->model->rating();		
	}

	
	public function view(){		
		$params = App::getRouter()->getParams();		
		if (isset($params[0])){			
			$this->data['mainlist'] = $this->model->getDetail($params);
		}		
	}
	
	public function add(){
		if (Session::get('id') == null ) {
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
			//Router::redirect('/mainlist/userprofile/');
		}
	}

	
	public function delete(){
		if(isset($this->params[0])){
			$result = $this->model->delete($this->params[0]);
			if ($result){				
				Session::setFlash(__('page_was_delete','Page was delete'));				
			} else {
				Session::setFlash( __('page_was_not_delete','Page was not delete'));
			}			
		}
		Router::redirect('/mainlist/userprofile/');
	}
/////////////////////// cart //////////////////////////

	public function cart(){
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		
		if($_POST){
			print("!!!!!!!!!!!!!!!!!!!");
		} else {
			if (!isset($_POST['back'])){					
				$this->data['mainlist']	 = $this->model->getCart((int)Session::get('id'));
			} else {
				Router::redirect('/mainlist/userprofile/');	
			}
			
		}
	}	
	
	public function update_cart(){			
		$this->model->updateCart();
	}

	public function clear_cart(){			
		$this->model->cartClear();
		Router::redirect('/');
	}
	
/////////////////////////////admin ///////////////////////////
	public function admin_index(){
		$this->data['pages'] = $this->model->getList();
	}
	
	public function admin_view(){
			$params = App::getRouter()->getParams();
			//print_r($params);
			if ($params[0] == null && Session::get('role') != 'admin') {
				Router::redirect('/'); 
			}		
		$this->data['mainlist'] =  $this->model->getListForUser($params[0]);		
	}
	
	public function admin_add(){
		if(isset($_POST)){
			if (!isset($_POST['back'])){					
				$result = $this->model->save($_POST);
				if ($result){
					Session::setFlash( __('page_was_saved','Page was saved'));				
				} else {
					Session::setFlash( __('page_was_not_saved','Page was not saved'));
				}
			}
			Router::redirect('/admin/pages/');
		}
	}
	
	public function admin_edit(){
		//die(Session::get('id'));
		if (Session::get('id') == null ) {
			Router::redirect('/'); 
		}		
		if(!$_POST['back']){
			$params = App::getRouter()->getParams();			
			if($params[0]==null || $params[1]==null){
				Router::redirect('/');	
			}
			$result = $this->model->getGood($params);
			
			$cur_goods = $result[0];
				
			if (($cur_goods['goods_active'] == 1 || (int)$cur_goods['goods_days_left'] > 0) && $cur_goods['goods_start_time'] < date('Y-m-d H:m:s', time()) ) {				
				Session::setFlash( __('page_was_not_saved','Page was not saved'));
				Router::redirect('/admin/allusers/');
			} else {	
				$this->data['mainlist']	 = $result;
			}
				
			
		} else { 
			if (Session::get('id') != null ) {
				Router::redirect('/admin/allusers/'); 
				} else {
				Router::redirect('/admin/allusers/'); 
			}
		}	
	}
	
	public function admin_delete(){
		if(isset($this->params[0])){
			$result = $this->model->delete($this->params[0]);
			if ($result){				
				Session::setFlash(__('page_was_delete','Page was delete'));
				
			} else {
				Session::setFlash( __('page_was_not_delete','Page was not delete'));
			}			
		}
		Router::redirect('/admin/pages/');
	}
	
	public function admin_back(){		
		if($_POST['back']){			
			Router::redirect('/admin/pages/');
		}
	}
	
	
	
}