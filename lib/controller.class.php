<?php
class Controller{
	protected $data;
	protected $model;
	protected $params;
	
	public function getModel() {
		return $this->model;
	}
	
	public function getData() {
		return $this->data;
	}

	public function getParams() {
		return $this->params;
	}
	
	public function __construct($data = array()) {
	
		//session_start();
		// определим время сессии и если оно больше 1 часа - то выбросить пользователя из системы.
		if(isset($_SESSION['time'])&&(time()-$_SESSION['time'])>3600) {
			session_destroy();
			Router::redirect('/');
			exit();
		   // session_start();
		}
		$_SESSION['time']=time();	
		
		$this->data = $data;
		$this->params = App::getRouter()->getParams();
	}
	// впилим сюда мейлер потому как мыло должно улетать из контроллера а не моделей
	public function sendemail($email, $login, $message) {

		//$this->model->sendEmail($user);
		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		//date_default_timezone_set('Etc/UTC');
		require ROOT.DS.'lib'.DS.'mailer\PHPMailerAutoload.php';
		
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
		$mail->Port = 465 ;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'SSL';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username =  'igor.pyatenko00@gmail.com';
		//Password to use for SMTP authentication
		$mail->Password = '1234567890skynet';
		//Set who the message is to be sent from
		$mail->setFrom('igor.pyatenko00@gmail.com', 'Administrator');
		//Set an alternative reply-to address
		$mail->addReplyTo('igor.pyatenko00@gmail.com', 'Administrator');
		//Set who the message is to be sent to
		$mail->addAddress($email, $login);
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
		  <p>ISO-8859-1 text: йиоьзЕсжЯ</p>
		</div>
		</body>
		</html>');//file_get_contents('contents.html'), dirname(__FILE__));*/
				//Replace the plain text body with one created manually
				$mail->Subject = 'Registration';
				$mail->AltBody = $message;
				$mail->Body = $message;
				//Attach an image file
				//$mail->addAttachment(dirname(__FILE__).DS.'mailer'.DS.'images'.DS.'phpmailer_mini.png');
				//send the message, check for errors
								
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
	}	
	
}