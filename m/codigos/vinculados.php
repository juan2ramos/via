<link href="../css/style.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:0;
	background:#fff;
	text-align:center;
		background-color:#383838
	}
	#carga{
		display:none;}
	a{
		color:#FFF;
		text-decoration:underline;}	
			
</style>
<?php
include("../application.php");
GLOBAL $CFG, $ME, $db;

$frm["id"]=$_GET["item"];
$frm["area"]=$_GET["area"];
$frm["paso"]=$_GET["paso"];

if($frm["paso"]==1){
$vinculados = $db->sql_query("SELECT * FROM vinculados WHERE id_grupo_".$frm["area"]."='".$frm["id"]."'");
while($datos_obras=$db->sql_fetchrow($obras)){
	?>
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?=$datos_obras["nombre"]?></td>
    <td><?=$datos_obras["documento"]?></td>
    <td>eliminar</td>
  </tr>
</table>
	<?php
	}
}
?>
