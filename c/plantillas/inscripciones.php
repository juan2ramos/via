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
	$seccion="inscripciones";


	$result=$db->sql_row("SELECT * FROM grupos_".$frm["area"]." WHERE id='".$frm["id_grupo"]."'");
	$frm["id"]=$frm["id_grupo"];
	$frm["ingresado_por"]=1;
	$frm["terminos"]=1;
	$db->sql_update("grupos_".$frm["area"], $frm);	

	
		   require("class.phpmailer.php");
		
			$mailer = new PHPMailer();
			$mailer->IsSMTP();
			$mailer->Host = 'ssl://smtp.gmail.com:465';
			$mailer->SMTPAuth = TRUE;
			$mailer->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer->From = $result['email'];  // This HAVE TO be your gmail adress
			$mailer->FromName = 'Artista VIA2014'; // This is the from name in the email, you can put anything you like here
			
			
			$dest = 'via@circulart.org'; //remplazar por el de info@bogotamusicmarlet.com
			$body="El Grupo o Artista ".$result["nombre"]." ha finalizado el proceso de actualizaci�n de la inscripci�n al mercado VIA2014\n\n";	
			$body.="\n\n";
			$body.="Milena Garc�a\n";
			$body.="Coordinaci�n de Artistas Rueda de Negocios \n";
			$body.="VIA 2014 - Ventana Internacional de las Artes\n";
			$body.="FESTIVAL IBEROAMERICANO DE TEATRO\n";
			$body.="www.festivaldeteatro.com.co\n";
			$body.="\n";
			

			$mailer->Body = $body;
			$mailer->Subject = '[VIA2014] Actualizaci�n de inscripci�n';
			$mailer->AddAddress($dest);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			}else{
				
				}
				
			$mailer2 = new PHPMailer();
			$mailer2->IsSMTP();
			$mailer2->Host = 'ssl://smtp.gmail.com:465';
			$mailer2->SMTPAuth = TRUE;
			$mailer2->Username = 'cesarvalencia@circulart.org';  // Change this to your gmail adress
			$mailer2->Password = 'v4l3nc14!"#';  // Change this to your gmail password
			$mailer2->FromName = 'VIA2014'; // This is the from name in the email, you can put anything you like here	
			$mailer2->From = 'via@circulart.org'; 	 //remplazar por el de info@bogotamusicmarlet.com
			$dest2 = $result["email"];
			$body2= "Estimado(s) ".$result["nombre"]." ha finalizado el proceso de actualizaci�n de la inscripci�n al mercado VIA2014\n\n";	
			$body2.="\n\n";
			$body2.="Milena Garc�a\n";
			$body2.="Coordinaci�n de Artistas Rueda de Negocios\n";
			$body2.="VIA 2014 - Ventana Internacional de las Artes\n";
			$body2.="FESTIVAL IBEROAMERICANO DE TEATRO\n";
			$body2.="www.festivaldeteatro.com.co\n";
			$body2.="\n";

			$mailer2->Body = $body2;
			$mailer2->Subject = '[VIA2014] Actualizaci�n de inscripci�n';
			$mailer2->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer2->Send())
			{
		
			}else{
				
				}	
			
	//
	include("CCB/final.php");
}

function procesar_paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
	$frm["id_usuario"]=$frm["id_usuario"];
		$frm["id_grupo"]=$frm["id_grupo"];
		$frm["area"]=$frm["area"];
    include("CCB/confirmar_inscripcion.php");
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
		if($frm["id"]!=""){
			$frm["id_usuario"]=$user["id"];
			$frm["id_grupo"]=$frm["id"];
			$frm["login"]=$user["login"];
			$frm["area"]=$area;
			$db->sql_query("UPDATE usuarios SET nombre='".$frm["nombre"]."', apellido='VIA2014' WHERE id='$frm[id_usuario]'");
			$db->sql_query("UPDATE grupos_$area SET convenio='VIA2014' WHERE id='$frm[id_grupo]'");		
			include("CCB/paso_2.php");
		}else{
			$frm["error2"] = "Login inv�lido, por favor intente de nuevo.";
			$newMode="acceso";
			include("CCB/paso_1.php");
			}
	
	} else {
		$frm["error2"] = "Login inv�lido, por favor intente de nuevo.";
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
		$frm["error"] = "Login inv�lido, por favor intente de nuevo.";
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
   // include("CCB/paso_1Cierre2.php");
	include("CCB/login_form.php");
}

function procesar_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";
    //include("CCB/paso_1Cierre2.php");
	//include("CCB/paso_4.php");
}

function procesar_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	$usuario=$db->sql_row("SELECT * FROM usuarios WHERE id='$frm[id_usuario]'");

	if($frm["id_grupo"]!=""){//Ya existe...

    if($frm["area"]=="teatro"){
      if(isset($frm["genero1"])){
       if($frm["genero1"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="5";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='5'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='5'");  
		   };
	  }
		  
	if(isset($frm["genero2"])){	   
       if($frm["genero2"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="1";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='1'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='1'");  
		   };
	}
	
	if(isset($frm["genero3"])){
		if($frm["genero3"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="7";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='7'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='7'");  
		   };
	}
	
	
	if(isset($frm["genero4"])){	   
	    if($frm["genero4"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="3";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='3'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='3'");  
		   };
	}
	
	if(isset($frm["genero5"])){	   
	    if($frm["genero5"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="8";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='8'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='8'");  
		   };
	}
	
	if(isset($frm["genero6"])){		   
		 if($frm["genero6"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="10";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='10'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='10'");  
		   };
	}
	
	
	if(isset($frm["genero7"])){	   
	     if($frm["genero7"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="6";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='6'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='6'");  
		   };
	}
	
	
	if(isset($frm["genero8"])){	   
		if($frm["genero8"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="11";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='11'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='11'");  
		   };   	      	   	      		   
	}
	
	
	if(isset($frm["genero9"])){	   
		 if($frm["genero9"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="9";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='9'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='9'");  
		   }; 
	}
	
	if(isset($frm["genero10"])){	   
		 if($frm["genero10"]=="on"){
		   $frm["id_grupos_teatro"]=$frm["id_grupo"];
		   $frm["id_generos_teatro"]="2";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatro='2'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_teatro",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_teatro where id_grupos_teatro='".$frm["id_grupo"]."' AND id_generos_teatros='2'");  
		   };    
    }
	
	}
		   
	if($frm["area"]=="danza"){

if(isset($frm["genero1"])){
      if($frm["genero1"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="12";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='12'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='12'");  
		   };
}

if(isset($frm["genero2"])){		   
	 if($frm["genero2"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="10";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='10'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='10'");  
		   };
}
		if(isset($frm["genero3"])){   
	 if($frm["genero3"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="2";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='2'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='2'");  
		   };}
		   
		   
	if(isset($frm["genero4"])){	   
	 if($frm["genero4"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="6";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='6'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='6'");  
		   };
	}
		   
	if(isset($frm["genero5"])){	   
	 if($frm["genero5"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="11";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='11'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='11'");  
		   };
	}
		   
	if(isset($frm["genero6"])){	   
	 if($frm["genero6"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="9";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='9'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='9'");  
		   };
	}
		   
	if(isset($frm["genero7"])){	   
	 if($frm["genero7"]=="on"){
		   $frm["id_grupos_danza"]=$frm["id_grupo"];
		   $frm["id_generos_danza"]="8";
		   $genero=$db->sql_row("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='8'");
		   if($genero["id"]==""){
		   	$db->sql_insert("generos_grupo_danza",$frm);
		   }
		}else{
			 $db->sql_query("delete from generos_grupo_danza where id_grupos_danza='".$frm["id_grupo"]."' AND id_generos_danza='8'");  
		   };	   	   	   	   	   	   
	}
		   
		   
 }
		   
		 
		$frm["id"]=$frm["id_grupo"];
		$db->sql_update("grupos_" . $frm["area"], $frm);
	}
	
	//include("CCB/paso_1Cierre2.php");
	include("CCB/paso_3.php");
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
	$seccion="inscripciones";
		$area=$frm["area"];	
        //$frm["id_usuario"]=$_GET["$id_usurio"];
		//$frm["id_grupo"]=$_GET["id_grupo"];
		$frm["area"]=$area;
		include("CCB/paso_3.php");
	}
	
	
	
	
function eliminar_obra($frm){
	GLOBAL $CFG, $ME, $db;
	$frm["id_usuario"]=$_GET["id_usuario"];
	$frm["id_grupo"]=$_GET["id_grupo"];
	$frm["area"]=$_GET["area"];
	$seccion="inscripciones";
	$obra["id"]=$_GET["item"];
	$db->sql_query("delete from obras_".$frm["area"]." where id='". $obra["id"]."'");
	include("CCB/paso_3.php");
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
		//include("CCB/paso_1Cierre2.php");
		//include("CCB/verpaso_2.php");
		//include("CCB/verpaso_3.php");
		//include("CCB/verpaso_4.php");	
	}

function muestra_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$area=$frm["area"];	
	$id_usurio=$_GET["id_usuario"];
	if($id_usurio!=""){
		$seccion="inscripciones";
		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$id_usurio' LIMIT 1)
		");
		$frm["id_usuario"]=$id_usurio;
		$frm["id_grupo"]=$frm["id"];
		$frm["area"]=$area;
		
		include("CCB/paso_2.php");
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
