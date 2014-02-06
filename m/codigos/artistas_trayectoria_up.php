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
	
		$frm["id"]=$_POST["id_grupo"];
		$frm["area"]=$_POST["area"];
		$id_archivo=$arch_obra=$db->sql_row("SELECT mmdd_trayectoria_filename FROM grupos_".$frm["area"]." WHERE id='".$frm["id"]."'");
		
		$archivo=array();
		$archivo["id"]=$frm["id"];
		$archivo["trayectoria"]=1;
		$archivo["mmdd_trayectoria_filename"]=$val["name"];
		$archivo["mmdd_trayectoria_filetype"]=$val["type"];
		$archivo["mmdd_trayectoria_filesize"]=$val["size"];

		if($archivo["mmdd_trayectoria_filesize"]<5000000){
		if($archivo["mmdd_trayectoria_filetype"]=="application/pdf"){
			   $path= "/home/redlat/public_html/circulart/files/grupos_".$frm["area"]."/trayectoria/".$archivo["id"];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				 $db->sql_query("UPDATE grupos_".$frm["area"]." SET trayectoria='".$archivo["trayectoria"]."', mmdd_trayectoria_filename='".$archivo["mmdd_trayectoria_filename"]."', mmdd_trayectoria_filetype='".$archivo["mmdd_trayectoria_filetype"]."',mmdd_trayectoria_filesize='".$archivo["mmdd_trayectoria_filesize"]."' WHERE id='".$archivo["id"]."'");
				?>
				<script>
				 window.location="artistas_trayectoria.php?item=<?php echo $archivo["id"] ?>&area=<?php echo $frm["area"] ?>";
				</script>
                <div align="center">El documento subió correctamente - <strong>The file uploaded correctly</strong></div>
				<?php
				}else{
					?>
                    <div align="center">
                      <p>Error al subir el archivo, verifique que este debe ser inferior de 5 Megas de peso y en formato PDF. Intentar de nuevo, haciendo clic <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">aqu&iacute;</a>.<br />
                      <strong><em>Failed to upload file, verify that the file must be less than 5 megabytes and in PDF format. To try again, <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">click here</a>.</strong></p>
                    </div>

                    <?php
				}
		     
		  }else{
		?>
                <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso y de formato [PDF]. Intentar de nuevo, haciendo clic <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">aqu&iacute;</a>.<br />
                <strong><em>Failed to upload file, remember that the file is 5 megabyte and of format PDF. Try Again, <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">click here</a>.</strong></div>

                    <?php
	}
	
}else{
		?>
                    <div align="center"><p>Error al subir el archivo, verifique que este debe ser inferior de 5 Megas de peso y en formato PDF. Intentar de nuevo, haciendo clic <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">aqu&iacute;</a>.<br />
                      <strong><em>Failed to upload file, verify that the file must be less than 5 megabytes and in PDF format. To try again, <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">click here</a>.</strong></p></div>

                    <?php
	}
	
	}

}else{

?>
<div align="center"><p>Error al subir el archivo, verifique que este debe ser inferior de 5 Megas de peso y en formato PDF. Intentar de nuevo, haciendo clic <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">aqu&iacute;</a>.<br />
                      <strong><em>Failed to upload file, verify that the file must be less than 5 megabytes and in PDF format. To try again, <a href="artistas_trayectoria2.php?item=<?php echo $frm["id"] ?>&area=<?=$frm["area"]?>">click here</a>.</strong></p></div>

<?php }?>