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
<?php $frm["id_empresa"]=$_GET["item"];?>
<?php
			
			$caratula=$db->sql_row("SELECT * FROM empresas WHERE id='".$frm["id_empresa"]."'");
			
			 if($caratula["imagen"]!="" && $caratula["imagen"]!=0 ){
			 ?>
            
            <img src="http://redlat.org/circulart/phpThumb/phpThumb.php?src=/home/redlat/public_html/circulart/files/empresas/imagen/<?php echo $caratula["id"];?>" width="300" />      
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php } else
			  {  
			  ?><img src="../images/mercados/imagen.jpg" width="250" />
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php  
				  }?>
                  <a href="subirIempresa.php?mode=paso_2muestra&id_empresa=<?=$frm["id_empresa"]?>">Subir logo - <strong>Upload logo</strong></a><br />
</body>
