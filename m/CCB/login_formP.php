<script>
function revisar(frm){
	if(frm.login.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: usuario');
		frm.login.focus();
		return(false);
	}
	if(frm.password.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: password');
		frm.password.focus();
		return(false);
	}
	
	<? if ($CFG->mercado!=21){ ?>
	if(!document.getElementById('terminos').checked){
		window.alert('Para continuar con la inscripción debe aceptar los términos y condiciones.');
		return(false);
	}
	<? } ?>
	return(true);
}

function copy(){
	document.getElementById('password2').value=document.getElementById('password').value; 
	
	
	}


</script>
 <!-- este codigo es para VIA 2012 --->
	<? if ($CFG->mercado==21){?>
		<style>
			 h1 {
				/*background-color:#fff;*/
				background-color:#005BAA;
				color:#FFFFFF;
				padding:5px;
				font-weight:normal;
				margin:0px;
				font-size:14pt;
			}
			.azul{
				background-color:#005BAA;
				color:#FFF;
				font-size:20px;
				padding:5px;}
			.margenp{
				margin-left:10px;
				font-size:12px;
				
				}	
			#disciplina{
				position:absolute;
				top:20;}	
        </style>
 <? }?>  
<!-- finde código --> 

<div style="width:550px; margin-left:240px; float:left;">
			<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>" method="post" enctype="multipart/form-data" onSubmit="return revisar(this)">
			<input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="<?=$newMode?>" />
            <input type="hidden" name="mercado" value="<?=$CFG->mercado?>" />
			<input type="hidden" name="password2" id="password" value=""/></label>
        
        <!-- codigo para via -->
        <? if ($CFG->mercado!=21){?>
        <h1>Acuerdo</h1>
       <p>Declaro que he le&iacute;do, entendido y aceptado el contenido del Reglamento de la Convocatoria en su integridad. Asumir&eacute; las implicaciones que se ocasionen con la presentaci&oacute;n de mi propuesta, sin implicar en alg&uacute;n tipo de responsabilidad a los organizadores de Circulart 2011: Segundo Mercado Cultural de Medell&iacute;n.</p> 
        <? } ?>
        
       <? if ($CFG->mercado!=21){?>
        <h1>Acuerdo</h1>
       <p><strong>Declaro que he le&iacute;do, entendido y aceptado el contenido del Reglamento de la Convocatoria en su integridad. Asumir&eacute; las implicaciones que se ocasionen con la presentaci&oacute;n de mi propuesta, sin implicar en alg&uacute;n tipo de responsabilidad a la Ventana Internacional de las Artes -VIA- del Festival Iberoamericano de teatro de Bogot&aacute</strong> </p> 
        <? } ?>
        
        
        
        <? if ($CFG->mercado==21){?>
        <h1>Herramienta de Actualización de datos /   Data&nbsp;Update Tool </h1>
       <p class="margenp"><strong>Ingrese el Usuario y la Contraseña /  Enter the&nbsp;Username&nbsp;and Password </strong></p> 
        <? } ?>
        <!-------------------->
        <?if(isset($frm["error"])) echo "<h2><font color=\"#FF0000\">Error: $frm[error]</font></h2>"?>
        <table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="197"><strong>(*) Usuario/login:</strong></td>
            <td width="268"><label>
              <input type="text" name="login" id="login" value="<?=nvl($frm["login"])?>" />
            </label></td>
          </tr>
          <tr>
            <td><strong>(*) Contrase&ntilde;a/Password:</strong></td>
            <td><label><input type="password" name="password" id="password"  onchange="copy()"/>
            </td>
          </tr>
           <? if ($CFG->mercado!=21){?>
          <tr>
            <td><strong>(*) He le&iacute;do y acepto los t&eacute;rminos y condiciones:</strong></td>
            <td><label><input type="checkbox" id="terminos" ></label></td>
          </tr>
          <? } ?>
          <tr>
            <td>&nbsp;</td>
            <td><label><input type="submit" id="button" value="Participar/Participate" /></label></td>
          </tr>
        </table>
 
		 </form>
     </div>
