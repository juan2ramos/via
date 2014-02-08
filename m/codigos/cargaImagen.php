<?php 
include("../application.php");
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
<body>
<?php
if(isset($_POST["obra"])&&isset($_POST["etiqueta"])){
if($_POST["obra"]!=""&&$_POST["etiqueta"]!=""){
 $caratula=$_FILES['caratula'];
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM archivos_obras_".$_POST["area"]." where id_obras_".$_POST["area"]."='".$_POST["obra"]."'");
 $ordenMax["MAX(orden)"];



if($caratula["name"]!=""){
	
	if(preg_match("/php$/i",$caratula["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
	    $archivo=array();
		$archivo["caratula"]=1;
		$str=file_get_contents($caratula["tmp_name"]);
		$str=base64_encode($str);
		$archivo["archivo"]=$str;
		$archivo["id_obras_".$_POST["area"]]=$_POST["obra"];
	    $archivo["tipo"]=1;
	    $archivo["etiqueta"]=$_POST["etiqueta"];
	    $archivo["orden"]=($ordenMax["MAX(orden)"]+1);
		$archivo["mmdd_archivo_filename"]=$caratula["name"];
		$archivo["mmdd_archivo_filetype"]=$caratula["type"];
		$archivo["mmdd_archivo_filesize"]=$caratula["size"];
	    
		
		$tamanos = getimagesize($caratula["tmp_name"]);
		
		
        if($archivo["mmdd_archivo_filesize"]<8000000&&$tamanos[0]<103000&&$tamanos[1]<80000){
		
		if($archivo["mmdd_archivo_filetype"]=="image/png"||$archivo["mmdd_archivo_filetype"]=="image/jpeg"||$archivo["mmdd_archivo_filetype"]=="image/jpg"||$archivo["mmdd_archivo_filetype"]=="image/gif"){
		
			  $archivo["id"]=$db->sql_insert("archivos_obras_".$_POST["area"], $archivo);
			   $path= "home/redlat/public_hml/circulart/tmp/".$archivo["id"]."_".$_POST["area"]."_a_".$caratula["name"];		
				 if(copy($caratula['tmp_name'], $path))
				  { 
				   
					?>
<script>
					  //window.parent.refrescar()
					</script>
					 <div align="center">. </div>
	
					<?php
				  }else{
						?>
						<div align="center">
                      .
                        </div>
						<?php
				  }
		}   } 
	}
}}}
?>
<form action="cargaImagen.php?item=<?php echo $_GET["item"];?>&area=<?php echo $_GET["area"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["item"];?>" name="obra" id="obra"/>
<input type="hidden" value="<?php echo $_GET["area"];?>" name="area" id="area"/>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2" ><strong>Recuerde que las imagenes deben ser inferiores de 5 Megas de peso, sus dimensiones  [600X400] y el formato [jpg, gif o png].</strong></td>
    </tr>
  <tr>
    <td width="32%" ><strong>Etiqueta:</strong></td>
    <td width="68%"><input name="etiqueta" type="text" id="etiqueta" size="65" /></td>
  </tr>
  <tr>
    <td class="colorTexto"><strong>Imagen:</strong></td>
    <td>
      <input name="caratula" type="file" id="caratula" size="40" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="enviar" id="Submit" value="Enviar" /></td>
  </tr>
</table>

</form>

<?php 
$area=$_GET["area"];
$obras = $db->sql_query("SELECT * FROM archivos_obras_".$area." WHERE id_obras_".$area."='".$_GET["item"]."' AND tipo='1'");
	while($datos_obras=$db->sql_fetchrow($obras)){
		
?>
<hr />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?></b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="eliminarItemsImagen.php?item=<?php echo $datos_obras["id"]?>&item2=<?php echo $_GET["item"]?>" class="link">Eliminar</a></td>
  </tr>
  <tr>
    <td><img src="http://redlat.org/circulart/phpThumb/phpThumb.php?src=/home/redlat/www/circulart/tmp/<?=$datos_obras["id"]?>_<?=$area?>_a_<?=$datos_obras["mmdd_archivo_filename"]?>&amp;w=200" border="0"></td>
  </tr>
</table>
<?php
}
?>
</body>
</html>