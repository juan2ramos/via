<link rel="stylesheet" type="text/css" href="<?php echo $CFG->dirwww;?>circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
 <!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>
<script>
function revisar(frm){
	
	if(!document.getElementById('terminos').checked){
		window.alert('Para terminar con la inscripción debe aceptar los términos y condiciones, como el manejo de datos.');
		return(false);
	}
	
	
	
	document.getElementById('submit_button').value='Enviando información...';
	document.getElementById('submit_button').disabled=true;
	return(true);
}
$(document).ready(function() {
					
					$("#fancybox-manual-f").click(function() {
						$.fancybox.open({
							href : 'index.php?modo=inscripciones&mode=vertodo&id_usuario<?=$frm["id_usuario"]?>&area=<?=$frm["area"]?>&id_grupo=<?=nvl($frm["id_grupo"])?>',
							padding : 5,
							height :600,
							width  :1010,
							autoSize: false,
							type : 'iframe'
						});
					});
	 });
</script>


		<form name="entryform" action="index.php?modo=inscripciones&mercado=<?=$CFG->mercado?>&a=<?php echo$_GET["a"];?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			<input type="hidden" name="modo" value="<?=$seccion?>" />
			<input type="hidden" name="mode" value="confirmar_inscripcion">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
		<table width="900" border="0" cellspacing="10" cellpadding="10" bgcolor="#E7D8B1">
			  <tr>
			    <td><h1>Env&iacute;o definitivo de la inscripci&oacute;n</h1></p>			      Haga clic en 'Confirmar inscripción' para enviar su solicitud. Al hacerlo entiende que<strong> NO</strong> podrá editar, borrar, ni adjuntar mas información a la cuenta y que el jurado recibirá su inscripción tal y como usted la ha elaborado hasta este punto. Recibirá un correo electrónico notificándole su inscripción definitiva a Circulart2013.
                    <label><br />
                      <hr />
                    </label>              <div style="font-size:12px; background-color:#F5F0DE; padding:10px;">   <p> En cumplimiento de la <strong>ley 1581 de 2012</strong> nos permitimos informarle que <strong>CIRCULART</strong> contar&aacute; con los datos personales que ser&aacute;n solicitados en el momento de su inscripci&oacute;n. Esta informaci&oacute;n ser&aacute; utilizada en el desarrollo de las actividades de Circulart, tales como divulgaci&oacute;n cultural, encuestas y dem&aacute;s actividades de uso ordinario de la plataforma.
                      <p>As&iacute; mismo, ser&aacute; utilizada para comunicarle a trav&eacute;s de correo electr&oacute;nico y/o mensajes de texto, sobre la programaci&oacute;n de eventos de <strong>CIRCULART</strong> y los eventos y servicios que prestan las entidades con las cuales tenemos convenios. Si usted desea mayor informaci&oacute;n sobre el manejo de sus datos personales o quiere ser excluido para no volver a recibir informaci&oacute;n de eventos o actividades, se puede comunicar a <strong>info@circulart.org.</strong></p>
                      <p>Adicionalmente, usted podr&aacute; ejercer sus derechos a conocer, actualizar, rectificar y solicitar la supresi&oacute;n de sus datos personales, a trav&eacute;s del correo electr&oacute;nico indicado. </p>
                 
                    <p> <strong>
                     <?php 

 $frm=$db->sql_row("SELECT * FROM grupos_musica WHERE id='$frm[id_grupo]'");

?>
               
               
                    <input type="checkbox" name="terminos" id="terminos"  <?php if($frm["terminos"]=='1'){echo "checked='checked'";}else{}?>/>
                      <label for="terminos">He le&iacute;do y acepto los t&eacute;rminos y condiciones de la convocatoria como las condiciones de manejo de datos por parte de Circulart.</label>
                    </strong></div></p>
                    <label><br />
                    </label>
                  <table width="870" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="10%"><label><a href="index.php?modo=<?=$seccion?>&amp;mode=paso_4muestra&amp;id_usuario=<?=$frm["id_usuario"]?>&amp;area=<?=$frm["area"]?>&amp;id_grupo=<?=$frm["id_grupo"]?>&a=<?php echo$_GET["a"];?>">Regresar</a></label></td>
                      <td width="59%"><label><a href="#" id="fancybox-manual-f">Ver los datos ingresados</a></label></td>
                      <td width="16%"><input type="submit" id="submit_button2" value="Confirmar inscripci&oacute;n"  class="link" style="background-color:#F17126; color:#fff; font-weight:bold; border-color:#F17126; cursor:pointer"/></td>
                      <td width="15%"><input type="button" value="Continuar m&aacute;s tarde" onclick="window.location.href='index.php?modo=inscripciones'" style="font-weight:bold; height:40px; cursor:pointer;"/></td>
                    </tr>
                  </table>
                  <label>                  </label></td>
		      </tr>
	    </table>
			<h1>&nbsp;</h1>