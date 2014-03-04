<?php

include("../application.php");
GLOBAL $CFG, $ME, $db;
?>
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
<body>
<?php $frm["id_programador"]=$_GET["item"];?>
<?php
			$caratula=$db->sql_row("SELECT * FROM promotores WHERE id='".$frm["id_programador"]."'");
			
			 if($caratula["imagen"]!=""){
			 ?>
            
            <img src="http://redlat.org/circulart/phpThumb/phpThumb.php?src=/home/redlat/public_html/circulart/files/promotores/imagen/<?=$caratula["id"];?>" width="300" />      
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php } else
			  {  
			  ?>
                  <img src="../images/mercados/imagen.jpg" width="250" />
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php  
				  }?>
                  <a href="subirICompadores.php?mode=paso_2muestra&id_programador=<?=$frm["id_programador"]?>">Subir foto - <strong>Upload photo</strong></a><br />
</body>
