<style>
#acciones{display:none;}
footer{
	margin-top:100px;
}	
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
function refrescar(){
		window.location="http://redlat.org/via/m/index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>";
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

	return(true);
}
function actualizar(num){
		$("#agregar").css("display","none");
		$("#acciones").css("display","inline");
		$("#registros").css("display","none");
		$("#submit_button").css("display","none");
		$("#regresar").css("display","none");
		
		url="http://redlat.org/via/m/codigos/obras.php?item=<?=$frm["id_grupo"]?>&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&paso=1&id_obra="+num;
		$("#iframe").attr("src",url);
	}
function eliminarObra(num){
	url="http://redlat.org/via/m/codigos/obras.php?item=<?=$frm["id_grupo"]?>&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&paso=3&id_obra="+num;
	$("#iframe").attr("src",url);
	//refrescar();
	}	
$(document).ready(function() {
	$("#agregar").click(function(){
		$("#agregar").css("display","none");
		$("#acciones").css("display","inline");
		$("#registros").css("display","none");
		$("#submit_button").css("display","none");
		$("#regresar").css("display","none");
		
		url="http://redlat.org/via/m/codigos/obras.php?item=<?=$frm["id_grupo"]?>&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&paso=1&id_obra=0";
		$("#iframe").attr("src",url);
		
		})
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><h2>Obras o producci&oacute;nes esc&eacute;nicas</h2><br />
  <input name="numObras" type="hidden" value="<?php 
			$numeroO=$db->sql_query("SELECT COUNT(*) FROM obras_".$frm["area"]." WHERE id_grupos_".$frm["area"]."='".$frm["id_grupo"]."'");
			$resultado=$db->sql_fetchrow($numeroO);
			echo $resultado[0];?>"/>
<div id="agregar" style="text-align:center; margin-top:10px; margin-bottom:20px; padding:15px; background-color:#F00; width:150px; font-size:14px; text-decoration:none; cursor:pointer; text-transform: uppercase">[+] agregar</div>
  </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
    <div id="acciones" style="width:100%; height:600px;">
    <iframe name="ifrAcc" id="iframe" frameborder="0" scrolling="no" width="100%" height="1900px" src="http://redlat.org/via/m/codigos/blanco.php"></iframe>
    </div>
    <div id="registros">
	<table width="93%" border="0" cellspacing="0" cellpadding="0">
  <tr style="text-transform:uppercase">
    <td width="66%" bgcolor="" style=" text-align:center;"><strong>Nombre </strong></td>
    <td width="34%" bgcolor="" style=" text-align:center; "><strong>Estado<b></b></strong><strong><b></b></strong></td>
    </tr>


	
	<?php $fatantes=0;
	/*** armanos el listado de obras ***/
	$obras = $db->sql_query("SELECT * FROM obras_".$frm["area"]." WHERE id_grupos_".$frm["area"]." ='".$frm["id_grupo"]."'");
	while($datos_obras=$db->sql_fetchrow($obras)){	

		$numeroImagen=$db->sql_query("select count(*) from archivos_obras_".$frm["area"]." WHERE id_obras_".$frm["area"]."='".$datos_obras["id"]."' AND tipo='1'");
		$resultado_3=$db->sql_fetchrow($numeroImagen);
		//conteo de imagenes
		$resultado_3[0];
		$datos_obras["obra"];
		$datos_obras["anio"];
		$datos_obras["id_generos_".$frm["area"]];
		$datos_obras["resena"];
		$datos_obras["en_resena"];
		?>
        <tr style="">
            <td valign="top" ><a style="color:#FFF; text-decoration:underline" href="#" onclick="actualizar(<?=$datos_obras["id"]?>)"><?=$datos_obras["obra"]?></a><br />
<br />
</td>
            <td valign="top" style="border-left-width: 1px;
	border-left-style:dashed;	border-left-color: #999; ">
    <?php if($resultado_3[0]>0 && $datos_obras["obra"]!=''&& $datos_obras["anio"]!=''&& $datos_obras["id_generos_".$frm["area"]]!=''&& $datos_obras["resena"]!='' && $datos_obras["en_resena"]!=''){?>
    <div style="margin-left:20px; margin-right:20px; text-transform:uppercase; text-align:center; background-color:#030">completo</div>
    <?php }else{?>
	<div style="margin-left:20px; margin-right:20px; text-transform:uppercase; text-align:center; background-color:#F00">incompleto</div>
    <div style="margin-left:20px; margin-right:20px; ">Hace falta la siguiente informaci&oacute;n:</div>
    <? if($datos_obras["obra"]==''){?>
    <div style="margin-left:20px; margin-right:20px;">- Nombre de la obra</div>
    <? } ?>
   <? if($datos_obras["anio"]==''){?>
    <div style="margin-left:20px; margin-right:20px;">- A&ntilde;o</div>
    <? } ?>
     <? if($datos_obras["id_generos_".$frm["area"]]==''){?>
    <div style="margin-left:20px; margin-right:20px;">- Seleccionar el g&eacute;nero</div>
    <? } ?>
    <? if($datos_obras["resena"]==''){?>
    <div style="margin-left:20px; margin-right:20px;">- Ingresar la rese&ntilde; en espa&ntilde;ol</div>
    <? } ?>
    <? if($datos_obras["en_resena"]==''){?>
    <div style="margin-left:20px; margin-right:20px;">- Ingresar la rese&ntilde; en ingl&eacute;</div>
    <? } ?>
    <? if($resultado_3[0]==0){?>
    <div style="margin-left:20px; margin-right:20px;">- Imagenes relacionadas con la producci&oacute;n</div>
    <? } ?>
    <?php } ?>
<br />

    </td>
    <td valign="top" style="border-left-width: 1px;
	border-left-style:dashed;	border-left-color: #999; "><div style="margin-left:20px; text-align:center; margin-right:20px;">
    <strong><a style="color:#FFF; text-decoration:underline" href="#" onclick="eliminarObra(<?=$datos_obras["id"]?>)">
    Borrar obra
    </a></strong>
    </div>
    </td>
          </tr>
          
        <?php
		}
		
		
	?>
    
    <input name="numDatosArchivos" type="hidden"  value="<?php echo $fatantes++; ?>" />
    </table>
    </div>
	<br />
    </td>
  </tr>
  <tr>
    <td width="61"><a id="regresar" style="color:#FFF" href="index.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>"><div id="agregar" style="text-align:center; margin-top:10px; margin-bottom:20px; padding:15px; background-color:#F00; width:150px; font-size:14px; text-decoration:none; cursor:pointer; text-transform: uppercase">Regresar</div></a></td>
    <td width="660">&nbsp;</td>
    <td width="149"><input type="submit" value="Continuar" id="submit_button" class="link" style="width:120px; background-color:#F17126; color:#fff; font-weight:bold; border-color:#F17126; cursor:pointer"/></td>
  </tr>
</table>
