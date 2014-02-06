<?
$CFG->sesion_grnic="SESIONGRNIC";

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
		//print_login_form($frm,"acceso");
		break;
	case "paso_4":
		procesar_paso_3($frm);
		break;
	case "paso_3":
		procesar_paso_2($frm);
		break;
	case "paso_2":
		procesar_paso_1($frm);
		break;
	default:
		paso_1($frm);
		break;
}

function confirmar_inscripcion($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	
		if($result=$db->sql_row("SELECT id FROM confirmados_grnic WHERE id_grupo_" . $frm["area"] . "='".$frm[id_grupo]."'")){
			$qUpdate=$db->sql_query("UPDATE confirmados_grnic SET inscripcion_confirmada='1', fecha=now() WHERE id='$result[id]'");
			if ($CFG->mercado==21){				
			    $qUpdate=$db->sql_query("UPDATE grupos_".$frm["area"]." SET ingresado_por='1' WHERE id='".$frm[id_grupo]."'");
			}
		}else{
			$db->sql_query("INSERT INTO confirmados_grnic (id_grupo_" . $frm["area"] . ",inscripcion_confirmada,fecha) VALUES('$frm[id_grupo]','1',now())");
		}
	
	
	$grupo=$db->sql_row("SELECT id,nombre,email FROM grupos_$frm[area] WHERE id='$frm[id_grupo]'");
	if ($CFG->mercado==21){
		$strMail="NOTIFICACIÓN\n\n";
		$strMail.="Usted ha quedado INSCRITO OFICIALMENTE en la VI versión de la VENTANA INTERNACIONAL DE LAS ARTES. Muchas gracias por participar.\n\n";
		$strMail.="Atentamente,\n\n";
		$strMail.="VIA / XIII FESTIVAL IBEROAMERICANO DE TEATRO DE BOGOTÁ\n";
		$strMail.="via@circulart.org\n";
		$strMail.="http://via.circulart.org/\n";
		$strMail.="\n";
		mail($grupo["email"],"Notificacion ",$strMail,"From: via@circulart.org");
		
		$strMail="NOTIFICACIÓN:\n\n";
		$strMail.="El grupo de [" . $frm["area"] . "] *" . $grupo["nombre"] . "* ha finalizado su inscripción.\n\n";
		$strMail.="Atentamente,\n\n";
		$strMail.="VIA / XIII FESTIVAL IBEROAMERICANO DE TEATRO DE BOGOTÁ\n";
		$strMail.="via@circulart.org\n";
		$strMail.="http://via.circulart.org/\n";
		$strMail.="\n";

		mail("via@circulart.org","Notificacion-XIII Festival Iberoamericano",$strMail,"From: via@circulart.org");
		mail("info@circulart.org","Notificacion-XIII Festival Iberoamericano",$strMail,"From: via@circulart.org");
	}else{
		$strMail="NOTIFICACIÓN\n\n";
		$strMail.="Usted ha quedado INSCRITO OFICIALMENTE en la Plataforma Nacional de Artes Escénicas. Muchas gracias por participar.\n\n";
		$strMail.="Atentamente,\n\n";
		$strMail.="Circulart - Redlat\n";
		$strMail.="info@circulart.org - info@redlat.com\n";
		$strMail.="http://www.circulart.org/\n";
		$strMail.="\n";
		mail($grupo["email"],"Notificacion ",$strMail,"From: info@circulart.org");
		
		$strMail="NOTIFICACIÓN:\n\n";
		$strMail.="El grupo de [" . $frm["area"] . "] *" . $grupo["nombre"] . "* ha finalizado su inscripción.\n\n";
		$strMail.="Atentamente,\n\n";
		$strMail.="Circulart - Redlat\n";
		$strMail.="info@circulart.org - info@redlat.com\n";
		$strMail.="http://www.circulart.org/\n";
		$strMail.="\n";
	
		mail("info@circulart.org","Notificacion-Plataforma Nacional de Artes Escénicas",$strMail,"From: info@circulart.org");
		
		}
	


	include("CCB/final.php");
}

function procesar_paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	foreach($frm["nombre"] AS $key => $nombre){
		if(trim($nombre)!=""){
			$qPersonas=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_" . $frm["area"] . "='$frm[id_grupo]' ORDER BY id");
			$persona1=$db->sql_fetchrow($qPersonas);
			$persona2=$db->sql_fetchrow($qPersonas);

			$vinculado=array();
			$vinculado["nombre"]=trim($nombre);
			$vinculado["documento"]=trim($frm["documento"][$key]);
			$vinculado["id_grupo_" . $frm["area"]]=$frm["id_grupo"];
			if($key==1 && isset($persona1) && isset($persona1["id"])){
				$vinculado["id"]=$persona1["id"];
				if(isset($_FILES["foto"]) && isset($_FILES["foto"]["error"]) && isset($_FILES["foto"]["error"][$key]) && $_FILES["foto"]["error"][$key]==0){
					if(preg_match("/php$/i",$_FILES["foto"]["name"][$key])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers

					$vinculado["foto"]="1";
					$vinculado["mmdd_foto_filename"]=$_FILES["foto"]["name"][$key];
					$vinculado["mmdd_foto_filetype"]=$_FILES["foto"]["type"][$key];
					$vinculado["mmdd_foto_filesize"]=$_FILES["foto"]["size"][$key];
					$dir=$CFG->dirroot . "/" . $CFG->filesdir . "/vinculados";
					if(!is_dir($dir)) mkdir($dir);
					$dir.="/foto";
					if(!is_dir($dir)) mkdir($dir);
					copy($_FILES["foto"]["tmp_name"][$key],$dir . "/" . $vinculado["id"]);
				}
				$db->sql_update("vinculados",$vinculado);
			}
			elseif($key==2 && isset($persona2) && isset($persona2["id"])){
				$vinculado["id"]=$persona2["id"];
				if(isset($_FILES["foto"]) && isset($_FILES["foto"]["error"]) && isset($_FILES["foto"]["error"][$key]) && $_FILES["foto"]["error"][$key]==0){
					if(preg_match("/php$/i",$_FILES["foto"]["name"][$key])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
					$vinculado["foto"]="1";
					$vinculado["mmdd_foto_filename"]=$_FILES["foto"]["name"][$key];
					$vinculado["mmdd_foto_filetype"]=$_FILES["foto"]["type"][$key];
					$vinculado["mmdd_foto_filesize"]=$_FILES["foto"]["size"][$key];
					$dir=$CFG->dirroot . "/" . $CFG->filesdir . "/vinculados";
					if(!is_dir($dir)) mkdir($dir);
					$dir.="/foto";
					if(!is_dir($dir)) mkdir($dir);
					copy($_FILES["foto"]["tmp_name"][$key],$dir . "/" . $vinculado["id"]);
				}
				$db->sql_update("vinculados",$vinculado);
			}
			else{
				$vinculado["id"]=$db->sql_insert("vinculados",$vinculado);
				if(isset($_FILES["foto"]) && isset($_FILES["foto"]["error"]) && isset($_FILES["foto"]["error"][$key]) && $_FILES["foto"]["error"][$key]==0){
					if(preg_match("/php$/i",$_FILES["foto"]["name"][$key])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
					$vinculado["foto"]="1";
					$vinculado["mmdd_foto_filename"]=$_FILES["foto"]["name"][$key];
					$vinculado["mmdd_foto_filetype"]=$_FILES["foto"]["type"][$key];
					$vinculado["mmdd_foto_filesize"]=$_FILES["foto"]["size"][$key];
					$dir=$CFG->dirroot . "/" . $CFG->filesdir . "/vinculados";
					if(!is_dir($dir)) mkdir($dir);
					$dir.="/foto";
					if(!is_dir($dir)) mkdir($dir);
					copy($_FILES["foto"]["tmp_name"][$key],$dir . "/" . $vinculado["id"]);
					$db->sql_update("vinculados",$vinculado);
				}
			}
		}
	}
	$grupo=$db->sql_row("SELECT id,nombre,email FROM grupos_$frm[area] WHERE id='$frm[id_grupo]'");
	if ($CFG->mercado==21){
		$strMail="Estimados " . $grupo["nombre"] . ":\n";
		$strMail.="Su inscripción en la VI Ventana Internacional de las Artes -VIA- del Festival Iberoamericano de teatro de Bogotá se ha realizado con éxito.\n";
		$strMail.="Recuerde que sus datos de acceso son:\n";
		$strMail.="email: " . $grupo["email"] . "\n";
		$strMail.="Login: " . $frm["login"] . "\n";
		if($frm["password"]!="") $strMail.="Password: " . $frm["password"] . "\n";
		$strMail.="\n";
		$strMail.="Cordialmente:\n";
		$strMail.="VIA\n";
		$strMail.="via@circulart.org\n";
		$strMail.="http://via.circulart.org/\n";
		$strMail.="\n";
		mail($grupo["email"],"Inscripcion - XIII Festival Iberoamericano de teatro de Bogotá",$strMail,"From: via@circulart.org");
	}else{
		$strMail="Estimados " . $grupo["nombre"] . ":\n";
		$strMail.="Su inscripción en la Plataforma Nacional de Artes Escénicas se ha realizado con éxito.\n";
		$strMail.="Recuerde que sus datos de acceso son:\n";
		$strMail.="email: " . $grupo["email"] . "\n";
		$strMail.="Login: " . $frm["login"] . "\n";
		if($frm["password"]!="") $strMail.="Password: " . $frm["password"] . "\n";
		$strMail.="\n";
		$strMail.="Cordialmente:\n";
		$strMail.="Circulart - Redlat\n";
		$strMail.="http://www.circulart.org/\n";
		$strMail.="info@circulart.org - info@redlat.com\n";
		$strMail.="\n";
		mail($grupo["email"],"Inscripcion-Plataforma Nacional de Artes Escénicas",$strMail,"From: info@circulart.org");
		}
	include("CCB/confirmar_inscripcion.php");
}

function acceso($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";


	$user= verify_login($_SESSION[$CFG->sesion]["username"], $_SESSION[$CFG->sesion]["pass"]);
	
	
	
	if ($user) {
		$_SESSION[$CFG->sesion_grnic]["user"] = $user;
		$_SESSION[$CFG->sesion_grnic]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_grnic]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_grnic]["path"] = NULL;
	    $frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id= '$user[id]'
		");
		$frm["id_usuario"]=$user["id"];
		$frm["login"]=$user["login"];
		$frm["password2"]=$frm["password2"];
		$frm["tipoEntrada"]=1;
		include("CCB/paso_2P.php");

		die;
	} else {
		$frm["error"] = "Login inválido, por favor intente de nuevo.";
		$newMode="acceso";
		//include("CCB/login_formP.php");
	}
}


function acceso_admin($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	$user = verify_login($frm["login"], $frm["password"]);
	if ($user) {
		$_SESSION[$CFG->sesion_admin]["user"] = $user;
		$_SESSION[$CFG->sesion_admin]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_admin]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_admin]["path"] = NULL;

		if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 4 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 7)
			$area="danza";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
			$area="musica";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
			$area = "teatro";
		else die("Error: " . __FILE__ . ":" . __LINE__);

		$goto = $CFG->admin_dir . "/index.php?module=grupos_$area";

		$grupo=$db->sql_row("SELECT id, nombre, email FROM grupos_$area WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$user[id]' LIMIT 1)");
if ($CFG->mercado==21){
		$strMail="Estimados " . $grupo["nombre"] . ":\n";
		$strMail.="Su inscripción en el XIII Festival Iberoamericano de teatro de Bogotá se ha realizado con éxito.\n";
		$strMail.="Recuerde que sus datos de acceso son:\n";
		$strMail.="email: " . $grupo["email"] . "\n";
		$strMail.="Login: " . $frm["login"] . "\n";
		$strMail.="Password: " . $frm["password"] . "\n";
		$strMail.="\n";
		$strMail.="VIA - Circulart - Redlat\n";
		$strMail.="infovia@circulart.org - via@circulart.org\n";
		$strMail.="http://via.circulart.org/\n";
		$strMail.="\n";

		mail($grupo["email"],"Inscripcion-Plataforma Nacional de Artes Escénicas",$strMail,"From: infovia@circulart.org");
}else{
		$strMail="Estimados " . $grupo["nombre"] . ":\n";
		$strMail.="Su inscripción en la Plataforma Nacional de Artes Escénicas se ha realizado con éxito.\n";
		$strMail.="Recuerde que sus datos de acceso son:\n";
		$strMail.="email: " . $grupo["email"] . "\n";
		$strMail.="Login: " . $frm["login"] . "\n";
		$strMail.="Password: " . $frm["password"] . "\n";
		$strMail.="\n";
		$strMail.="Cordialmente:\n";
		$strMail.="Circulart - Redlat\n";
		$strMail.="http://www.circulart.org/\n";
		$strMail.="info@circulart.org - info@redlat.com\n";
		$strMail.="\n";

		mail($grupo["email"],"Inscripcion-Plataforma Nacional de Artes Escénicas",$strMail,"From: info@circulart.org");
	}
		header("Location: $goto");
		die;
	} else {
		$frm["error"] = "Login inválido, por favor intente de nuevo.";
		include("CCB/login_formP.php");
	}
}

function verify_login($username, $password) {
	GLOBAL $db;
	$seccion="actPro";

	$pass = md5($password);
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM promotores WHERE login = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid))	return($user);
	return(FALSE);
}

function print_login_form($frm,$newMode="acceso_admin"){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	include("CCB/login_formP.php");
}

function procesar_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	$grupo=$db->sql_row("SELECT id,nombre,email FROM grupos_$frm[area] WHERE id='$frm[id_grupo]'");

	if($frm["area"]=="musica") $frm["produccion"]=$frm["obra"];
	$frm["id_grupos_" . $frm["area"]]=$frm["id_grupo"];
	if($frm["id_obra"]=="")	$frm["id"]=$db->sql_insert("obras_" . $frm["area"],$frm);
	else{
		$frm["id"]=$frm["id_obra"];
		$db->sql_update("obras_" . $frm["area"],$frm);
		$qPersonas=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_" . $frm["area"] . "='$frm[id_grupo]' ORDER BY id");
		$persona1=$db->sql_fetchrow($qPersonas);
		$persona2=$db->sql_fetchrow($qPersonas);
	}
	if(isset($frm["codigo_video"])){
		if($frm["id_obra"]==""){
			if($frm["codigo_video"]!=""){
				$archivo=array();
				$archivo["id_obras_" . $frm["area"]]=$frm["id"];
				$archivo["tipo"]=3;//Video
				$archivo["etiqueta"]="Video";
				$archivo["orden"]="1";
				$archivo["url"]=$frm["codigo_video"];
				$archivo["id"]=$db->sql_insert("archivos_obras_" . $frm["area"], $archivo);
			}
		}
		else{
			if($archivo=$db->sql_row("SELECT * FROM archivos_obras_" . $frm["area"] . " WHERE id_obras_" . $frm["area"] . "='$frm[id]' AND tipo='3' AND etiqueta='Video'")){
				$archivo["url"]=$frm["codigo_video"];
				$db->sql_update("archivos_obras_" . $frm["area"], $archivo);
			}
			else{
				if($frm["codigo_video"]!=""){
					$archivo=array();
					$archivo["id_obras_" . $frm["area"]]=$frm["id"];
					$archivo["tipo"]=3;//Video
					$archivo["etiqueta"]="Video";
					$archivo["orden"]="1";
					$archivo["url"]=$frm["codigo_video"];
					$archivo["id"]=$db->sql_insert("archivos_obras_" . $frm["area"], $archivo);
				}
			}
		}
	}
	if(isset($_FILES["caratula"])){
		$val=$_FILES["caratula"];
		if($val["error"]==0){
			if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
			$str=file_get_contents($val["tmp_name"]);
			$str=base64_encode($str);
			$archivo=array();
			$archivo["id_obras_" . $frm["area"]]=$frm["id"];
			$archivo["tipo"]=1;
			$archivo["etiqueta"]="Carátula";
			$archivo["archivo"]=$str;
			$archivo["mmdd_archivo_filename"]=$val["name"];
			$archivo["mmdd_archivo_filetype"]=$val["type"];
			$archivo["mmdd_archivo_filesize"]=$val["size"];
			$archivo["orden"]="1";
			if($frm["id_obra"]=="") $archivo["id"]=$db->sql_insert("archivos_obras_" . $frm["area"], $archivo);
			else{
				if($arch_obra=$db->sql_row("SELECT id FROM archivos_obras_" . $frm["area"] . " WHERE id_obras_" . $frm["area"] . "='" . $frm["id"] . "' AND etiqueta='Carátula'")){
					$archivo["id"]=$arch_obra["id"];
					$db->sql_update("archivos_obras_" . $frm["area"], $archivo);
				}
				else{
					$archivo["id"]=$db->sql_insert("archivos_obras_" . $frm["area"], $archivo);
				}
			}
		}
	}
	if(isset($_FILES["audio"])){
		if(!is_dir($CFG->dirroot . "/musica/audio/" . $frm["id_grupo"])) mkdir($CFG->dirroot . "/musica/audio/" . $frm["id_grupo"]);
		if(!is_dir($CFG->dirroot . "/musica/audio/" . $frm["id_grupo"] . "/obras/")) mkdir($CFG->dirroot . "/musica/audio/" . $frm["id_grupo"] . "/obras/");
		foreach($_FILES["audio"]["error"] AS $key => $error){
			if($error==0){
				if(preg_match("/php$/i",$_FILES["audio"]["name"][$key])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
				$val=array();
				$archivo=array();
				$val["name"]=$_FILES["audio"]["name"][$key];
				$val["type"]=$_FILES["audio"]["type"][$key];
				$val["tmp_name"]=$_FILES["audio"]["tmp_name"][$key];
				$val["error"]=$_FILES["audio"]["error"][$key];
				$val["size"]=$_FILES["audio"]["size"][$key];
				if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
				$archivo["id_obras_" . $frm["area"]]=$frm["id"];
				$archivo["etiqueta"]="Archivo de audio # " . $key;
				$archivo["orden"]=$key;
				$archivo["mmdd_archivo_filename"]=$val["name"];
				$archivo["mmdd_archivo_filetype"]=$val["type"];
				$archivo["mmdd_archivo_filesize"]=$val["size"];
				//Verificar si existe:
				if($result=$db->sql_row("SELECT * FROM tracklist WHERE id_obras_" . $frm["area"] . "='" . $frm["id"] . "' AND orden='$key'")){
					$archivo["id"]=$result["id"];
					$db->sql_update("tracklist", $archivo);
				}
				else $archivo["id"]=$db->sql_insert("tracklist", $archivo);
				if(!is_dir($CFG->dirroot . "/musica/audio/" . $frm["id_grupo"] . "/obras/" . $archivo["id"])) mkdir($CFG->dirroot . "/musica/audio/" . $frm["id_grupo"] . "/obras/" . $archivo["id"]);
				copy($val["tmp_name"],$CFG->dirroot . "/musica/audio/" . $frm["id_grupo"] . "/obras/" . $archivo["id"] . "/" . $val["name"]);
			}
		}
	}
	

	
	//include("CCB/paso_4.php");
}

function procesar_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	$usuario=$db->sql_row("SELECT * FROM promotores WHERE id='$frm[id_usuario]'");

	if($frm["id_usuario"]!=""){//Ya existe...
		$frm["id"]=$frm["id_usuario"];
		$db->sql_update("promotores", $frm);
	}
	
	/***********************************tareas o actividades************************************/
	$tarea1=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='1'");
    if (@$frm['pr_promotores_tareas1']){
		  if($tarea1[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','1')");
		  }
		}else{
		  if($tarea1[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='1'");
		   }
		}
		
	
	$tarea2=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='2'");
    if (@$frm['pr_promotores_tareas2']){
		  if($tarea2[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','2')");
		  }
		}else{
		  if($tarea2[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='2'");
		   }
		}	
		
	$tarea3=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='3'");
    if (@$frm['pr_promotores_tareas3']){
		  if($tarea3[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','3')");
		  }
		}else{
		  if($tarea3[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='3'");
		   }
		}		
		
	$tarea4=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='4'");
    if (@$frm['pr_promotores_tareas4']){
		  if($tarea4[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','4')");
		  }
		}else{
		  if($tarea4[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='4'");
		   }
		}		
		
	$tarea5=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='5'");
    if (@$frm['pr_promotores_tareas5']){
		  if($tarea5[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','5')");
		  }
		}else{
		  if($tarea5[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='5'");
		   }
		}	
	$tarea6=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='6'");
    if (@$frm['pr_promotores_tareas6']){
		  if($tarea6[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','6')");
		  }
		}else{
		  if($tarea6[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='6'");
		   }
		}		
				
	$tarea7=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='7'");
    if (@$frm['pr_promotores_tareas7']){
		  if($tarea7[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','7')");
		  }
		}else{
		  if($tarea7[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='7'");
		   }
		}		

    $tarea8=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='8'");
    if (@$frm['pr_promotores_tareas8']){
		  if($tarea8[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','8')");
		  }
		}else{
		  if($tarea8[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='8'");
		   }
		}	

    $tarea9=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='9'");
    if (@$frm['pr_promotores_tareas9']){
		  if($tarea9[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','9')");
		  }
		}else{
		  if($tarea9[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='9'");
		   }
		}	
		
	$tarea10=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='10'");
    if (@$frm['pr_promotores_tareas10']){
		  if($tarea10[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','10')");
		  }
		}else{
		  if($tarea10[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='10'");
		   }
		}
		
	$tarea11=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='11'");
    if (@$frm['pr_promotores_tareas11']){
		  if($tarea11[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','11')");
		  }
		}else{
		  if($tarea11[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='11'");
		   }
		}	
		
	$tarea12=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='12'");
    if (@$frm['pr_promotores_tareas12']){
		  if($tarea12[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','12')");
		  }
		}else{
		  if($tarea12[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='12'");
		   }
		}						

   $tarea13=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='13'");
    if (@$frm['pr_promotores_tareas13']){
		  if($tarea13[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','13')");
		  }
		}else{
		  if($tarea13[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='13'");
		   }
		}	
		
		
	$tarea14=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='14'");
    if (@$frm['pr_promotores_tareas14']){
		  if($tarea14[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','14')");
		  }
		}else{
		  if($tarea14[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='14'");
		   }
		}	
	
	$tarea15=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='15'");
    if (@$frm['pr_promotores_tareas15']){
		  if($tarea15[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','15')");
		  }
		}else{
		  if($tarea15[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='15'");
		   }
		}	
		
		
	$tarea16=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='16'");
    if (@$frm['pr_promotores_tareas16']){
		  if($tarea16[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','16')");
		  }
		}else{
		  if($tarea16[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='16'");
		   }
		}		
		
	$tarea17=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='17'");
    if (@$frm['pr_promotores_tareas17']){
		  if($tarea17[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm[id_usuario]."','17')");
		  }
		}else{
		  if($tarea17[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='17'");
		   }
		}					
   /********************* fin codigo de las tareas ************/
   
   /**********************codigo Areas******************************/
   
   $area1=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='1'");
    if (@$frm['pr_promotores_areas1']){
		  if($area1[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm[id_usuario]."','1')");
		  }
		}else{
		  if($area1[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='1'");
		   }
		}	
		
		
	$area2=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='2'");
    if (@$frm['pr_promotores_areas2']){
		  if($area2[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm[id_usuario]."','2')");
		  }
		}else{
		  if($area2[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='2'");
		   }
		}		
		
	$area3=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='3'");
    if (@$frm['pr_promotores_areas3']){
		  if($area3[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm[id_usuario]."','3')");
		  }
		}else{
		  if($area3[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='3'");
		   }
		}	
		
	$area4=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='4'");
    if (@$frm['pr_promotores_areas4']){
		  if($area4[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm[id_usuario]."','4')");
		  }
		}else{
		  if($area4[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='4'");
		   }
		}				
   /************************************fin del codigo de areas ********************************/
   /************************************ idioma *************************************************/
   $idioma1=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='1'");
    if (@$frm['pr_promotores_idiomas1']){
		  if($idioma1[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm[id_usuario]."','1')");
		  }
		}else{
		  if($idioma1[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='1'");
		   }
		}	
		

   $idioma2=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='2'");
    if (@$frm['pr_promotores_idiomas2']){
		  if($idioma2[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm[id_usuario]."','2')");
		  }
		}else{
		  if($idioma2[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='2'");
		   }
		}		
		
		
    $idioma3=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='3'");
    if (@$frm['pr_promotores_idiomas3']){
		  if($idioma3[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm[id_usuario]."','3')");
		  }
		}else{
		  if($idioma3[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='3'");
		   }
		}					
   
    $idioma4=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='4'");
    if (@$frm['pr_promotores_idiomas4']){
		  if($idioma4[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm[id_usuario]."','4')");
		  }
		}else{
		  if($idioma4[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='4'");
		   }
		}		
   
    $idioma5=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='5'");
    if (@$frm['pr_promotores_idiomas5']){
		  if($idioma5[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm[id_usuario]."','5')");
		  }
		}else{
		  if($idioma5[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='5'");
		   }
		}	
   /***************************** organizacion **********************************************/
   
   $qEmpresas=$db->sql_query("
							SELECT emp.*
							FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
							WHERE ep.id_promotor='$frm[id_usuario]'
						");
						
	if($db->sql_numrows($qEmpresas)>0){ 
	//actualizacion
	  $id_empresa=$db->sql_query("select id_empresa from empresas_promotores  where id_promotor=".$frm[id_usuario]);
      $idemp=$db->sql_fetchrow($id_empresa);
	  $db->sql_query("UPDATE empresas SET empresa='".$frm[empresa]."', id_naturaleza='".$frm[id_naturaleza]."', nit='".$frm[nit]."', direccion='".$frm[direccion_emp]."', telefono='".$frm[telefono_emp]."', web='".$frm[web_emp]."', observaciones='".$frm[observaciones]."', email='".$frm[email_emp]."', pais='".$frm[pais_emp]."', ciudad='".$frm[ciudad_emp]."', telefono2='".$frm[telefono2_emp]."'    WHERE id='".$idemp[0]."'");
	
	/***********************************actividad empresa *****************************************/
	
	    $actividad1=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
    if (@$frm['empresas_razones1']){
		  if($actividad1[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','1')");
		  }
		}else{
		  if($actividad1[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
		   }
		}	
	
	
	 $actividad2=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
    if (@$frm['empresas_razones2']){
		  if($actividad2[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','2')");
		  }
		}else{
		  if($actividad2[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
		   }
		}	
		
		
		
	 $actividad3=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
    if (@$frm['empresas_razones3']){
		  if($actividad3[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','3')");
		  }
		}else{
		  if($actividad3[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
		   }
		}	
		
		
	 $actividad4=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
    if (@$frm['empresas_razones1']){
		  if($actividad4[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','4')");
		  }
		}else{
		  if($actividad4[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
		   }
		}	
		
	 $actividad5=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
    if (@$frm['empresas_razones5']){
		  if($actividad5[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','5')");
		  }
		}else{
		  if($actividad5[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
		   }
		}	
		
	 $actividad6=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
    if (@$frm['empresas_razones6']){
		  if($actividad6[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','6')");
		  }
		}else{
		  if($actividad6[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
		   }
		}	
		
	 $actividad7=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
    if (@$frm['empresas_razones7']){
		  if($actividad7[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','7')");
		  }
		}else{
		  if($actividad7[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
		   }
		}	
		
	 $actividad8=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
    if (@$frm['empresas_razones8']){
		  if($actividad8[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','8')");
		  }
		}else{
		  if($actividad8[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
		   }
		}	
		
		
	 $actividad9=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
    if (@$frm['empresas_razones9']){
		  if($actividad9[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','9')");
		  }
		}else{
		  if($actividad9[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
		   }
		}	
		
	 $actividad10=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
    if (@$frm['empresas_razones10']){
		  if($actividad10[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','10')");
		  }
		}else{
		  if($actividad10[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
		   }
		}	
		
	}else{
	//insertar nuevo
	  $db->sql_query("INSERT INTO empresas (empresa,id_naturaleza,nit,direccion,telefono,web,observaciones,email,pais,ciudad,telefono2) VALUES('".$frm[empresa]."','".$frm[id_naturaleza]."','".$frm[nit]."','".$frm[direccion_emp]."','".$frm[telefono_emp]."','".$frm[web_emp]."','".$frm[observaciones]."','".$frm[email_emp]."','".$frm[pais_emp]."','".$frm[ciudad_emp]."','".$frm[telefono2_emp]."')");
	
	
	$id_empresa=$db->sql_query("select max(id) from empresas");
    $idemp=$db->sql_fetchrow($id_empresa);
    $db->sql_query("INSERT INTO empresas_promotores (id_empresa,id_promotor) VALUES('".$idemp[0]."','".$frm[id_usuario]."')");
	
	
	    $actividad1=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
    if (@$frm['empresas_razones1']){
		  if($actividad1[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','1')");
		  }
		}else{
		  if($actividad1[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
		   }
		}	
	
	
	 $actividad2=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
    if (@$frm['empresas_razones2']){
		  if($actividad2[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','2')");
		  }
		}else{
		  if($actividad2[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
		   }
		}	
		
		
		
	 $actividad3=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
    if (@$frm['empresas_razones3']){
		  if($actividad3[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','3')");
		  }
		}else{
		  if($actividad3[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
		   }
		}	
		
		
	 $actividad4=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
    if (@$frm['empresas_razones1']){
		  if($actividad4[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','4')");
		  }
		}else{
		  if($actividad4[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
		   }
		}	
		
	 $actividad5=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
    if (@$frm['empresas_razones5']){
		  if($actividad5[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','5')");
		  }
		}else{
		  if($actividad5[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
		   }
		}	
		
	 $actividad6=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
    if (@$frm['empresas_razones6']){
		  if($actividad6[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','6')");
		  }
		}else{
		  if($actividad6[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
		   }
		}	
		
	 $actividad7=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
    if (@$frm['empresas_razones7']){
		  if($actividad7[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','7')");
		  }
		}else{
		  if($actividad7[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
		   }
		}	
		
	 $actividad8=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
    if (@$frm['empresas_razones8']){
		  if($actividad8[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','8')");
		  }
		}else{
		  if($actividad8[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
		   }
		}	
		
		
	 $actividad9=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
    if (@$frm['empresas_razones9']){
		  if($actividad9[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','9')");
		  }
		}else{
		  if($actividad9[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
		   }
		}	
		
	 $actividad10=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
    if (@$frm['empresas_razones10']){
		  if($actividad10[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','10')");
		  }
		}else{
		  if($actividad10[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
		   }
		}	
	
	}
	
	/**************************fin organizacion ************************/

   		echo "<div style='margin-left:250px;'>Sus datos fueron actualizados.</div>";
   
   
   
	//include("CCB/paso_3P.php");
}

function procesar_paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";
    $usuario=$db->sql_row("SELECT id FROM promotores WHERE login='".$frm[login]."'");
	if($usuario[0]!=''){
		$frm["error"]="El usuario ya existe.";
		paso_1($frm);
	}
	else{
		$frm["password"]=md5($frm["password"]);
		$frm["password2"]=$frm["password2"];
		$frm["id_usuario"]=$db->sql_insert("promotores",$frm);
		$frm["tipoEntrada"]=0;
		include("CCB/paso_2P.php");
	}
}

function paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="actPro";

	/*if($CFG->mercado!=20 && $CFG->mercado!=21 ){
	$areas_options=$db->sql_listbox("SELECT codigo, nombre FROM pr_areas WHERE id=2","",nvl($frm["area"]));
	}else if($CFG->mercado==21){
	$areas_options=$db->sql_listbox("SELECT codigo, nombre FROM pr_areas WHERE id!=2","",nvl($frm["area"]));	
	}else{
	$areas_options=$db->sql_listbox("SELECT codigo, nombre FROM pr_areas WHERE id!=2","",nvl($frm["area"]));
	}*/
	include("CCB/paso_1P.php");
}

?>
