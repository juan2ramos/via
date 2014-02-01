<?php

if (isset($_POST)) {


echo "jan";
	require 'include/PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'juan2ramos@gmail.com';                            // SMTP username
	$mail->Password = 'JcRpYjErT1212';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

	$mail->From = 'juan2ramos@gmail.com';
	$mail->FromName = 'Mailer';
	$mail->addAddress('jramosp1@ucentral.edu.co', 'Josh Adams');  // Add a recipient


	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	       // Add attachments
	    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Here is the subject';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}

	 $arrayMsj['success'] = TRUE;
     $arrayMsj['url'] = '/administracion/principalAdmin';
     echo (json_encode($arrayMsj));
     
}