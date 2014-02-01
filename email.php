<?php

if (isset($_POST)) {


echo "jan";
	require 'include/PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;
	$mail->IsSendmail();
	$mail->FromName ='jkjkjkj' ;

	$mail->From = 'juan2ramos@gmail.com';
	$mail->Subject = 'Boletin de Variedades #1 ';
	$mail->MsgHTML('Mensaje con HTML');
	$template = "sdfsdf";
	$mail->Body = $template;

	
	    $mail->AddAddress('juan2ramos@gmail.com', '');

	    if (!$mail->Send()) {
	        echo $mail->ErrorInfo;
	    } else { 
	    }
	    $mail->ClearAddresses();
	    
	


	 $arrayMsj['success'] = TRUE;
     $arrayMsj['url'] = '/administracion/principalAdmin';
     echo (json_encode($arrayMsj));
     
}