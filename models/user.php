<?php

class User extends Model{
	
	
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

	public function save($data){
		
		if( !isset($data['login']) || !isset($data['password']) ){
			return false;			
		}
		
		$id = (int)$id;
		$login = $this->db->escape($data['login']);
		$email = $this->db->escape($data['email']);
		$role = $this->db->escape($data['role']);		
		$password = md5(Config::get('salt').$this->db->escape($data['password'])) ;		
		$is_active = $this->db->escape($data['is_active']);
		$city = $this->db->escape($data['city']);
		
		if(!$id){ //add new 
			$sql = "
				insert into users
				set login = '{$login}',
					email = '{$email}',
					role = '{$role}',
					password = '{$password}',
					is_active = '{$is_active}',
					city = '{$city}'
			";			
		} 
		return $this->db->query($sql);
	}
	
	public function sendemail($user){

		//$this->model->sendEmail($user);
		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		//date_default_timezone_set('Etc/UTC');
		require '/mailer/PHPMailerAutoload.php';
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 465;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'ssl';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username =  'igor.pyatenko00@gmail.com';
		//Password to use for SMTP authentication
		$mail->Password = 'skynet1234567890';
		//Set who the message is to be sent from
		$mail->setFrom('igor.pyatenko00@gmail.com', 'Administrator');
		//Set an alternative reply-to address
		$mail->addReplyTo('igor.pyatenko00@gmail.com', 'Administrator');
		//Set who the message is to be sent to
		$mail->addAddress($user['email'], $user['login']);
		//Set the subject line
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		/*$mail->msgHTML('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		  <title>PHPMailer Test</title>
		</head>
		<body>
		<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
		  <h1>This is a test of PHPMailer.</h1>
		  <div align="center">
		  </div>
		  <p>This example uses <strong>HTML</strong>.</p>
		  <p>ISO-8859-1 text: éèîüçÅñæß</p>
		</div>
		</body>
		</html>');//file_get_contents('contents.html'), dirname(__FILE__));*/
				//Replace the plain text body with one created manually
				$mail->Subject = 'Registration';
				$mail->AltBody = "Congratulations! You was register successfull. Your login - ".$user['login'].", password - ".$user['password'];
				$mail->Body = "Congratulations! You was register successfull. Your login - ".$user['login'].", password - ".$user['password'];
				//Attach an image file
				//$mail->addAttachment(dirname(__FILE__).DS.'mailer'.DS.'images'.DS.'phpmailer_mini.png');
				//send the message, check for errors
	
				if (!$mail->send()) {
					//echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}
	}
	
}
