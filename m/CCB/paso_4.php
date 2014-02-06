<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
 <!-- Add jQuery library -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>

<script>
function refrescar(){
		window.location="http://2013.circulart.org/m/index.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>";
	}



function revisar(frm){
	
	/*if(frm.numObras.value==0){
		window.alert('Por favor ingrese las Obras');
		return(false);
	}
	
	
	if(frm.numDatosArchivos.value!=0){
		window.alert('Revise y verifique los datos faltantes');
		return(false);
	}*/

	document.getElementById('submit_button').value='Continuando...';
	document.getElementById('submit_button').disabled=true;
	return(true);
}


function editar(obj){
	url="codigos/crearObra.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra="+obj;
	$.fancybox.open({
							href : url,
							padding : 5,
							height :500,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
    });
}


$(document).ready(function() {
				   $("#fancybox-manual-a").click(function() {
						$.fancybox.open({
							href : 'codigos/subirArchivoAudio.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :250,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
                        });
                  });
				  
				  
				  
				  $("#fancybox-manual-a2").click(function() {
						$.fancybox.open({
							href : 'codigos/subirArchivoImagen.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :250,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
     				 });
                 });	  
				  
				   $("#fancybox-manual-a3").click(function() {
						$.fancybox.open({
							href : 'codigos/subirArchivoVideo.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :250,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
     				 });
                 });
				 
				 $("#fancybox-manual-f").click(function() {
						$.fancybox.open({
							href : 'index.php?modo=inscripciones&mode=vertodo&id_usuario<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :600,
							width  :1010,
							autoSize: false,
							type : 'iframe'
						});
					});	  
				  
});



</script>
  			<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>&a=<?php echo$_GET["a"];?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			 <input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="final">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=$frm["password"]?>">
			<input type="hidden" name="id_obra" value="<?=nvl($obra["id"]);?>">
  
        
  
<table width="890" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td colspan="2"><h2>Otros Archivos</h2>Espacio para subir otros archivos que pudan complementar la trayectoria o carrera artistica.<br />
      <br /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="fancybox-manual-f" style="background-color:#E7D8B1; border:none;" title="Ver tus datos Guardados"><img src="http://2013.circulart.org/m/CCB/icono.fw.png" alt="Ver tus datos Guardados" width="35" height="35" /></a></td>
  </tr>
  <tr>
    <td height="55"><input name="numAudios" type="hidden"  value="<?php 
			
			$numeroA=$db->sql_query("SELECT COUNT(*) FROM archivos_grupos_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND tipo='2'");
			$resultadoA=$db->sql_fetchrow($numeroA);
			echo $resultadoA[0];?>"/>
    <a href="#" id="fancybox-manual-a">[+] Agregar Audios </a></td>
    <td width="419" align="center"><input name="numImagen" type="hidden"  value="<?php 
			
			$numeroI=$db->sql_query("SELECT COUNT(*) FROM archivos_grupos_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND tipo='1'");
			$resultadoI=$db->sql_fetchrow($numeroI);
			echo $resultadoI[0];?>"/>
    <a href="#" id="fancybox-manual-a2">[+] Agregar Imagen </a></td>
    <td colspan="3" align="right"><input name="numImagen2" type="hidden"  value="<?php 
			
			$numeroV=$db->sql_query("SELECT COUNT(*) FROM archivos_grupos_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND tipo='3'");
			$resultadoV=$db->sql_fetchrow($numeroV);
			echo $resultadoV[0];?>"/>
    <a href="#" id="fancybox-manual-a3">[+] Agregar Video </a></td>
  </tr>
  <tr>
    <td colspan="5">
    <!--- listo los archivos de audio --->
    <?php $archivos = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."' AND tipo='2'");
	while($datos_archivos=$db->sql_fetchrow($archivos)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="23%" align="center" valign="top"><?php echo $datos_archivos["etiqueta"];?></td>
            <td width="59%" valign="top"> 
			<script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>
 <object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer<?php echo $datos_archivos["id"]?>" height="24" width="290">
			<param name="movie" value="http://circulart.org/audio_base/player.swf">
			<param name="FlashVars" value="playerID=<?php echo $datos_archivos["id"];?>&amp;soundFile=http://circulart.org/musica/audio/<?php echo $frm["id_grupo"];?>/grupo/<?php echo $datos_archivos["id"];?>/<?php echo $datos_archivos["mmdd_archivo_filename"];?>">
			<param name="quality" value="high">
			<param name="menu" value="false">
			<param name="wmode" value="transparent">
			</object></td>
            <td width="18%" align="center" style=""><a href="http://2013.circulart.org/m/index.php?item=<?php echo $datos_archivos["id"];?>&modo=<?=$seccion?>&mode=eliminar_archivo&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>">Eliminar</a>            </td>
        </tr>
    </table>
    <?php }?>
    <!--- listo los archivos de Imagen --->
    <?php $archivosI = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."' AND tipo='1'");
	while($datos_archivosI=$db->sql_fetchrow($archivosI)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="23%" align="center" valign="top"><?php echo $datos_archivosI["etiqueta"];?></td>
            <td width="59%" valign="top"> 
			<img src="http://2013.circulart.org/m/admin/imagen.php?table=archivos_grupos_musica&amp;field=archivo&amp;id=<?php echo $datos_archivosI["id"]?>" border="0" width="200">
            </td>
            <td width="18%" align="center" style=""><a href="http://2013.circulart.org/m/index.php?item=<?php echo $datos_archivosI["id"];?>&modo=<?=$seccion?>&mode=eliminar_archivo&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>">Eliminar</a>            </td>
        </tr>
    </table>
    <?php }?>
    
    <!--- listo los archivos de Video --->
    <?php $archivosV = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."' AND tipo='3'");
	while($datos_archivosV=$db->sql_fetchrow($archivosV)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="36%" align="center" valign="top"><?php echo $datos_archivosV["etiqueta"];?></td>
            <td width="46%" valign="top"> 
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
			?>            </td>
            <td width="18%" align="center" style=""><a href="http://2013.circulart.org/m/index.php?item=<?php echo $datos_archivosV["id"];?>&modo=<?=$seccion?>&mode=eliminar_archivo&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>">Eliminar</a>            </td>
        </tr>
    </table>
    <?php }?>
    
	<br />
    </td>
  </tr>
  <tr>
    <td width="194"><a href="index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>">Regresar</a></td>
    <td colspan="2">&nbsp;</td>
    <td width="119">&nbsp;</td>
    <td width="117">&nbsp;&nbsp;<input style="background-color:#F17126; color:#fff; font-weight:bold; border-color:#F17126;" type="submit" value="Continuar" id="submit_button" class="link"/></td>
  </tr>
</table>
