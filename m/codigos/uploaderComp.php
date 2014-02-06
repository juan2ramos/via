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
<?php
include("../application.php");
GLOBAL $CFG, $ME, $db;
$val=$_FILES['ufile'];
if($val["name"]!="")
{

	if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
		$frm["id"]=$_POST["id_programador"];
		
		$imagen=array();
		$imagen["id"]=$frm["id"];
		$imagen["imagen"]=1;
		$imagen["mmdd_imagen_filename"]=$val["name"];
		$imagen["mmdd_imagen_filetype"]=$val["type"];
		$imagen["mmdd_imagen_filesize"]=$val["size"];
	
	    $tamanos = getimagesize($val["tmp_name"]);

		if($imagen["mmdd_imagen_filesize"]<9000000&&$tamanos[0]<26000000&&$tamanos[1]<26000000){
		
		if($imagen["mmdd_imagen_filetype"]=="image/png"||$imagen["mmdd_imagen_filetype"]=="image/jpeg"||$imagen["mmdd_imagen_filetype"]=="image/jpg"||$imagen["mmdd_imagen_filetype"]=="image/gif"){
		
			    //$path= "/home/redlat/public_html/circulart/files/promotores/imagen/".$imagen["id"];
			 
			 
			 $ftp_server="redlat.org";
			 $conn_id = ftp_connect($ftp_server);
			 $login_result = ftp_login($conn_id, 'redlat', '}wQ,g*DJyV}~');
			 $path="/public_html/circulart/files/promotores/imagen/".$imagen["id"];
			 
			    $local = $imagen["mmdd_imagen_filename"];
				// Este es el nombre temporal del archivo mientras dura la transmisión
				$remoto = $imagen["id"];
				// El tamaño del archivo
				$tama = $imagen["mmdd_imagen_filesize"];
				
			if (ftp_put($conn_id, $path,$remoto, FTP_ASCII)) {
			 echo "se ha cargado $file con éxito\n";
			 $db->sql_query("UPDATE promotores SET imagen='".$imagen["imagen"]."', mmdd_imagen_filename='".$imagen["mmdd_imagen_filename"]."', mmdd_imagen_filetype='".$imagen["mmdd_imagen_filetype"]."',mmdd_imagen_filesize='".$imagen["mmdd_imagen_filesize"]."' WHERE id='".$imagen["id"]."'");
			} else {
			 echo "Hubo un problema durante la transferencia de $file\n";
			}
			
			ftp_close($conn_id);
			 
			 
	}}}}
			 
			  /* if(copy($val['tmp_name'], $path))
				{ 
				
				$db->sql_query("UPDATE promotores SET imagen='".$imagen["imagen"]."', mmdd_imagen_filename='".$imagen["mmdd_imagen_filename"]."', mmdd_imagen_filetype='".$imagen["mmdd_imagen_filetype"]."',mmdd_imagen_filesize='".$imagen["mmdd_imagen_filesize"]."' WHERE id='".$imagen["id"]."'");
				?>
                <div align="center">La imagen subio correctamente <br />
                <strong>- The image up properly                </strong></div>
				<script> 	
				window.location="imagen.php?item=<?php echo $_POST["id_programador"]; ?>";
				</script>
               
				<?php
				}else{
					?>
                    <div align="center">Error al subir la imagen, recuerde que este debe ser inferior de 5 Megabyte de peso y de dimensi&oacute;n maxima [1024X768]. Intentar de nuevo, haciendo clic <a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                    <strong>- Failed to upload the image, remember that this should be less of 5 Megabyte maximum weight and dimension [1024X768]. Try again by clicking </strong><em><strong><a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">here</a>. </strong></em></div>

                    <?php
				}
		      
		  }else{
		?>
                    <div align="center">Error al subir la imagen, recuerde que este debe ser inferior de 5 Megabyte de peso y de dimensi&oacute;n maxima [1024X768]. Intentar de nuevo, haciendo clic <a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                    <strong>- Failed to upload the image, remember that this should be less of 5 Megabyte maximum weight and dimension [1024X768]. Try again by clicking </strong><em><strong><a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">here</a>. </strong></em> </div>

                    <?php
	}
	
}else{
		?>
                    <div align="center">Error al subir la imagen, recuerde que este debe ser inferior de 5 Megabyte de peso y de dimensi&oacute;n maxima [1024X768]. Intentar de nuevo, haciendo clic <a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                    <strong>- Failed to upload the image, remember that this should be less of 5 Megabyte maximum weight and dimension [1024X768]. Try again by clicking </strong><em><strong><a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">here</a>. </strong></em> </div>

                    <?php
	}
	
	}

}else{

?>
<div align="center">
Error no hay imagen para subir. Ingrese el imagen clic <a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>. <br />
<strong>Error no image. Enter the image</strong>, <a href="subirICompadores.php?modo=<?php echo $_POST["modo"]; ?>&amp;mode=paso_2muestra&amp;id_programador=<?php echo $_POST["id_programador"]; ?>">here</a>. <br />
</div>

<?php }?>*/