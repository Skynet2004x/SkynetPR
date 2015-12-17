<?php

	public function rating_up(){		
		if(isset($_POST['id']) && isset($_POST['user_id'])){
			$good_id = $this->db->escape($_POST['id']);
			$user_id = $this->db->escape($_POST['user_id']);

			if (isset($_POST['rating_id']) && $_POST['rating_id']!=null ) {
				$rating_id = $this->db->escape($_POST['rating_id']);
				$sql = "SELECT rating.id AS rating_id, rating.value as rating_value, rating.goods_id as rating_good_id, rating.user_id as rating_user_id
						from rating
						where rating.id = {$rating_id}";
				$res = $this->db->query($sql);
				
				$rating_value = (int)$res[0]['rating_value']+1;
				
				$sql = "update rating SET value = {$rating_value} WHERE id = {$rating_id}";			
				
			} else {
				$sql = "INSERT INTO rating (goods_id, user_id, value) VALUES ({$good_id},{$user_id},1)";			
			}
						
			return $this->db->query($sql);
		}
		return	false;
	}	
