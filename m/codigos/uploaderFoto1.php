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

include("../application.php");
GLOBAL $CFG, $ME, $db;
$val=$_FILES['ufile'];
if($val["name"]!="")
{

	if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
		$frm["id"]=$_POST["id_grupo"];
		$frm["nombre"]=$_POST["nombre"];
		$frm["documento"]=$_POST["documento"];
		
		$frm["area"]="musica"; 
		$id_archivo=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_musica='".$frm['id_grupo']."' AND documento='".$frm["documento"]."'");
		$p1=$db->sql_fetchrow($id_archivo);
		
		$archivo=array();
		$archivo["id_grupo_" . $frm["area"]]=$frm["id"];
		$archivo["foto"]=1;
		$archivo["nombre"]=$frm["nombre"];
		$archivo["documento"]=$frm["documento"];
		$archivo["mmdd_foto_filename"]=$val["name"];
		$archivo["mmdd_foto_filetype"]=$val["type"];
		$archivo["mmdd_foto_filesize"]=$val["size"];
		
        $tamanos = getimagesize($val["tmp_name"]);
		
		if($archivo["mmdd_foto_filesize"]<5000000&&$tamanos[0]<103500&&$tamanos[1]<80500){
		
		if($archivo["mmdd_foto_filetype"]=="image/png"||$archivo["mmdd_foto_filetype"]=="image/jpeg"||$archivo["mmdd_foto_filetype"]=="image/jpg"||$archivo["mmdd_foto_filetype"]=="image/gif"){
		
		  if($p1["id"]==""){
			 $archivo["id"]=$db->sql_insert("vinculados", $archivo);
			 $path= "../../../files/vinculados/foto/".$archivo["id"];
				 if(copy($val['tmp_name'], $path))
				  { 
				   
					?>
					<script>
					  window.parent.refrescar();
				 window.frameElement.ownerDocument.parentWindow.refrescar();
				 window.parent.location="<?php echo $CFG->dirwww;?>/m/index.php?modo=inscripciones&mode=paso_2muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
					</script>
					 <div align="center">
	La imagen subio correctamente </div>
	
					<?php
				  }else{
						?>
						<div align="center">
	Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirFoto1.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>
						<?php
				  }
		   }else{
			  $path= "../../../files/vinculados/foto/".$archivo["id"];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				?>
				<script>
				 window.parent.refrescar();
				 window.frameElement.ownerDocument.parentWindow.refrescar();
				 window.parent.location="<?php echo $CFG->dirwww;?>/m/index.php?modo=inscripciones&mode=paso_5 Megasuestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
				</script>
                <div align="center">
La imagen subio correctamente </div>
				<?php
				}else{
					?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirFoto1.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
				}
		      $db->sql_query("UPDATE vinculados SET nombre='".$archivo["nombre"]."', documento='".$archivo["documento"]."', foto='".$archivo["foto"]."', mmdd_foto_filename='".$archivo["mmdd_foto_filename"]."', mmdd_foto_filetype='".$archivo["mmdd_foto_filetype"]."',mmdd_foto_filesize='".$archivo["mmdd_foto_filesize"]."' WHERE id='".$p1["id"]."'");
		  }
		  
		
	}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirFoto1.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
	}
}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]. Intentar de nuevo, haciendo clic <a href="subirFoto1.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
	}
	
	}

}else{

?>
<div align="center">
Error no hay archivo para subir. Ingrese el archivo clic <a href="subirFoto1.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. 
</div>

<?php }?>