<?php

class allUser extends Model{
	
	
	public function getListByLogin(){
				
		$sql = "select * from users";
		$result = $this->db->query($sql);
		if (isset($result[0])){
			return $result;
		}
		return false;
	}	
	public function delete($id){		
		$sql = "delete from users where id = {$id}";			
		return $this->db->query($sql);					
	}

	public function unactive($id){
		
		$sql = "update users
				set is_active = '0'
				where id = {$id}
			";				
		return $this->db->query($sql);					
	}
	
	public function active($id){
		
		$sql = "update users
				set is_active = '1'
				where id = {$id}
			";				
		return $this->db->query($sql);					
	}

}
