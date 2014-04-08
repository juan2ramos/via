


<table width="890" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td width="870"><br /><a href="http://2013.circulart.org/m/index.php?modo=curadores&amp;mode=listar_grupos&amp;a=1">
      Regresar al listado de grupos </a><br />
<br />
<h2>      Obras Desarrolladas<br />
<input name="numObras" type="hidden"  value="<?php 
			
			$numeroO=$db->sql_query("SELECT COUNT(*) FROM obras_musica WHERE id_grupos_musica='".$_GET["id_grupo"]."'");
			$resultado=$db->sql_fetchrow($numeroO);
			echo $resultado[0];?>"/>
    </h2></td>
  </tr>
  <tr>
    <td>
	<table width="890" border="0" cellspacing="5" cellpadding="5">


	
	<?php $fatantes=0;
	/*** armanos el listado de obras ***/
	$obras = $db->sql_query("SELECT * FROM obras_musica WHERE id_grupos_musica ='".$_GET["id_grupo"]."'");
	while($datos_obras=$db->sql_fetchrow($obras)){
		
		$caratula=$db->sql_row("SELECT * FROM archivos_obras_musica WHERE id_obras_musica='".    $datos_obras["id"]."' AND etiqueta='Caratula'");
		if($caratula["id"]!=""){
		 $cara=$caratula["id"]."_musica_a_".$caratula["mmdd_archivo_filename"];
		}else{
		 $cara="";
			}
			
		$numeroAudios=$db->sql_query("select count(*) from tracklist WHERE id_obras_musica='".$datos_obras["id"]."'");
		$resultado=$db->sql_fetchrow($numeroAudios);
		$resultado[0];
		
		$numeroVideos=$db->sql_query("select count(*) from archivos_obras_musica WHERE id_obras_musica='".$datos_obras["id"]."' AND tipo='3'");
		$resultado_2=$db->sql_fetchrow($numeroVideos);
		$resultado_2[0];
		
		$numeroImagen=$db->sql_query("select count(*) from archivos_obras_musica WHERE id_obras_musica='".$datos_obras["id"]."' AND tipo='1'");
		$resultado_3=$db->sql_fetchrow($numeroImagen);
		$resultado_3[0];
		
			
		?>
        <tr>
            <td width="41%" valign="top"><?php if($cara!=""){?>
            <img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/tmp/<?php echo $cara;?>&amp;w=350" border="0"><?php }?></td>
            <td width="59%" align="center" style=""><a style="cursor:pointer" id="item<?php echo $datos_obras["id"];?>2" onclick="ver(<?php echo $datos_obras["id"];?>)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ver Obra&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
        </tr>
        <?php
		}
		
		
	?>
    
    <input name="numDatosArchivos" type="hidden"  value="<?php echo $fatantes++; ?>" />
    </table>
	<br />
    </td>
  </tr>
</table>
