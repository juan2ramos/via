    <!-- Add jQuery library -->
<script>
check=0;
function seleccion(i){
	check=i;
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
	
	 
    if(check==0){
		window.alert('Seleccione el área [TEATRO o DANZA]');
		return(false);
		
		}
     
	
	
	return(true);
}






</script>
<style>
.textoR{
	text-align:justify;}
#nuevos{
	width:94%;
	}	
	
#formularionuevos{
width:100%;
	text-align:center;
	}	

input[type=radio]{
	width:30px;}	
</style>

<br />
<div>
    <div class="textoR">
            <p>En cumplimiento de la <strong>ley 1581 de 2012</strong> nos permitimos informarle que <strong>CIRCULART</strong> - <strong>VIA</strong> contar&aacute; con los datos personales que ser&aacute;n solicitados en el momento de su inscripci&oacute;n. Esta informaci&oacute;n ser&aacute; utilizada en el desarrollo de las actividades de Circulart - VIA, tales como divulgaci&oacute;n cultural, encuestas y dem&aacute;s actividades de uso ordinario de la plataforma.</p>
            <p>As&iacute; mismo, ser&aacute; utilizada para comunicarle a trav&eacute;s de correo electr&oacute;nico y-o mensajes de texto, sobre la programaci&oacute;n de eventos de <strong>CIRCULART</strong> - <strong>VIA </strong>y los eventos y servicios que prestan las entidades con las cuales tenemos convenios. Si usted desea mayor informaci&oacute;n sobre el manejo de sus datos personales o quiere ser excluido para no volver a recibir informaci&oacute;n de eventos o actividades, se puede comunicar a <strong>info@circulart.org.</strong></p>
            <p>Adicionalmente, usted podr&aacute; ejercer sus derechos a conocer, actualizar, rectificar y solicitar la supresi&oacute;n de sus datos personales, a trav&eacute;s del correo electr&oacute;nico indicado.</p>
    </div>
    <div id="formularios">
        <div id="nuevos">
        <div class="titulo_registro">
        Herramienta de actualización de datos.
        </div>
        <div>
        <form action="index.php" method="post" enctype="multipart/form-data" name="entryform" id="entryform2" onsubmit="return revisar2(this)">
      <input type="hidden" name="modo" value="<?=$seccion?>" />
      <input type="hidden" name="mode" value="acceso" />
      <input type="hidden" name="mercado" value="<?=$CFG->mercado?>" />
        <!-------------------->
      <?if(isset($frm["error2"])) echo "<h3><font color=\"#F17126\">Error: $frm[error2]</font></h3>"?>
      <div id="formularionuevos">
         <div class="titulos_formularios">Usuario<span>*</span><label>
            <br />
            <input type="text" name="login" id="login" value="<?=nvl($frm["login"])?>" />
          </label></div>
         <div class="titulos_formularios">Contrase&ntilde;a<span>*</span><label>
            <br />
            <input type="password" name="password" id="password"  onchange="copy()"/>
          </label></div>
        <div class="titulos_formularios">&Aacute;rea art&iacute;stica<span>*</span>
          <label> <br />
            <br />
            <input type="radio" name="area" id="area" value="teatro" onclick="seleccion(1)" />
              Teatro
            <input type="radio" name="area" id="area" value="danza"  onclick="seleccion(2)"/>
              Danza<br />
          <br />
          </label>
          </div>
         <div class="titulos_formularios"><label>
            <input type="submit" id="button2" value="Entrar" />
          </label></div>
      </div>
    
    </form>
    <div>
        </div>
   </div>     
</div>
