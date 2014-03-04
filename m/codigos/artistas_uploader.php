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
<script>
function alerta(){
	 window.location="artista_imagen.php?area=<?php echo $_POST["area"]?>&item=<?php echo $_POST["id_grupo"]?>";
	 }
</script>

<?php
include("../application2.php");
GLOBAL $CFG, $ME, $db;
$val=$_FILES['ufile'];
if($val["name"]!="")
{

	if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
		$frm["id"]=$_POST["id_grupo"];
		$frm["area"]=$_POST["area"]; 
		$id_archivo=$arch_obra=$db->sql_row("SELECT id FROM archivos_grupos_" . $frm["area"] . " WHERE id_grupos_" . $frm["area"] . "='".$frm["id"]."' AND orden='0'");
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
		
		if($archivo["mmdd_archivo_filesize"]<2000000&&$tamanos[0]<2048&&$tamanos[1]<1846){
		
		if($archivo["mmdd_archivo_filetype"]=="image/png"||$archivo["mmdd_archivo_filetype"]=="image/jpeg"||$archivo["mmdd_archivo_filetype"]=="image/jpg"||$archivo["mmdd_archivo_filetype"]=="image/gif"){
		
		  if($id_archivo==""){
			 
			 $path= "/home/redlat/public_html/circulart/tmp/".$archivo["id"]."_musica_a_".$_FILES['ufile']['name'];		
				 if(copy($val['tmp_name'], $path))
				  { 
				  $archivo["id"]=$db->sql_insert("archivos_grupos_" . $frm["area"], $archivo);
				echo "<script>";
				echo "alerta()";
				echo "</script>";
					?>
					 <div align="center">
	La imagen subio correctamente </div>
	
					<?php
				  }else{
						?>
						<div align="center">
	Error al subir el archivo, recuerde que este debe ser inferior de 5M de peso, sus dimensiones [1024X768] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="artista_Up_imagen.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>">aqu&iacute;</a>. </div>
						<?php
				  }
		   }else{
			   $path= "/home/redlat/public_html/circulart/tmp/".$id_archivo["id"]."_musica_a_".$_FILES['ufile']['name'];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				echo "<script>";
				echo "alerta()";
				echo "</script>";
				
				$db->sql_query("UPDATE archivos_grupos_". $frm["area"] ." SET id_grupos_". $frm["area"] ."='".$frm["id"]."', archivo='".$archivo["archivo"]."', mmdd_archivo_filename='".$archivo["mmdd_archivo_filename"]."', mmdd_archivo_filetype='".$archivo["mmdd_archivo_filetype"]."',mmdd_archivo_filesize='".$archivo["mmdd_archivo_filesize"]."' WHERE id='".$id_archivo["id"]."'");
				
				
				
				?>
                <div align="center">La imagen subio correctamente </div>
				<?php
				}else{
					?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de inferior de 5M de peso, sus dimensiones [1024X768] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="artista_Up_imagen.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>">aqu&iacute;</a>. </div>
                    <?php
				}
		      
		  }
		  
		
	}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de inferior de 5M de peso, sus dimensiones [1024X768] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="artista_Up_imagen.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>">aqu&iacute;</a>. </div>
                    <?php
	}
}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de inferior de 5M de peso, sus dimensiones [1024X768] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="artista_Up_imagen.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>">aqu&iacute;</a>. </div>

                    <?php
	}
	
	}

}else{

?>
<div align="center">
Error no hay archivo para subir. Ingrese el archivo clic <a href="artista_Up_imagen.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>">aqu&iacute;</a>. 
</div>

<?php }?>