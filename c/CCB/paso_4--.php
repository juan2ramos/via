    <!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>m/js/source/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->dirwww;?>m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<style type="text/css">
.margenp {				margin-left:10px;
				font-size:12px;
}
</style>

<script>
function revisar(frm){
	if(frm.pregunta1.value.replace(/ /g, '') ==''){
		window.alert('Este campo es requerido');
		frm.pregunta1.focus();
		return(false);
	}
	
	if(frm.pregunta2.value.replace(/ /g, '') ==''){
		window.alert('Este campo es requerido');
		frm.pregunta2.focus();
		return(false);
	}
	
	if(frm.pregunta3.value.replace(/ /g, '') ==''){
		window.alert('Este campo es requerido');
		frm.pregunta3.focus();
		return(false);
	}
	
	if(frm.pregunta4.value.replace(/ /g, '') ==''){
		window.alert('Este campo es requerido');
		frm.pregunta4.focus();
		return(false);
	}
	
	if(frm.pregunta5.value.replace(/ /g, '') ==''){
		window.alert('Este campo es requerido');
		frm.pregunta5.focus();
		return(false);
	}
	
	
  if(!document.getElementById('verifica1').checked){
		window.alert('Para terminar con la inscripción debe aceptar los términos y condiciones.');
		return(false);
	}
	
	if(!document.getElementById('verifica2').checked){
		window.alert('Para terminar debe autorizar a la Cámara de Comercio de Bogotá para el uso y tratamiento de todos los datos personales y/o de la compañía, ingresados en esta convocatoria.');
		return(false);
	}
	
	
	document.getElementById('submit_button').value='Enviando información...';
	document.getElementById('submit_button').disabled=true;
	return(true);
}


 $(document).ready(function() {
	  $.fn.extend( {
						limiter: function(limit, elem) {
							$(this).on("keyup focus", function() {
								setCount(this, elem);
							});
							function setCount(src, elem) {
								var chars = src.value.length;
								if (chars > limit) {
									src.value = src.value.substr(0, limit);
									chars = limit;
								}
								elem.html( limit - chars );
							}
							setCount($(this)[0], elem);
						}
					});
					
					var elem = $("#chars");
					$("#pregunta1").limiter(700, elem);
					
					var elem = $("#chars2");
					$("#pregunta2").limiter(700, elem);  
					
					var elem = $("#chars3");
					$("#pregunta3").limiter(700, elem);  
					
					var elem = $("#chars4");
					$("#pregunta4").limiter(700, elem);  
					
					var elem = $("#chars5");
					$("#pregunta5").limiter(700, elem);  
	 });
</script>

  
			<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			 <input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="final">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=$frm["password"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
   <?php 

 $frm=$db->sql_row("SELECT * FROM grupos_musica WHERE id='$frm[id_grupo]'");

?>
        <h2>Perfil de la propuesta (*) Campos requeridos</h2>
    
        <table width="960" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td colspan="4" align="left" valign="top" bgcolor="#D31245" style="color:#fff;"><strong>IDENTIDAD</strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="colorTexto">(*) 1. Haz una breve descripci&oacute;n tuya o de tu grupo (promedio de edad, lugar de residencia, a qu&eacute; se dedican, estudios, hobbies, otros intereses&hellip;)<br />
(700 caracteres) </td>
            <td colspan="2" align="left" valign="top"><textarea name="pregunta1" cols="50" rows="10" id="pregunta1"><?=nvl($frm["pregunta1"])?></textarea><em><div id="chars" style=""></div></em></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="colorTexto">(*) 2. &iquest;A qui&eacute;n va dirigida tu propuesta art&iacute;stica? (por favor ay&uacute;danos a describir a tu audiencia por edad, si crees que puedas clasificarla por nivel socio econ&oacute;mico y ubicaci&oacute;n </td>
            <td colspan="2" align="left" valign="top"><textarea name="pregunta2" id="pregunta2" cols="50" rows="10"><?=nvl($frm["pregunta2"])?></textarea><em><div id="chars2" style=""></div></em></td>
          </tr>
        	<tr>
            <td colspan="4" align="left" valign="top" bgcolor="#D31245" style="color: #fff;"><strong>REPRESENTACI&Oacute;N</strong></td>
          </tr>
          <tr>
            <td colspan="2" valign="top" class="colorTexto">(*) 3. &iquest;Qu&eacute; valores caracterizan o definen tu propuesta art&iacute;stica? (Def&iacute;nelos en palabras sencillas como: tenacidad, alegr&iacute;a, esfuerzo&hellip; )</td>
            <td colspan="2"><textarea name="pregunta3" id="pregunta3" cols="50" rows="10"><?=nvl($frm["pregunta2"])?></textarea><em><div id="chars3" style=""></div></em></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="colorTexto">(*) 4. Si tu proyecto musical se pudiera resumir en una emoci&oacute;n, &iquest;cu&aacute;l ser&iacute;a?</td>
            <td colspan="2" align="left" valign="top"><textarea name="pregunta4" id="pregunta4" cols="50" rows="10"><?=nvl($frm["pregunta2"])?></textarea><em><div id="chars4" style=""></div></em></td>
          </tr>
          <tr>
            <td colspan="4" align="left" valign="top" bgcolor="#D31245" style="color: #fff;"><strong>PROYECTIVA</strong></td>
          </tr>
        	<tr>
            <td colspan="2" align="left" valign="top" class="colorTexto">(*) 5: &iquest;D&oacute;nde quieres ver  tu proyecto musical en 10 a&ntilde;os?</td>
            <td colspan="2" align="left" valign="top"><textarea name="pregunta5" id="pregunta5" cols="50" rows="10"><?=nvl($frm["pregunta2"])?></textarea><em><div id="chars5" style=""></div></em></td>
          </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="colorTexto"><input type="checkbox" name="verifica1" id="verifica1" <?php if($frm["verifica1"]=='1'){echo "checked='checked'";}else{}?>/>
            (*)
              <label for="verifica1">He leido y acepto los T&eacute;rminos y Condiciones de participacion en el BOmm</label></td>
          </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="colorTexto"><input type="checkbox" name="verifica2" id="verifica2" <?php if($frm["verifica2"]=='1'){echo "checked='checked'";}else{}?>/>
(*)
  Manifiesto que en virtud de la Ley 1581 de 2012 &ldquo;Por la cual se dictan disposiciones generales para la protecci&oacute;n de datos personales&rdquo;, autorizo a la C&aacute;mara de Comercio de Bogot&aacute; de manera expresa para llevar a cabo el uso y tratamiento de todos los datos personales y/o de la compa&ntilde;&iacute;a.  <label for="verifica2"></label></td>
          </tr>
          <tr>
            <td colspan="4" align="left" valign="top" bgcolor="#D31245" style="color: #fff;"><span ><strong>SHOWCASES</strong></span></td>
          </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="colorTexto"><input type="checkbox" name="verifica3" id="verifica3" <?php if($frm["verifica3"]=='1'){echo "checked='checked'";}else{}?>/>
El BOmm tendr&aacute; una tarima de Showcases donde los artistas seleccionados tendr&aacute;n la oportunidad de presentar su propuesta musical en vivo a los compradores y agentes de booking nacionales e internacionales. Un Showcase es una gran oportunidad de negocio para el artista en el cual el artista se presenta de forma voluntaria y no remunerada. Si quieres que los curadores evaluen tu inscripci&oacute;n para uno de los cupos en los Showcases, haz clic en la casilla. Con dar clic en la casilla se da a entender que tienes la disponibilidad de presentar tu show en vivo durante las fechas del BOmm.
<label for="verifica3"><br />
  <br />
</label></td>
          </tr>
          <tr>
            <td width="142" align="left" valign="top"><a href="index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>">Regresar</a></td>
            <td width="437" align="left" valign="top">&nbsp;</td>
            <td width="186" align="left" valign="top">&nbsp;</td>
            <td width="130" align="left" valign="top"><input type="submit" id="submit_button" value="Continuar" class="link"/></td>
          </tr>
        </table>
    
    
			</form>
     
