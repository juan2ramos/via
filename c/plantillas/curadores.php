<?

$CFG->sesion_grnic_cur="GRNICCUR";
if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
else $frm=$_GET;

if((!isset($frm["mode"]) || ($frm["mode"]!="acceso" && $frm["mode"]!="login")) && (!isset($_SESSION[$CFG->sesion_grnic_cur]) || !isset($_SESSION[$CFG->sesion_grnic_cur]["user"]))){
	header("Location: " . $ME . "?mode=login&mercado=".$CFG->mercado);
	die();
}

switch(nvl($frm["mode"])){
	case "acceso":
		verificar_acceso($frm);
		break;
	case "login":
		print_login_form($frm);
		break;
	case "listar_grupos":
		listar_grupos($frm);
		break;
	case "final":
		paso_2($frm);
		break;
	case "paso_3":
		paso_3($frm);
		break;
	case "paso_4":
		paso_4($frm);
		break;
	case "evaluar":
		eval_form($frm);
		break;
	case "update":
		update($frm);
		break;
	default:
		preguntar($frm);
		break;
}

function update($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	include($CFG->modulesdir . "/curadores_grupos.php");
	$entidad->loadValues($frm);
	$entidad->set("mode","$frm[mode]");
	$entidad->update();

	echo "<script>\nwindow.location.href='" . $ME . "?modo=curadores&mode=listar_grupos&a=1';\n</script>\n";

}

function eval_form($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	 $curador=$_SESSION[$CFG->sesion_grnic_cur]["user"];
	 $curador_id=$_SESSION[$CFG->sesion_grnic_cur]["user"]["id"];
	if($curador_id!=24){
		if($curador_grupo=$db->sql_row("SELECT * FROM curadores_grupos WHERE id_curador='$curador[id]' AND id_grupo_" . $frm["area"] . "='" . $frm["id_grupo"] . "'")){
		}
		else{
			$curador_grupo["id_curador"]=$curador["id"];
			$curador_grupo["id_grupo_" . $frm["area"]]=$frm["id_grupo"];
			$curador_grupo["fecha"]=date("Y-m-d H:i:s");
			$curador_grupo["id"]=$db->sql_insert("curadores_grupos",$curador_grupo);
		}
	
		include($CFG->modulesdir . "/curadores_grupos.php");
	
		$attCurador=$entidad->getAttributeByName("id_curador");
		$attCurador->foreignTableFilter="id='$curador[id]'";
	
		//if($frm["area"]=="musica"){
			$attGrupoDanza=$entidad->getAttributeByName("id_grupo_danza");
			$attGrupoDanza->inputType="hidden";
			$attGrupoMusica=$entidad->getAttributeByName("id_grupo_musica");
			$attGrupoMusica->foreignTableFilter="id='" . $frm["id_grupo"] . "'";
			$attGrupoTeatro=$entidad->getAttributeByName("id_grupo_teatro");
			$attGrupoTeatro->inputType="hidden";
		//}
	
	
		$entidad->load($curador_grupo["id"]);
		$entidad->set("newMode","update");
		$entidad->set("mode","$frm[mode]");
		$string_entidad=$entidad->getForm($frm);
		$javascript_entidad=$entidad->getJavaScript();
	}
	
	include("CCB/verpaso_2Curadores.php");
	include("CCB/verpaso_3Curadores.php");
	include("CCB/verpaso_4Curadores.php");
	if($curador_id!=24){
	include("CCB/eval_form.php");
	}
}

function paso_4($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$grupo=$db->sql_row("SELECT id,nombre,email FROM grupos_$frm[area] WHERE id='$frm[id_grupo]'");

	if($frm["area"]=="musica") $frm["produccion"]=$frm["obra"];
	$frm["id_grupos_" . $frm["area"]]=$frm["id_grupo"];

	$frm["id"]=$frm["id_obra"];
	$qPersonas=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_" . $frm["area"] . "='$frm[id_grupo]' ORDER BY id");
	$persona1=$db->sql_fetchrow($qPersonas);
	$persona2=$db->sql_fetchrow($qPersonas);

	include("CCB/paso_4.php");
}

function paso_3($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$obra=$db->sql_row("SELECT * FROM obras_" . $frm["area"] . " WHERE id_grupos_" . $frm["area"] . " = '$frm[id_grupo]'");
	if($frm["area"]=="musica") $obra["obra"]=$obra["produccion"];
	if($od=$db->sql_row("SELECT * FROM archivos_obras_" . $frm["area"] . " WHERE id_obras_" . $frm["area"] . "='$obra[id]' AND etiqueta='Video'")){
		$frm["codigo_video"]=$od["url"];
	}
	include("CCB/paso_3.php");
}

function paso_2($frm){
	/*GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$frm["id_usuario"]="curador";
	$frm["login"]="curador";
	$grupo=$db->sql_row("SELECT * FROM grupos_" . $frm["area"] . " WHERE id='$frm[id_grupo]'");
	foreach($grupo as $key=>$val){
		if(!is_numeric($key)) $frm[$key]=$val;
	}

	include("CCB/paso_2.php");*/
	
}

function listar_grupos($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$id_curador=$_SESSION[$CFG->sesion_grnic_cur]["user"]["id"];
	/*$curador=$db->sql_row("
		SELECT cur.*, 
		(SELECT GROUP_CONCAT(ca.id_area SEPARATOR ',') FROM curadores_areas ca WHERE ca.id_curador=cur.id GROUP BY ca.id_curador) as areas
		FROM curadores cur WHERE cur.id='$id_curador'
	");*/

	//if(preg_match("/1/",$curador["areas"]))	$qGruposDanza=$db->sql_query("SELECT id,nombre,'danza' as area FROM grupos_danza WHERE id IN (SELECT id_grupo_danza FROM curadores_grupos WHERE cumple_requisitos='1') ORDER BY nombre");
	//if(preg_match("/2/",$curador["areas"])) $qGruposMusica=$db->sql_query("SELECT id,nombre,'musica' as area FROM grupos_musica WHERE id IN (SELECT id_grupo_musica FROM curadores_grupos WHERE cumple_requisitos='1') ORDER BY nombre");
	//if(preg_match("/3/",$curador["areas"])) $qGruposTeatro=$db->sql_query("SELECT id,nombre,'teatro' as area FROM grupos_teatro WHERE id IN (SELECT id_grupo_teatro FROM curadores_grupos WHERE cumple_requisitos='1') ORDER BY nombre");
	
	//if(preg_match("/1/",$curador["areas"]))	$qGruposDanza=$db->sql_query("SELECT id,nombre,'danza' as area FROM grupos_danza WHERE ingresado_por ='1' ORDER BY nombre");
	//if(preg_match("/2/",$curador["areas"])) $qGruposMusica=$db->sql_query("SELECT id,nombre,'musica' as area FROM grupos_musica WHERE ingresado_por ='1' ORDER BY nombre");
	//if(preg_match("/3/",$curador["areas"])) $qGruposTeatro=$db->sql_query("SELECT id,nombre,'teatro' as area FROM grupos_teatro WHERE ingresado_por ='1' ORDER BY nombre");
	
	
	//colocar banner
	//$qGruposMusica=$db->sql_query("SELECT id,nombre,'musica' as area FROM grupos_musica WHERE ingresado_por ='1' AND convenio='Centroamerica' ORDER BY nombre");
	$qGruposMusica=$db->sql_query("SELECT id,nombre,'musica' as area FROM grupos_musica WHERE ingresado_por ='1' AND convenio='Circulart2013' ORDER BY nombre");
	include("CCB/listado_grupos.php");
}

function verificar_acceso($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$login=mysql_real_escape_string($frm["login"]);
	$password=mysql_real_escape_string($frm["password"]);
	$strSQL="SELECT * FROM curadores WHERE login='$login' AND password='$password'";
	if($user=$db->sql_row($strSQL)){
		$_SESSION[$CFG->sesion_grnic_cur]["user"]=$user;
		//listar_grupos($frm);
		header("Location:index.php?modo=curadores&mode=listar_grupos&a=1");
		die();
	}
	else{
		$frm["error"]="Login o password incorrecto";
		print_login_form($frm);
	}
}

function print_login_form($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";
	
	if(isset($_SESSION[$CFG->sesion_grnic_cur])) unset($_SESSION[$CFG->sesion_grnic_cur]);
	$newMode="acceso";
	$a=1;
	include("CCB/login_curador_form.php");

}
?>