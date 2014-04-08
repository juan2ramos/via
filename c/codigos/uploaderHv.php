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
	
		$frm["id"]=$_POST["id_programador"];
		$id_archivo=$arch_obra=$db->sql_row("SELECT mmdd_hv_filename FROM promotores WHERE id='".$frm["id"]."'");
		
		$archivo=array();
		$archivo["id"]=$frm["id"];
		$archivo["hv"]=1;
		$archivo["mmdd_hv_filename"]=$val["name"];
		$archivo["mmdd_hv_filetype"]=$val["type"];
		$archivo["mmdd_hv_filesize"]=$val["size"];

		if($archivo["mmdd_hv_filesize"]<5000000){
		
		if($archivo["mmdd_hv_filetype"]=="application/pdf"){
		
			   $path= "/home/redlat/public_html/circulart/files/promotores/hv/".$archivo["id"];
			 
			   if(copy($val['tmp_name'], $path))
				{ 
				 $db->sql_query("UPDATE promotores SET hv='".$archivo["hv"]."', mmdd_hv_filename='".$archivo["mmdd_hv_filename"]."', mmdd_hv_filetype='".$archivo["mmdd_hv_filetype"]."',mmdd_hv_filesize='".$archivo["mmdd_hv_filesize"]."' WHERE id='".$archivo["id"]."'");
				?>
				<script>
				 window.location="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>";
				</script>
                <div align="center">El documento subió correctamente - <strong>The file uploaded correctly</strong></div>
				<?php
				}else{
					?>
                    <div align="center">
                      <p>Error al subir el archivo, verifique que este debe ser inferior de 5 Megas de peso y en formato PDF. Intentar de nuevo, haciendo clic <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                      <strong><em>Failed to upload file, verify that the file must be less than 5 megabytes and in PDF format. To try again, <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">click here</a>.</strong></p>
                    </div>

                    <?php
				}
		     
		  }else{
		?>
                <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5 Megas de peso y de formato [PDF]. Intentar de nuevo, haciendo clic <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                <strong><em>Failed to upload file, remember that the file is 5 megabyte and of format PDF. Try Again, <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">click here</a>.</strong></div>

                    <?php
	}
	
}else{
		?>
                    <div align="center"><p>Error al subir el archivo, verifique que este debe ser inferior de 5 Megas de peso y en formato PDF. Intentar de nuevo, haciendo clic <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                      <strong><em>Failed to upload file, verify that the file must be less than 5 megabytes and in PDF format. To try again, <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">click here</a>.</strong></p></div>

                    <?php
	}
	
	}

}else{

?>
<div align="center"><p>Error al subir el archivo, verifique que este debe ser inferior de 5 Megas de peso y en formato PDF. Intentar de nuevo, haciendo clic <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">aqu&iacute;</a>.<br />
                      <strong><em>Failed to upload file, verify that the file must be less than 5 megabytes and in PDF format. To try again, <a href="subirHv.php?item=<?php echo $_POST["id_programador"]; ?>">click here</a>.</strong></p></div>

<?php }?>