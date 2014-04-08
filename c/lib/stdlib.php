<?
/* stdlib.php */

function nvl(&$var, $default="") {
/* si $var no está definida, devuelve $default, si no, devuelve $var */

	return isset($var) ? $var : $default;
}

function strip_querystring($url) {
/* toma un URL y lo devuelve sin la parte querystring */

	if ($commapos = strpos($url, '?')) {
		return substr($url, 0, $commapos);
	} else {
		return $url;
	}
}

function simple_me($url) {
/* toma un URL y lo devuelve sin la parte querystring y sin la ruta */

	if($last = substr (strrchr ($url, '/'), 1 )){
		return $last;
	} else {
		return $url;
	}
}

function get_referer() {
/* devuelve el URL del HTTP_REFERER, sin la parte querystring */

	$HTTP_REFERER = getenv("HTTP_REFERER");
	return strip_querystring(nvl($HTTP_REFERER));
}

function me() {
/* devuelve el nombre del script actual, sin la parte querystring
 * esta función es necesaria, porque las funciones PHP_SELF, REQUEST_URI y PATH_INFO
 * devuelven cosas diferentes dependiendo de cosas como el sistema operativo, el
 * servidor web, y la forma de compilación del php (v.gr. como un módulo CGI, módule, ISAPI, etc.) */

	if (getenv("REQUEST_URI")) {
		$me = getenv("REQUEST_URI");

	} elseif (getenv("PATH_INFO")) {
		$me = getenv("PATH_INFO");

	} elseif ($_SERVER["PHP_SELF"]) {
		$me = $_SERVER["PHP_SELF"];
	}

	return strip_querystring($me);
}

function complete_me() {
/* devuelve el nombre del script actual, sin la parte querystring
 * esta función es necesaria, porque las funciones PHP_SELF, REQUEST_URI y PATH_INFO
 * devuelven cosas diferentes dependiendo de cosas como el sistema operativo, el
 * servidor web, y la forma de compilación del php (v.gr. como un módulo CGI, módule, ISAPI, etc.) */

	if (getenv("REQUEST_URI")) {
		$me = getenv("REQUEST_URI");

	} elseif (getenv("PATH_INFO")) {
		$me = getenv("PATH_INFO");

	} elseif ($GLOBALS["PHP_SELF"]) {
		$me = $GLOBALS["PHP_SELF"];
	}

	return $me;
}

function qualified_me() {
/* como me() pero devuelve un URL completo */

	$HTTPS = getenv("HTTPS");
	$SERVER_PROTOCOL = getenv("SERVER_PROTOCOL");
	$HTTP_HOST = getenv("HTTP_HOST");

	$protocol = (isset($HTTPS) && $HTTPS == "on") ? "https://" : "http://";
	$url_prefix = "$protocol$HTTP_HOST";
	return $url_prefix . me();
}

function redirect($url, $message="", $delay=0) {
/* redirecciona a un nuevo URL usando meta tags */
	echo "<meta http-equiv='Refresh' content='$delay; url=$url'>";
	if (!empty($message)) echo "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center>$message</div>";
	die;
}

function hallar_querystring($variable="",$valor="",$frm=""){

	if($frm=="") $frm=$_GET;
	elseif(!is_array($frm)){
		$str=preg_replace("/^\?/","",$frm);
		$str=preg_replace("/&amp;/","&",$str);
		$array=explode("&",$str);
		$frm=array();
		for($i=0;$i<sizeof($array);$i++){
			if(preg_match("/(.*)=(.*)/",$array[$i],$matches)){
				$key=$matches[1];
				$val=$matches[2];
			}
			else{
				$key=$array[$i];
				$val="";
			}
			$frm[$key]=$val;
		}
	}
	$querystring="?";
	$cambiada=0;  //Para revisar si la variable $variable viene en el querystring y se cambió, si no, pues toca agregarla
	$i=0;

	foreach ($frm AS $key => $val)
	{
		if($i!=0) $querystring.= "&amp;";
		if ($key != $variable && $key!="results") $querystring.= $key .  "=" . stripslashes(str_replace("&","%26",$val));
		elseif($valor!=""){
			$querystring.= $variable .  "=" . $valor;
			$cambiada=1;
		}
		$i++;
	}
	if($cambiada==0 && $valor!=""){
		if($i!=0) $querystring.= "&amp;";
		$querystring.= $variable .  "=" . $valor;
	}
	return $querystring;
}

function querystring2array($querystring){
	
	$querystring=preg_replace("/^\\?/","",$querystring);
	$querystring=preg_replace("/&amp;/","&",$querystring);

	$array=array();
	$array1=explode("&",$querystring);
	for($i=0;$i<sizeof($array1);$i++){
		$array2=explode("=",$array1[$i]);
		$array[$array2[0]]=$array2[1];
	}
	return($array);
}

function preguntar($var){
	GLOBAL $CFG;
		echo "<pre><font color='#FF00FF'>";
		print_r($var);
		echo "</font></pre>";
}

function es_vguzman(){
	GLOBAL $CFG;
	if(nvl($_SESSION[$CFG->sesion]["user"]["login"]) == "vguzman") return(TRUE);
	return(FALSE);
}

function listbox($arreglo, $default="", $suffix="\n"){
	$string="";
  foreach ($arreglo AS $key => $val){
		$selected="";
		if($key==$default) $selected=" SELECTED";
		$string.="<option value=\"" . $key . "\"" . $selected . ">" . $val . $suffix;
	}
	return $string;
}

function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

function wc($file){
	exec("/usr/bin/wc -l " . $file, $resultado);
	preg_match("/^[ \t]+([0-9]+)[ \t]/",$resultado[0],$matches);
	$total=$matches[1];
	return($total);
}

function print_tiempo($inicio,$fin){
	$diferencia=$fin-$inicio;

	$horas=str_pad(floor($diferencia/3600),2,"0", STR_PAD_LEFT);
	$minutos=str_pad(floor(($diferencia%3600)/60),2,"0", STR_PAD_LEFT);
	$segundos=str_pad(floor($diferencia%60),2,"0", STR_PAD_LEFT);
	$decimas=str_pad(floor(($diferencia-floor($diferencia))*100),2,"0", STR_PAD_LEFT);
	return("$horas:$minutos:$segundos,$decimas");
}

/*Funcion para incluir multiples archivos de un directorio que se encuentre dentro
	de la libreria de la aplicacion.*/

function import($archivo, $recursivo=true)
{
	global $CFG;
	$ruta = $CFG->libdir."/".$archivo;
	if(file_exists($ruta) && !is_dir($ruta))
	{
		include_once($ruta);
	}
	elseif(is_dir($ruta))
	{
		$all = scandir($ruta);
		foreach($all as $key=>$val)
		{
			if($val != "." && $val != "..")
			{
				if(is_dir($ruta."/".$val) && $recursivo)
				{
					import($archivo."/".$val,true);
				}
				else
				{
					if(substr($val,-4)=="php5" || substr($val,-3)=="php")
						include_once($ruta."/".$val);
				}
			}
		}
	}
	else
	{
		echo "La ruta de importacion: <b>".$ruta."</b> es errada<br>";
	}
}

function file2db($table,$field,$id,$file,$colId="id"){
	GLOBAL $CFG, $db;

	$str=file_get_contents($file);
	$str=base64_encode($str);
	$str=basename($file) . "|" . mime_content_type($file) . "|" . filesize($file)  . "|" . $str;
	$strQuery="UPDATE $table SET $field = '$str' WHERE $colId='$id'";
	$qid=$db->sql_query($strQuery);
}

function db2file($table,$field,$id){
	GLOBAL $CFG, $db;

	$strQuery="SELECT $field FROM $table WHERE id = '$id'";
	$qid=$db->sql_query($strQuery);
	if($result=$db->sql_fetchrow($qid)){
		$strImage=$result[0];
		$arrImage=explode("|",$strImage);
		if(sizeof($arrImage)!=4) return(FALSE);
		$imgName=$arrImage[0];
		$imgType=$arrImage[1];
		$imgSize=$arrImage[2];
		$imgImg=base64_decode($arrImage[3]);
		$filename=$CFG->tmpdir . "/" . $imgName;
		if (!$handle = fopen($filename, 'w')) return(FALSE);
		if (fwrite($handle, $imgImg) === FALSE) return(FALSE);
		return($filename);
	}
	else return(FALSE);

}

if ( ! function_exists ( 'mime_content_type' ) )
{
	function mime_content_type ( $f )
	{
		return trim ( exec ('file -bi ' . escapeshellarg ( $f ) ) ) ;
	}
}

function decrom($dec){
//	CONVERTIR UN NÚMERO ENTERO A ROMANO
	$digits=array(
			1 => "I",
			4 => "IV",
			5 => "V",
			9 => "IX",
			10 => "X",
			40 => "XL",
			50 => "L",
			90 => "XC",
			100 => "C",
			400 => "CD",
			500 => "D",
			900 => "CM",
			1000 => "M"
			);
	krsort($digits);
	$retval="";
	foreach($digits as $key => $value){
		while($dec>=$key){
			$dec-=$key;
			$retval.=$value;
		}
	}
	return $retval;
}


function moverImagenToArchivo($archivo,$tabla,$campo,$id)
{
	global $db;

	$strQuery="SELECT ".$campo." FROM ".$tabla." WHERE id = ".$id;
	$qid=$db->sql_query($strQuery);
	if($result=$db->sql_fetchrow($qid))
	{
		$imgImg=base64_decode($result[$campo]);
		$gestor = fopen($archivo,"x+");
		fwrite($gestor,$imgImg);
		fclose($gestor);
		//    file_put_contents($archivo,$imgImg);
	}
}

function verificar_sud($dato)
{
	foreach ($dato AS $key => $val)
	{
		if(is_array($val))
			verificar_sud($val);
		else
			if(preg_match("/\\W(select|update|delete)\\W/i",preg_replace("/[\n\r]/"," ",$val))) die("Error");
	}
}




?>
