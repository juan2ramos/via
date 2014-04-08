<style>
input[type=checkbox]{
	width:30px;}
table{
	font-size:14px;}	
</style>
<script>
function revisar(frm){
	
	if(!document.getElementById('terminos').checked){
		window.alert('Para terminar debe aceptar los términos y condiciones, como el manejo de datos.');
		return(false);
	}
	
	
	
	document.getElementById('submit_button').value='Enviando información...';
	document.getElementById('submit_button').disabled=true;
	return(true);
}
</script>


		<form name="entryform" action="index.php?modo=inscripciones" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			<input type="hidden" name="modo" value="<?=$seccion?>" />
			<input type="hidden" name="mode" value="confirmar_inscripcion">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
            
            <? 
			$id_usuario=$frm["id_usuario"];
			$area=$frm["area"];
			$id_grupo=$frm["id_grupo"];
			?>
		<table width="95%" border="0" cellspacing="10" cellpadding="10" >
			  <tr>
			    <td>
			      <div class="textoR">
                     <p>En cumplimiento de la <strong>ley 1581 de 2012</strong> nos permitimos informarle que <strong>CIRCULART</strong> - <strong>VIA</strong> contar&aacute; con los datos personales que ser&aacute;n solicitados en el momento de su inscripci&oacute;n. Esta informaci&oacute;n ser&aacute; utilizada en el desarrollo de las actividades de Circulart - VIA, tales como divulgaci&oacute;n cultural, encuestas y dem&aacute;s actividades de uso ordinario de la plataforma.</p>
        <p>As&iacute; mismo, ser&aacute; utilizada para comunicarle a trav&eacute;s de correo electr&oacute;nico y-o mensajes de texto, sobre la programaci&oacute;n de eventos de <strong>CIRCULART</strong> - <strong>VIA </strong>y los eventos y servicios que prestan las entidades con las cuales tenemos convenios. Si usted desea mayor informaci&oacute;n sobre el manejo de sus datos personales o quiere ser excluido para no volver a recibir informaci&oacute;n de eventos o actividades, se puede comunicar a <strong>info@circulart.org.</strong></p>
        <p>Adicionalmente, usted podr&aacute; ejercer sus derechos a conocer, actualizar, rectificar y solicitar la supresi&oacute;n de sus datos personales, a trav&eacute;s del correo electr&oacute;nico indicado.
        
        </p>
                 
                    <p> <strong>
                     <?php 

 $frm=$db->sql_row("SELECT * FROM grupos_".$frm["area"]." WHERE id='$frm[id_grupo]'");

?>
               
               
                    <input type="checkbox" name="terminos" id="terminos"  <?php if($frm["terminos"]=='1'){echo "checked='checked'";}else{}?>/>
                      <label for="terminos" style="color:#FFF">He le&iacute;do y acepto los t&eacute;rminos y condiciones de la convocatoria como las condiciones de manejo de datos por parte de Circulart - VIA.</label>
                    </strong></div></p>
                    <label><br />
                    </label>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="10%" rowspan="2"><label><a id="regresar" style="color:#FFF" href="index.php?modo=<?=$seccion?>&mode=paso_3muestra&id_usuario=<?=$id_usuario?>&area=<?=$area?>&id_grupo=<?=$id_grupo?>"><div id="agregar" style="text-align:center; margin-top:10px; margin-bottom:20px; padding:15px; background-color:#F00; width:150px; font-size:14px; text-decoration:none; cursor:pointer; text-transform: uppercase">Regresar</div></a></label></td>
                      <td width="59%" rowspan="2">&nbsp;</td>
                      <td width="16%">&nbsp;</td>
                      <td width="15%" rowspan="2" align="right" valign="top"><input type="submit" id="submit_button2" value="Terminar" style="width:180px; font-size:14px; background-color:#F17126; color:#fff;  border-color:#F17126; padding:15px; text-transform:uppercase; cursor:pointer"/></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </td>
		      </tr>
	    </table>
		