<?php
$desactivaSession=1;
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" >
<tr>
<form action="artistas_uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table border="0" cellpadding="3" cellspacing="1" align="center">
<tr>
  <td><br></td>
</tr>
<tr>
  <td><div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div></td>
</tr>
<tr>
<td align="center" class="colorTexto">Recuerde que el archivo debe ser inferior de
  5 Megas de peso y de formato [jpg, gif o png].</td>
</tr>
<tr>
<td align="center">
<input type="hidden" name="area" value="<?=$_GET["area"]?>" />
<input type="hidden" name="id_grupo" value="<?=$_GET["id_grupo"];?>">
<input name="ufile" type="file" id="ufile" size="10" value="Seleccionar" style="width:250px;"/>
</td>
</tr>
<tr>
<td align="center" id="submit1"><input  type="submit" name="Submit" id="Submit" value="Upload" /></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
</body>