<?php
include("../application2.php");
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
#form1 td table tr .colorTexto {
	text-align: left;
}
</style>
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>
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
<form action="uploaderFoto1.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<?php 

        /*$id_archivo=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_musica='".$frm['id_grupo']."' ORDER BY id");
		$p1=$db->sql_fetchrow($id_archivo);*/

?>
<table width="430" border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
<td width="126" class="colorTexto">Nombre:</td>
<td width="726"><input name="nombre" type="text" id="nombre" size="40" value="" /></td>
</tr>
<tr>
  <td class="colorTexto">No. de documento:</td>
  <td><input name="documento" type="text" id="documento" size="40" value="" /></td>
</tr>
<tr>
  <td class="colorTexto">Foto:</td>
  <td class="colorTexto">Recuerde que el archivo debe ser inferior de 5 Megas de peso, sus dimensiones  [200X200] y el formato [jpg, gif o png]</td>
</tr>
<tr>
  <td colspan="2"><div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="modo" value="<?=$_GET["modo"]?>" />
<input type="hidden" name="mode" value="paso_2muestra">
<input type="hidden" name="id_grupo" value="<?=$_GET["id_grupo"];?>">
<input type="hidden" name="id_usuario" value="<?=$_GET["id_usuario"]?>">
<input type="hidden" name="area" value="<?=$_GET["area"]?>">
<input type="hidden" name="a" value="<?=$_GET["a"]?>">
<input name="ufile" type="file" id="ufile" size="10" value="Seleccionar"/></td>
</tr>
<tr>
<td colspan="2" align="center" id="submit1"><input  type="submit" name="Submit" value="Upload" /></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
</body>