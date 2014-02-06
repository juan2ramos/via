<link rel="stylesheet" type="text/css" href="<?php echo $CFG->dirwww;?>circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
 <!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>

<script>
function refrescar(){
		window.location="http://2013.circulart.org/m/index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>";
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

	document.getElementById('submit_button').value='Enviando información...';
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


$(document).ready(function() {
				   $("#fancybox-manual-a").click(function() {
						$.fancybox.open({
							href : 'codigos/crearObra.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0',
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
            <input type="hidden" name="mode" value="paso_4">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=$frm["password"]?>">
			<input type="hidden" name="id_obra" value="<?=nvl($obra["id"]);?>">
  
        
  
<table width="900" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td colspan="3"><h2>Obras Publicadas</h2><br />
<input name="numObras" type="hidden"  value="<?php 
			
			$numeroO=$db->sql_query("SELECT COUNT(*) FROM obras_musica WHERE id_grupos_musica='".$frm["id_grupo"]."'");
			$resultado=$db->sql_fetchrow($numeroO);
			echo $resultado[0];?>"/><a href="#" id="fancybox-manual-a">[+] Agregar Obra</a></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
		
		$numeroImagen=$db->sql_query("select count(*) from archivos_obras_musica WHERE id_obras_musica='".$datos_obras["id"]."' AND tipo='1'");
		$resultado_3=$db->sql_fetchrow($numeroImagen);
		$resultado_3[0]=$resultado_3[0]-1;
		
			
		?>
        <tr>
            <td width="23%" valign="top"><?php if($cara!=""){?>
            <img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/tmp/<?php echo $cara;?>&amp;w=200" border="0"><?php }?></td>
            <td width="29%" valign="top" style="border-left-width: 1px;
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
            <?php if($resultado_3[0]!=0 || $resultado_3[0]!=-1){?>
			<span class="colorTexto">(*) Imagenes</span>:<?php echo " ok<br />"; }?>
            </td>
            <td width="30%" valign="top" style="border-left-width: 1px;
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
            <?php if($resultado_3[0]==0 || $resultado_3[0]==-1){ $fatantes++;?>
			(*) Imagenes:<span class="colorTexto"><?php echo " <b>FALTA</b><br />"; }?></span>
            </td>
            <td width="8%" style=""><a href="#" id="item<?php echo $datos_obras["id"];?>" onclick="editar(<?php echo $datos_obras["id"];?>)">Editar</a></td>
            <td width="10%"><a href="codigos/eliminarO.php?item=<?php echo $datos_obras["id"];?>&modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>">Eliminar</a></td>
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
    <td width="61"><a href="index.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>">Regresar</a></td>
    <td width="648">&nbsp;</td>
    <td width="161"><input type="submit" value="Continuar" id="submit_button" class="link"/></td>
  </tr>
</table>
