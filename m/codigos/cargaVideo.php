<?php 
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
<?php

$obra_id=$_GET["item"];
if($_POST["obra"]!=""&&$_POST["etiqueta"]!=""&&$_POST["url"]!=""){
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM archivos_obras_musica where id_obras_musica='".$_POST["obra"]."'");
 $ordenMax["MAX(orden)"];
 $archivo=array();
 $archivo["id_obras_musica"]=$_POST["obra"];
 $archivo["tipo"]=3;
 $archivo["etiqueta"]=$_POST["etiqueta"];
 $archivo["url"]=$_POST["url"];
 $archivo["orden"]=($ordenMax["MAX(orden)"]+1);
   $cadena = $_POST["url"];
  $buscar = "iframe";
  $resultado = strpos($cadena, $buscar);

if($resultado !== FALSE){
 $id_audio=$db->sql_insert("archivos_obras_musica", $archivo);}
}
?>
<form action="cargaVideo.php?item=<?php echo $_GET["item"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["item"];?>" name="obra" id="obra"/>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="34%"  class="colorTexto"><strong>(*) Etiqueta:</strong></td>
    <td width="66%"><input name="etiqueta" type="text" id="etiqueta" size="75" /></td>
  </tr>
  <tr>
    <td  class="colorTexto"><strong>(*) Video YOUTUBE o VIMEO:<br />
      <br />
      Ve las intrucciones, haciendo clic en el bot&oacute;n
    </strong></td>
    <td><label for="url"></label>
      <textarea name="url" id="url" cols="58" rows="3"></textarea></td>
  </tr>
  <tr>
    <td><a href="http://2013.circulart.org/m/pdf/manualVideo.pdf" target="_blank" class="link">Ver Instrucciones</a></td>
    <td><input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
  </tr>
</table>

</form>
<div style="text-align:right; margin-bottom:30px; margin-right:30px;">si no puede ver los videos haga clic en 
<a href="cargaVideo.php?item=<?php echo $_GET["item"]; ?>" class="link">actualizar </a></div>
<?php 
$obras = $db->sql_query("SELECT * FROM archivos_obras_musica WHERE id_obras_musica ='".$_GET["item"]."' AND tipo='3'");
	while($datos_obras=$db->sql_fetchrow($obras)){
?> 

<hr />
<table width="100%" border="0" cellspacing="5" cellpadding="5" >
  <tr>
    <td width="84%" class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?><b></td>
    <td width="16%" rowspan="2" align="center" valign="middle"><a class="link" href="eliminarItemsVideo.php?item=<?php echo $datos_obras["id"]?>&item2=<?php echo $_GET["item"]?>">Eliminar</a></td>
  </tr>
  <tr>
    <td><?php echo $datos_obras["url"]; ?></td>
  </tr>
</table>
<?php
}
?>
</body>
</html>