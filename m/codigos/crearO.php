<style>
body{
	margin:0;
	background:#E7D8B1;
	color: #3D1211;}
	#carga{
		display:none;}
</style>

<?php
include("../application.php");
GLOBAL $CFG, $ME, $db;
/********* codigo para insertar la acaratula *********/
$frm["id"]=$_POST["id_obra"];
$caratula=$_FILES['caratula'];
$caratula["name"];

if($caratula["name"]!=""){
	
	if(preg_match("/php$/i",$caratula["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
	    $id_archivo=$arch_obra=$db->sql_row("SELECT id FROM archivos_obras_musica WHERE id_obras_musica='".$frm["id"]."' AND etiqueta='caratula'");
	
	    $archivo=array();
		$archivo["id_obras_musica"]=$frm["id"];
		$archivo["id"]=$id_archivo["id"];
		$archivo["caratula"]=1;
		$str=file_get_contents($caratula["tmp_name"]);
		$str=base64_encode($str);
		$archivo["archivo"]=$str;
		$archivo["etiqueta"]="Caratula";
		$archivo["mmdd_archivo_filename"]=$caratula["name"];
		$archivo["mmdd_archivo_filetype"]=$caratula["type"];
		$archivo["mmdd_archivo_filesize"]=$caratula["size"];
		$archivo["orden"]="0";
		$archivo["tipo"]="1";
		
		$tamanos = getimagesize($val["tmp_name"]);
		
        if($archivo["mmdd_archivo_filesize"]<2000000&&$tamanos[0]<700&&$tamanos[1]<500){
		
		if($archivo["mmdd_archivo_filetype"]=="image/png"||$archivo["mmdd_archivo_filetype"]=="image/jpeg"||$archivo["mmdd_archivo_filetype"]=="image/jpg"||$archivo["mmdd_archivo_filetype"]=="image/gif"){
		
		//si el archivo no esta creado
		 if($id_archivo["id"]==""){
			$archivo["id"]=$db->sql_insert("archivos_obras_musica", $archivo);
			$path= "../../../tmp/".$archivo["id"]."_musica_a_".$caratula["name"];		
				 if(copy($caratula['tmp_name'], $path))
				  { 
				   
					?>
					<script>
					  //window.parent.refrescar()
					</script>
					 <div align="center"></div>
	
					<?php
				  }else{
						?>
						<div align="center"></div>
						<?php
				  }
		 }else{
			  $path= "../../../tmp/".$archivo["id"]."_musica_a_".$caratula["name"];	
			 
			   if(copy($caratula['tmp_name'], $path))
				{ // si el archivo esta creado
				?>
				<script>
				// window.parent.refrescar()
				</script>
                <div align="center"></div>
				<?php
				}else{
					?>
                    <div align="center"></div>

                    <?php
				}
		      $db->sql_query("UPDATE archivos_obras_musica SET archivo='".$archivo["archivo"]."', mmdd_archivo_filename='".$archivo["mmdd_archivo_filename"]."', mmdd_archivo_filetype='".$archivo["mmdd_archivo_filetype"]."',mmdd_archivo_filesize='".$archivo["mmdd_archivo_filesize"]."' WHERE id='".$archivo["id"]."'");
		  }
		  
		
	}else{
		?>
                    <div align="center"></div>

                    <?php
	}
}else{
		?>
                    <div align="center"></div>

                    <?php
	}
	
	}

}else{

?>
<div align="center"></div>
<?php
}

 $db->sql_query("UPDATE obras_musica SET id_generos_musica='".$_POST["id_generos_musica"]."' WHERE id='".$_POST["id_obra"]."'");
 $db->sql_query("UPDATE obras_musica SET produccion='".$_POST["obra"]."' WHERE id='".$_POST["id_obra"]."'");
 $db->sql_query("UPDATE obras_musica SET anio='".$_POST["anio"]."' WHERE id='".$_POST["id_obra"]."'");
 $db->sql_query("UPDATE obras_musica SET resena='".$_POST["resena"]."' WHERE id='".$_POST["id_obra"]."'");
 $db->sql_query("UPDATE obras_musica SET sello_disquero='".$_POST["sello_disquero"]."' WHERE id='".$_POST["id_obra"]."'");

?>

<script>
 window.parent.refrescar();
 window.frameElement.ownerDocument.parentWindow.refrescar();
 window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_3muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
</script>