<?php 
include("../application2.php");
GLOBAL $CFG, $ME, $db;
?>
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
	#ufile{
		background-color:#FFF;}	
	input, textarea{
		width:300px;}	
	table{
		font-size:14px;
		}	
</style>
<?php

$obra_id=$_GET["item"];
$area=$_GET["area"];
if(isset($_POST["obra"])&&isset($_POST["etiqueta"])&&isset($_POST["url"])){
if($_POST["obra"]!=""&&$_POST["etiqueta"]!=""&&$_POST["url"]!=""){
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM archivos_obras_".$area." where id_obras_".$area."='".$_POST["obra"]."'");
 $ordenMax["MAX(orden)"];
 $archivo=array();
 $archivo["id_obras_".$area]=$_POST["obra"];
 $archivo["tipo"]=3;
 $archivo["etiqueta"]=$_POST["etiqueta"];
 $archivo["url"]=$_POST["url"];
 $archivo["orden"]=($ordenMax["MAX(orden)"]+1);
   $cadena = $_POST["url"];
  $buscar = "iframe";
  $resultado = strpos($cadena, $buscar);

if($resultado !== FALSE){
 $id_audio=$db->sql_insert("archivos_obras_".$area, $archivo);}
}}
?>
<form action="cargaVideo.php?item=<?php echo $_GET["item"];?>&area=<?php echo $_GET["area"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["item"];?>" name="obra" id="obra"/>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="34%"><strong>(*) Etiqueta:</strong></td>
    <td width="66%"><input name="etiqueta" type="text" d="Submit" size="75" /></td>
  </tr>
  <tr>
    <td valign="top" ><strong>(*) Video YOUTUBE o VIMEO:<br />
      <br />
      Ve las intrucciones, haciendo clic en el enlace
    </strong></td>
    <td><label for="url"></label>
      <textarea name="url" id="url" cols="58" rows="5"></textarea></td>
  </tr>
  <tr>
    <td><a href="http://2013.circulart.org/m/pdf/manualVideo.pdf" target="_blank" class="link">Ver instrucciones</a></td>
    <td><input type="submit" name="enviar" id="Submit" value="Enviar" /></td>
  </tr>
</table>

</form>
<div style="text-align:right; margin-bottom:30px; margin-right:30px;">si no puede ver los videos, haga clic 
<a href="cargaVideo.php?item=<?php echo $_GET["item"]; ?>&area=<?php echo $_GET["area"]; ?>" class="link">aqu&iacute;</a></div>
<?php 
$obras = $db->sql_query("SELECT * FROM archivos_obras_".$_GET["area"]." WHERE id_obras_".$_GET["area"]." ='".$_GET["item"]."' AND tipo='3'");
	while($datos_obras=$db->sql_fetchrow($obras)){
?> 

<hr />
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="42%" valign="top" class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?><b>
    <br />
    <br /></td>
    <td colspan="2" valign="top" class="colorTexto"><a class="link" href="eliminarItemsVideo.php?item=<?=$datos_obras["id"]?>&area=<?=$_GET["area"];?>&item2=<?=$_GET["item"]?>">Eliminar</a></td>
  </tr>
  <tr>
    <td colspan="3"><?php echo $datos_obras["url"]; ?></td>
  </tr>
</table>
<?php
}
?>
</body>
</html>