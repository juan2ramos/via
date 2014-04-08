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
<?php 
$obras = $db->sql_query("SELECT * FROM archivos_obras_musica WHERE id_obras_musica ='".$_GET["item"]."' AND tipo='3'");
	while($datos_obras=$db->sql_fetchrow($obras)){
?>
<table width="100%" border="0" cellspacing="5" cellpadding="5" >
  <tr>
    <td class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?><b></td>
  </tr>
  <tr>
    <td><?php 
	
		$cadena = $datos_obras["url"];
  $buscar = "iframe";
  $resultado = strpos($cadena, $buscar);
  if($resultado !== FALSE){
	  echo $datos_obras["url"];
	  }else{
		  $pieces = explode("=", $cadena);
		  
		 echo "<iframe width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/".$pieces[1]."\" frameborder=\"0\" allowfullscreen></iframe>";
		  }
	?></td>
  </tr>
</table>
<?php
}
?>
</body>
</html>