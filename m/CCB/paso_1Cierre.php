    <!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>m/js/lib/jquery-1.9.0.min.js"></script>
<script>
function revisar(frm){
	if(frm.email.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: e-mail');
		frm.email.focus();
		return(false);
	}
	else{
		var regexpression=/@.*\./;
		if(!regexpression.test(frm.email.value)){
			window.alert('[e-mail] no contiene un dato válido.');
			frm.email.focus();
			return(false);
		}
	}
	
	if(frm.nombre.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: Nombre del grupo o del artista');
		frm.login.focus();
		return(false);
	}
	
	
	if(frm.login.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: usuario');
		frm.login.focus();
		return(false);
	}
	else{
		var regexpression=/./;
		if(!regexpression.test(frm.login.value)){
			window.alert('[Login] no contiene un dato válido.');
			frm.login.focus();
			return(false);
		}
	}
	if(frm.password.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: password');
		frm.password.focus();
		return(false);
	}
	else{
		var regexpression=/./;
		if(!regexpression.test(frm.password.value)){
			window.alert('[Password] no contiene un dato válido.');
			frm.password.focus();
			return(false);
		}
	}
	if(frm.password.value != frm.__CONFIRM_password.value){
		window.alert('La confirmación de Password no corresponde.');
		frm.password.focus();
		return(false);
	}
	if(!document.getElementById('terminos').checked){
		window.alert('Para continuar con la inscripción debe aceptar los términos y condiciones.');
		return(false);
	}
	return(true);
}

function revisar2(frm){
	if(frm.login.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba el usuario');
		frm.login.focus();
		return(false);
	}
	if(frm.password.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba la clave');
		frm.password.focus();
		return(false);
	}
	return(true);
}


$(document).ready(function() {

	$('#terminos').click( function() {
	  if($(this).is(':checked')){
		$('#textoverifica').slideDown("slow")
	  }else{
		$('#textoverifica').slideUp("slow")
	  }
	})

})

</script>
<style type="text/css">
.colorTexto {
	text-align: center;
}
</style>

<table width="910" border="0" cellspacing="10" cellpadding="10" bgcolor="#E7D8B1">
  <tr>
			    <td class="colorTexto">Gracias por participar en esta convocatoria de &quot;Hecho en Centroamerica&quot;.<br />
Espere la publicaci&oacute;n de los seleccionados en la p&aacute;gina del <strong>Circulart2013</strong></span><strong></strong></td>
  </tr>
</table>
