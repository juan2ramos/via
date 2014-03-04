
<?php
$desactivaSession=1;
include("../application.php");
GLOBAL $CFG, $ME, $db;
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:0;
	background:#E7D8B1;
	color: #3D1211;}
	#carga{
		display:none;}
</style>
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#submit1').click(function(){
			$('#carga').show();
			})
	})		
</script>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" >

<tr>
<form action="uploaderF.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table border="0" cellpadding="3" cellspacing="1" align="center">
<tr>
  <td><br></td>
</tr>
<tr>
  <td><div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div></td>
</tr>
<tr>
<td class="colorTexto">Recuerde que el archivo debe ser inferior de 5 Megas de peso y de formato [PDF]</td>
</tr>
<tr>
  <td><div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div></td>
</tr>
<tr>
<td><input type="hidden" name="modo" value="<?=$_GET["modo"]?>" />
<input type="hidden" name="mode" value="paso_2muestra">
<input type="hidden" name="id_grupo" value="<?=$_GET["id_grupo"];?>">
<input type="hidden" name="id_usuario" value="<?=$_GET["id_usuario"]?>">
<input type="hidden" name="area" value="<?=$_GET["area"]?>">
<input type="hidden" name="a" value="<?=$_GET["a"]?>">
<input name="ufile" type="file" id="ufile" size="40" value="Seleccionar"/></td>
</tr>
<tr>
<td align="center" id="submit1"><input  type="submit" name="Submit" value="Upload" /></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
</body>