<?php
$CFG->sesion_grnic="SESIONBOMM";

if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
else $frm=$_GET;

switch(nvl($frm["mode"])){
	case "confirmar_inscripcion":
		confirmar_inscripcion($frm);
		break;
	case "acceso":
		acceso($frm);
		break;
	case "final":
		procesar_paso_4($frm);
		break;
	case "acceso_admin":
		acceso_admin($frm);
		break;
	case "login":
		print_login_form($frm,"acceso");
		break;
	case "paso_4":
		procesar_paso_3($frm);
		break;
	case "paso_4muestra":
		muestra_paso_4($frm);
		break;
	case "paso_3":
		procesar_paso_2($frm);
		break;
	case "paso_3muestra":
		muestra_paso_3($frm);
		break;
	case "paso_2":
		procesar_paso_1($frm);
		break;
	case "paso_2muestra":
		muestra_paso_2($frm);
		break;
	case "eliminar_obra":
		eliminar_obra($frm);
		break;	
	case "vertodo":
		vertodo($frm);
		break;		
	default:
		paso_1($frm);
		break;
}

function confirmar_inscripcion($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";

	
	$result=$db->sql_row("SELECT * FROM promotores WHERE id='".$frm["id_programador"]."'");
		
		if($result["preinscripto"]==0){
			$frm["id"]=$frm["id_programador"];
			$frm["preinscripto"]=1;
			$db->sql_update("promotores", $frm);	
	
			require("../class.phpmailer.php");
			
			$mailer = new PHPMailer();
			$mailer->IsSMTP();
			$mailer->Host = 'ssl://smtp.gmail.com:465';
			$mailer->SMTPAuth = TRUE;
			$mailer->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer->From = $_POST['email1'];  // This HAVE TO be your gmail adress
			$mailer->FromName = 'BOmm'; // This is the from name in the email, you can put anything you like here
			
			
			$dest = 'compradores@bogotamusicmarket.com'; //remplazar por el de compradores@bogotamusicmarlet.com
			$body.="El Comprador ".$result["nombre_empresa"]." ha finalizado el proceso de pre-inscripción al BOmm - Bogotá Music Market\n\n";	
			$body.="Atentamente,\n\n";
			$body.="BOmm - Bogotá Music Market\n";
			$body.="compradores@bogotamusicmarket.com\n";
			$body.="http://www.bogotamusicmarket.com/\n";
			$body.="\n";

			$mailer->Body = $body;
			$mailer->Subject = 'Comprador BOmm - finalización Pre-inscripción';
			$mailer->AddAddress($dest);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			  /* echo "Message was not sent<br/ >";
			   echo "Mailer Error: " . $mailer->ErrorInfo;*/
			}else{
				
				}
				
			$mailer2 = new PHPMailer();
			$mailer2->IsSMTP();
			$mailer2->Host = 'ssl://smtp.gmail.com:465';
			$mailer2->SMTPAuth = TRUE;
			$mailer2->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer2->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer2->From = $_POST['email'];  // This HAVE TO be your gmail adress
			$mailer2->FromName = 'BOmm'; // This is the from name in the email, you can put anything you like here	
			$mailer2->From = 'compradores@bogotamusicmarket.com'; 	 //remplazar por el de compradores@bogotamusicmarlet.com
			$dest2 = $result["email1"];
			$body2.= "Comprador(s) ".$result["nombre_empresa"]." ha finalizado el proceso de pre-inscripción al BOmm - Bogotá Music Market, muy pronto estaremos en contacto con usted\n\n";	
			$body2.="Cordialmente:\n";
			$body2.="BOmm - Bogotá Music Market\n";
			$body2.="compradores@bogotamusicmarket.com\n";
			$body2.="http://www.bogotamusicmarket.com/\n";
			$body2.="\n";

			$mailer2->Body = $body2;
			$mailer2->Subject = 'Comprador BOmm - finalización Pre-inscripción';
			$mailer2->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer2->Send())
			{
			  /* echo "Message was not sent<br/ >";
			   echo "Mailer Error: " . $mailer->ErrorInfo;*/
			}else{
				
				}	
			
			
			}	
	
	
		


	include("CCB/finalp.php");
}

function procesar_paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
    $frm["id"]=$frm["id_programador"];
 if (@$frm['verifica1']){
	  $frm['verifica1']=1;
	 }else{
	  $frm['verifica1']=0;	 
		 }

	 $frm["pregunta1"];
	 $frm["pregunta2"];
	 $frm["pregunta3"];
	 $frm["pregunta4"];
	 $frm["pregunta5"];
	
	$db->sql_update("promotores", $frm);	
    include("CCB/confirmar_inscripcionp.php");
}

function acceso($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
	$user = verify_login($frm["login"], $frm["password"]);
	if ($user) {
		$_SESSION[$CFG->sesion_grnic]["user"] = $user;
		$_SESSION[$CFG->sesion_grnic]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_grnic]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_grnic]["path"] = NULL;	
		$frm=$db->sql_row("SELECT * FROM promotores WHERE id = '$user[id]'");
		if($frm["preinscripto"]==0){
		$frm["id_programador"]=$user["id"];
		include("CCB/paso_2P.php");
    	}else{
			include("CCB/final2P.php");
			}
	} else {
		$frm["error2"] = "Login inválido, por favor intente de nuevo.";
		//$newMode="acceso";
		include("CCB/paso_1P.php");
	}
}


function acceso_admin($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";

	$user = verify_login($frm["login"], $frm["password"]);
	if ($user) {
		$_SESSION[$CFG->sesion_admin]["user"] = $user;
		$_SESSION[$CFG->sesion_admin]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_admin]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_admin]["path"] = NULL;
		$area="musica";
		$goto = $CFG->admin_dir . "/index.php?module=grupos_$area";

		header("Location: $goto");
		die;
	} else {
		$frm["error"] = "Login inválido, por favor intente de nuevo.";
		include("CCB/login_form.php");
	}
}

function verify_login($username, $password) {
	GLOBAL $db;
	$seccion="compradores";
	$pass = md5($password);
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM promotores WHERE login = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid))	return($user);
	return(FALSE);
}

function print_login_form($frm,$newMode="acceso_admin"){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";

	include("CCB/login_form.php");
}

function procesar_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
   
	include("CCB/paso_4P.php");
}

function procesar_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";

		$frm["id"]=$frm["id_programador"];
		$frm["id_programador"]=$frm["id"];
		
		$frm["interes"]='';
		if (@$frm['interes1']){$frm["interes"].='Balada Pop  ';}
		if (@$frm['interes2']){$frm["interes"].='Blues  ';}
		if (@$frm['interes3']){$frm["interes"].='Blues Rock  ';}
		if (@$frm['interes4']){$frm["interes"].='Bolero  ';}
		if (@$frm['interes5']){$frm["interes"].='Cumbia  ';}
		if (@$frm['interes6']){$frm["interes"].='Electronica  ';}
		if (@$frm['interes7']){$frm["interes"].='Folk  ';}
		if (@$frm['interes8']){$frm["interes"].='Fusion  ';}
		if (@$frm['interes9']){$frm["interes"].='Heavy Metal  ';}
		if (@$frm['interes10']){$frm["interes"].='Hip-Hop/Rap  ';}
		if (@$frm['interes11']){$frm["interes"].='Jazz  ';}
		if (@$frm['interes12']){$frm["interes"].='Mariachi  ';}
		if (@$frm['interes13']){$frm["interes"].='Merengue  ';}
		if (@$frm['interes14']){$frm["interes"].='Música Clásica  ';}
		if (@$frm['interes15']){$frm["interes"].='Música Infantil  ';}
		if (@$frm['interes16']){$frm["interes"].='Opera  ';}
		if (@$frm['interes17']){$frm["interes"].='Popular  ';}
		if (@$frm['interes18']){$frm["interes"].='Pop Alternativo  ';}
		if (@$frm['interes19']){$frm["interes"].='Pop Electrónico  ';}
		if (@$frm['interes20']){$frm["interes"].='Poprock  ';}
		if (@$frm['interes21']){$frm["interes"].='Punk/Hardcore  ';}
		if (@$frm['interes22']){$frm["interes"].='Ranchera  ';}
		if (@$frm['interes23']){$frm["interes"].='Reggae  ';}
		if (@$frm['interes24']){$frm["interes"].='Reggaeton  ';}
		if (@$frm['interes25']){$frm["interes"].='Rock Clásico  ';}
		if (@$frm['interes26']){$frm["interes"].='Salsa y Son  ';}
		if (@$frm['interes27']){$frm["interes"].='Ska  ';}
		if (@$frm['interes28']){$frm["interes"].='Soft Rock  ';}
		if (@$frm['interes29']){$frm["interes"].='Tango  ';}
		if (@$frm['interes30']){$frm["interes"].='Vallenato  ';}
		if (@$frm['interes31']){$frm["interes"].='Vocal y Acapella  ';}

		
		$db->sql_update("promotores", $frm);

	include("CCB/paso_3P.php");
}

function procesar_paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
	if($usuario=$db->sql_row("SELECT * FROM promotores WHERE login='$frm[login]'")){
		$frm["error"]="El usuario ya existe.";
		paso_1($frm);
	}else{
		
		if($usuario=$db->sql_row("SELECT * FROM promotores WHERE email1='$frm[email1]'")){
			$frm["error"]="El usuario ya existe.";
			paso_1($frm);
		}else{
			$pss=$frm["password"];
			$frm["password"]=md5($frm["password"]);
			$frm["email1"]=$_POST["email1"];
			$frm["preinscripto"]="0";//En proceso
			$frm["id_promotor"]=$db->sql_insert("promotores", $frm);
			/* codigo de envio de notificaciones */
			
			require("../class.phpmailer.php");
			$mailer = new PHPMailer();
			$mailer->IsSMTP();
			$mailer->Host = 'ssl://smtp.gmail.com:465';
			$mailer->SMTPAuth = TRUE;
			$mailer->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer->From = $_POST['email1'];  // This HAVE TO be your gmail adress
			$mailer->FromName = 'BOmm'; // This is the from name in the email, you can put anything you like here
			
			
			$dest = 'compradores@bogotamusicmarket.com'; //remplazar por el de compradores@bogotamusicmarlet.com
			$body.= "Se ha creado una cuenta como comprador con los siguiente datos:\n\n";	
			$body.= "Usuario:    ".$frm["login"]."\n";	
			$body.= "Clave:    ".$pss."\n\n";
			
			$body.="Atentamente,\n\n";
			$body.="BOmm - Bogotá Music Market\n";
			$body.="compradores@bogotamusicmarket.com\n";
			$body.="http://www.bogotamusicmarket.com/\n";
			$body.="\n";

			$mailer->Body = $body;
			$mailer->Subject = 'Comprador Cuenta Nueva BOmm';
			$mailer->AddAddress($dest);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			  /* echo "Message was not sent<br/ >";
			   echo "Mailer Error: " . $mailer->ErrorInfo;*/
			}else{
				
				}
				
			$mailer2 = new PHPMailer();
			$mailer2->IsSMTP();
			$mailer2->Host = 'ssl://smtp.gmail.com:465';
			$mailer2->SMTPAuth = TRUE;
			$mailer2->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer2->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer2->From = $_POST['email'];  // This HAVE TO be your gmail adress
			$mailer2->FromName = 'BOmm'; // This is the from name in the email, you can put anything you like here	
			$mailer2->From = 'compradores@bogotamusicmarket.com'; 	 //remplazar por el de compradores@bogotamusicmarlet.com
			$dest2 = $frm["email1"];
			$body2.= "Usted ha creado una cuenta como comprador con los siguiente datos:\n\n";	
			$body2.= "Usuario:    ".$frm["login"]."\n";	
			$body2.= "Clave:    ".$pss."\n\n";
			
			$body2.="Cordialmente:\n";
			$body2.="BOmm - Bogotá Music Market\n";
			$body2.="compradores@bogotamusicmarket.com\n";
			$body2.="http://www.bogotamusicmarket.com/\n";
			$body2.="\n";

			$mailer2->Body = $body2;
			$mailer2->Subject = 'Comprador Cuenta Nueva BOmm';
			$mailer2->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer2->Send())
			{
			  /* echo "Message was not sent<br/ >";
			   echo "Mailer Error: " . $mailer->ErrorInfo;*/
			}else{
				
				}	
			
			
			
			
			
			include("CCB/paso_2P.php");
		}
	}
}


function muestra_paso_4($frm){
GLOBAL $CFG, $ME, $db;
	$frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id=".$frm["id_programador"]."
		");
		
	$frm["id_programador"]=$frm["id"];
	$frm["id_promotor"]=$frm["id"];
	include("CCB/paso_4P.php");
	}



function muestra_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id=".$_GET["id_programador"]."
		");
		
	$frm["id_programador"]=$frm["id"];
	$frm["id_promotor"]=$frm["id"];
	include("CCB/paso_3P.php");
	}

function vertodo($frm){
	GLOBAL $CFG, $ME, $db;
		$seccion="compradores";
	$frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id=".$frm["id_programador"]."
		");
		
	$frm["id_programador"]=$frm["id"];
	$frm["id_promotor"]=$frm["id"];

		include("CCB/verpaso_2P.php");
		include("CCB/verpaso_3P.php");
		include("CCB/verpaso_4P.php");
	}

function eliminar_obra($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
    $frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id=".$_GET["id_promotor"]."
		");
		
	$frm["id_programador"]=$frm["id"];
	$frm["id_promotor"]=$frm["id"];
	$obra["id"]=$_GET["item"];
	$db->sql_query("delete from archivos_promotores where id='". $obra["id"]."'");
	include("CCB/paso_3P.php");

	}	

function muestra_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
	$frm["area"]="compradores";
	$id_programador=$_GET["id_programador"];
	
	if($id_programador!=""){
	$frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id=".$frm["id_programador"]."
		");
		
		$frm["id_programador"]=$id_programador;
		include("CCB/paso_2P.php");
	 }else{
		 paso_1($frm);
		 }
		 
}

function paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="compradores";
	$frm["area"]="compradores";
	include("CCB/paso_1P.php");
}

?>
