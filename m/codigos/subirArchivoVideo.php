<?php 
include("../application2.php");
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
if($_POST["id_grupo"]!=""&&$_POST["etiqueta"]!=""&&$_POST["url"]!=""){
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM archivos_grupos_musica where id_grupos_musica='".$_POST["id_grupo"]."'");
 $ordenMax["MAX(orden)"];
 $archivo=array();
 $archivo["id_grupos_musica"]=$_POST["id_grupo"];
 $archivo["tipo"]=3;
 $archivo["etiqueta"]=$_POST["etiqueta"];
 $archivo["url"]=$_POST["url"];
 $archivo["orden"]=($ordenMax["MAX(orden)"]+1);
 
  $cadena = $_POST["url"];
  $buscar = "iframe";
  $resultado = strpos($cadena, $buscar);

if($resultado !== FALSE){
 $id_audio=$db->sql_insert("archivos_grupos_musica", $archivo);
 
 ?>
 <script>
  window.parent.refrescar();
  window.frameElement.ownerDocument.parentWindow.refrescar();
  window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_4muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"];?>";
 </script>
 
 <?php
 
}else{
	echo "<script>";
	echo "alert('El codigo de video no es valido')";
	echo "</script>";
  }
}else{
	
	
	}
?>
<form action="subirArchivoVideo.php?item=<?php echo $_GET["item"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["id_grupo"];?>" name="id_grupo" id="id_grupo"/>
<input type="hidden" value="<?php echo $_GET["id_usuario"];?>" name="id_usuario" id="id_usuario"/>
<input type="hidden" value="<?php echo $_GET["area"];?>" name="area" id="area"/>
<input type="hidden" name="a" value="<?=$_GET["a"]?>">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="34%"  class="colorTexto"><strong>(*) Etiqueta:</strong></td>
    <td width="66%"><input name="etiqueta" type="text" id="etiqueta" size="45" /></td>
  </tr>
  <tr>
    <td  class="colorTexto"><strong>(*) Video YOUTUBE o VIMEO:<br />
      <br />
      Ve las intrucciones, haciendo clic en el botón
    </strong></td>
    <td><label for="url"></label>
      <textarea name="url" id="url" cols="58" rows="3"></textarea></td>
  </tr>
  <tr>
    <td><a href="manualVideo.pdf" target="_blank" class="link">Ver Instrucciones</a></td>
    <td><input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
  </tr>
</table>

</form>
</body>
</html>