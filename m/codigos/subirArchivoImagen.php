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
<body>
<?php

$obra_id=$_GET["id_grupo"];
 $caratula=$_FILES['caratula'];
 $caratula["name"];
if($_POST["id_grupo"]!=""&&$_POST["etiqueta"]!=""&&$caratula["name"]!=""){
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM archivos_grupos_musica where id_grupos_musica='".$_POST["id_grupo"]."'");
 $ordenMax["MAX(orden)"];



if($caratula["name"]!=""){
	
	if(preg_match("/php$/i",$caratula["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
	    $archivo=array();
		$archivo["id_grupos_musica"]=$_POST["id_grupo"];
		$str=file_get_contents($caratula["tmp_name"]);
		$str=base64_encode($str);
		$archivo["archivo"]=$str;
	    $archivo["tipo"]=1;
	    $archivo["etiqueta"]=$_POST["etiqueta"];
	    $archivo["orden"]=($ordenMax["MAX(orden)"]+1);
		$archivo["mmdd_archivo_filename"]=$caratula["name"];
		$archivo["mmdd_archivo_filetype"]=$caratula["type"];
		$archivo["mmdd_archivo_filesize"]=$caratula["size"];
	    
		
		$tamanos = getimagesize($val["tmp_name"]);
		
		
        if($archivo["mmdd_archivo_filesize"]<7000000&&$tamanos[0]<103000&&$tamanos[1]<80000){
		
		if($archivo["mmdd_archivo_filetype"]=="image/png"||$archivo["mmdd_archivo_filetype"]=="image/jpeg"||$archivo["mmdd_archivo_filetype"]=="image/jpg"||$archivo["mmdd_archivo_filetype"]=="image/gif"){
		
			   $archivo["id"]=$db->sql_insert("archivos_grupos_musica", $archivo);
			   $grupo_id=$db->sql_row("SELECT * FROM archivos_grupos_musica where id_grupos_musica='".$_POST["id_grupo"]."'");
			   $path= "../../../tmp/".$archivo["id"]."_musica_a_".$caratula["name"];		
				 if(copy($caratula['tmp_name'], $path))
				  { 
				   
					?>
<script>
					 window.parent.refrescar();
					 window.frameElement.ownerDocument.parentWindow.refrescar();
				     window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_4muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"];?>";
					</script>
					 <div align="center">. </div>
	
					<?php
				  }else{
						?>
						<div align="center">
                      <strong>Recuerde que las imagenes deben ser inferiores de 2M de peso, sus dimensiones  [600X400] y el formato [jpg, gif o png].</strong>
                        </div>
						<?php
				  }
		}} 
	}
}}
?>
<form action="subirArchivoImagen.php?item=<?php echo $_GET["item"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["id_grupo"];?>" name="id_grupo" id="id_grupo"/>
<input type="hidden" value="<?php echo $_GET["id_usuario"];?>" name="id_usuario" id="id_usuario"/>
<input type="hidden" value="<?php echo $_GET["area"];?>" name="area" id="area"/>
<input type="hidden" name="a" value="<?=$_GET["a"]?>">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2" class="colorTexto"><strong>Recuerde que las imagenes deben ser inferiores de 5 Megas de peso, sus dimensiones  [600X400] y el formato [jpg, gif o png].</strong></td>
    </tr>
  <tr>
    <td width="32%" class="colorTexto"><strong>Etiqueta:</strong></td>
    <td width="68%"><input name="etiqueta" type="text" id="etiqueta" size="65" /></td>
  </tr>
  <tr>
    <td class="colorTexto"><strong>Imagen:</strong></td>
    <td>
      <input name="caratula" type="file" id="caratula" size="40" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
  </tr>
</table>

</form>
<hr />
</body>
</html>