<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
 <!-- Add jQuery library -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>

<script>
function refrescar(){
		window.location="http://2013.circulart.org/m/index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>";
	}



function revisar(frm){
	
	if(frm.numObras.value==0){
		window.alert('Por favor ingrese las Obras');
		return(false);
	}
	
	
	if(frm.numDatosArchivos.value!=0){
		window.alert('Revise y verifique los datos faltantes');
		return(false);
	}

	document.getElementById('submit_button').value='Continuando...';
	document.getElementById('submit_button').disabled=true;
	return(true);
}


function editar(obj){
	url="codigos/crearObra.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra="+obj;
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

function ver(obj){
	url="codigos/verObra.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra="+obj;
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
							href : 'codigos/crearObra.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :500,
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
  			<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>&a=<?php echo $_GET["a"];?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			 <input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="paso_4">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=$frm["password"]?>">
			<input type="hidden" name="id_obra" value="<?=nvl($obra["id"]);?>">
  
        
  
<table width="900" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td colspan="2"><h2>Obras Desarrolladas</h2><br />
  <input name="numObras" type="hidden"  value="<?php 
			
			$numeroO=$db->sql_query("SELECT COUNT(*) FROM obras_musica WHERE id_grupos_musica='".$frm["id_grupo"]."'");
			$resultado=$db->sql_fetchrow($numeroO);
			echo $resultado[0];?>"/><a href="#" id="fancybox-manual-a">[+] Agregar Obra</a></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="fancybox-manual-f" style="background-color:#E7D8B1; border:none;" title="Ver tus datos Guardados"><img src="http://2013.circulart.org/m/CCB/icono.fw.png" alt="Ver tus datos Guardados" width="35" height="35" /></a></td>
  </tr>
  <tr>
    <td colspan="3">
	<table width="900" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="23%" bgcolor="" style="color:#3D1211; text-align:center;"><strong>Obra</strong></td>
    <td bgcolor="" style="color:#3D1211; text-align:center; border-left-width: 1px;
	border-left-style:dashed;	border-left-color: #999;"><strong>Datos subidos</strong></td>
    <td bgcolor="" style="color:#3D1211; text-align:center; border-left-width: 1px;
	border-left-style:dashed;	border-left-color: #999;  border-right-width: 1px;
	border-right-style:dashed;	border-right-color: #999;"><strong>Datos <b>faltantes</b></strong></td>
    <td width="8%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>


	
	<?php $fatantes=0;
	/*** armanos el listado de obras ***/
	$obras = $db->sql_query("SELECT * FROM obras_musica WHERE id_grupos_musica ='".$frm["id_grupo"]."'");
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
		
		$numeroImagen=$db->sql_query("select count(*) from archivos_obras_musica WHERE id_obras_musica='".$datos_obras["id"]."' AND tipo='1' AND orden<>'0'");
		$resultado_3=$db->sql_fetchrow($numeroImagen);
		$resultado_3[0];
		
			
		?>
        <tr>
            <td width="23%" rowspan="3" valign="top"><?php if($cara!=""){?>
            <img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/tmp/<?php echo $cara;?>&amp;w=200" border="0"><?php }?></td>
            <td width="29%" rowspan="3" valign="top" style="border-left-width: 1px;
	border-left-style:dashed;	border-left-color: #999;">
            <?php if($datos_obras["id_generos_musica"]!=0){?><span class="colorTexto">(*) Género: </span><?php echo " ok<br />"; }?>
            <?php if($datos_obras["produccion"]!=""){?><span class="colorTexto">(*) Nombre de la producci&oacute;n:</span><?php echo " ok<br />"; }?>
            <?php if($datos_obras["anio"]!=0){?><span class="colorTexto">(*)  A&ntilde;o de la producci&oacute;n:</span><?php echo " ok<br />"; }?>
            <?php if($datos_obras["resena"]!=""){?><span class="colorTexto">(*) Rese&ntilde;a:</span><?php echo " ok<br />"; }?>
			<?php if($datos_obras["sello_disquero"]!=""){?>
			<span class="colorTexto">(*) Sello discogr&aacute;fico:</span><?php echo " ok<br />"; }?>
            <?php if($caratula["id"]!=""){?>
			<span class="colorTexto">(*) Caratula</span>:<?php echo " ok<br />"; }?>
			<?php if($resultado[0]!=0){?>
			<span class="colorTexto">(*) Audios</span>:<?php echo " ok<br />"; }?>
            <?php if($resultado_2[0]!=0){?>
			<span class="colorTexto">(*) Videos</span>:<?php echo " ok<br />"; }?>
            <?php if($resultado_3[0]!=0){?>
			<span class="colorTexto">(*) Imagenes</span>:<?php echo " ok<br />"; }?>
            </td>
            <td width="30%" rowspan="3" valign="top" style="border-left-width: 1px;
	border-left-style:dashed;	border-left-color: #999;  border-right-width: 1px;
	border-right-style:dashed;	border-right-color: #999;">
            <?php  if($datos_obras["id_generos_musica"]==0){ $fatantes++;?>(*) Género: <span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            <?php if($datos_obras["produccion"]==""){ $fatantes++;?>(*) Nombre de la producci&oacute;n:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            <?php if($datos_obras["anio"]==0){ $fatantes++;?>(*)  A&ntilde;o de la producci&oacute;n:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            <?php if($datos_obras["resena"]==""){ $fatantes++;?>(*) Rese&ntilde;a:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
			<?php if($datos_obras["sello_disquero"]==""){ $fatantes++;?>
			(*) Sello discogr&aacute;fico:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            <?php if($caratula["id"]==""){ $fatantes++;?>
			(*) Caratula:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>		
			<?php if($resultado[0]==0){ $fatantes++;?>
			(*) Audios:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            <?php if($resultado_2[0]==0){ $fatantes++;?>
			(*) Videos:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            <?php if($resultado_3[0]==0){ $fatantes++;?>
			(*) Imagenes:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            </td>
            <td height="50" colspan="2" align="center" valign="middle" style=""><a href="#" id="item<?php echo $datos_obras["id"];?>2" onclick="ver(<?php echo $datos_obras["id"];?>)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ver Obra&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
        </tr>
        <tr>
          <td height="58" colspan="2" align="center" valign="middle" style=""><a href="#" id="item<?php echo $datos_obras["id"];?>" onclick="editar(<?php echo $datos_obras["id"];?>)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Editar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
        </tr>
        <tr>
          <td height="46" colspan="2" align="center" valign="middle" style=""><a href="http://2013.circulart.org/m/index.php?item=<?php echo $datos_obras["id"];?>&modo=<?=$seccion?>&mode=eliminar_obra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo $_GET["a"];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eliminar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
        </tr>
        <?php
		}
		
		
	?>
    
    <input name="numDatosArchivos" type="hidden"  value="<?php echo $fatantes++; ?>" />
    </table>
	<br />
    </td>
  </tr>
  <tr>
    <td width="61"><a href="index.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>">Regresar</a></td>
    <td width="660">&nbsp;</td>
    <td width="149"><input type="submit" value="Continuar" id="submit_button" class="link" style="width:120px; background-color:#F17126; color:#fff; font-weight:bold; border-color:#F17126;"/></td>
  </tr>
</table>
