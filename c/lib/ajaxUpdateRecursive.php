<?
include("../application.php");
//if(!preg_match("/^select/i",$_GET["query"])) die("ERROR EN LA CONSULTA.::" . $_GET["query"]);
$frm=$_GET;
/*
if(!isset($_SERVER["HTTP_REFERER"])) die("Error: " . __FILE__ . ":" . __LINE__);
$referer=parse_url($_SERVER["HTTP_REFERER"]);
$serverName=$_SERVER["SERVER_NAME"];
if($serverName!=$referer["host"]) die("Error: " . __FILE__ . ":" . __LINE__);
*/

if(!isset($frm["id"])) die("Error: " . __FILE__ . ":" . __LINE__);
if(!isset($frm["module"])) die("Error: " . __FILE__ . ":" . __LINE__);
if(!isset($frm["field"])) die("Error: " . __FILE__ . ":" . __LINE__);
if(!isset($frm["width"])) die("Error: " . __FILE__ . ":" . __LINE__);
if(!isset($frm["divid"])) die("Error: " . __FILE__ . ":" . __LINE__);

include($CFG->modulesdir . "/" . $frm["module"] . ".php");
if(!$objAttribute=$entidad->getAttributeByName($frm["field"])) die("Error: " . __FILE__ . ":" . __LINE__);

$width=$frm["width"];
if(!preg_match("/px\$/i",$width)) $width.="px";

if($objAttribute->foreignTableAlias!=""){
	$alias=$objAttribute->foreignTableAlias;
	$frm["query"]="SELECT $alias.id, " . $objAttribute->get("foreignLabelFields") . " ";
	$frm["query"].=" FROM " . $objAttribute->get("foreignTable") . " " . $alias;
 	$frm["query"].=" WHERE $alias." . $objAttribute->get("fieldIdParent") . "='" . $frm["id"] . "'";
}
else {
	$frm["query"]="SELECT " . $objAttribute->get("foreignFieldId") . ", " . $objAttribute->get("foreignLabelFields") . " FROM " . $objAttribute->get("foreignTable") . " WHERE " . $objAttribute->get("fieldIdParent") . "='" . $frm["id"] . "'";
}

$query=preg_replace("/=%$/"," IS NULL",$frm["query"]);
$qid = $db->sql_query($query);
//echo "<select id=\"" . $frm["divid"] . "\" name=\"" . $frm["field"] . "\" style=\"width:" . $width . "\">";
echo "<select id=\"" . $frm["field"] . "\" name=\"" . $frm["field"] . "\" style=\"width:" . $width . "\">";
	echo "<option value=\"%\">Seleccione...";
while($result=$db->sql_fetchrow($qid)){
	echo "<option value=\"" . $result[0] . "\">" . htmlentities($result[1]);
}
echo "</select>\n";
//echo $_SERVER["HTTP_REFERER"];
?>
