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
		print_login_form($frm,"acceso");
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
	$seccion="inscripciones";

	if($result=$db->sql_row("SELECT * FROM confirmados_grnic WHERE id_grupo_" . $frm["area"] . "='$frm[id_grupo]'")){
		$qUpdate=$db->sql_query("UPDATE confirmados_grnic SET inscripcion_confirmada='1', fecha=now() WHERE id='$result[id]'");
	}
	else{
		$db->sql_query("INSERT INTO confirmados_grnic (id_grupo_" . $frm["area"] . ",inscripcion_confirmada,fecha) VALUES('$frm[id_grupo]','1',now())");
	}
	$grupo=$db->sql_row("SELECT id,nombre,email FROM grupos_$frm[area] WHERE id='$frm[id_grupo]'");

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

	include("CCB/final.php");
}

function procesar_paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

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

		if($_SESSION[$CFG->sesion_grnic]["user"]["id_nivel"] == 4 || $_SESSION[$CFG->sesion_grnic]["user"]["id_nivel"] == 7)
			$area="danza";
		elseif($_SESSION[$CFG->sesion_grnic]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_grnic]["user"]["id_nivel"] == 8)
			$area="musica";
		elseif($_SESSION[$CFG->sesion_grnic]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_grnic]["user"]["id_nivel"] == 9)
			$area = "teatro";
		else die("Error: " . __FILE__ . ":" . __LINE__);

		$frm=$db->sql_row("
			SELECT *
			FROM grupos_$area
			WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$user[id]' LIMIT 1)
		");
		$frm["id_usuario"]=$user["id"];
		$frm["id_grupo"]=$frm["id"];
		$frm["login"]=$user["login"];
		$frm["area"]=$area;
		include("CCB/paso_2.php");

		die;
	} else {
		$frm["error"] = "Login inválido, por favor intente de nuevo.";
		$newMode="acceso";
		include("CCB/login_form.php");
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

		if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 4 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 7)
			$area="danza";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
			$area="musica";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
			$area = "teatro";
		else die("Error: " . __FILE__ . ":" . __LINE__);

		$goto = $CFG->admin_dir . "/index.php?module=grupos_$area";

		$grupo=$db->sql_row("SELECT id, nombre, email FROM grupos_$area WHERE id=(SELECT id_grupo_$area FROM usuarios_grupos_$area WHERE id_usuario = '$user[id]' LIMIT 1)");

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

		header("Location: $goto");
		die;
	} else {
		$frm["error"] = "Login inválido, por favor intente de nuevo.";
		include("CCB/login_form.php");
	}
}

function verify_login($username, $password) {
	GLOBAL $db;
	$seccion="inscripciones";

	$pass = md5($password);
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM usuarios WHERE login = '$username' AND password = '" . $pass . "' AND id_nivel IN (4,5,6,7,8,9)");
	if($user=$db->sql_fetchrow($qid))	return($user);
	return(FALSE);
}

function print_login_form($frm,$newMode="acceso_admin"){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	include("CCB/login_form.php");
}

function procesar_paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

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
	include("CCB/paso_4.php");
}

function procesar_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	$usuario=$db->sql_row("SELECT * FROM usuarios WHERE id='$frm[id_usuario]'");

	if(isset($_FILES["ficha"])){
		$val=$_FILES["ficha"];
		if($val["error"]==0){
			if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
			$str=file_get_contents($val["tmp_name"]);
			$str=base64_encode($str);
			$frm["ficha"]=$str;
			$frm["mmdd_ficha_filename"]=$val["name"];
			$frm["mmdd_ficha_filetype"]=$val["type"];
			$frm["mmdd_ficha_filesize"]=$val["size"];
		}
	}
/*
	if(isset($_FILES["trayectoria"]) && $_FILES["trayectoria"]["error"]==0){
		$val=$_FILES["trayectoria"];
		$frm["trayectoria"]="1";
		$frm["mmdd_trayectoria_filename"]=$val["name"];
		$frm["mmdd_trayectoria_filetype"]=$val["type"];
		$frm["mmdd_trayectoria_filesize"]=$val["size"];
	}
*/
	if($frm["id_grupo"]!=""){//Ya existe...
		$frm["id"]=$frm["id_grupo"];
		$db->sql_update("grupos_" . $frm["area"], $frm);
		$obra=$db->sql_row("SELECT * FROM obras_" . $frm["area"] . " WHERE id_grupos_" . $frm["area"] . " = '$frm[id_grupo]'");
		if($frm["area"]=="musica") $obra["obra"]=$obra["produccion"];
		if($od=$db->sql_row("SELECT * FROM archivos_obras_" . $frm["area"] . " WHERE id_obras_" . $frm["area"] . "='$obra[id]' AND etiqueta='Video'")){
			$frm["codigo_video"]=$od["url"];
		}
	}
	else{
		$frm["email"]=$usuario["email"];
		$frm["id_pais"]=4;
		$frm["ingresado_por"]=1;//grnic
		$frm["id_grupo"]=$db->sql_insert("grupos_" . $frm["area"], $frm);
		$db->sql_query("INSERT INTO usuarios_grupos_" . $frm["area"] . " (id_usuario,id_grupo_" . $frm["area"] . ") VALUES('$frm[id_usuario]','$frm[id_grupo]')");
		$db->sql_query("UPDATE usuarios SET nombre='Grupo', apellido='$frm[nombre]' WHERE id='$frm[id_usuario]'");
	}
/*
	if(isset($_FILES["trayectoria"]) && $_FILES["trayectoria"]["error"]==0){
		if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
		$dir=$CFG->dirroot . "/" . $CFG->filesdir . "/grupos_" . $frm["area"] . "/trayectoria/";
		if(!is_dir($CFG->dirroot . "/" . $CFG->filesdir . "/grupos_" . $frm["area"])){
			if(!mkdir($CFG->dirroot . "/" . $CFG->filesdir . "/grupos_" . $frm["area"])) die("Error: " . __FILE__ . ":" . __LINE__);
		}
		if(!is_dir($dir)){
			if(!mkdir($dir)) die("Error: " . __FILE__ . ":" . __LINE__);
		}
		copy($val["tmp_name"],$dir . $frm["id_grupo"]);
	}
*/
	include("CCB/paso_3.php");
}

function procesar_paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	if($usuario=$db->sql_row("SELECT * FROM usuarios WHERE login='$frm[login]'")){
		$frm["error"]="El usuario ya existe.";
		paso_1($frm);
	}
	else{
		if($frm["area"]=="danza") $frm["id_nivel"]=7;
		elseif($frm["area"]=="musica") $frm["id_nivel"]=8;
		elseif($frm["area"]=="teatro") $frm["id_nivel"]=9;
		else die(__FILE__ . ":" . __LINE__);
		$frm["password"]=md5($frm["password"]);
		$frm["id_usuario"]=$db->sql_insert("usuarios",$frm);
		include("CCB/paso_2.php");
	}
}

function paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="inscripciones";

	if($CFG->mercado!=20){
	$areas_options=$db->sql_listbox("SELECT codigo, nombre FROM pr_areas WHERE id=2","",nvl($frm["area"]));}else{
	$areas_options=$db->sql_listbox("SELECT codigo, nombre FROM pr_areas WHERE id!=2","",nvl($frm["area"]));
		}
	include("CCB/paso_1.php");
}

?>
