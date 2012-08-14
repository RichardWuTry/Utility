<?php
	function sendMail($addressArray, $subject, $body)
	{
		require_once '/phpmailer/class.phpmailer.php';
		
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host = C('MAIL_HOST');
		$mail->Port = C('MAIL_PORT');
		$mail->SMTPAuth = true;
		$mail->Username = C('MAIL_LOGINNAME');
		$mail->Password = C('MAIL_PASSWORD');
		$mail->CharSet='UTF-8';

		$mail->From = C('MAIL_REPLAY_ADDRESS');
		$mail->FromName = C('MAIL_FROM_NAME');
		
		foreach($addressArray as $address){
			$mail->AddAddress($address);
		}
		
		$mail->WordWrap = 80;
		$mail->IsHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $body;

		if(!$mail->Send())
		{		   
		   return false;
		}

		return true;
	}
?>