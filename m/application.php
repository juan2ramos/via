<?php
/*if(isset($_SERVER["SERVER_NAME"]) && preg_match("/ruedadenegociosculturales\.com\$/",$_SERVER["SERVER_NAME"])){
	header("Location: http://www.circulart.org/grnic/");
	die();
}
elseif(isset($_SERVER["SERVER_NAME"]) && preg_match("/redlat\.org\$/",$_SERVER["SERVER_NAME"])){
	header("Location: http://www.circulart.org/redlatcolombia/");
	die();
}
elseif(isset($_SERVER["SERVER_NAME"]) && preg_match("/vanialatina\.com\$/",$_SERVER["SERVER_NAME"])){
	header("Location: http://www.circulart.org/vanialatina/");
	die();
}
elseif(isset($_SERVER["SERVER_NAME"]) && preg_match("/(ibercultura\.org|mercadoculturaldebogota\.com|redlat\.org|vanialatina\.com)\$/",$_SERVER["SERVER_NAME"])){
	header("Location: http://www.circulart.org/");
	die();
}*/
error_reporting(15);

/* define un objeto generico */
class object {};

/* cambia la configuracoin del nuevo object */
$CFG = new object;

$CFG->dirroot  		  = dirname(__FILE__);

preg_match("/" . preg_quote($_SERVER["DOCUMENT_ROOT"],"/") . "(.*)/",$CFG->dirroot,$matches);

$CFG->wwwroot       		= @$matches[1];
$CFG->common_libdir 		= $CFG->dirroot."/lib";
$CFG->templatedir 			= "$CFG->dirroot/admin/templates";
$CFG->admin_dir				=	$CFG->wwwroot."/admin";
$CFG->templatePublicdir		=	$CFG->dirroot."/templates";
$CFG->filesdir    			= "files";
$CFG->tmpdir      			= "$CFG->dirroot/tmp";
$CFG->libdir      			= "$CFG->dirroot/lib";
$CFG->imagedir      		= "$CFG->wwwroot/admin/images";
$CFG->logosdir    			= "$CFG->dirroot/images";
$CFG->modulesdir    		= "$CFG->dirroot/admin/modules";
$CFG->wwwmodulesdir 		= "$CFG->wwwroot/admin/modules";
$CFG->icondir       		= "$CFG->wwwroot/iconos/transparente";
$CFG->javadir				= "$CFG->dirroot/java";
$CFG->jsdir					= "$CFG->dirroot/js";
$CFG->offset_gmt	  		= 0;
$CFG->offset        		= 0.0025;
$CFG->sesion        		= "redlat";
$CFG->sesion_admin  		= "redlatadmin";
$CFG->resultados    		= 10;
$CFG->nombreSitio   		= "VIA";
$CFG->nombreSitioCompleto 	= "VIA, Ventana Internacional de las artes";
$CFG->siteTitle     		= $CFG->nombreSitio." .:: Administración";
$CFG->siteLogo      		= $CFG->imagedir."/logo.gif";
$CFG->languages     		= array("es","en");
$CFG->defaultLang   		= $CFG->languages[0];
$CFG->objectPath    		= $CFG->common_libdir . "/entidades_v_1.4";
$CFG->mail_envio    		= "info@circulart.org";
$CFG->dirwww 				= "http://redlat.org/via/m/";

//tipos admitidos
$CFG->tiposAdmitidosDocumentos = array("application/pdf","application/msword");
$CFG->tiposAdmitidosImagen = array("image/pjpeg","image/jpeg","image/png","image/gif");
$CFG->tiposAdmitidosAudio = array("audio/mpeg","audio/mp3");

$CFG->prueba_return = "";

if(isset($_GET["lang"])){
	$CFG->lang=$_GET["lang"];
	setcookie("lang", $_GET["lang"],time()+60*60*24*30);	//30 días
}
elseif(isset($_COOKIE["lang"])){
	$CFG->lang=$_COOKIE["lang"];
}
else $CFG->lang=$CFG->defaultLang;
if($CFG->lang=="es") $CFG->lang="";

if(isset($_GET["mercado"])){
	$CFG->mercado=$_GET["mercado"];
	setcookie("mercado", $_GET["mercado"],time()+60*60*24*30);	//30 días
}else{ $CFG->mercado=0;

}

/*elseif(isset($_COOKIE["mercado"])){
	$CFG->mercado=$_COOKIE["mercado"];
	echo "<script>";
    echo "window.location='http://circulart.org/index.php?mercado=0';";
    echo "</script>";
}*/


/* define el comportamiento de los errores de la base de datos, como es en periodo de diseño,
 * se prenden todos los debugging  */
$DB_DEBUG = true;
$DB_DIE_ON_FAIL = true;

//Base de datos mysql
/*$CFG->dbhost = "localhost";
$CFG->dbname = "cir48lar_redlat";
$CFG->dbuser = "cir48lar_redlat";
$CFG->dbpass = "redlat4321";*/
$CFG->dbhost = "localhost";
//$CFG->dbhost = "184.107.157.218:3306";
$CFG->dbname = "redlat_cir48lar";
$CFG->dbuser = "redlat_cir48lar";
$CFG->dbpass = "c*giVR=1Z-q_";

require($CFG->common_libdir . "/stdlib.php");
require("$CFG->libdir/validate.php");
require("$CFG->libdir/stdliblocal.php");
require_once($CFG->common_libdir . "/db/mysql.php");

//preguntar($_SERVER);
$ME = qualified_me();
$CFG->ME = $ME;
$URL=$ME;
$db = new sql_db($CFG->dbhost, $CFG->dbuser, $CFG->dbpass, $CFG->dbname);
$db->logDebug=0;
$db->logFile=$CFG->dirroot . "/log/log.txt";
$db->logLevel=1;
$CFG->defaultModule="usuarios";

setlocale (LC_CTYPE, "es_ES");

/* inicializa el manejo de sesiones, sólo se usará un arreglo llamado SESSION para almacenar las variables.   */

if(!isset($_SERVER["REQUEST_METHOD"])) $CFG->cli=1;
else $CFG->cli=0;

//if (isset($_SERVER["REQUEST_METHOD"])) session_start();
if (!isset($_SESSION[$CFG->sesion])) $_SESSION[$CFG->sesion] = array();

if (isset($_SERVER["REQUEST_METHOD"])) $CFG->servidor = "http://" . $_SERVER["SERVER_NAME"];

if(isset($_GET))
{
	verificar_sud($_GET);
	foreach ($_GET AS $key => $val){
		if ($key != "GLOBALS") eval("\$" . $key . "=\$_GET[\"" . $key . "\"];");
	}
}

if (isset($_POST))
{
	verificar_sud($_POST);
	foreach ($_POST AS $key => $val){
		if ($key != "GLOBALS") eval("\$" . $key . "=\$_POST[\"" . $key . "\"];");
	}
}

$inicio=microtime();

if(simple_me($ME)!="login.php" && simple_me($ME)!="imagen.php" && simple_me($ME)!="file.php" && simple_me($ME)!="fileFS.php" && isset($_SERVER["REQUEST_METHOD"]) && simple_me($ME)!="registro_grupo.php"){

	if(!is_logged() && !preg_match("/\\/admin\\//",$ME)){
		$_SESSION[$CFG->sesion]["nivel"]="guest";
		$_SESSION[$CFG->sesion]["ip"]=$_SERVER["REMOTE_ADDR"];
	}
	elseif(!is_logged()){
		$_SESSION[$CFG->sesion]["goto"]=$ME;
		if(nvl($_SERVER["QUERY_STRING"])!="") $_SESSION[$CFG->sesion]["goto"].="?" . $_SERVER["QUERY_STRING"];
		$goto = $CFG->wwwroot . "/admin/login.php";
		header("Location: $goto");
		die();
	}
}
?>
