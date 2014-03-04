<?php 
$desactivaSession=1;
include("../application.php");
GLOBAL $CFG, $ME, $db;
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
body{
	background-color:#E7D8B1;
	color:#3D1211;}
table{
	font-size:13px;}
		#carga{
		display:none;}
</style>
<body>
<?php 
$obras = $db->sql_query("SELECT * FROM archivos_obras_musica WHERE id_obras_musica ='".$_GET["item"]."' AND tipo='1'");
	while($datos_obras=$db->sql_fetchrow($obras)){
		if($datos_obras["orden"]!='0'){
?>
<hr />
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="22%">
    <img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/tmp/<?=$datos_obras["id"]?>_musica_a_<?=$datos_obras["mmdd_archivo_filename"]?>&amp;w=200" border="0"></td>
    <td valign="top"  class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?></b></td>
  </tr>
</table>
<?php
}}
?>
</body>
</html>