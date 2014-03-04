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
</style>
<?php

include("../application.php");
GLOBAL $CFG, $ME, $db;
$val=$_FILES['ufile'];
if($val["name"]!="")
{

	if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
		echo $frm["id"]=$_POST["id_empresa"];
		
		$imagen=array();
		$imagen["id"]=$frm["id"];
		$imagen["imagen"]=1;
		$imagen["mmdd_imagen_filename"]=$val["name"];
		$imagen["mmdd_imagen_filetype"]=$val["type"];
		$imagen["mmdd_imagen_filesize"]=$val["size"];
	
	    $tamanos = getimagesize($val["tmp_name"]);

		if($imagen["mmdd_imagen_filesize"]<9000000&&$tamanos[0]<26000000&&$tamanos[1]<26000000){
		
		if($imagen["mmdd_imagen_filetype"]=="image/png"||$imagen["mmdd_imagen_filetype"]=="image/jpeg"||$imagen["mmdd_imagen_filetype"]=="image/jpg"||$imagen["mmdd_imagen_filetype"]=="image/gif"){
		
			    $path= "/home/redlat/public_html/circulart/files/empresas/imagen/".$imagen["id"];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				
				$db->sql_query("UPDATE empresas SET imagen='".$imagen["imagen"]."', mmdd_imagen_filename='".$imagen["mmdd_imagen_filename"]."', mmdd_imagen_filetype='".$imagen["mmdd_imagen_filetype"]."',mmdd_imagen_filesize='".$imagen["mmdd_imagen_filesize"]."' WHERE id='".$frm["id"]."'");
				?>
                <div align="center">La imagen subio correctamente <br />
                <strong>- The image up properly </strong></div>
				<script> 	
				window.location="imagenLogo.php?item=<?php echo $_POST["id_empresa"]; ?>";
				</script>
               
				<?php
				}else{
					?>
                    <div align="center">Error al subir la imagen, recuerde que este debe ser inferior de 5 Megabyte de peso y de dimensi&oacute;n maxima [1024X768]. Intentar de nuevo, haciendo clic <a href="subirIempresa.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_empresar=<?php echo $_POST["id_empresa"]; ?>">aqu&iacute;</a>.<br />
                    <strong>- Failed to upload the image, remember that this should be less of 5 Megabyte maximum weight and dimension [1024X768]. Try again by clicking</strong><em><strong> <a href="subirIempresa.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_empresar=<?php echo $_POST["id_empresa"]; ?>">here</a>. </strong></em></div>

                    <?php
				}
		      
		  }else{
		?>
                    <div align="center">Error al subir la imagen, recuerde que este debe ser inferior de 5 Megabyte de peso y de dimensi&oacute;n maxima [1024X768]. Intentar de nuevo, haciendo clic<strong>- - Failed to upload the image, remember that this should be less of 5 Megabyte maximum weight and dimension [1024X768]. Try again by clicking </strong><em><strong><a href="subirIempresa.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_empresar=<?php echo $_POST["id_empresa"]; ?>">here</a>. </strong></em>                    </div>

                    <?php
	}
	
}else{
		?>
                    <div align="center">Error al subir la imagen, recuerde que este debe ser inferior de 5 Megabyte de peso y de dimensi&oacute;n maxima [1024X768]. Intentar de nuevo, haciendo clic<strong>- - Failed to upload the image, remember that this should be less of 5 Megabyte maximum weight and dimension [1024X768]. Try again by clicking </strong><em><strong><a href="subirIempresa.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_empresar=<?php echo $_POST["id_empresa"]; ?>">here</a>. </strong></em></div>

                    <?php
	}
	
	}

}else{

?>
<div align="center">Error no hay imagen para subir. Ingrese el imagen clic <a href="subirIempresa.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_empresar=<?php echo $_POST["id_empresa"]; ?>">aqu&iacute;</a>. <br />
  <strong>Error no image. Enter the image</strong>,, <a href="subirIempresa.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_empresar=<?php echo $_POST["id_empresa"]; ?>">here</a>. <br />
</div>

<?php }?>