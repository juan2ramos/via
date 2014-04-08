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
	case "evaluar":
		paso_2($frm);
		break;
	case "paso_3":
		paso_3($frm);
		break;
	case "paso_4":
		paso_4($frm);
		break;
	case "final":
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

	echo "<script>\nwindow.location.href='" . $ME . "?modo=curadores&mode=listar_grupos';\n</script>\n";

}

function eval_form($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";
	$curador_grupo=$db->sql_row("SELECT * FROM curadores_grupos WHERE id_curador='".$frm["id_curador"]."' AND id_grupo_musica='" . $frm["id_grupo"] . "'");
	$datos=array();
	$datos["id_curador"]=$frm["id_curador"];
	$datos["id_grupo_musica"]=$frm["id_grupo"];
	$resultado='';
	if(@$frm["cumple_requisitos"]==1){
		$resultado=1;
		}else{
			$resultado=2;
			}

	$datos["cumple_requisitos"]=$resultado;
	$datos["comentarios"]=$frm["comentarios"]; 
	$datos["fecha"]=date("Y-m-d H:i:s");
	
	if($curador_grupo["id"]==""){
		$curador_grupo["id"]=$db->sql_insert("curadores_grupos",$datos);
		}else{
			$db->sql_query("UPDATE curadores_grupos SET cumple_requisitos='".$resultado."',comentarios='".$datos["comentarios"]."' , fecha='".$datos["fecha"]."' WHERE id='".$curador_grupo["id"]."'");
			}
	echo "<script>\nwindow.location.href='http://www.bogotamusicmarket.com/m/index.php?modo=curadores&mode=listar_grupos&mercado=".$_GET["mercado"]."';\n</script>\n";		
//direccionar a la pagina de listado
//include("CCB/final.php");
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
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$frm["id_usuario"]="curador";
	$frm["login"]="curador";
	$grupo=$db->sql_row("SELECT * FROM grupos_musica WHERE id='$frm[id_grupo]'");
	foreach($grupo as $key=>$val){
		if(!is_numeric($key)) $frm[$key]=$val;
	}
    include("CCB/vistacurador1.php");
    include("CCB/vistacurador2.php");
	include("CCB/vistacurador3.php");
	//include("CCB/paso_2.php");

}

function listar_grupos($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$id_curador=$_SESSION[$CFG->sesion_grnic_cur]["user"]["id"];
	if($id_curador!=""){
	$curador=$db->sql_row("
		SELECT cur.*, 
		(SELECT GROUP_CONCAT(ca.id_area SEPARATOR ',') FROM curadores_areas ca WHERE ca.id_curador=cur.id GROUP BY ca.id_curador) as areas
		FROM curadores cur WHERE cur.id='$id_curador'
	");
	
	//if(preg_match("/1/",$curador["areas"]))	;
	include("CCB/listado_grupos.php");}else{
		
		echo "<script>\nwindow.location.href='http://www.bogotamusicmarket.com/m/index.php?modo=curadores&mode=login;\n</script>\n";
		}
}

function verificar_acceso($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="curadores";

	$login=mysql_real_escape_string($frm["login"]);
	$password=mysql_real_escape_string($frm["password"]);
	$strSQL="SELECT * FROM curadores WHERE login='$login' AND password='$password'";
	if($user=$db->sql_row($strSQL)){
		$_SESSION[$CFG->sesion_grnic_cur]["user"]=$user;
		listar_grupos($frm);
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
	include("CCB/login_curador_form.php");

}
?>