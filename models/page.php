<?php

class Page extends Model{
	
	
	public function getList($user_id = null, $only_published = false){
				 
		$sql = "SELECT p.id, p.alias, p.title,p.date_time, p.content, p.is_published, u.id as user_id, u.login FROM pages p LEFT JOIN users u on p.user_id = u.id WHERE 1";
		if ( $only_published ){
			$sql .= " and p.is_published = 1";
		}
		if ( $user_id != null){
			$sql .= " and u.id = {$user_id}";
		} 
		return $this->db->query($sql);
	}	
	
	public function getByAlias($alias){
		$alias = $this->db->escape($alias);
		$sql = "select * from pages where alias ='{$alias}' limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}
	
	public function getByUserId($user_id){
		
		$user_id = $this->db->escape($user_id);
		$sql = "select * from pages where user_id = '{$user_id}'";
		return $this->db->query($sql);
		
	}	
	
	public function getById($id){
		$id = (int)$id;		
		$sql = "select * from pages where id ='{$id}' limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}	
	
	public function save($data, $id = null){
	
		if( !isset($data['alias']) && !isset($data['title']) && !isset($data['content']) ){ //&& (strlen($data['alias'])=0) && (strlen($data['title'])=0) && (strlen($data['content'])=0)) {
			return false;			
		}
		
		$user_id = (int)$this->db->escape($data['user_id']);
		$alias = $this->db->escape($data['alias']);
		$title = $this->db->escape($data['title']);
		$content = $this->db->escape($data['content']);
		$date_time = $this->db->escape($data['date_time']).' 00:00:00';
		$is_published = isset($data['is_published']) ? 1 : 0;
		
		if(!$id){ //add new 
			$sql = "
				insert into pages
				set alias = '{$alias}',
					title = '{$title}',
					content = '{$content}',					
					is_published = '{$is_published}',
					user_id = {$user_id},
					date_time = '{$date_time}'					
			";			
		} else {
			$sql = "
				update pages
				set alias = '{$alias}',
					title = '{$title}',
					content = '{$content}',
					is_published = '{$is_published}',
					user_id = '{$user_id}',
					date_time = '{$date_time}'
				where id = {$id}
			";						
		}
		return $this->db->query($sql);
	}	
	public function delete($id){
		
		$sql = "delete from pages where id = {$id}";			
		return $this->db->query($sql);					
	}
}
