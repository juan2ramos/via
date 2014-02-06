<table width="900" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td width="849"><br /><a href="http://2013.circulart.org/m/index.php?modo=curadores&amp;mode=listar_grupos&amp;a=1">
      Regresar al listado de grupos </a><br />
<br />
<h2>Otros Archivos</h2></td>
  </tr>
  <tr>
    <td>
    <!--- listo los archivos de audio --->
    <?php $archivos = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$_GET["id_grupo"]."' AND tipo='2'");
	while($datos_archivos=$db->sql_fetchrow($archivos)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="23%" align="center" valign="top"><?php echo $datos_archivos["etiqueta"];?></td>
            <td valign="top"> 
			<script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>
 <object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer<?php echo $datos_archivos["id"]?>" height="24" width="290">
			<param name="movie" value="http://circulart.org/audio_base/player.swf">
			<param name="FlashVars" value="playerID=<?php echo $datos_archivos["id"];?>&amp;soundFile=http://circulart.org/musica/audio/<?php echo $_GET["id_grupo"];?>/grupo/<?php echo $datos_archivos["id"];?>/<?php echo $datos_archivos["mmdd_archivo_filename"];?>">
			<param name="quality" value="high">
			<param name="menu" value="false">
			<param name="wmode" value="transparent">
			</object></td>
        </tr>
    </table>
    <?php }?>
    <!--- listo los archivos de Imagen --->
    <?php $archivosI = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$_GET["id_grupo"]."' AND tipo='1'");
	while($datos_archivosI=$db->sql_fetchrow($archivosI)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="23%" align="center" valign="top"><?php echo $datos_archivosI["etiqueta"];?></td>
            <td valign="top"> 
			<img src="http://2013.circulart.org/m/admin/imagen.php?table=archivos_grupos_musica&amp;field=archivo&amp;id=<?php echo $datos_archivosI["id"]?>" border="0" width="200">
            </td>
        </tr>
    </table>
    <?php }?>
    
    <!--- listo los archivos de Video --->
    <?php $archivosV = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$_GET["id_grupo"]."' AND tipo='3'");
	while($datos_archivosV=$db->sql_fetchrow($archivosV)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="36%" align="center" valign="top"><?php echo $datos_archivosV["etiqueta"];?></td>
            <td valign="top"> 
			<?php 
			$datos_archivosV["url"];
			$cadena = $datos_archivosV["url"];
  $buscar = "iframe";
  $resultado = strpos($cadena, $buscar);
  if($resultado !== FALSE){
	  echo $datos_archivosV["url"];
	  }else{
		  $pieces = explode("=", $cadena);
		  
		 echo "<iframe width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/".$pieces[1]."\" frameborder=\"0\" allowfullscreen></iframe>";
		  }
			?>
            </td>
        </tr>
    </table>
    <?php }?></td>
  </tr>
</table>
