
<?php
include("../application2.php");
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
	#ufile{
		background-color:#FFF;}	
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#submit1').click(function(){
			$('#carga').show();
			})
	})		
</script>
<body>
<?php  $frm["id_grupo"]=$_GET["item"];
       $frm["area"]=$_GET["area"];
	   
			 $trayectora=$db->sql_row("SELECT * FROM grupos_".$frm["area"]." WHERE id='".$frm["id_grupo"]."'");
			 if($trayectora["trayectoria"]==""){
			 ?>
<table width="200px" border="0" cellpadding="0" cellspacing="1" >

<tr>
<form action="artistas_trayectoria_up.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table border="0" cellpadding="3" cellspacing="1" align="center">
<tr>
  <td><div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div>    <div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div>
    <input type="hidden" name="id_grupo" value="<?=$_GET["item"]?>" />
    <input type="hidden" name="area" value="<?=$_GET["area"]?>" />
    Archivo m&aacute;ximo 5 Megas (PDF)</td>
</tr>
<tr>
  <td><input name="ufile" type="file" id="ufile" size="40" value="Seleccionar"/></td>
</tr>
<tr>
  <td align="center" id="submit1"><input  type="submit" name="Submit" id="Submit" value="Upload" /></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
<? 
}else{
?>
<a href="http://redlat.org/circulart/admin/fileFS.php?table=grupos_<?=$frm["area"]?>&amp;field=trayectoria&amp;id=<?=$_GET["item"];?>" target="_blank">Ver archivo - <strong>view file</strong></a>
<br><br>
<a href="artistas_trayectoria2.php?item=<?=$_GET["item"]?>&area=<?=$frm["area"]?>">
Actualizar archivo - <strong>update file</strong></a>
<?
}
?>
</body>