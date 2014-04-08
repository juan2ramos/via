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
		window.alert('Para continuar con la pre-inscripción debe aceptar las condiciones de manejo de datos.');
		return(false);
	}
	
	return(true);
}
</script>


		<style>
			
        body p {
	text-align: justify;
}
        </style>

<script>

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

 

<div >
<div class="textoR">
        <p>En cumplimiento de la <strong>ley 1581 de 2012</strong> nos permitimos informarle que <strong>CIRCULART</strong> - <strong>VIA</strong> contar&aacute; con los datos personales que ser&aacute;n solicitados en el momento de su inscripci&oacute;n. Esta informaci&oacute;n ser&aacute; utilizada en el desarrollo de las actividades de Circulart - VIA, tales como divulgaci&oacute;n cultural, encuestas y dem&aacute;s actividades de uso ordinario de la plataforma.</p>
        <p>As&iacute; mismo, ser&aacute; utilizada para comunicarle a trav&eacute;s de correo electr&oacute;nico y-o mensajes de texto, sobre la programaci&oacute;n de eventos de <strong>CIRCULART</strong> - <strong>VIA </strong>y los eventos y servicios que prestan las entidades con las cuales tenemos convenios. Si usted desea mayor informaci&oacute;n sobre el manejo de sus datos personales o quiere ser excluido para no volver a recibir informaci&oacute;n de eventos o actividades, se puede comunicar a <strong>info@circulart.org.</strong></p>
        <p>Adicionalmente, usted podr&aacute; ejercer sus derechos a conocer, actualizar, rectificar y solicitar la supresi&oacute;n de sus datos personales, a trav&eacute;s del correo electr&oacute;nico indicado.
        
        </p>
</div>


<div id="formularios">
<div id="nuevos"><form action="index.php?mercado=<?=$CFG->mercado?>" method="post" enctype="multipart/form-data" name="entryform" id="entryform2" onsubmit="return revisar(this)">
      <input type="hidden" name="modo" value="<?=$seccion?>" />
      <input type="hidden" name="mode" value="paso_2" />
      <div class="titulo_registro">Profesionales Nuevos 
            -              New Professionals</div>
      </p>
      S&iacute; no ha participado en  alguno de nuestros mercados, ingrese los datos solicitados en este formulario.<br />
      <br />
            - <strong> If  you have not participated in any of our markets, enter the information  requested on this form starting with user and password of your choice.</strong>
  <?if(isset($frm["error"])) echo "<br><br><strong><div class='error'>Error: $frm[error]</div></strong>"?>
  <div id="formularionuevos">
   <div class="titulos_formularios">Correo <strong>- E-mail </strong><span>*</span><br />
        <input name="email1" type="text" id="email" value="<?=nvl($frm["email1"])?>" /></div>
   <div class="titulos_formularios">Usuario <strong>- login </strong><span>*</span><br />
  <input type="text" name="login" id="login" value="<?=nvl($frm["login"])?>" />
      </div>
   <div class="titulos_formularios">Contrase&ntilde;a<strong> - Password </strong><span>*</span><br />
        <input type="password" name="password" id="password3" />
      </div>
   <div class="titulos_formularios">Repetir contrase&ntilde;a<strong> - retype password  </strong><span>*</span><br />
        <input type="password" name="__CONFIRM_password" id="__CONFIRM_password" />
      </div>
   <div class="titulos_formularios">Acepto las condiciones de manejo de datos 
            
          - <strong> I accept the terms of data management </strong><span>*</span>
            <label >
              <input type="checkbox" id="terminos" class="borde"/>
          </label>
       </div>
   <div class="titulos_formularios">
        <input type="submit" id="button" value="Enviar - Send" />
      </div>
  </div>
  
    </form>
</div>
<div id="antiguos"><form action="index.php?mercado=<?=$CFG->mercado?>" method="post" enctype="multipart/form-data" name="entryform" id="entryform" onsubmit="return revisar(this)">
      <input type="hidden" name="modo" value="<?=$seccion?>" />
      <input type="hidden" name="mode" value="acceso" />
      <input type="hidden" name="mercado" value="<?=$CFG->mercado?>" />
      <input type="hidden" name="password2" id="password2" value="0"/>
      </label>
      <div class="titulo_registro">
        Profesionales antiguos 
      -             Former Professionals </div>
      <p >Si ya realiz&oacute; el proceso de inscripci&oacute;n y quiere actualizar los datos o ha utilizado esta plataforma en otros mercados como VIA, Circulart, o las Ruedas de Negocios de la C&aacute;mara de Comercio de Bogot&aacute;, ingrese el usuario y la contrase&ntilde;a respectivas.<br />
        <br />
      - <strong>If you already registered in our platform from any of our previous markets, such as VIA, Circulart&nbsp;or&nbsp;the Bogota Business&nbsp;Market, and would like to update your information, log in here with&nbsp;your&nbsp;user and password</strong>.</p>
      <!-------------------->
      <?if(isset($frm["error2"])) echo "<br><br><strong><div class='error'>Error: $frm[error2]</div></strong>"?>
      <div id="formularionuevos">
         <div class="titulos_formularios">Usuario <strong>-</strong> <strong>login </strong><span>*</span><label>
            <br />
            <input type="text" name="login" id="login" value="<?=nvl($frm["login"])?>" />
          </label></div>
         <div class="titulos_formularios">Contrase&ntilde;a -<strong> Password </strong><span>*</span><label>
            <br />
            <input type="password" name="password" id="password"  onchange="copy()"/>
          </label></div>
         <div class="titulos_formularios"><label>
            <input type="submit" id="button2" value="Entrar - Enter" />
          </label></div>
      </div>
    </form></div>
</div>


<div>
   