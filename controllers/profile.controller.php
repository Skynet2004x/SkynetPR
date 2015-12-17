<?php

class profileController extends Controller{
	
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


}