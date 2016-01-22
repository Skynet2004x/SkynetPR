<?php

class Main_list extends Model{

	function reArrayFiles($file_post) {
		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i<$file_count; $i++) {
			foreach ( $file_keys as $key ) {
				if ( $file_post[error][$i] == 0 ) {
					$file_ary[$i][$key] = $file_post[$key][$i];										
					$file_ary[$i]['name'] = self::convertStr($file_ary[$i]['name']);					
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
	
	public function disActiveGood($good_id){								
		$sql = "UPDATE goods SET active = 0 WHERE id = {$good_id}";
		return $this->db->query($sql);
	}
	
	public function getEmailByUserId($user_id){								
		$sql = "SELECT email FROM users WHERE id = {$user_id}";
		return $this->db->query($sql)[0]['email'];
	}
		
	// отбор товаров с вариантов отбора по ид товара.
	public function getList($only_published = false, $good_id = null){
		
		$curent_user_id = getId();
		
		$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login AS user_login, u.email as user_email, u.id AS user_id, r.value AS rating_value, r.id AS rating_id, '' as goods_days_left
					FROM goods g
					left JOIN photo p ON g.id = p.goods_id
					JOIN users u ON g.user_id = u.id
					LEFT JOIN rating r ON g.id = r.goods_id ";
				if ( $good_id != null ) {
					$sql .= " WHERE u.is_active = 1 and g.active = 1 and g.id = {$good_id}"; 
				} else {
					if ( isset($curent_user_id) == null ) {
						$sql .= " WHERE u.is_active = 1 and g.active = 1 and g.start_time <= current_timestamp() ";
					} else {
						$sql .= " WHERE u.is_active = 1 and g.active = 1 and g.start_time <= current_timestamp() and g.user_id <> {$curent_user_id}";
					}
				}				 
				$sql .= " GROUP BY g.id";

		$result = $this->db->query($sql);
		$need_refresh = 0;
		foreach ($result as &$val){			
			$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );
			if ( $val['goods_active'] == 1 ) { // проверяем сроки если лот активен. если нет - пофигу
				if ( (int)$val['goods_days_left'] <= 0 ) { // скрыть все что с истекшим сроком
									
					$this->disActiveGood($val['goods_id']);			
					$need_refresh = 1;
				}
			}							
		}
		if ( $need_refresh == 1 ) {
			$this->getList();
		}		
		return $result;	
	}

	public function getGood($params){		
			$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, u.login as user_login, u.email as user_email, u.id as user_id, '' as goods_days_left, g.active AS goods_active
						FROM goods g
						join users u on g.user_id = u.id 
						WHERE g.id = {$params[0]} and u.id = {$params[1]}";
			$result = $this->db->query($sql);	
			$need_refresh = 0;							
			foreach ($result as &$val){			
				$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );	
					if ( $val['goods_active'] == 1 ) { // проверяем сроки если лот активен. если нет - пофигу				
						if( (int)$val['goods_days_left']  < 0 ){ 
							// отключить актуальность но показать				
							$this->disActiveGood($val['goods_id']);			
							$need_refresh = 1;							
						}					
					}
			}
			if ( $need_refresh == 1 ){
				$this->getGood($params);
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
		$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login AS user_login, u.id AS user_id,  '' as goods_days_left, g.active AS goods_active, cb.winer as winer,  cb.user_id as winer_id , u1.login as winer_login
					FROM goods g
					LEFT JOIN photo p ON g.id = p.goods_id
					JOIN users u ON g.user_id = u.id
					LEFT JOIN curent_buyer cb ON g.id = cb.goods_id
					LEFT JOIN users u1 ON u1.id = cb.user_id";
			if ( $user_id == null ) {
				$sql .= " WHERE u.is_active = 1 "; 
			} else {			
				$sql .= " WHERE u.is_active = 1 and g.user_id = {$user_id}"; 
			}				 
		$sql .= " GROUP BY g.id";
	
		$result	= $this->db->query($sql);
		$need_refresh = 0;
		foreach ( $result as &$val ) {
			
			$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );	

			if ( $val['goods_active'] == 1 ) { // проверяем сроки если лот активен. если нет - пофигу
				if( (int)$val['goods_days_left'] <= 0 ) { 
				// отключить актуальность но показать				
					$this->disActiveGood($val['goods_id']);	
					$need_refresh = 1;				
				}
			}
		}		
		if ( $need_refresh == 1 ) {
			$this->getListForUser($user_id);
		}				
		//print_r($result);
		for ($i=0; $i < count($result); $i++) {
			$val = &$result[$i];
			//добавим всех кто делал ставки
			$sql = "SELECT cb.user_id,cb.goods_id,cb.set_price, cb.date_time, cb.winer, u.city, u.login as winer_login
						FROM curent_buyer cb 
						JOIN users u ON cb.user_id = u.id
						where u.is_active = 1 and cb.goods_id = {$val['goods_id']} #cb.user_id = {$user_id} and";
				$result_w = $this->db->query($sql);
			if( $result_w != null ) {
				$val['winer_u'] = $result_w;			
			} 
			
		}		
		return $result;				
	}
	
	public function getDetail($params) {		
		$sql = "SELECT g.id AS goods_id, g.name AS goods_name, g.cur_price AS goods_cur_price, g.decs AS goods_decs, g.num_days AS goods_num_days, g.price AS goods_price, g.start_time AS goods_start_time, g.step_price AS goods_step_price, p.path AS photo_path, p.goods_id AS photo_goods_id, u.login as user_login, u.email as user_email, u.id as user_id, r.value AS rating_value, r.id AS rating_id, '' as goods_days_left, g.active AS goods_active
					FROM goods g
					left JOIN photo p ON g.id = p.goods_id	
					join users u on g.user_id = u.id 
					LEFT JOIN rating r ON r.goods_id = g.id
					WHERE g.active = 1 and g.id = {$params[0]}";
											
		$result = $this->db->query($sql);
		$need_refresh = 0;
		foreach ( $result as &$val ) {			
				$val['goods_days_left'] = $this->getTimeFromDate($val['goods_start_time'] , $val['goods_num_days'] );				
					if( (int)$val['goods_days_left']  <= 0 ) { 
						// отключить актуальность но показать				
						$this->disActiveGood($val['goods_id']);			
						$need_refresh = 1;							
					}					
			}
			if ( $need_refresh == 1 ) {
				$this->getDetail($params);
			}	
		return $result;	
		
	}	
	
	public function  updateCurrentPrice(){		
		if(isset($_POST['id']) && isset($_POST['user_id'])){
			$good_id = (int)$_POST['id'];
			$user_id = $this->db->escape($_POST['user_id']);
			$res = $this->getDetail(array('0'=>$good_id));
			
				$cur_goods = $res[0];			
				if ($cur_goods['goods_cur_price'] != $cur_goods['goods_price']){
					// проверим когда пользователь нажимал эту кнопку последний раз . период 1 раз в час
					$sql = "SELECT  60-(UNIX_TIMESTAMP( current_timestamp ) - UNIX_TIMESTAMP( date_time ))/60 as time_left , max(id) FROM byers WHERE user_id = {$user_id} AND goods_id = {$good_id}";
					$result_time = $this->db->query($sql);
					
					if (isset($result_time[0]['time_left'])){
						$time_left = (int)$result_time[0]['time_left']; // из хитроумного запроса получаем сразу время которое исталось ждать след. ставки						
						if ( ($time_left >= 0 ) && ($time_left <= 61)) {
							echo "Следующая ставка будет доступна через {$time_left} минут";
							return true;						
						} else {
							// срок огранечения истек. строчку надо удалить
							$sql = "DELETE FROM byers WHERE user_id = {$user_id} AND goods_id = {$good_id}";
							$result_delete = $this->db->query($sql);
							
							// обновим див с текущей ценой
							$new_price = $cur_goods['goods_step_price']+$cur_goods['goods_cur_price'];
						echo "<label id='lbl_cur_price'>".__('form_add_price','Price').": </label> <button id='btn_cur_pr' class='btn btn-sm btn-success' onClick='javascript: byestep({$cur_goods['goods_id']},".getId().");'>{$new_price} ".__('uah','UAH.')."</button>";																	
						};	
					}else {
						$new_price = $cur_goods['goods_step_price']+$cur_goods['goods_cur_price'];
					echo "<label id='lbl_cur_price'>".__('form_add_price','Price').": </label> <button id='btn_cur_pr' class='btn btn-sm btn-success' onClick='javascript: byestep({$cur_goods['goods_id']},".getId().");'>{$new_price} ".__('uah','UAH.')."</button>";																	
					
					}					
				} else {
					echo "1";				
				}
		}
		return false;
	}
	
	public function  byeStep(){	
		
		if( isset($_POST['id']) && isset($_POST['user_id']) ) {
			$good_id    = (int)$_POST['id'];
			$user_id    = $this->db->escape($_POST['user_id']);			
			// надо взять из базы стоимости товаров текущей, шаг, текущей + шаг , максималка
			$sql = "SELECT * FROM goods where id = {$good_id }";
			$res = $this->db->query($sql);
			
			$cur_price  = $res[0]['cur_price'];
			$step_price = $res[0]['step_price'];
			$max_price  = $res[0]['price'];
			$new_cur_price = $cur_price + $step_price;						
			// сначала надо проверить не равна ли новая цена максимальной.

			if( $new_cur_price >= (int)$max_price){ // приплыли... последняя ставка сделана

				// записать в базу победителя. 
				//добавить в карзину
				//закрыть товар	
					
					$sql = "UPDATE goods SET cur_price ={$max_price}, 
											 active = 0 
										 WHERE id = {$good_id}; ";
					$res = $this->db->query($sql);
					
					$sql = "INSERT INTO byers SET goods_id = {$good_id}, 
											  user_id = {$user_id}";
					$res = $this->db->query($sql);					
					
					$sql = "INSERT INTO cart SET goods_id = {$good_id}, 
												 user_id = {$user_id}";								
					$res = $this->db->query($sql);					
					
					$sql = "INSERT INTO curent_buyer SET goods_id = {$good_id}, 
														 user_id = {$user_id}, 
														 set_price = {$max_price}, 
														 winer = 1";			
					$res = $this->db->query($sql);	

		
		// тут надо определеить чей товар и ему отправить письмо
					echo __('ads_sold','Sold');
					return "sold";					
			} else { // торгуем дальше 							
				
				$sql2 = "INSERT INTO byers SET goods_id = {$good_id}, 
											   user_id = {$user_id}";
				$res2 = $this->db->query($sql2);				
				
				$sql1 = "INSERT INTO curent_buyer SET goods_id = {$good_id}, 
												  user_id = {$user_id}, 
												  set_price = {$new_cur_price}, 
												  winer = '0'";			
				$res1 = $this->db->query($sql1);									
				
				$sql3 = "UPDATE goods SET cur_price = {$new_cur_price} WHERE id = {$good_id}";
				$res3 = $this->db->query($sql3);	
				$time_left = 60; 
				echo "Следующая ставка будет доступна через {$time_left} минут";									
				return true;
			}			
		}
		return	false;
	}

	public function soldMaxPrice(){
			if( isset($_POST['id']) && isset($_POST['user_id']) ) {
				$good_id = (int)$_POST['id'];
				$user_id = (int)$_POST['user_id'];			
				
				$sql = "SELECT * FROM goods where id = {$good_id }";
				$res = $this->db->query($sql);
				
				$cur_price  = $res[0]['cur_price'];
				$step_price = $res[0]['step_price'];
				$max_price  = $res[0]['price'];				

				// проверим когда пользователь нажимал эту кнопку последний раз . период 1 раз в час
				$sql = "SELECT date_time , max(id) FROM byers where user_id = {$user_id} AND goods_id = {$good_id}";
				$res = $this->db->query($sql);
			
				$sql = "INSERT INTO byers SET goods_id = {$good_id}, 
											  user_id = {$user_id}";			
				$res = $this->db->query($sql);	

				$sql = "INSERT INTO curent_buyer SET goods_id = {$good_id}, 
													 user_id = {$user_id}, 
													 set_price = {$max_price}, 
													 winer = 1";			
				$res = $this->db->query($sql);	
				
				$sql = "UPDATE goods SET cur_price ={$max_price}, active = 0 WHERE id = {$good_id}";
				$res = $this->db->query($sql);	
				
				$sql = "INSERT INTO cart SET goods_id = {$good_id}, 
											 user_id = {$user_id}";			
				$res = $this->db->query($sql);			
				
				echo __('ads_sold','Sold');
				return "sold";							
			}
			return	false;		
	}
	
	
	public function rating(){
	
		if( isset($_POST['goods_id']) && isset($_POST['user_votes']) ) {
			$good_id = (int)$_POST['goods_id'];
			$value = round($this->db->escape($_POST['user_votes']),2);
			if ( isset($_POST['rating_id']) && $_POST['rating_id']!=0 ) {				
				$rating_id = $this->db->escape($_POST['rating_id']);
				$sql = "UPDATE rating SET value = {$value} WHERE id = {$rating_id} and goods_id = {$good_id}";			
				$res = $this->db->query($sql);
				echo __('rating','Rating').": {$value}";
				//return $value; 
			} else {
				$sql = "INSERT INTO rating SET goods_id = {$good_id}, 
											   user_id = '', 
											   value = {$value}";							
				$res = $this->db->query($sql);
				
				echo __('rating','Rating').": {$value}";
			}
		}
			
	}	

	public function save($good_id = null){
		
		if ( isset($_FILES) ) {	
			
			$file_ary = $this->reArrayFiles($_FILES['filename']);
			
			foreach ( $file_ary as $file ) {
			
			   if($file["size"] > 1024*1*1024)
			   {
				 echo ("Размер файла превышает 1 мегабайт");
				 exit;
			   }
			   // Проверяем загружен ли файл
			   if( is_uploaded_file($file["tmp_name"]) ) {
				 // Если файл загружен успешно, перемещаем его
				 // из временной директории в конечную
				 move_uploaded_file($file["tmp_name"], ROOT.DS."webroot/uploads/".$file["name"]);
			   } else {
				  echo("Ошибка загрузки файла");
			   }
			}
		}	
		
		if( strlen($_POST['name'])>0 && strlen($_POST['price'])>0 && strlen($_POST['start_time'])>0 && strlen($_POST['num_days'])>0 && strlen($_POST['step_price'])>0 ) {
			
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
			$good_user_id = (int)$_POST['user_id'];	
			$goods_id = (int)$_POST['goods_id'];
			
			if( $goods_id > 0 ) {
				$sql = "update goods SET `name` = '{$good_name}' ,
										user_id = {$good_user_id} ,
										decs = '{$good_desc}' ,
										start_time = '{$good_start_time}' ,
										num_days = {$good_num_days} ,
										active = {$good_active} ,
										step_price = {$good_step_price} ,
										price = {$good_price}				
				WHERE id = {$goods_id} ";			
				$res = $this->db->query($sql);			
						
			} else {
				$sql = "INSERT INTO goods SET user_id = {$good_user_id},
											  `name`='{$good_name}', 
											  decs = '{$good_desc}',
											  start_time = '{$good_start_time }', 
											  num_days = {$good_num_days}, 
											  active = {$good_active},
											  step_price = {$good_step_price}, 
											  price = {$good_price}";															
				$res = $this->db->query($sql);
				
				$sql = "select id AS goods_id  from goods where user_id = {$good_user_id} 
												and `name` ='{$good_name}' 
												and decs = '{$good_desc}' 
												and start_time ='{$good_start_time }' 
												and num_days = {$good_num_days}
												and active = {$good_active} 
												and step_price = {$good_step_price}
												and price = {$good_price}";					
				$res = $this->db->query($sql);				
				$goods_id = $res[0]['goods_id'];
			}
			if ( count($file_ary)>0 ) {
				$sql = "INSERT INTO photo (goods_id, path) VALUES ";
				foreach ( $file_ary as $file ) {
					
					$goods_path = '/webroot/uploads/'.$file["name"];
					$sql .= " ({$goods_id},'{$goods_path}'),";						
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
////////////////// cart ////////////////////////
	public function getCart($user_id, $goods_id = null, $nouser_id = null){
		$sql = "SELECT * FROM cart c
						left JOIN goods g ON g.id = c.goods_id	
						left JOIN curent_buyer cb ON cb.user_id = c.user_id and cb.goods_id = c.goods_id and cb.winer = 1	
						WHERE c.user_id = {$user_id}";
		if ( $goods_id != null ) {
			
			$sql .= " and cb.goods_id = {$goods_id}";						
		}
		$result = $this->db->query($sql);
		
		foreach( $result as &$val ) {
			$sql = "SELECT p.path FROM photo p
					join goods g on p.goods_id = g.id
					join cart c on c.goods_id = g.id
					where c.goods_id = {$val['goods_id']}
					limit 1";
			$val['path'] = $this->db->query($sql)[0];
															// добавим всех кто делал ставки по каждому товару			
			$sql = "SELECT cb.user_id,cb.goods_id,cb.set_price, cb.date_time, cb.winer, u.city, u.login as winer_login
											FROM curent_buyer cb 
											JOIN users u ON cb.user_id = u.id
											where u.is_active = 1 and cb.goods_id = {$val['goods_id']} ";
			if ( $nouser_id != null ) {
				$sql .= 					" and cb.user_id != {$nouser_id} ";	
			}								
			$sql .=							"order by cb.date_time desc , cb.set_price desc ";
		
			$val['byers'] = $this->db->query($sql);			
		}
	
		return $result;
	}
	
	public function updateCart(){
			$user_id =	(int)$_POST['user_id'];
			$sql = "SELECT *, count(c.id) as num FROM cart c
					left JOIN goods g ON g.id = c.goods_id	
					WHERE c.user_id =  {$user_id}";
			$result =  $this->db->query($sql);

			echo "<a href='/mainlist/cart/'><img src='/img/card.png'> Ads: {$result[0]['num']} </a>";
			return true;
	}	
	
	public function cartClear(){
		
		$user_id = (int)$_POST['user_id'];
		$cart = new Cart($user_id);
		$cart->clear($user_id);

	}
	public function cartBackOut($user_id, $goods_id) {
		$current_user_id = $user_id; // победитель торгов
		$current_goods_id = $goods_id; // победитель торгов		
		$res = $this->getCart($user_id, $goods_id, $user_id);
		
		$all_byers = $res[0][byers]; /// список всех делавших ставки кроме победителя 

		if ( isset($all_byers[0]) ) { // если есть на кого отказаться то на него и вешаем.
				
				$user_id = (int)$all_byers[0]['user_id'];
				$goods_id = (int)$all_byers[0]['goods_id'];
				$set_price = $this->db->escape($all_byers[0]['set_price']);
				$date_time = $this->db->escape($all_byers[0]['date_time']);								

				$sql = "UPDATE curent_buyer SET winer = 1
											WHERE user_id = {$user_id} and 
												goods_id = {$goods_id} and 
												#date_time = '{$date_time}' and
												set_price = '{$set_price}'";															
				
				$res = $this->db->query($sql);	
				
				$sql = "UPDATE goods SET cur_price ={$set_price}, active = 0 WHERE id = {$goods_id}";
				$res = $this->db->query($sql);	
				
				$sql = "INSERT INTO cart SET goods_id = {$goods_id}, 
											 user_id = {$user_id}";	
				
				$res = $this->db->query($sql);		
			
		} else { // не на кого отказываться - скрываем лот
			$sql = "UPDATE goods SET cur_price = 0, 
									 active = 0, 
									 num_days = 0
									 WHERE id = {$goods_id}";
			$res = $this->db->query($sql);		
		}

		// // а с этого снять победу.
	

		$sql = "DELETE FROM cart WHERE goods_id = {$current_goods_id} and 
											 user_id = {$current_user_id}";					
		$res = $this->db->query($sql);	
		$sql = "DELETE FROM curent_buyer WHERE user_id = {$current_user_id} and 
												goods_id = {$current_goods_id}";															
		$res = $this->db->query($sql);			
		
	}	
}

