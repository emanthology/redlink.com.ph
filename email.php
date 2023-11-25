<?php
	// Import the plugin
	require_once('PHPMailer/src/PHPMailerAutoload.php');

	// Get POST variables
	$email 			= $_POST['email'];
	$subject 		= $_POST['subject'];
	$message 		= 	'Email:' . $email . "\r\n" . 
						'Name: ' . $_POST['name'] . "\r\n" . 
						'Contact: ' . $_POST['contact-number'] . "\r\n\r\n" . 
						'Comments: ' . $_POST['comments'];
	
	// SEND EMAIL
	sendEmail('info@redlink.com.ph', $subject, $message);

	// FUNCTIONS
	function redirect($url, $statusCode = 303)
	{		
	   header('Location: ' . $url, true, $statusCode);
	   die();
	}

	function sendEmail($sendto, $subject, $message){

		// SERVER DETAILS
		$debug 			= 0; 						// Set to 0 on Production
		$host 			= 'mail.redlink.com.ph';	// You can see this on cPanel under Email Configuration
		$port 			= 25;						// Default
		$username 		= 'iconel@redlink.com.ph';	// Username of email account
		$password 		= 'conel.123!@#.';				// Password of email account


		// PHPMailer Configuration
		$mail 				= new PHPMailer();
		$mail->SMTPDebug 	= $debug;		
		$mail->Host 		= $host;
		$mail->Port 		= $port;
		$mail->SMTPAuth 	= true;					
		$mail->Username 	= $username;
		$mail->Password 	= $password; 
		$mail->From 		= $sendto;
		$mail->Subject 		= $subject;
		$mail->Body    		= $message;
		$mail->isSMTP();
		$mail->setFrom($username, 'REDLINK');		
		$mail->addAddress($sendto, 'RECIPIENT');		

		// Remove this code if you going to use SSL
		$mail->SMTPOptions = array(
			'ssl' => array(
		    'verify_peer' => false,
		    'verify_peer_name' => false,
		    'allow_self_signed' => true
		    ));		

		// SEND EMAIL
		if($mail->send()) {
			redirect('sent.html');
		} else {
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}
?>