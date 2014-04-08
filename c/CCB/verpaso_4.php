<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
 <!-- Add jQuery library -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>

<script>
function refrescar(){
		window.location="http://2013.circulart.org/m/index.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>";
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
							href : 'codigos/subirArchivoAudio.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0',
							padding : 5,
							height :500,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
                        });
                  });
				  
				  
				  
				  $("#fancybox-manual-a2").click(function() {
						$.fancybox.open({
							href : 'codigos/subirArchivoImagen.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0',
							padding : 5,
							height :500,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
     				 });
                 });	  
				  
				   $("#fancybox-manual-a3").click(function() {
						$.fancybox.open({
							href : 'codigos/subirArchivoVideo.php?modo=<?=$seccion?>&mode=paso_4muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0',
							padding : 5,
							height :500,
							width  :800,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
     				 });
                 });	  
				  
});



</script>
  			<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			 <input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="final">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=$frm["password"]?>">
			<input type="hidden" name="id_obra" value="<?=nvl($obra["id"]);?>">
  
        
  
<table width="900" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td width="849"><h2>Otros Archivos</h2></td>
  </tr>
  <tr>
    <td>
    <!--- listo los archivos de audio --->
    <?php $archivos = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."' AND tipo='2'");
	while($datos_archivos=$db->sql_fetchrow($archivos)){?>
    
	<table width="890" border="0" cellspacing="5" cellpadding="5" style="border-bottom-style: dashed; border-bottom-width: 1px; ">
        <tr>
            <td width="23%" align="center" valign="top"><?php echo $datos_archivos["etiqueta"];?></td>
            <td valign="top"> 
			<script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>
 <object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer<?php echo $datos_archivos["id"]?>" height="24" width="290">
			<param name="movie" value="http://circulart.org/audio_base/player.swf">
			<param name="FlashVars" value="playerID=<?php echo $datos_archivos["id"];?>&amp;soundFile=http://circulart.org/musica/audio/<?php echo $frm["id_grupo"];?>/grupo/<?php echo $datos_archivos["id"];?>/<?php echo $datos_archivos["mmdd_archivo_filename"];?>">
			<param name="quality" value="high">
			<param name="menu" value="false">
			<param name="wmode" value="transparent">
			</object></td>
        </tr>
    </table>
    <?php }?>
    <!--- listo los archivos de Imagen --->
    <?php $archivosI = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."' AND tipo='1'");
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
    <?php $archivosV = $db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."' AND tipo='3'");
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
