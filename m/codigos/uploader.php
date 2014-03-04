<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:10% 15px 0 15px;
	background:#E7D8B1;
	font-size:13px;
	color: #3D1211;}
	#carga{
		display:none;}
</style>
<?php
$desactivaSession=1;
include("../application.php");
GLOBAL $CFG, $ME, $db;
$val=$_FILES['ufile'];
if($val["name"]!="")
{

	if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
		$frm["id"]=$_POST["id_grupo"];
		$frm["area"]="musica"; 
		$id_archivo=$arch_obra=$db->sql_row("SELECT id FROM archivos_grupos_" . $frm["area"] . " WHERE id_grupos_" . $frm["area"] . "='".$frm["id"]."' AND etiqueta='Imagen'");
		$str=file_get_contents($val["tmp_name"]);
		$str=base64_encode($str);
		$archivo=array();
		$archivo["id_grupos_" . $frm["area"]]=$frm["id"];
		$archivo["tipo"]=1;
		$archivo["etiqueta"]="Imagen";
		$archivo["archivo"]=$str;
		$archivo["mmdd_archivo_filename"]=$val["name"];
		$archivo["mmdd_archivo_filetype"]=$val["type"];
		$archivo["mmdd_archivo_filesize"]=$val["size"];
		$archivo["orden"]="0";
		
		$tamanos = getimagesize($val["tmp_name"]);
		
		if($archivo["mmdd_archivo_filesize"]<2000000&&$tamanos[0]<205&&$tamanos[1]<205){
		
		if($archivo["mmdd_archivo_filetype"]=="image/png"||$archivo["mmdd_archivo_filetype"]=="image/jpeg"||$archivo["mmdd_archivo_filetype"]=="image/jpg"||$archivo["mmdd_archivo_filetype"]=="image/gif"){
		
		  if($id_archivo==""){
			 $archivo["id"]=$db->sql_insert("archivos_grupos_" . $frm["area"], $archivo);
			 $path= "../../../tmp/".$archivo["id"]."_musica_a_".$_FILES['ufile']['name'];		
				 if(copy($val['tmp_name'], $path))
				  { 
				   
					?>
					<script>
					 // window.parent.refrescar()
					  
					 window.parent.refrescar();
				     window.frameElement.ownerDocument.parentWindow.refrescar();
					 window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_2muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
					</script>
					 <div align="center">
	La imagen subio correctamente </div>
	
					<?php
				  }else{
						?>
						<div align="center">
	Error al subir el archivo, recuerde que este debe ser inferior de 2M de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirImagen.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>
						<?php
				  }
		   }else{
			   $path= "../../../tmp/".$id_archivo["id"]."_musica_a_".$_FILES['ufile']['name'];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				?>
				<script>
				window.parent.refrescar();
				window.frameElement.ownerDocument.parentWindow.refrescar();
                window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_2muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
                </script>
                <div align="center">
La imagen subio correctamente </div>
				<?php
				}else{
					?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 2M de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirImagen.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
				}
		      $db->sql_query("UPDATE archivos_grupos_musica SET id_grupos_musica='".$frm["id"]."', archivo='".$archivo["archivo"]."', mmdd_archivo_filename='".$archivo["mmdd_archivo_filename"]."', mmdd_archivo_filetype='".$archivo["mmdd_archivo_filetype"]."',mmdd_archivo_filesize='".$archivo["mmdd_archivo_filesize"]."' WHERE id='".$id_archivo["id"]."'");
		  }
		  
		
	}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 2M de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirImagen.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
	}
}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 2M de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirImagen.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
	}
	
	}

}else{

?>
<div align="center">
Error no hay archivo para subir. Ingrese el archivo clic <a href="subirImagen.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. 
</div>

<?php }?>