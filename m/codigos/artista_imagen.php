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
<?php 
         $frm["id_grupo"]=$_GET["item"];
		 $frm["area"]=$_GET["area"];
	     $caratula=$db->sql_row("SELECT * FROM archivos_grupos_".$frm["area"]." WHERE id_grupos_".$frm["area"]."='".$frm["id_grupo"]."' AND orden='0'");

		 if($caratula["archivo"]!=""){
			 ?>
<br>
<img src="http://redlat.org/circulart/admin/imagen.php?table=archivos_grupos_<?=$frm["area"]?>&amp;field=archivo&amp;id=<?php echo $caratula["id"];?>" width="250"  />      
                  <?php } else
			  {  
			  ?>
              Archivo no mayor a 5 Megas y 1024X768 de tama&ntilde;o<br>
            <img src="../images/mercados/imagen.jpg" width="250" />
            <?php } ?>
                  <br>
                  <a href="artista_Up_imagen.php?id_grupo=<?=$frm["id_grupo"]?>&area=<?=$frm["area"]?>">Subir imagen del grupo o artista</a><br />
</body>
