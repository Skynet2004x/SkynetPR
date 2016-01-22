<?php

class User extends Model{
	
	public function getByLogin($login) {
		
		$login = $this->db->escape($login);
		$sql = "select * from users where login = '{$login}' limit 1";
		$result = $this->db->query($sql);		
		if ( isset($result[0]) ) {
			return $result[0];			
		}
		return false;
	}
	
	public function getByEmail($email) {
		
		$login = $this->db->escape($login);
		$sql = "select * from users where email = '{$email}' limit 1";
		$result = $this->db->query($sql);		
		if ( isset($result[0]) ) {
			return $result[0];			
		}
		return false;
	}	
	
	public function getUsersById($id) {				
		$id = (int)$id;			
		$sql = "SELECT * FROM users where id = {$id} limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}	
	
	public function setRestorePass($id, $email , $hash) {
		$hash = $this->db->escape($hash);
		$id_user = (int)$id;
		$sql = "INSERT INTO userrestorepass
					set id_user = '{$id_user}',
						hash = '{$hash}',
						email = '{$email}'";							
		return $this->db->query($sql);		
	}

	public function getRestorePass($hash) {
		$sql = "SELECT r.id_user, r.email, r.hash, max(timedate)
					FROM userrestorepass r
					left JOIN users u ON r.id_user = u.id                    
					Where hash = '{$hash}'";						
		return $this->db->query($sql);		
	}

	public function delRestorePass($email , $hash) {
		$sql = "DELETE FROM userrestorepass
					WHERE email = '{$email}'";						
		return $this->db->query($sql);		
	}
	
	public function saveNewPass($data) {
						
		$id = (int)$data['id'];	
		$is_active = (int)$data['is_active'];			
		$role = $this->db->escape($data['role']);		
		$password = md5(Config::get('salt').$this->db->escape($data['password'])) ;		
							
		if( $id != 0 ) { //update 
			$sql = "
				UPDATE users
				set role = '{$role}',
					password = '{$password}',
					is_active = '{$is_active}'
					WHERE id = {$id}";

			

			return $this->db->query($sql);
		} 		
	}	
	
	public function save($data) {
		if( strlen($data['login']) == 0  || strlen($data['email']) == 0 ) {
			return false;			
		}
				
		$id = (int)$data['id'];		
		$login = $this->db->escape($data['login']);
		$email = $this->db->escape($data['email']);
		$role = $this->db->escape($data['role']);		
		$password = md5(Config::get('salt').$this->db->escape($data['password'])) ;		
		$is_active = $this->db->escape($data['is_active']);
		
		if ( $is_active == 'on') { 
			$is_active =1; 
			} else { 
				$is_active=0; 
			}
			
		$city = $this->db->escape($data['city']);
		
		if( $id != 0 ) { //update 
			$sql = "
				UPDATE users
				set login = '{$login}',
					email = '{$email}',";

			if ( $data['role'] != null ) {				
					$sql .=	"role = '{$role}',";
			}
			
			if ( $data['password'] != null ) {				
				$sql .=	"password = '{$password}',";
			}
			
			if ( $data['is_active'] != null ) {				
				$sql .=	"is_active = '{$is_active}',";
			}			
				$sql .=	"city = '{$city}' 
						WHERE id = {$id}";			
			return $this->db->query($sql);
		} else {
			
			$sql = "INSERT INTO users
					set login = '{$login}',
						email = '{$email}',";
			if ( $data['role'] != null ) {				
				$sql .=	"role = '{$role}',";
			}

			if ( $data['password'] != null ) {				
				$sql .=	"password = '{$password}',";
			}

			if ( $data['is_active'] != null ) {				
				$sql .=	"is_active = '{$is_active}',";
			}
				$sql .=	"city = '{$city}'";								
			return $this->db->query($sql);				
		}				
	}

	public function getListByLogin() {
				
		$sql = "select * from users";
		$result = $this->db->query($sql);
		if ( isset($result[0]) ) {
			return $result;
		}
		return false;
	}	
	
	public function delete($id) {		
		$sql = "delete from users where id = {$id}";			
		return $this->db->query($sql);					
	}

	public function unactive($id) {
		
		$sql = "update users
				set is_active = '0'
				where id = {$id}
			";				
		return $this->db->query($sql);					
	}
	
	public function active($id) {
		
		$sql = "update users
				set is_active = '1'
				where id = {$id}
			";				
		return $this->db->query($sql);					
	}
	
}
