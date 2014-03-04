<?php 
include("../application2.php");
GLOBAL $CFG, $ME, $db;
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
body{
	background-color:#E7D8B1;
	color:#3D1211;}
table{
	font-size:13px;}
		#carga{
		display:none;}
</style>
<script type="text/javascript" src="http://2013.circulart.org/m/js/lib/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#enviar').click(function(){
			$('#carga').show();
			})
	})		
</script>
<body>
<?php 
$obras = $db->sql_query("SELECT * FROM tracklist where id_obras_musica ='".$_GET["item"]."'");
	while($datos_obras=$db->sql_fetchrow($obras)){
?>
<table width="100%" border="0" cellspacing="5" cellpadding="5" >
  <tr>
    <td  class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?></b></td>
  </tr>
  <tr>
    <td>
      <?php 
	$grupo_id2=$db->sql_row("SELECT * FROM obras_musica where id='".$_GET["item"]."'");
	?>
      <script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>
      <object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer<?php echo $datos_obras["id"]?>" height="24" width="290">
        <param name="movie" value="http://circulart.org/audio_base/player.swf">
        <param name="FlashVars" value="playerID=<?php echo $datos_obras["id"]?>&amp;soundFile=http://circulart.org/musica/audio/<?php echo $grupo_id2["id_grupos_musica"];?>/obras/<?php echo $datos_obras["id"]?>/<?php echo $datos_obras["mmdd_archivo_filename"]?>">
        <param name="quality" value="high">
        <param name="menu" value="false">
        <param name="wmode" value="transparent">
      </object>
</td>
  </tr>
</table>
<br>
<br>

<?php
}
?>
</body>
</html>