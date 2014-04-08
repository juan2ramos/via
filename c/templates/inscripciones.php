<?php
$CFG->sesion_grnic="SESIONCIRCULART";

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
	case "eliminar_archivo":
		eliminar_archivo($frm);
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
	$seccion="inscripciones";


	$result=$db->sql_row("SELECT * FROM grupos_musica WHERE id='".$frm["id_grupo"]."'");
		
		if($result["ingresado_por"]==0){
			
	        $frm["id"]=$frm["id_grupo"];
			$frm["ingresado_por"]=1;
			$frm["terminos"]=1;
			$db->sql_update("grupos_musica", $frm);	

	
		require("../class.phpmailer.php");
			
			$mailer = new PHPMailer();
			$mailer->IsSMTP();
			$mailer->Host = 'ssl://smtp.gmail.com:465';
			$mailer->SMTPAuth = TRUE;
			$mailer->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer->From = $result['email'];  // This HAVE TO be your gmail adress
			$mailer->FromName = 'Artista Circulart2013'; // This is the from name in the email, you can put anything you like here
			
			
			$dest = 'info@circulart.org'; //remplazar por el de info@bogotamusicmarlet.com
			$body.="El Grupo o Artista ".$result["nombre"]." ha finalizado el proceso de inscripción al mercado de Circulart2013\n\n";	
			$body.="Atentamente,\n\n";
			$body.="Circulart2013\n";
			$body.="info@circulart.org\n";
			$body.="http://2013.circulart.org/\n";
			$body.="\n";

			$mailer->Body = $body;
			$mailer->Subject = 'Notificación de finalización de Inscripción';
			$mailer->AddAddress($dest);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			   //echo "Message was not sent<br/ >";
			   //echo "Mailer Error: " . $mailer->ErrorInfo;
			}else{
				
				}
				
			$mailer2 = new PHPMailer();
			$mailer2->IsSMTP();
			$mailer2->Host = 'ssl://smtp.gmail.com:465';
			$mailer2->SMTPAuth = TRUE;
			$mailer2->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer2->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer2->From = $_POST['email'];  // This HAVE TO be your gmail adress
			$mailer2->FromName = 'Circulart2013'; // This is the from name in the email, you can put anything you like here	
			$mailer2->From = 'info@circulart.org'; 	 //remplazar por el de info@bogotamusicmarlet.com
			$dest2 = $result["email"];
			$body2.= "Estimado(s) ".$result["nombre"]." ha finalizado el proceso de inscripción al mercado de Circulart2013, espere los resultados en la página web\n\n";	
			$body2.="Cordialmente:\n";
			$body2.="Circualrt2013\n";
			$body2.="info@circulart.org\n";
			$body2.="http://2013.circulart.org/\n";
			$body2.="\n";

			$mailer2->Body = $body2;
			$mailer2->Subject = 'Notificación de finalización de Inscripción';
			$mailer2->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer2->Send())
			{
			  /* echo "Message was not sent<br/ >";
			   echo "Mailer Error: " . $mailer->ErrorInfo;*/
			}else{
				
				}	
			
			}	
	include("CCB/paso_1Cierre2.php");
	//include("CCB/final.php");
}

function procesar_paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
    $frm["id"]=$frm["id_grupo"];
	include("CCB/paso_1Cierre2.php");
   //include("CCB/confirmar_inscripcion.php");
}

function acceso($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
	$user = verify_login($frm["login"], $frm["password"]);
	if ($user) {
		$_SESSION[$CFG->sesion_grnic]["user"] = $user;
		$_SESSION[$CFG->sesion_grnic]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_grnic]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_grnic]["path"] = NULL;
		$area=$frm["area"];	
		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$user[id]' LIMIT 1)
		");
		
		/**validacion si la cuenta esta relacionado con el cgurpo **/
		$frm["id_usuario"]=$user["id"];
		$frm["id_grupo"]=$frm["id"];
		$frm["login"]=$user["login"];
		$frm["area"]=$area;
		$db->sql_query("UPDATE usuarios SET nombre='".$frm["nombre"]."', apellido='VIA2014' WHERE id='$frm[id_usuario]'");
		$db->sql_query("UPDATE grupos_$area SET convenio='VIA2014' WHERE id='$frm[id_grupo]'");		
		include("CCB/paso_2.php");
	} else {
		$frm["error2"] = "Login inválido, por favor intente de nuevo.";
		$newMode="acceso";
		include("CCB/paso_1.php");
	}
}


function acceso_admin($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

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
		include("CCB/paso_1Cierre2.php");
		//include("CCB/login_form.php");
	}
}

function verify_login($username, $password) {
	GLOBAL $db;
	$seccion="inscripciones";
	$pass = md5($password);
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM usuarios WHERE login = '$username' AND password = '" . $pass . "' AND id_nivel IN (4,5,6,7,8,9)");
	if($user=$db->sql_fetchrow($qid)){
		if($user["apellido"]!="Centroamerica"){
		   return($user);
			}else{
		return(FALSE);
		};
	}else{
		return(FALSE);
		};
}

function print_login_form($frm,$newMode="acceso_admin"){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
    include("CCB/paso_1Cierre2.php");
	//include("CCB/login_form.php");
}

function procesar_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
    include("CCB/paso_1Cierre2.php");
	//include("CCB/paso_4.php");
}

function procesar_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	$usuario=$db->sql_row("SELECT * FROM usuarios WHERE id='$frm[id_usuario]'");

	if($frm["id_grupo"]!=""){//Ya existe...

       if($frm["genero1"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="42";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='42'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='42'");  
		   };
		   
		   
		   
		if($frm["genero2"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="10";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='10'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='10'");  
		   };
		   
		 
		 
		 if($frm["genero2"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="11";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='11'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='11'");  
		   };
		   
		   
		   
		   
		if($frm["genero4"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="6";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='6'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='6'");  
		   };
		   
		   
		   
		   
		if($frm["genero5"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="5";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='5'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='5'");  
		   };
		   
		   
		if($frm["genero6"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="22";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='22'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='22'");  
		   };
		   
		   
		   
		if($frm["genero7"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="20";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='20'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='20'");  
		   };
		   
		   
		   
		if($frm["genero8"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="45";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='45'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='45'");  
		   };
		   
		   
		   
		if($frm["genero9"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="38";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='38'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='38'");  
		   };
		   
		   
		   
		if($frm["genero10"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="46";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='46'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='46'");  
		   };
		   
		   
		if($frm["genero11"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="44";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='44'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='44'");  
		   };
		   
		   
		if($frm["genero12"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="41";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='41'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='41'");  
		   };
		   
		   
		if($frm["genero13"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="7";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='7'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='7'");  
		   };
		   
		   
		if($frm["genero14"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="37";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='37'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='37'");  
		   };
		   
		   
	if($frm["genero15"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="4";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='4'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='4'");  
		   };
		   
		   
	 if($frm["genero16"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="43";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='43'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='43'");  
		   };
		   
	  if($frm["genero17"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="13";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='13'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='13'");  
		   };
		   
		   
		if($frm["genero18"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="39";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='39'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='39'");  
		   };
		   
		   
		if($frm["genero19"]=="on"){
		   $frm["id_grupos_musica"]=$frm["id_grupo"];
		   $frm["id_generos_musica"]="40";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='40'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_musica",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_musica where id_grupos_musica='".$frm["id_grupo"]."' AND id_generos_musica='40'");  
		   };
		   
		   
		   	                                         
		   
		   
	   
	
		$frm["id"]=$frm["id_grupo"];
		$db->sql_update("grupos_" . $frm["area"], $frm);
	}
	include("CCB/paso_1Cierre2.php");
	//include("CCB/paso_2.php");
}

function procesar_paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	if($usuario=$db->sql_row("SELECT * FROM usuarios WHERE login='$frm[login]'")){
		$frm["error"]="El usuario ya existe.";
		paso_1($frm);
	}else{
		if($usuario=$db->sql_row("SELECT * FROM usuarios WHERE email='$frm[email]'")){
			$frm["error"]="El usuario ya existe.";
			paso_1($frm);
		}else{
			$pss=$frm["password"];
			$frm["id_nivel"]=8;
			$frm["password"]=md5($frm["password"]);
			$frm["id_usuario"]=$db->sql_insert("usuarios",$frm);
			$frm["area"]="musica";
			$frm["email"]=$_POST["email"];
			$frm["terminos"]=1;//acepto los terminos y condiciones
			$frm["ingresado_por"]="0";//En proceso
			if(isset($_GET['a'])) {	
				if($_GET['a']==0){
					$frm["convenio"]="Circulart2013";
					$frm["id_grupo"]=$db->sql_insert("grupos_" . $frm["area"], $frm);
				}else{
					$frm["convenio"]="Centroamerica";
					$frm["id_grupo"]=$db->sql_insert("grupos_" . $frm["area"], $frm);
					}
			}
			$db->sql_query("INSERT INTO usuarios_grupos_" . $frm["area"] . " (id_usuario,id_grupo_" . $frm["area"] . ") VALUES('$frm[id_usuario]','$frm[id_grupo]')");
			
			if(isset($_GET['a'])) {	
				if($_GET['a']==0){
					$db->sql_query("UPDATE usuarios SET nombre='".$frm["nombre"]."', apellido='Circulart2013' WHERE id='$frm[id_usuario]'");
				}else if($_GET['a']==1){
						$db->sql_query("UPDATE usuarios SET nombre='".$frm["nombre"]."', apellido='Centroamerica' WHERE id='$frm[id_usuario]'");
						
						}
  			}
			
			
			
		
					
			require("../class.phpmailer.php");
			$mailer = new PHPMailer();
			$mailer->IsSMTP();
			$mailer->Host = 'ssl://smtp.gmail.com:465';
			$mailer->SMTPAuth = TRUE;
			$mailer->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer->From = $_POST['email'];  // This HAVE TO be your gmail adress
			$mailer->FromName = 'Artista Circulart2013'; // This is the from name in the email, you can put anything you like here
			
			
			$dest = 'info@circulart.org'; //remplazar por el de info@bogotamusicmarlet.com
			$body.= "El Grupo o Artista ".$frm["nombre"]." ha creado una cuenta para participar en el mercado del Circulart2013\n\n";	
			$body.= "Nombre:    ".$frm["nombre"]."\n";
			$body.= "Usuario:    ".$frm["login"]."\n";	
			$body.= "Clave:    ".$pss."\n\n";
			
			$body.="Atentamente,\n\n";
			$body.="Circulart2013\n";
			$body.="info@circulart.org\n";
			$body.="http://2013.circulart.org/\n";
			$body.="\n";

			$mailer->Body = $body;
			$mailer->Subject = 'Notificación de Cuenta Nueva Circulart2013';
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
			$mailer2->FromName = 'Circulart2013'; // This is the from name in the email, you can put anything you like here	
			$mailer2->From = 'info@circulart.org'; 	 //remplazar por el de info@bogotamusicmarlet.com
			$dest2 = $frm["email"];
			$body2.= "Estimado(s) ".$frm["nombre"]." ha creado una cuenta para participar en el mercado de Circulart2013\n\n";	
			$body2.= "Nombre:    ".$frm["nombre"]."\n";
			$body2.= "Usuario:    ".$frm["login"]."\n";	
			$body2.= "Clave:    ".$pss."\n\n";
			
			$body2.="Cordialmente:\n";
			$body2.="Circulart2013\n";
			$body2.="info@circulart.org\n";
			$body2.="http://2013.circulart.org/\n";
			$body2.="\n";

			$mailer2->Body = $body2;
			$mailer2->Subject = 'Notificación de Cuenta Nueva Circulart2013';
			$mailer2->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer2->Send())
			{
			  /* echo "Message was not sent<br/ >";
			   echo "Mailer Error: " . $mailer->ErrorInfo;*/
			}else{
				
				}	
	
				
				include("CCB/paso_1Cierre2.php");
			//include("CCB/paso_2.php");
			}
	}
}


function muestra_paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$area="musica";	
	$id_usurio=$_SESSION[$CFG->sesion_grnic]["user"]["id"];
		$seccion="inscripciones";
		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$id_usurio' LIMIT 1)
		");
		$frm["id_usuario"]=$id_usurio;
		$frm["id_grupo"]=$frm["id"];
		$frm["login"]=$user["login"];
		$frm["area"]=$area;
		include("CCB/paso_1Cierre2.php");
		//include("CCB/paso_4.php");
	}


function muestra_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$area="musica";	
	$id_usurio=$_SESSION[$CFG->sesion_grnic]["user"]["id"];
		$seccion="inscripciones";
		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$id_usurio' LIMIT 1)
		");
		$frm["id_usuario"]=$id_usurio;
		$frm["id_grupo"]=$frm["id"];
		$frm["login"]=$user["login"];
		$frm["area"]=$area;
		include("CCB/paso_1Cierre2.php");
		//include("CCB/paso_3.php");
	}
	
	
function eliminar_archivo($frm){
	GLOBAL $CFG, $ME, $db;
	    $frm["id_usuario"]=$_GET["id_usuario"];
		$frm["id_grupo"]=$_GET["id_grupo"];
		$frm["area"]=$_GET["area"];
		$seccion=$_GET["modo"];
		
	$obra["id"]=$_GET["item"];
	$db->sql_query("delete from archivos_grupos_musica where id='". $obra["id"]."'");
	include("CCB/paso_1Cierre2.php");
	//include("CCB/paso_4.php");
	
	}		
	
function eliminar_obra($frm){
	GLOBAL $CFG, $ME, $db;
	    $frm["id_usuario"]=$_GET["id_usuario"];
		$frm["id_grupo"]=$_GET["id_grupo"];
		$frm["area"]=$_GET["area"];
		$seccion=$_GET["modo"];
		
	$obra["id"]=$_GET["item"];
	$db->sql_query("delete from obras_musica where id='". $obra["id"]."'");
	include("CCB/paso_1Cierre2.php");
	//include("CCB/paso_3.php");
	
	}	
	
function vertodo($frm){
	GLOBAL $CFG, $ME, $db;
	$area="musica";	
	$id_usurio=$_SESSION[$CFG->sesion_grnic]["user"]["id"];
		$seccion="inscripciones";
		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$id_usurio' LIMIT 1)
		");
		$frm["id_usuario"]=$id_usurio;
		$frm["id_grupo"]=$frm["id"];
		$frm["login"]=$user["login"];
		$frm["area"]=$area;
		include("CCB/paso_1Cierre2.php");
		//include("CCB/verpaso_2.php");
		//include("CCB/verpaso_3.php");
		//include("CCB/verpaso_4.php");	
	}

function muestra_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$area="musica";	
	$id_usurio=$_GET["id_usuario"];
	$_SESSION[$CFG->sesion_grnic]["user"]["id"];
	if($id_usurio!=""){
		$seccion="inscripciones";
		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_musica FROM usuarios_grupos_musica WHERE id_usuario = '$id_usurio' LIMIT 1)
		");
		$frm["id_usuario"]=$id_usurio;
		$frm["id_grupo"]=$frm["id"];
		$frm["login"]=$user["login"];
		$frm["area"]=$area;
		include("CCB/paso_1Cierre2.php");
		//include("CCB/paso_2.php");
	 }else{
		 paso_1($frm);
		 }
	}

function paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
	include("CCB/paso_1.php");
}

?>
