
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

<?php
			$pdf=$db->sql_row("SELECT * FROM obras_".$_GET["area"]." WHERE id='".$_GET["id_obra"]."' and id_grupos_".$_GET["area"]."='".$_GET["item"]."'");
			
			 if($pdf["plano_luces"]==""){
			 ?>
<table width="200px" border="0" cellpadding="0" cellspacing="1" >

<tr>
<form action="uploaderIluminacion.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table border="0" cellpadding="3" cellspacing="1" align="center">
<tr>
  <td><div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div>    <div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div>
    <input type="hidden" name="id_grupos_<?=$_GET["area"]?>" value="<?=$_GET["item"]?>" />
    <input type="hidden" name="id_obra" value="<?=$_GET["id_obra"]?>" />
    <input type="hidden" name="area" value="<?=$_GET["area"]?>" />
    Archivo m&aacute;ximo 5 Megas (PDF)<em><strong> - </strong></em><strong>Maximum file 5 megabyte</strong></td>
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
<a href="http://redlat.org/circulart/admin/file.php?table=obras_<?=$_GET["area"]?>&field=plano_luces&id=<?=$_GET["id_obra"];?>" target="_blank">Ver archivo</a>
<br><br>
<a href="subirIluninacion2.php?area=<?php echo $_GET["area"]?>&item=<?php echo $_GET["item"]?>&id_obra=<?php echo $_GET["id_obra"]?>">
Actualizar archivo</a>
<?
}
?>
</body>