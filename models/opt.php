<?php

class Opt extends Model{

	public function getConfig(){				 
		$sql = "SELECT * FROM config";
		return $this->db->query($sql);
	}
	
	public function setConfig($data){
		$adsperpage = $this->db->escape($data['adsperpage']);
		$sitename = $this->db->escape($data['sitename']);
		$sendemail = $this->db->escape($data['sendemail']);		
		$sql = "UPDATE config
				set adsperpage = '{$adsperpage}',
					sitename = '{$sitename}',
					sendemail  = '{$sendemail}'					
				WHERE id = 0";
		return $this->db->query($sql);
	}	
	
	
	public function getByLogin($login){
		
		$login = $this->db->escape($login);
		$sql = "select * from users where login = '{$login}' limit 1";
		$result = $this->db->query($sql);		
		if (isset($result[0])){
			return $result[0];			
		}
		return false;
	}
	
	public function getByEmail($email){
		
		$login = $this->db->escape($login);
		$sql = "select * from users where email = '{$email}' limit 1";
		$result = $this->db->query($sql);		
		if (isset($result[0])){
			return $result[0];			
		}
		return false;
	}
	
	public function getUsersById($id){				
		$id = (int)$id;			
		$sql = "SELECT * FROM users where id = {$id} limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}	
	
	public function save($data){
		
		if( !isset($data['login']) || !isset($data['email']) ){
			return false;			
		}
		
		$id = (int)$data['id'];
		$login = $this->db->escape($data['login']);
		$email = $this->db->escape($data['email']);
		$role = $this->db->escape($data['role']);		
		$password = md5(Config::get('salt').$this->db->escape($data['password'])) ;		
		$is_active = $this->db->escape($data['is_active']);
		if ($is_active == 'on') { $is_active =1; } else { $is_active=0; }
		$city = $this->db->escape($data['city']);
	
		if($id != 0){ //update 
			$sql = "
				UPDATE users
				set login = '{$login}',
					email = '{$email}',
					role = '{$role}',";
			if ($data['password'] != null) {				
				$sql .=	"password = '{$password}',";
			}
				$sql .=	"is_active = '{$is_active}',
						city = '{$city}' 
						WHERE id = {$id}";			
			return $this->db->query($sql);
		} else {
			$sql = "INSERT INTO users
					set login = '{$login}',
						email = '{$email}',
						role = '{$role}',";
				if ($data['password'] != null) {				
					$sql .=	"password = '{$password}',";
				}
					$sql .=	"is_active = '{$is_active}',
							city = '{$city}'";			
				return $this->db->query($sql);				
		}		
		
	}

}
