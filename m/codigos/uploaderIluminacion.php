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
	 window.location="subirIluninacion.php?area=<?php echo $_POST["area"]?>&item=<?php echo $_POST["id_grupos_".$_POST["area"]]?>&id_obra=<?php echo $_POST["id_obra"]?>";
	 }
</script>

<?php
include("../application2.php");
GLOBAL $CFG, $ME, $db;
$val=$_FILES['ufile'];
if($val["name"]!="")
{

	if(preg_match("/php$/i",$val["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
		$frm["id"]=$_POST["id_grupos_".$_POST["area"]];
		$frm["area"]=$_POST["area"]; 
		$id_obra=$_POST["id_obra"];
		$str=file_get_contents($val["tmp_name"]);
		$str=base64_encode($str);
		$archivo=array();
		$archivo["plano_luces"]=$str;
		$archivo["mmdd_plano_luces_filename"]=$val["name"];
		$archivo["mmdd_plano_luces_filetype"]=$val["type"];
		$archivo["mmdd_plano_luces_filesize"]=$val["size"];
		
		if($archivo["mmdd_plano_luces_filetype"]=="application/pdf"){
		
				$db->sql_query("UPDATE obras_" . $frm["area"]." SET plano_luces='".$archivo["plano_luces"]."', mmdd_plano_luces_filename='".$archivo["mmdd_plano_luces_filename"]."', mmdd_plano_luces_filetype='".$archivo["mmdd_plano_luces_filetype"]."',mmdd_plano_luces_filesize='".$archivo["mmdd_plano_luces_filesize"]."' WHERE id='".$id_obra."'");

				echo "<script>";
				echo "alerta()";
				echo "</script>";
				?>
                <div align="center">La imagen subio correctamente </div>
				<?php	
		 
	}else{
		?>
                    <div align="center">Error al subir el archivo, recuerde que este debe ser inferior de 5M de peso y el formato [pdf]. Intentar de nuevo, haciendo clic <a href="subirIluninacion2.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>&id_obra=<?php echo $_POST["id_obra"]?>">aqu&iacute;</a>. </div>
                    <?php
	}

	
	}

}else{

?>
<div align="center">
Error no hay archivo para subir. Ingrese el archivo clic <a href="subirIluninacion2.php?area=<?php echo $frm["area"]?>&amp;id_grupo=<?php echo $frm["id"]?>&id_obra=<?php echo $_POST["id_obra"]?>">aqu&iacute;</a>. 
</div>

<?php }?>