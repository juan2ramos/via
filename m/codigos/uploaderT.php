<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:10% 15px 0 15px;
	background:#E7D8B1;
	font-size:13px;
	color: #3D1211;
	}
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
		$frm["area"]="musica"; 
		$id_archivo=$arch_obra=$db->sql_row("SELECT mmdd_trayectoria_filename FROM grupos_" . $frm["area"] . " WHERE id='".$frm["id"]."'");
		
		$archivo=array();
		$archivo["id"]=$frm["id"];
		$archivo["trayectoria"]=1;
		$archivo["mmdd_trayectoria_filename"]=$val["name"];
		$archivo["mmdd_trayectoria_filetype"]=$val["type"];
		$archivo["mmdd_trayectoria_filesize"]=$val["size"];

		if($archivo["mmdd_trayectoria_filesize"]<5000000){
		
		if($archivo["mmdd_trayectoria_filetype"]=="application/pdf"){
		
			   $path= "../../../files/grupos_musica/trayectoria/".$archivo["id"];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				?>
				<script>
				window.parent.refrescar();
				window.frameElement.ownerDocument.parentWindow.refrescar();
				window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_2muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
				</script>
                <div align="center">El documento subio correctamente </div>
				<?php
				}else{
					?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso y de formato [PDF]. Intentar de nuevo, haciendo clic <a href="subirTrayectoria.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a>. </div>

                    <?php
				}
		      $db->sql_query("UPDATE grupos_musica SET id='".$frm["id"]."', trayectoria='".$archivo["trayectoria"]."', mmdd_trayectoria_filename='".$archivo["mmdd_trayectoria_filename"]."', mmdd_trayectoria_filetype='".$archivo["mmdd_trayectoria_filetype"]."',mmdd_trayectoria_filesize='".$archivo["mmdd_trayectoria_filesize"]."' WHERE id='".$archivo["id"]."'");
		  }else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso y de formato [PDF]. Intentar de nuevo, haciendo clic <a href="subirRut.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a> </div>

                    <?php
	}
	
}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso y de formato [PDF]. Intentar de nuevo, haciendo clic <a href="subirTrayectoria.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>">aqu&iacute;</a> </div>

                    <?php
	}
	
	}

}else{

?>
<div align="center">
Error no hay archivo para subir. Ingrese el archivo clic <a href="subirTrayectoria.php?modo=<?php echo $_POST["mode"]; ?>&amp;mode=paso_2muestra&amp;id_usuario=<?php echo $_POST["id_usuario"]; ?>&amp;area=<?php echo $_POST["area"]?>&amp;id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php $_GET["a"]?>">aqu&iacute;</a>. </div>

<?php }?>