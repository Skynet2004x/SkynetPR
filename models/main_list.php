<?php

class Main_list extends Model{

	function reArrayFiles($file_post) {
		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				if ($file_post[error][$i] == 0 ) {
					$file_ary[$i][$key] = $file_post[$key][$i];
				}
			}
		}

		return $file_ary;
	}
	
	public function getTimeFromDate($date_start, $num_days){
		$strdate_start = strtotime( $date_start )+$num_days*86400;
		$time_2 = mktime (date("H") ,date("i") ,date("s") ,date("n") ,date("j") ,date("Y") ); // (0 часы, 0 мин, 0 сек, месяц, число, год) 
		$razniza = ($strdate_start - $time_2); // разница в секундах. 
		$razniza_2 = ($razniza /60); // делим $razniza на 60 чтобы узнать сколько минут в $razniza "; 
		$hour = floor($razniza_2 /60); // делим $razniza_2 на 60 чтобы узнать сколько часов в $razniza_2 получаем $hour - это будут часы"; 
		$min = $razniza_2 % 60; // что тут нужно? 			

		return "{$hour} Час(ов) : {$min} минут(ы)";
	}	
	
	// отбор товаров с вариантов отбора по ид товара.
	public function getList($only_published = false, $good_id = null){
		
		$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login AS user_login, u.id AS user_id, r.value AS rating_value, r.id AS rating_id, '' as goods_days_left
				 FROM goods g
				 left JOIN photo p ON g.id = p.goods_id
				 JOIN users u ON g.user_id = u.id
                 LEFT JOIN rating r ON g.id = r.goods_id ";
				 if ($good_id != null) {
					$sql .= " WHERE u.is_active = 1 and g.active = 1 and g.id = {$good_id}"; 
				 } else {
					$sql .= " WHERE u.is_active = 1 and g.active = 1 and (g.num_days > (current_timestamp - g.start_time)/(10*60*60*24)) and start_time <= current_timestamp";
				 }				 
				 $sql .= " GROUP BY g.id";				 
		/*if ( $only_published ){
			$sql .= " and  active = 1";
		}*/
		$result = $this->db->query($sql);
		foreach ($result as &$val){			
			$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );
		}
	return $result;	
	}

	public function getGood($params){		
			$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, u.login as user_login, u.id as user_id, '' as goods_days_left, g.active AS goods_active
				 FROM goods g
                 join users u on g.user_id = u.id 
				 WHERE g.id = {$params[0]} and u.id = {$params[1]}";
			$result = $this->db->query($sql);	
		
			foreach ($result as &$val){			
				$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );
			}
			
			$sql = "SELECT p.path AS photo_path
				 FROM goods g
				 left JOIN photo p ON g.id = p.goods_id	
                 join users u on g.user_id = u.id 
                 LEFT JOIN rating r ON r.goods_id = g.id
                 where g.id ={$params[0]}";
			
			$result[] = $this->db->query($sql);			
			return  $result;	
	}
	
	// отбор товаров конкретного юзера с вариантов отбора по ид юзера.
	public function getListForUser($user_id = null){
		//$user_id = Session::get('id');
						
		$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login AS user_login, u.id AS user_id,  '' as goods_days_left, g.active AS goods_active
		 FROM goods g
		 left JOIN photo p ON g.id = p.goods_id
		 JOIN users u ON g.user_id = u.id";
		 if ($user_id == null) {
			$sql .= " WHERE u.is_active = 1 "; 
		 } else {
			
			$sql .= " WHERE u.is_active = 1 and g.user_id = {$user_id}"; 
		 }				 
		 $sql .= " GROUP BY g.id";	
		$result	= $this->db->query($sql);
	
		foreach ($result as $val){
			$goods_days_left = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );
			
			if( (int)$goods_days_left < 0){ 
			// отключить актуальность но показать
				
				$good_id = $val['goods_id'];
				$sql = "UPDATE goods SET active = 0 WHERE id = {$good_id}";
				$this->db->query($sql);				
			}
		}
			$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login AS user_login, u.id AS user_id,  '' as goods_days_left, g.active AS goods_active
							 FROM goods g
							 left JOIN photo p ON g.id = p.goods_id
							 JOIN users u ON g.user_id = u.id";
							 if ($user_id != null) {
								$sql .= " WHERE u.is_active = 1 and g.user_id = {$user_id}"; 
							 } else {
								$sql .= " WHERE u.is_active = 1 "; //and g.active = 1 and (g.num_days > (current_timestamp - g.start_time)/(10*60*60*24)) 
							 }				 
							 $sql .= " GROUP BY g.id";	
				$result = $this->db->query($sql);
				foreach ($result as &$val){			
					$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );
				}
				return $result;				
	}
	
	public function getDetail($params){
		
		$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login as user_login, u.id as user_id, r.value AS rating_value, r.id AS rating_id, '' as goods_days_left, g.active AS goods_active
				 FROM goods g
				 left JOIN photo p ON g.id = p.goods_id	
                 join users u on g.user_id = u.id 
                 LEFT JOIN rating r ON r.goods_id = g.id
				 WHERE g.active = 1 and g.id = {$params[0]} and ((g.num_days-(current_timestamp - g.start_time)/(10*60*60*24)) > 0)";
							
				
				$result = $this->db->query($sql);
				foreach ($result as &$val){			
					$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );
				}
			return $result;	
		
	}	
	
	public function  updateCurrentPrice(){
		if(isset($_POST['id']) && isset($_POST['user_id'])){
			$good_id = $this->db->escape($_POST['id']);
			$user_id = $this->db->escape($_POST['user_id']);
			$res = $this->getDetail(array('0'=>$good_id));
			
				$cur_goods = $res[0];			
				if ($cur_goods['goods_cur_price'] != $cur_goods['goods_price']){
					// проверим когда пользователь нажимал эту кнопку последний раз . период 1 раз в час
					$sql = "SELECT date_time , max(id) FROM byers WHERE user_id = {$user_id} AND goods_id = {$good_id}";
					$result_time = $this->db->query($sql);
					if (isset($result_time[0]['date_time'])){
						$time_left = (int)(120-(time() - strtotime($result_time[0]['date_time']))/60);
						
						if ( ($time_left > 0 ) && ($time_left < 61)) {
							echo "Следующая ставка будет доступна через {$time_left} минут";
							return false;						
						} else {
							// срок огранечения истек. строчку надо удалить
							$sql = "DELETE FROM byers WHERE user_id = {$user_id} AND goods_id = {$good_id}";
							$result_delete = $this->db->query($sql);
							
							// обновим див с текущей ценой
							$new_price = $cur_goods['goods_step_price']+$cur_goods['goods_cur_price'];
							echo "<label id='lbl_cur_price'>".__('form_add_price','Price').":</label> <button id='btn_cur_pr' class='btn btn-sm btn-success' onClick='javascript: byestep({$cur_goods['goods_id']},".Session::get('id').",s{$cur_goods['goods_step_price']},{$cur_goods['goods_cur_price']});'>{$new_price} грн.</button>";																	
						};	
					}else {
						$new_price = $cur_goods['goods_step_price']+$cur_goods['goods_cur_price'];
					echo "<label id='lbl_cur_price'>".__('form_add_price','Price')."</label> <button id='btn_cur_pr' class='btn btn-sm btn-success' onClick='javascript: byestep({$cur_goods['goods_id']},".Session::get('id').",{$cur_goods['goods_step_price']},{$cur_goods['goods_cur_price']});'>{$new_price} грн.</button>";																	
					
					}					
				} else {
					echo "1";				
				}
		}
		return false;
	}
	
	public function  byeStep(){	
		if(isset($_POST['id']) && isset($_POST['user_id'])&& isset($_POST['cur_price'])){
			$good_id = $this->db->escape($_POST['id']);
			$cur_price = (int)$this->db->escape($_POST['cur_price']);
			$user_id = $this->db->escape($_POST['user_id']);			
			$step_price = (int)$this->db->escape($_POST['step_price']);
			$new_cur_price = $cur_price +$step_price;			
					
			$time_left = 60; 
			$sql = "INSERT INTO byers (goods_id, user_id) VALUES ({$good_id},{$user_id})";			
			$res = $this->db->query($sql);	
			
			$sql = "UPDATE goods SET cur_price ={$new_cur_price} WHERE id = {$good_id}";
			$res = $this->db->query($sql);					
			echo "Следующая ставка будет доступна через {$time_left} минут";
			return false;													
		}
		return	false;
	}

	public function soldMaxPrice(){
			if(isset($_POST['id']) && isset($_POST['user_id'])&& isset($_POST['max_price'])){
				$good_id = $this->db->escape($_POST['id']);
				$max_price = (int)$this->db->escape($_POST['max_price']);
				$user_id = $this->db->escape($_POST['user_id']);			
				
				// проверим когда пользователь нажимал эту кнопку последний раз . период 1 раз в час
				$sql = "SELECT date_time , max(id) FROM byers where user_id = {$user_id} AND goods_id = {$good_id}";
				$res = $this->db->query($sql);
			
				$sql = "INSERT INTO byers (goods_id, user_id) VALUES ({$good_id},{$user_id})";			
				$res = $this->db->query($sql);	
				
				$sql = "UPDATE goods SET cur_price ={$max_price}, active = 0 WHERE id = {$good_id}";
				$res = $this->db->query($sql);	
				echo "Товар продан.";
				return true;				
			}
			return	false;		
	}
	
	
	public function rating(){
	
		if(isset($_POST['goods_id']) && isset($_POST['user_votes'])){
			$good_id = $this->db->escape($_POST['goods_id']);
			$value = round($this->db->escape($_POST['user_votes']),2);
			if (isset($_POST['rating_id']) && $_POST['rating_id']!=0 ) {				
				$rating_id = $this->db->escape($_POST['rating_id']);
				$sql = "update rating SET value = {$value} WHERE id = {$rating_id} and goods_id = {$good_id}";			
				$res = $this->db->query($sql);
				echo __('rating','Rating').": {$value}";
				//return $value; 
			} else {
				$sql = "INSERT INTO rating (goods_id, user_id, value) VALUES ({$good_id},'',{$value})";							
				$res = $this->db->query($sql);
				
				echo __('rating','Rating').": {$value}";
			}
		}
			
	}	

	public function save($good_id = null){
		
		if (isset($_FILES)) {	
			$file_ary = $this->reArrayFiles($_FILES['filename']);
			foreach ($file_ary as $file) {
			
			   if($file["size"] > 1024*1*1024)
			   {
				 echo ("Размер файла превышает три мегабайта");
				 exit;
			   }
			   // Проверяем загружен ли файл
			   if(is_uploaded_file($file["tmp_name"]))
			   {
				 // Если файл загружен успешно, перемещаем его
				 // из временной директории в конечную
				 move_uploaded_file($file["tmp_name"], ROOT.DS."webroot/uploads/".$file["name"]);
			   } else {
				  echo("Ошибка загрузки файла");
			   }
			}
		}	
			   
		if(strlen($_POST['name'])>0 && strlen($_POST['price'])>0 && strlen($_POST['start_time'])>0 && strlen($_POST['num_days'])>0 && strlen($_POST['step_price'])>0){
			$good_name = $this->db->escape($_POST['name']);
			$good_price = $this->db->escape($_POST['price']);
			$good_start_time = $this->db->escape($_POST['start_time']);
			$good_num_days = $this->db->escape($_POST['num_days']);
			$good_step_price = $this->db->escape($_POST['step_price']);
			$good_desc = $this->db->escape($_POST['desc']);
			$good_active = $this->db->escape($_POST['active']);
			if ($good_active =='on'){
				$good_active = 1;
				} else {
					$good_active = 0; 
			}
			$good_user_id = $this->db->escape($_POST['user_id']);			
			 
			if(strlen($_POST['goods_id'])>0) {
				$sql = "update goods SET `name` = '{$good_name}' ,
										user_id = {$good_user_id} ,
										decs = '{$good_desc}' ,
										start_time = '{$good_start_time}' ,
										num_days = {$good_num_days} ,
										active = {$good_active} ,
										step_price = {$good_step_price} ,
										price = {$good_price}				
				WHERE id = {$_POST['goods_id']} ";			
				$res = $this->db->query($sql);			
						
			} else {
				$sql = "INSERT INTO goods (user_id, `name`, decs, start_time, num_days, active, step_price, price) VALUES 
						({$good_user_id},'{$good_name}','{$good_desc}','{$good_start_time }',{$good_num_days},{$good_active},{$good_step_price},{$good_price})";											
				
				$res = $this->db->query($sql);
				$sql = "select goods_id from goods where user_id = {$good_user_id} 
												and `name` ='{$good_name}' 
												and `decs` = '{$good_desc}' 
												and start_time ='{$good_start_time }' 
												and num_days = {$good_num_days}
												and active = {$good_active} 
												and step_price = {$good_step_price}
												and price = {$good_price}";					
				$res = $this->db->query($sql);
				
			}	
			
				
			
			
			if (count($file_ary)>0) {
				$sql = "INSERT INTO photo (goods_id, path) VALUES ";
				foreach ($file_ary as $file) {
					
					$goods_path = '/upload/'.$file["name"];
					$sql .= " ({$res[0]['goods_id']},'{$goods_path}'),";						
				}
				
				$sql = rtrim($sql,',');			
				return $this->db->query($sql);
			}
			return true;
			
		}
		return	false;
	}	
	
	public function delete($id){
		
		$sql = "delete from goods where id = {$id}";			
		return $this->db->query($sql);					
	}
}