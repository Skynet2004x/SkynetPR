<?php
class Message extends Model{
	
	public function save($data, $id = null){
		
		if( !isset($data['name']) || !isset($data['email']) || !isset($data['message']) ){
			return false;			
		}
		
		$id = (int)$id;
		$name = $this->db->escape($data['name']);
		$email = $this->db->escape($data['email']);
		$message = $this->db->escape($data['message']);
		$user_id = $this->db->escape($data['user_id']);
		
		if(!$id){ //add new 
			$sql = "
				insert into messages
				set name = '{$name}',
					email = '{$email}',
					message = '{$message}',
					user_id = '{$user_id}'
			";			
		} else {
			$sql = "
				update messages
				set name = '{$name}',
					email = '{$email}',
					message = '{$message}',
					user_id = '{$user_id}',
				where id = {$id}
			";						
		}
		return $this->db->query($sql);
	}
	
	public function getList($user_id = null){
		$sql = "select * from messages where 1";
		if ( $user_id != null){
			$sql .= " and user_id = {$user_id}";
		} 
		
		return $this->db->query($sql);
		
	}
}