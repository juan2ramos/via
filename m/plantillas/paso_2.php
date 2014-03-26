    <!-- Add jQuery library -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.scrollTo-1.4.3.1-min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
<style type="text/css">
.margenp {				margin-left:10px;
				font-size:12px;
}


</style>
<script>
function refrescar(){
	window.location="http://2013.circulart.org/m/index.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>";
	}
	
function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnopqrstuvwxyz1234567890 ";
    especiales = [8];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}

function limpia() {
    var val = document.getElementById("miInput").value;
    var tam = val.length;
    for(i = 0; i < tam; i++) {
        if(!isNaN(val[i]))
            document.getElementById("miInput").value = '';
    }
}	
function continuar(id){
	if(id==true){
	window.location="http://2013.circulart.org/m/index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>";
	}else{}
	}	
	
function revisar(frm){
	b=0;
	if(frm.imagen.value.replace(/ /g, '') ==''){
		    $('#imagenGrupo').css('background-color','#F17126');
			
			alert('Por favor suba una imagen [jpg, png o gif] que identifique.');
			frm.imagen.focus();
			continuar(false);
			b++;
	}
	
	if(frm.nombre.value.replace(/ /g, '') ==''){
	
		$('.nombre').css('background-color','#F17126');
		alert('Por favor escriba el nombre de la agrupación o del artista');
		frm.nombre.focus();
		continuar(false);
			b++;
	}

	if(frm.resena_corta.value.replace(/ /g, '') ==''){
		
			$('.resena').css('background-color','#F17126');
			alert('Por favor escriba una breve reseña');
			frm.resena_corta.focus();
			continuar(false);
				b++;
		}
		
	if(frm.en_resena_corta.value.replace(/ /g, '') ==''){
			
			$('.resena2').css('background-color','#F17126');
			alert('Por favor escriba una breve reseña en ingles');
			frm.en_resena_corta.focus();
			continuar(false);
				b++;
		}	
	
		
	if(document.getElementById('tipo_propuesta').selectedIndex==0){
		
			$('.propuesta').css('background-color','#F17126');
			alert('Por favor escoja el tipo de propuesta');
			frm.resena_corta.focus();
			continuar(false);
				b++;
		}
		

   if(document.getElementById('id_pais').selectedIndex==0){
				$('.id_pais').css('background-color','#F17126');
			alert('Por favor escoja el país');
			frm.id_pais.focus();
			continuar(false);
				b++;
		}	
		
		
		
   if(frm.ciudad.value.replace(/ /g, '') ==''){
		$('.ciudad').css('background-color','#F17126');
		alert('Por favor escriba la ciudad');
		frm.ciudad.focus();
		continuar(false);
			b++;
	}
	
	if(frm.direccion.value.replace(/ /g, '') ==''){
		$('.direccion').css('background-color','#F17126');
		alert('Por favor escriba la direccion');
		frm.direccion.focus();
		continuar(false);
			b++;
	}
	
	if(frm.telefono.value.replace(/ /g, '') ==''){
		$('.telefono').css('background-color','#F17126');
		alert('Por favor escriba el teléfono');
		frm.telefono.focus();
		continuar(false);
			b++;
	}
	
	
	if(frm.email.value.replace(/ /g, '') ==''){
		alert('Por favor escriba: e-mail');
		$('.email').css('background-color','#F17126');
		frm.email.focus();
		continuar(false);
			b++;
	}
	else{
		var regexpression=/@.*\./;
		if(!regexpression.test(frm.email.value)){
			alert('[e-mail] no contiene un dato válido.');
			frm.email.focus();
			continuar(false);
				b++;
		}
	}
	
    if(frm.trayectoria.value.replace(/ /g, '') ==''){
		$('.trayec').css('background-color','#F17126');
		alert('Por favor seleccione un archivo pdf para la trayectoria.');
		frm.trayectoria.focus();
		continuar(false);
			b++;
	}
	
	if(frm.website.value.replace(/ /g, '') ==''){
		$('.website1').css('background-color','#F17126');
		alert('Por favor escriba la url del website');
		frm.website.focus();
		continuar(false);
			b++;
	}
	

	
	if(frm.contacto.value.replace(/ /g, '') ==''){
		$('.contacto').css('background-color','#F17126');
		alert('Por favor ingrese el contacto');
		frm.contacto.focus();
		continuar(false);
			b++;
	}
	
	if(frm.contacto_cc.value.replace(/ /g, '') ==''){
		$('.cc1').css('background-color','#F17126');
		alert('Por favor ingrese la cédula contacto');
		frm.contacto_cc.focus();
		continuar(false);
			b++;
	}
	
	if(frm.num_personas_gira.value.replace(/ /g, '') ==''){
		$('.nop').css('background-color','#F17126');
		alert('Por favor escriba el No. de personas en gira');
		frm.num_personas_gira.focus();
		continuar(false);
			b++;
	}
	
	if(frm.num_personas_escenario.value.replace(/ /g, '') ==''){
		$('.nope').css('background-color','#F17126');
	
		alert('Por favor escriba el No. de personas en escenario');
		frm.num_personas_escenario.focus();
		continuar(false);
			b++;
	}
	
	

	
	if(frm.ficha.value.replace(/ /g, '') ==''){
		$('.ficha').css('background-color','#F17126');
	
		alert('Por favor ingrese la ficha [PDF]');
		frm.en_equipos_adicionales.focus();
		continuar(false);
			b++;
	}
	
	if(frm.demo.value.replace(/ /g, '') ==''){
		$('.demo').css('background-color','#F17126');
	
		alert('Por favor suba un MP3 como demo');
		frm.en_equipos_adicionales.focus();
		continuar(false);
			b++;
	}
	
	if(frm.personas.value==0){
		$('.personas').css('background-color','#F17126');
	
		alert('En caso de quedar seleccionado(s) indique el nombre y documento de la(s) persona(s) que lo(s) representará(n) en las citas de la Rueda de Negocios.');
		frm.personas.focus();
		continuar(false);
			b++;
	}
	
	if(b==0){
	document.getElementById('submit_button').value='Enviando información...';
	document.getElementById('submit_button').disabled=true;	
	continuar(true);}
}
    </script>

		<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>&a=<?php echo$_GET["a"];?>" method="POST" enctype="multipart/form-data" id="entryform">
		  <input type="hidden" name="modo" value="<?=$seccion?>" />
          <input type="hidden" name="mode" value="paso_3">
		  <input type="hidden" name="id_grupo" value="<?=nvl($frm["id_grupo"])?>">
		  <input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
		  <input type="hidden" name="area" value="<?=$frm["area"]?>">
		  <input type="hidden" name="login" value="<?=$frm["login"]?>">
		  <input type="hidden" name="password" value="<?=nvl($frm["__CONFIRM_password"])?>">
     
      
        <table width="910" height="2398" border="0" cellpadding="12" cellspacing="5" style="color:#3D1211; " bgcolor="#E7D8B1">
          <tr>
            <td colspan="3" align="left" valign="top">
			<script type="text/javascript">
			
		       $(document).ready(function() {
				   $("#pie").css('display','none');
				   $("#fancybox-manual-b").click(function() {
						$.fancybox.open({
							href : 'codigos/subirImagen.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :200,
							width  : 400,
							autoSize: false,
							type : 'iframe'
						});
					});
					
					
					 $("#fancybox-manual-a").click(function() {
						$.fancybox.open({
							href : 'codigos/subirTrayectoria.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :200,
							width  : 400,
							autoSize: false,
							type : 'iframe'
						});
					});
					
					$("#fancybox-manual-c").click(function() {
						$.fancybox.open({
							href : 'codigos/subirRut.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :200,
							width  : 400,
							autoSize: false,
							type : 'iframe'
						});
					});
					
					$("#fancybox-manual-d").click(function() {
						$.fancybox.open({
							href : 'codigos/subirFicha.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :200,
							width  : 400,
							autoSize: false,
							type : 'iframe'
						});
					});
					
					$("#fancybox-manual-e").click(function() {
						$.fancybox.open({
							href : 'codigos/subirFoto1.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :300,
							width  : 500,
							autoSize: false,
							type : 'iframe'
						});
					});
					
					
					$("#fancybox-manual-k").click(function() {
						$.fancybox.open({
							href : 'codigos/subirMP3.php?modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>&a=<?php echo$_GET["a"];?>',
							padding : 5,
							height :200,
							width  : 400,
							autoSize: false,
							type : 'iframe'
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
					$("#resena_corta").limiter(700, elem);
					
					var elem = $("#chars3");
					$("#en_resena_corta").limiter(700, elem);
					
					
					var elem = $("#chars2");
					$("#instrumentos").limiter(500, elem); 
					
					var elem = $("#chars4");
					$("#en_instrumentos").limiter(500, elem);
					
					var elem = $("#chars5");
					$("#equipos_adicionales").limiter(500, elem);
					
					var elem = $("#chars6");
					$("#en_equipos_adicionales").limiter(500, elem);
					
					$("#tipo_propuesta").change(function () {
					  var str = "";
					  $("#tipo_propuesta option:selected").each(function () {
							str += $(this).val();
						  });
					 if(str==3){
						 	$('.oculto').slideDown("slow")
						  }else{
							$('.oculto').slideUp("slow")
					 }
					})
					.trigger('change');
					
					
					
					
					
					 
				   })
				   
				  

				   
		    </script>
			  <h2>Datos B&aacute;sicos (*) Campos requeridos</h2>
			    <h4>Antes de subir imagenes o archivos PDF, haga clic en el bot&oacute;n &quot;Guardar datos&quot;</h4>
		    </td>
            <td align="left" valign="top"><a href="#" id="fancybox-manual-f" style="background-color:#E7D8B1; border:none;" title="Ver tus datos Guardados" ><img src="http://2013.circulart.org/m/CCB/icono.fw.png" alt="Ver tus datos Guardados" width="35" height="35" /></a></td>
          </tr>
          <tr>
            <td width="220" rowspan="7" align="left" valign="top" ><table width="100%" border="0" cellspacing="5" cellpadding="5" id="imagenGrupo">
              <tr>
                <td align="center" valign="middle"><?php
			$caratula=$db->sql_row("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND etiqueta='Imagen' AND orden='0'");
			
			$trayectoria=$db->sql_row("SELECT * FROM grupos_musica WHERE id='".$frm["id_grupo"]."'");
			 
			 if($caratula["id"]!=""){
			 ?>
                  <img src="http://2013.circulart.org/m/admin/imagen.php?table=archivos_grupos_musica&amp;field=archivo&amp;id=<?php echo $caratula["id"];?>" width="200" />
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php } else
			  {  
			  ?>
                  <img src="http://circulart.org/circulart2013/m/images/mercados/imagen.jpg" width="200" />
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php  
				  }?>
                <a href="#" id="fancybox-manual-b">Editar imagen</a><br />
</td>
              </tr>
            </table></td>
            <td width="145" align="left" valign="top" class="colorTexto">(*) Nombre del grupo o del artista:</td>
            <td colspan="2" align="left" valign="top" ><table class="nombre"width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="nombre" type="text" id="nombre" size="58" value="<?=nvl($frm["nombre"])?>" onkeypress="return soloLetras(event)" onblur="limpia()"/></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto"><p>(*) Breve descripci&oacute;n:<br />
              (700 caracteres)
            </p></td>
            <td colspan="2" align="left" valign="top" ><table class="resena" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><textarea name="resena_corta" id="resena_corta" cols="45" rows="15"><?=nvl($frm["resena_corta"])?>
                  </textarea></td>
                </tr>
              </table>
            <em><div id="chars" style=""></div></em></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Breve descripci&oacute;n en ingles:<br />
(700 caracteres)</td>
            <td colspan="2" align="left" valign="top"><table  class="resena2"width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><textarea name="en_resena_corta" id="en_resena_corta" cols="45" rows="15"><?=nvl($frm["en_resena_corta"])?>
                  </textarea></td>
              </tr>
              </table>
            <em><div id="chars3" style=""></div></em></td>
          </tr>
          
          
          <tr>
            <td align="left" valign="top" class="colorTexto generos">(*) G&eacute;nero: </td>
            <td colspan="2" align="left" valign="top" class="generos">
             <?php 
					
					$g1=0; $g2=0; $g3=0; $g4=0; $g5=0; $g6=0; $g7=0; $g8=0; $g9=0; $g10=0; $g11=0; $g12=0; $g13=0; $g14=0; $g15=0; $g16=0; $g17=0; $g18=0; $g19=0; 
								 
			   $generos=$db->sql_query("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$frm["id_grupo"]."'");
				
				while($generos_artista=$db->sql_fetchrow($generos)){
			   	   if($generos_artista["id_generos_musica"]==42){$g1=1;} 
				   if($generos_artista["id_generos_musica"]==10){$g2=1;} 
				   if($generos_artista["id_generos_musica"]==11){$g3=1;} 
				   if($generos_artista["id_generos_musica"]==6){$g4=1;} 
				   if($generos_artista["id_generos_musica"]==5){$g5=1;} 
				   if($generos_artista["id_generos_musica"]==22){$g6=1;} 
				   if($generos_artista["id_generos_musica"]==20){$g7=1;} 
				   if($generos_artista["id_generos_musica"]==45){$g8=1;} 
				   if($generos_artista["id_generos_musica"]==38){$g9=1;} 
				   if($generos_artista["id_generos_musica"]==46){$g10=1;} 
				   if($generos_artista["id_generos_musica"]==44){$g11=1;} 
				   if($generos_artista["id_generos_musica"]==41){$g12=1;} 
				   if($generos_artista["id_generos_musica"]==7){$g13=1;} 
				   if($generos_artista["id_generos_musica"]==37){$g14=1;} 
				   if($generos_artista["id_generos_musica"]==4){$g15=1;} 
				   if($generos_artista["id_generos_musica"]==43){$g16=1;} 
				   if($generos_artista["id_generos_musica"]==13){$g17=1;} 
				   if($generos_artista["id_generos_musica"]==39){$g18=1;} 
				   if($generos_artista["id_generos_musica"]==40){$g19=1;} 
				}
				
			?>
            <input type="checkbox" name="genero1" id="genero1" <?php  if($g1==1){echo "checked='checked'";}else{}?>  />Acústico
            <br /><input type="checkbox" name="genero2" id="genero2" <?php if($g2==1){echo "checked='checked'";}else{}?>  />Contemporánea
            <br /><input type="checkbox" name="genero3" id="genero3" <?php if($g3==1){echo "checked='checked'";}else{}?>  />Electrónica
            <br /><input type="checkbox" name="genero4" id="genero4" <?php if($g4==1){echo "checked='checked'";}else{}?>  />Electrónico Latino
            <br /><input type="checkbox" name="genero5" id="genero5" <?php if($g5==1){echo "checked='checked'";}else{}?>  />Fusión
            <br /><input type="checkbox" name="genero6" id="genero6" <?php if($g6==1){echo "checked='checked'";}else{}?>  />Hip Hop &amp; Rap
            <br /><input type="checkbox" name="genero7" id="genero7" <?php if($g7==1){echo "checked='checked'";}else{}?>  />Jazz
            <br /><input type="checkbox" name="genero8" id="genero8" <?php if($g8==1){echo "checked='checked'";}else{}?>  />Metal
            <br /><input type="checkbox" name="genero9" id="genero9" <?php if($g9==1){echo "checked='checked'";}else{}?>  />Pop
            <br /><input type="checkbox" name="genero10" id="genero10" <?php if($g10==1){echo "checked='checked'";}else{}?>  />Pop alternativo
            <br /><input type="checkbox" name="genero11" id="genero11" <?php if($g11==1){echo "checked='checked'";}else{}?>  />Punk/Hardcore
            <br /><input type="checkbox" name="genero12" id="genero12" <?php if($g12==1){echo "checked='checked'";}else{}?>  />Reggae
            <br /><input type="checkbox" name="genero13" id="genero13" <?php if($g13==1){echo "checked='checked'";}else{}?>  />Rock &amp; Alternative
            <br /><input type="checkbox" name="genero14" id="genero14" <?php if($g14==1){echo "checked='checked'";}else{}?>  />Rock Latino
            <br /><input type="checkbox" name="genero15" id="genero15" <?php if($g15==1){echo "checked='checked'";}else{}?>  />Salsa &amp; Son
            <br /><input type="checkbox" name="genero16" id="genero16" <?php if($g16==1){echo "checked='checked'";}else{}?>  />Ska
            <br /><input type="checkbox" name="genero17" id="genero17" <?php if($g17==1){echo "checked='checked'";}else{}?>  />Tradicional
            <br /><input type="checkbox" name="genero18" id="genero18" <?php if($g18==1){echo "checked='checked'";}else{}?>  />Tropical
            <br /><input type="checkbox" name="genero19" id="genero19" <?php if($g19==1){echo "checked='checked'";}else{}?>  />Vocal &amp; Capella
</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Pa&iacute;s:</td>
            <td colspan="2" align="left" valign="top" class="id_pais">
              
                <?php 
			$pais=$db->sql_row("SELECT * FROM grupos_musica WHERE id='".$frm["id_grupo"]."'");
			?>
             
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_pais">
                <tr>
                  <td align="center"><select name="id_pais" id="id_pais" style="width:85%">
                    <option value="%"  <?php if($propuesta["id_pais"]==0){echo "selected";}else{}?>>Seleccione...</option>
                    <option value="1" <?php if($propuesta["id_pais"]==1){echo "selected";}else{}?>>Argentina</option>
                    <option value="2" <?php if($propuesta["id_pais"]==1){echo "selected";}else{}?>>Bolivia</option>
                    <option value="23" <?php if($propuesta["id_pais"]==23){echo "selected";}else{}?> >Brasil</option>
                    <option value="23" <?php if($propuesta["id_pais"]==25){echo "selected";}else{}?> >Canada</option>
                    <option value="3" <?php if($propuesta["id_pais"]==3){echo "selected";}else{}?>>Chile</option>
                    <option value="4" <?php if($propuesta["id_pais"]==4){echo "selected";}else{}?>>Colombia</option>
                    <option value="5" <?php if($propuesta["id_pais"]==5){echo "selected";}else{}?>>Costa Rica</option>
                    <option value="6" <?php if($propuesta["id_pais"]==6){echo "selected";}else{}?>>Cuba</option>
                    <option value="7" <?php if($propuesta["id_pais"]==7){echo "selected";}else{}?>>Ecuador</option>
                    <option value="8" <?php if($propuesta["id_pais"]==8){echo "selected";}else{}?>>El Salvador</option>
                    <option value="9" <?php if($propuesta["id_pais"]==9){echo "selected";}else{}?>>España</option>
                    <option value="24" <?php if($propuesta["id_pais"]==24){echo "selected";}else{}?>>Francia</option>
                    <option value="10" <?php if($propuesta["id_pais"]==10){echo "selected";}else{}?>>Guatemala</option>
                    <option value="11" <?php if($propuesta["id_pais"]==11){echo "selected";}else{}?>>Honduras</option>
                    <option value="12" <?php if($propuesta["id_pais"]==12){echo "selected";}else{}?>>México</option>
                    <option value="13" <?php if($propuesta["id_pais"]==13){echo "selected";}else{}?>>Nicaragua</option>
                    <option value="14" <?php if($propuesta["id_pais"]==14){echo "selected";}else{}?>>Panamá</option>
                    <option value="15" <?php if($propuesta["id_pais"]==15){echo "selected";}else{}?>>Paraguay</option>
                    <option value="16" <?php if($propuesta["id_pais"]==16){echo "selected";}else{}?>>Perú</option>
                    <option value="17" <?php if($propuesta["id_pais"]==17){echo "selected";}else{}?>>Puerto Rico</option>
                    <option value="18" <?php if($propuesta["id_pais"]==18){echo "selected";}else{}?>>República Dominicana</option>
                    <option value="19" <?php if($propuesta["id_pais"]==19){echo "selected";}else{}?>>Uruguay</option>
                    <option value="20" <?php if($propuesta["id_pais"]==20){echo "selected";}else{}?>>Venezuela</option>
                  </select></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Ciudad:</td>
            <td colspan="2" align="left" valign="top" ><table class="ciudad" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="ciudad" type="text" id="ciudad" size="58" value="<?=nvl($frm["ciudad"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Direcci&oacute;n:</td>
            <td colspan="2" align="left" valign="top" ><table class="direccion" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="direccion" type="text" id="direccion" size="58" value="<?=nvl($frm["direccion"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Tel&eacute;fono:<br /></td>
            <td colspan="2" align="center" valign="top" ><table class="telefono" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="telefono" type="text" id="telefono" size="58" value="<?=nvl($frm["telefono"])?>" /></td>
              </tr>
            </table>
            <span class="colorTexto"><em><strong>Incluir el prefijo del pa&iacute;s  y de la ciudad. Ejemplo: 57 1 XXXXXX</strong></em></span></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Tel&eacute;fono dos:</td>
            <td colspan="2" align="center" valign="top"><input name="telefono2" type="text" id="telefono2" size="58" value="<?=nvl($frm["telefono2"])?>" />
            <br />
            <em><strong>Incluir el prefijo del pa&iacute;s  y de la ciudad. Ejemplo: 57 1 XXXXXX</strong></em></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Correo: </td>
            <td colspan="2" align="left" valign="top" ><table class="email" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="email" type="text" id="telefono3" size="58" value="<?=nvl($frm["email"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Correo dos:</td>
            <td colspan="2" align="center" valign="top"><input name="email2" type="text" id="email2" size="58" value="<?=nvl($frm["email2"])?>" /></td>
          </tr>
          <tr>
            <td height="32" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">(*) Nombre del Contacto:</span></td>
            <td colspan="2" align="left" valign="top" ><table class="contacto" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="contacto" id="contacto" size="58" value="<?=nvl($frm["contacto"])?>" /></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="33" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) C&eacute;dula del contacto:</td>
            <td colspan="2" align="left" valign="top" ><table class="cc1" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="contacto_cc" id="contacto_cc" size="58" value="<?=nvl($frm["contacto_cc"])?>" /></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="88" align="left" valign="top"><em><strong>&quot;Recuerde guardar los datos, antes de subir im&aacute;genes,  archivos PDF's y de continuar.&quot;</strong></em></td>
            <td align="left" valign="top" class="colorTexto" >(*) Trayectoria en pdf:</td>
            <td colspan="2" align="left" valign="top"><br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="trayec" height="150">
                <tr>
    <td align="center"><input type="hidden" name="trayectoria"  id="trayectoria" size="20" value="<?php echo $trayectoria["mmdd_trayectoria_filename"];?>" />
      <a href="#" id="fancybox-manual-a">Subir PDF [Editar]</a>
      <!-- se activa si el artista ya subio una trayectoria --->
      <?php if($trayectoria["mmdd_trayectoria_filename"]!=""){?>
      <a href="http://2013.circulart.org/m/fileFSpdf.php?table=grupos_musica&field=trayectoria&id=<?php echo $frm["id_grupo"]?>" target="_blank" >Ver archivo</a><br />
      <?php }?>
      <br />
      <br />
      <em><strong>Archivo PDF de la trayectoria, discograf&iacute;a o historia donde muestre   la experiencia art&iacute;stica.</strong></em></td>
  </tr>
</table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*)Website:</td>
            <td colspan="2" align="left" valign="top" ><table class="website1" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="website" id="website" size="58" value="<?=nvl($frm["website"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Facebook:</td>
            <td colspan="2" align="center" valign="top"><input name="facebook" id="facebook" size="58" value="<?=nvl($frm["facebook"])?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Twitter:</td>
            <td colspan="2" align="center" valign="top"><input name="twitter" id="twitter" size="58" value="<?=nvl($frm["twitter"])?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"></td>
            <td colspan="3" align="left" valign="top" class="colorTexto "><hr /></td>
          </tr>
          <tr>
            <td height="67" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto rut"><span class="colorTexto ">Entidades o empresas:</span></td>
            <td colspan="2" align="center" valign="top" class="rut"><input name="empresa" id="empresa" size="58" value="<?=nvl($frm["empresa"])?>" />
              <br />
            <em><strong>(Entidades o empresas que lo representan legalmente)</strong></em></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">N&uacute;mero de identificaci&oacute;n de la empresa:<br /></td>
            <td colspan="2" align="center" valign="top" class=""><span class="rut">
              <input name="nit" id="nit" size="58" value="<?=nvl($frm["nit"])?>" />
            </span><span class="colorTexto"><br />
            <strong><em>(Colombia NIT o RUT)</em></strong><em></em></span></td>
          </tr>

<?if($frm["area"]=="musica"){?>
          <tr>
            <td height="129" align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top" class="colorTexto personas"><hr />
            En caso de quedar seleccionado(s) indique el nombre y documento de la(s) persona(s) que lo(s) representar&aacute;(n) en las citas de la Rueda de Negocios.<br />
            <br /><a href="#" id="fancybox-manual-e">Agregar[+]</a></td>
          </tr>
          
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top"><input type="hidden" name="personas"  id="personas" size="20" value="<?php 
			
			$numero=$db->sql_query("select count(*) from vinculados WHERE id_grupo_musica='".$frm['id_grupo']."' ORDER BY id");
			$resultado=$db->sql_fetchrow($numero);
			echo $resultado[0];?>" />
              <?php 
		  
		  $id_persona=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_musica='".$frm['id_grupo']."' ORDER BY id");
			
		  while($vinculo=$db->sql_fetchrow($id_persona)){
			  
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="29%">&nbsp;</td>
    <td width="35%">&nbsp;</td>
    <td width="36%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="colorTexto ">Foto:</td>
    <td width="35%"><?php if($vinculo["foto"]==1){?><img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/files/vinculados/foto/<?php echo $vinculo["id"]; ?>&amp;w=80" border="0"><?php } ?></td>
    <td width="36%"><a href="codigos/eliminar.php?persona=<?php echo $vinculo["id"];?>&modo=<?=$seccion?>&mode=paso_2muestra&id_usuario=<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=$frm["id_grupo"]?>">Quitar persona</a></td>
  </tr>
  <tr>
    <td class="colorTexto ">Nombre:</td>
    <td><?php echo $vinculo["nombre"]; ?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="colorTexto ">Documento:</td>
    <td><?php echo$vinculo["documento"]; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>

        <br />
        
        <?php 
			  
			  }
		  
		  ?>&nbsp;</td>
          </tr>
<?}?>

          <tr>
            <td height="49" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="354" align="left" valign="top"><br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br /></td>
            <td width="70" align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
        <div id="column-left">
        <hr style="border-bottom-style: dashed; border-bottom-width: 1px; width:905px; text-align:center; margin-left:10px;"/>
        <table width="910" align="center" cellpadding="10" cellspacing="10"  class="blanco" style="margin-top: -5px; font-weight: bold;">
          <td width="110" height="46" align="left" valign="top"><input type="submit" id="submit_button" value="Guardar Datos" style="background-color:#F17126; color:#fff; font-weight:bold; border-color:#F17126;"/></td>
            <td align="left" valign="top"><em><strong>&quot;Recuerde guardar los datos, antes de subir im&aacute;genes,  archivos PDF's y de continuar.&quot;</strong></em></td>
            <td width="74" align="left" valign="top"><a href="#" onclick="revisar(entryform)" class="link">Continuar</a></td>
        </table>
        </div>
		</form>
      
