<?php

if (!empty($_POST)) {

	if(empty($_POST['nombre']) || empty($_POST['mensaje']) || empty($_POST['email']) ||  empty($_POST['apellido']) || ($_POST['asunto'] == "-- SELECCIONE --") ){
		$arrayMsj['success'] = FALSE;
    	$arrayMsj['message'] = 'Todos los campos son requeridos';
    	echo (json_encode($arrayMsj));
    	exit;
	}

	
	$template = '<h1>Mensaje enviado desde el formulario de via</h1><br><br>';
	$template .= 'Nombre: ' . $_POST['nombre'] . ' ' . $_POST['apellido'] . '<br>';
	$template .= 'Email: ' . $_POST['email'] .'<br>';
	$template .= 'Mensaje: <br>' . $_POST['mensaje'] ;
	
 	//$mail->Send(); 

	$arrayMsj['success'] = TRUE;
    $arrayMsj['message'] = 'Felicitaciones, su mensaje a sido enviado con éxito!!';
    echo (json_encode($arrayMsj));
     
}else{
	echo "Error al intentar acceder";
}