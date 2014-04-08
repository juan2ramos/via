<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
 <!-- Add jQuery library -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>

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
							type : 'iframe'
							
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
							type : 'iframe'
							
    });
}

$(document).ready(function() {
				   $("#fancybox-manual-a").click(function() {
						$.fancybox.open({
							href : 'codigos/crearObra.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&id_obra=0',
							padding : 5,
							height :500,
							width  :800,
							autoSize: false,
							type : 'iframe'
							
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
  
        
  
<table width="890" border="0" cellspacing="5" cellpadding="5" style="color:#3D1211; " bgcolor="#E7D8B1">
  <tr>
    <td width="870"><h2>Obras Desarrolladas<br />
<input name="numObras" type="hidden"  value="<?php 
			
			$numeroO=$db->sql_query("SELECT COUNT(*) FROM obras_musica WHERE id_grupos_musica='".$frm["id_grupo"]."'");
			$resultado=$db->sql_fetchrow($numeroO);
			echo $resultado[0];?>"/>
    </h2></td>
  </tr>
  <tr>
    <td>
	<table width="890" border="0" cellspacing="5" cellpadding="5">


	
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
		$resultado_3[0];
		
			
		?>
        <tr>
            <td width="41%" valign="top"><?php if($cara!=""){?>
            <img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/tmp/<?php echo $cara;?>&amp;w=350" border="0"><?php }?></td>
            <td width="59%" align="center" style=""><a href="#" id="item<?php echo $datos_obras["id"];?>2" onclick="ver(<?php echo $datos_obras["id"];?>)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ver Obra&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
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
