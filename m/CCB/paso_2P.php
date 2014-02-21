<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
function revisar(frm){

	
	if(frm.nombre.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba su nombre');
		frm.nombre.focus();
		return(false);
	}
	
	if(frm.apellido.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba su apellido');
		frm.apellido.focus();
		return(false);
	}
	
	if(frm.resena.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba su reseña');
		frm.resena.focus();
		return(false);
	}
	
	if(frm.cargo.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese su cargo');
		frm.cargo.focus();
		return(false);
	}
	
	if(frm.telefono1.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese un número teléfonico');
		frm.telefono1.focus();
		return(false);
	}
	
	
	if(frm.email1.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: e-mail');
		frm.email1.focus();
		return(false);
	}
	else{
		var regexpression=/@.*\./;
		if(!regexpression.test(frm.email1.value)){
			window.alert('[e-mail] no contiene un dato válido.');
			frm.email1.focus();
			return(false);
		}
	}
	
	if(frm.pais.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese su pais de origen');
		frm.pais.focus();
		return(false);
	}
	
	if(frm.ciudad.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese su ciudad de origen');
		frm.ciudad.focus();
		return(false);
	}
	

	if(frm.empresa.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese el nombre de la empresa');
		frm.empresa.focus();
		return(false);
	}
	
	
	if(frm.direccion_emp.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese la dirección de la empresa');
		frm.direccion_emp.focus();
		return(false);
	}
	
	if(frm.nit.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese el nit de la empresa');
		frm.nit.focus();
		return(false);
	}
	
	if(frm.telefono_emp.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese el teléfono de la empresa');
		frm.telefono_emp.focus();
		return(false);
	}
	
	
	
	if(frm.email_emp.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: e-mail de la empresa');
		frm.email_emp.focus();
		return(false);
	}
	else{
		var regexpression=/@.*\./;
		if(!regexpression.test(frm.email1.value)){
			window.alert('[e-mail] no contiene un dato válido.');
			frm.email_emp.focus();
			return(false);
		}
	}
	
	
	
	if(frm.ciudad_emp.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese la ciudad de la empresa');
		frm.ciudad_emp.focus();
		return(false);
	}
	
	if(frm.pais_emp.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese el país de la empresa');
		frm.pais_emp.focus();
		return(false);
	}
	
	if(frm.observaciones.value.replace(/ /g, '') ==''){
		window.alert('Por favor ingrese una descripcion de la empresa');
		frm.observaciones.focus();
		return(false);
	}
	
	return(true);
}

function numeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "1234567890- ";
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

function sololetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnopqrstuvwxyzáéíóúñ ";
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
					$("#resena").limiter(1024, elem);
					
					var elem = $("#chars2");
					$("#observaciones").limiter(1024, elem);
	  })
</script>
<style>
table, table b, table strong {
	text-transform: uppercase;
	font-size:14px;}
table span{
	color:red;
	font-size:20px;}	
footer{
	display:none;}
input{
	font-size:14px;}	
input[type=radio],input[type=checkbox]{
	width:30px;}
textarea{
	width:90%;
	text-align:left;}	
.titulo_registro, .titulo_registro strong{
	font-size:20px;
	background:none;
	text-align:left;}	
</style>
<div style="width:1150px; float:left;">
  <form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			 <input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="paso_3">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
            <input type="hidden" name="tipoEntrada" value="<?=$frm["tipoEntrada"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=nvl($frm["password"])?>">
            <input type="hidden" name="password2" value="<?=$frm["__CONFIRM_password"]?>">
            <input type="hidden" name="vigente" value="1">
        <table width="1150px" border="0" cellspacing="0" cellpadding="7">
          <tr>
            <td colspan="6" align="left" valign="top" ><strong > <span >
              <?php
			$caratula=$db->sql_row("SELECT * FROM promotores WHERE id='".$frm["id_programador"]."'");
			 ?>
              <input  name="imagen" id="imagen" type="hidden" value="<?php echo $caratula["imagen"];?>" />
            </span><div class="titulo_registro">Datos Personales
              <strong>- personal data </strong><div></td>
          </tr>
          <tr>
            <td rowspan="5" align="left" valign="top">&nbsp;</td>
            <td colspan="2" rowspan="4" align="left" valign="top"><iframe src="http://redlat.org/via/m/codigos/imagen.php?item=<?=$frm["id_programador"]?>" width="100%" height="300px" frameborder="0" scrolling="yes"></iframe></td>
            <td width="39" align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top"><span> * </span>Sr - <strong>Mr </strong>
            <? 
			if (isset($frm["sr"])) {$sr=$frm["sr"];}else{$sr="";}
			?>
            <input type="radio" name="sr" id="sr" value="1" <?php if($sr==1)echo"checked=\"checked\"";?>  class="radio"/>
            Sra - <strong>Mrs </strong>
            <input type="radio" name="sr" id="sr" value="2" <?php if($sr==2)echo"checked=\"checked\"";?> class="radio"/>
            </td>
          </tr>
          <tr>
            <td width="39" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><span> * </span>Nombre<strong style="font-size:14px"> <br />
            -            Name</strong></td>
            <td width="451" align="left" valign="top"><input name="nombre" type="text" id="nombre" size="50" value="<?=nvl($frm["nombre"])?>" onkeypress="return sololetras(event)" onblur="limpia()" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><span> * </span>Apellido<strong style="font-size:14px"><br />
            -            Last name</strong></td>
            <td width="451" align="left" valign="top"><input name="apellido" type="text" id="apellido" size="50" value="<?=nvl($frm["apellido"])?>" onkeypress="return sololetras(event)" onblur="limpia()"/></td>
          </tr>
          <tr>
            <td height="140" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><span> * </span>Profesi&oacute;n <strong style="font-size:14px"><br />
- Profession</strong></td>
            <td width="451" align="left" valign="top"><input name="cargo" type="text" id="cargo" size="50" value="<?=nvl($frm["cargo"])?>" /></td>
          </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span> * </span>Rese&ntilde;a<strong style="font-size:14px"> - abstract</strong>
              <br />
              Resumen CV (curriculum vitae) - Summary CV (curriculum vitae)<div id="chars" style=" display:none"></div>
              <div >
              <textarea name="resena"   rows="7" id="resena" ><?=nvl($frm["resena"])?></textarea>
             
            </div>
            <br />
            <br />
            </td>
          </tr>
          <tr>
            <td width="28" height="156" rowspan="4" align="left" valign="top">&nbsp;</td>
            <td width="104" align="left" valign="top"><span> * </span>Correo 1<strong style="font-size:14px"> <br />
- E-mail 1</strong></td>
            <td colspan="2" align="left" valign="top"><input name="email1" type="text" id="email1" size="40" value="<?=nvl($frm["email1"])?>" /></td>
            <td width="138" rowspan="3" align="left" valign="top"><span> * </span>CV<strong style="font-size:14px"> (curriculum vitae)<br />
            </strong></td>
            <td rowspan="3" align="left" valign="top"><iframe src="http://redlat.org/via/m/codigos/subirHv.php?item=<?=$frm["id_programador"]?>" width="100%" height="160px;" frameborder="0" scrolling="no"></iframe></td>
          </tr>
          <tr>
            <td align="left" valign="top">Correo 2 <strong style="font-size:14px"><br />
            - E-mail 2</strong></td>
            <td colspan="2" align="left" valign="top"><input name="email2" type="text" id="email2" size="40" value="<?=nvl($frm["email2"])?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><span> * </span>Tel&eacute;fono 1<strong style="font-size:14px"> <br />
- Phone1</strong></td>
            <td colspan="2" align="left" valign="top"><strong>57 1 XXX XX XX</strong><br />              
            <input name="telefono1" type="text" id="telefono1" size="40" value="<?=nvl($frm["telefono1"])?>" onkeypress="return numeros(event)" onblur="limpia()" /></td>
          </tr>
          <tr>
            <td width="104" align="left" valign="top">Tel&eacute;fono 2 <strong style="font-size:14px"><br />
- Phone2</strong></td>
            <td colspan="2" align="left" valign="top"><strong>57 1 XXX XX XX</strong><br />              
            <input name="telefono2" type="text" id="telefono2" size="40" value="<?=nvl($frm["telefono2"])?>" onkeypress="return numeros(event)" onblur="limpia()" /></td>
            <td width="138" align="left" valign="top"><span> * </span> Pa&iacute;s <strong style="font-size:14px"><br />
            - Conutry</strong></td>
            <td align="left" valign="top"><input name="pais" type="text" id="pais" size="50" value="<?=nvl($frm["pais"])?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Web <strong style="font-size:14px"><br />
            - Web:</strong></td>
            <td colspan="2" align="left" valign="top"><input name="web" type="text" id="web" size="40" value="<?=nvl($frm["web"])?>" /></td>
            <td align="left" valign="top"><span> * </span>Ciudad <strong style="font-size:14px"><br />
- City:</strong></td>
            <td align="left" valign="top"><input name="ciudad" type="text" id="ciudad" size="50" value="<?=nvl($frm["ciudad"])?>"/></td>
          </tr>

          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="306" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Actividades <strong style="font-size:14px"><br />
- Activity:</strong></td>
            <td colspan="4" align="left" valign="top"><? 
			$qTareas=$db->sql_query("SELECT * FROM pr_tareas");
						while($tarea=$db->sql_fetchrow($qTareas)){
							if($tarea["id"]!=7&&$tarea["id"]!=14&&$tarea["id"]!=15&&$tarea["id"]!=16){
							$qTarea=$db->sql_query("SELECT * FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='$tarea[id]'");
							if($db->sql_numrows($qTarea)>0){ $checked=" CHECKED";}else{$checked="";};
							echo "<input type=\"checkbox\" name=\"pr_promotores_tareas".$tarea["id"]."\" value=\"" . $tarea["id"]. "\"" . $checked . ">";
							echo "" . $tarea["nombre"] . "<br/>";
							}
						} ?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Otra actividad <strong style="font-size:14px"><br />
            - Another activity</strong></td>
            <td colspan="4" align="left" valign="top"><input name="otras" type="text" id="otras" size="50" value="<?=nvl($frm["otras"])?>" onkeypress="return sololetras(event)" onblur="limpia()"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
          </tr>
          
           <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Idioma <strong style="font-size:14px"><br />
             - Languages</strong></td>
            <td colspan="4" align="left" valign="top"><? 
			
			echo "<table>\n";
						$qIdiomas=$db->sql_query("SELECT * FROM pr_idiomas");
						$i=0;
						while($idioma=$db->sql_fetchrow($qIdiomas)){
							$qIdioma=$db->sql_query("SELECT * FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='$idioma[id]'");
							if($db->sql_numrows($qIdioma)>0) $checked=" CHECKED";
							else $checked="";
							if(($i%2)==0) echo "<tr>";
							echo "<td><input type=\"checkbox\" name=\"pr_promotores_idiomas".$idioma["id"]."\" value=\"" . $idioma["id"] . "\"" . $checked . "></td>\n";	
							echo "<td>" . $idioma["idioma"] . "</td>\n";
							$i++;
							if(($i%2)==0) echo "</tr>";
						}
						echo "</table>\n";
						
			
			
			?></td>
          </tr>
           <tr>
             <td align="left" valign="top">&nbsp;</td>
             <td align="left" valign="top">&nbsp;</td>
             <td colspan="4" align="left" valign="top">&nbsp;</td>
           </tr>
           <tr>
             <td align="left" valign="top">&nbsp;</td>
             <td align="left" valign="top"><span><br>
             * </span>pago
<div id="chars2" style=" display:none"></div>
- <strong>payment</strong></td>
             <td colspan="4" align="left" valign="top" style="text-align:justify"><?php if (isset($frm["forma"])) {$forma=$frm["forma"];}else{$forma="";} ?>
            <hr> Para participantes Internacionales - <strong>For international participants<br>
             </strong>
            
             <p><input type="radio" name="forma" id="forma" value="1" <?php if($forma==1)echo"checked=\"checked\"";?>  class="radio"/>
             USD 500 Incluye: Hospedaje 4 noches, desayuno, Transporte hotel-sitio-hotel y a los espect&aacute;culos que hacen parte de VIA (en horarios definidos), acreditaci&oacute;n, gu&iacute;a (coordinador), materiales, entradas a los espect&aacute;culos que hacen parte de VIA. 
             <strong>- USD$ 500 Includes: Accommodation 4 nights, breakfast, transportation hotel-site-hotel and to the shows that are part of the VIA (in the set hours), credentials, guide (coordinator), materials, tickets to the shows that are part of the VIA.</strong></p>
             <p>
               <input type="radio" name="forma" id="forma" value="2" <?php if($forma==2)echo"checked=\"checked\"";?>  class="radio"/>
             USD 150 Incluye materiales, acreditaci&oacute;n e ingreso a los espect&aacute;culos de VIA, no Incluye hospedaje. 
             - <strong>USD$ 150 Includes materials, credentials and entry to the VIA shows, does not include accommodation</strong>.</p><hr>
             <p>Para participantes Colombianos - <strong>For Colombian participants:&nbsp;</strong><br>
               <br>
               <input type="radio" name="forma" id="forma" value="3" <?php if($forma==3)echo"checked=\"checked\"";?>  class="radio"/>
             COP $700.000 incluye: Hospedaje 4 noches, desayuno, transporte hotel-sitio-hotel y a los espect&aacute;culos que hacen parte de VIA (en horarios definidos), acreditaci&oacute;n, gu&iacute;a, materiales, entradas a los espect&aacute;culos que hacen parte de VIA. <strong>             - COP $700.000 Includes: Accommodation 4 nights, breakfast, transportation hotel-site-hotel and to the shows that are part of the VIA (in the set hours), credentials, guide (coordinator), materials, tickets to the shows that are part of the VIA. <br>
             <br>
             <input type="radio" name="forma" id="forma" value="4" <?php if($forma==4)echo"checked=\"checked\"";?>  class="radio"/>
             </strong>COP $ 300.000 Incluye materiales, acreditaci&oacute;n e ingreso a los espect&aacute;culos de VIA, no Incluye hospedaje. 
             <strong>- COP $ 300.000 Includes materials, credentials and entry to all VIA shows,  does not include accommodation. </strong></p></td>
           </tr>
           <tr>
             <td align="left" valign="top">&nbsp;</td>
             <td align="left" valign="top">&nbsp;</td>
             <td colspan="4" align="left" valign="top">&nbsp;</td>
           </tr>
          <tr>
            <td colspan="6" align="left" valign="bottom" class="azul" ><div class="titulo_registro"><strong >            Datos de la Organizaci&oacute;n, Sala, Evento o Festival que representa <br />
            - institution information</strong></div>
            <?
						$qEmpresas=$db->sql_query("
							SELECT emp.*
							FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
							WHERE ep.id_promotor='$frm[id_usuario]'
						");
						
						
						?>  </td>
          </tr>
          <tr>
            <td colspan="6" align="left" valign="top">
            
            <?  
			
			if($db->sql_numrows($qEmpresas)>0){ 
			  while($empresa=$db->sql_fetchrow($qEmpresas)){
				            $naturalezasOptions=$db->sql_listbox("SELECT id,nombre FROM emp_naturalezas","Seleccione/Select...",$empresa["id_naturaleza"]); ?>
			  <table width="100%" cellpadding="5">
							<tr>
							<td colspan="2" rowspan="4"><iframe src="http://redlat.org/via/m/codigos/imagenLogo.php?item=<?=$empresa["id"]?>" width="100%" height="290px;" frameborder="0" scrolling="yes"></iframe></td>
							<td width="165"><span> * </span>Instituci&oacute;n <br />
							  <b>- Institution</b></td>
                            <td width="406"><input size="30" type="text" name="empresa" value="<?=$empresa["empresa"];?>" onkeypress="return sololetras(event)" onblur="limpia()"></td>
                            </tr>
							<tr>
							<td width="165"><span> * </span>Tipo de Entidad <br /><b>- Entity Type</b></td>
							<td width="406"><select name="id_naturaleza"><?=$naturalezasOptions;?></select></td></tr>
							<tr>
							<td><span> * </span>Nit <br />
                              <b>- ID Institution</b></td><td><input size="30" type="text" name="nit" value="<?=$empresa["nit"]?>" onkeypress="return numeros(event)" onblur="limpia()"/></td></tr>
							<tr>
							  <td height="125" valign="top"><span> * </span>Direcci&oacute;n <br />
                              <strong>- Adress</strong></td>
							  <td valign="top"><input size="30" type="text" name="direccion_emp" value="<?=$empresa["direccion"];?>" /></td>
			    </tr>
							<tr>
							  <td width="171" valign="top"><span> * </span>Tel&eacute;fono 1 <br />
						      <b>- Phone1</b></td>
							  <td width="342"><strong>57 1 XXX XX XX</strong><br />							    
						      <input size="30"type="text" name="telefono_emp" value="<?=$empresa["telefono"];?>" onkeypress="return numeros(event)" onblur="limpia()" /></td>
							  <td>Tel&eacute;fono 2 <br />
						      <b>- Phone2</b></td>
							  <td><strong>57 1 XXX XX XX</strong><br />							    
						      <input size="30" type="text" name="telefono2_emp" value="<?=$empresa["telefono2"];?>" onkeypress="return numeros(event)" onblur="limpia()"/></td>
			    </tr>
							<tr><td>Web <br><b>-Web</b></td><td><input size="30" type="text" name="web_emp" value="<?=$empresa["web"]?>"></td>
							<td><span> * </span>Correo <br><b>- E-mail</b></td><td><input size="30" type="text" name="email_emp" value="<?=$empresa["email"];?>"></td></tr>
							<tr>
							  <td><b><span> * </span>Pa&iacute;s <br />
							        <b>- Country</b></b></td><td><input size="30" type="text" name="pais_emp" value="<?=$empresa["pais"]?>" /></td>
							<td><span> * </span>Ciudad <br />
						    <b> - City</b></td><td><input size="30" type="text" name="ciudad_emp" value="<?=$empresa["ciudad"];?>" /></td></tr>
							<tr>
							  <td><span> * </span>Descripci&oacute;n de la organizaci&oacute;n<br>
							    <b>- Description institution:</b></td><td colspan="3"><textarea name="observaciones" cols="75" rows="5"><?=$empresa["observaciones"];?></textarea><div id="chars" style=""></div>
							</table>
                            <?
							}
			}else{	
							$naturalezasOptions=$db->sql_listbox("SELECT id,nombre FROM emp_naturalezas","Seleccione/Select...",$empresa["id_naturaleza"]);	
							?>
                            <table width="100%" cellpadding="5">
							<tr>
							<td colspan="2" rowspan="4"><iframe src="http://redlat.org/via/m/codigos/imagenLogo.php?item=<?=$empresa["id"]?>" width="100%" height="290px;" frameborder="0" scrolling="yes"></iframe></td>
							<td width="167">(*Instituci&oacute;n<br />
							  <b>- Institution</b></td>
                            <td width="405"><input size="30" type="text" name="empresa" value="<?=$empresa["empresa"];?>"></td>
                            </tr>
							<tr>
							<td width="167"><span> * </span>Tipo de Entidad <br /><b>- Entity Type</b></td>
							<td width="405"><select name="id_naturaleza"><?=$naturalezasOptions;?></select></td></tr>
							<tr>
							<td><span> * </span>Nit <br />
                              <b>- ID Institution</b></td><td><input size="30" type="text" name="nit" value="<?=$empresa["nit"]?>" onkeypress="return numeros(event)" onblur="limpia()" /></td></tr>
							<tr>
							  <td valign="top"><span> * </span>Direcci&oacute;n <br />
                              <strong>- Adress</strong></td>
							  <td><input size="30" type="text" name="direccion_emp" value="<?=$empresa["direccion"];?>" /></td>
							  </tr>
							<tr>
							  <td width="174"><span> * </span>Tel&eacute;fono 1 <br />
						      <b>- Phone1</b></td>
							  <td width="338"><input size="30"type="text" name="telefono_emp" value="<?=$empresa["telefono"];?>" onkeypress="return numeros(event)" onblur="limpia()" /></td>
							  <td>Tel&eacute;fono 2 <br />
						      <b>- Phone2</b></td>
							  <td><input size="30" type="text" name="telefono2_emp" value="<?=$empresa["telefono2"];?>" onkeypress="return numeros(event)" onblur="limpia()" /></td>
							  </tr>
							<tr><td>Web <br><b>-Web</b></td><td><input size="30" type="text" name="web_emp" value="<?=$empresa["web"]?>"></td>
							<td><span> * </span>Correo <br><b>- E-mail</b></td><td><input size="30" type="text" name="email_emp" value="<?=$empresa["email"];?>"></td></tr>
							<tr>
							  <td><span> * </span>Pa&iacute;s <br />
                              <b>- Country</b></td><td><input size="30" type="text" name="pais_emp2" value="<?=$empresa["pais"]?>"/></td>
							<td><b> <span> * </span>Ciudad <br />
							<b> - City</b></b></td>
							<td><input size="30" type="text" name="ciudad_emp2" value="<?=$empresa["ciudad"];?>" /></td></tr>
							<tr>
							  <td><span> * </span>Descripci&oacute;n de la organizaci&oacute;n<br>
							    <b>- Description institution:</b></td><td colspan="3"><textarea name="observaciones" cols="75" rows="5"><?=$empresa["observaciones"];?></textarea>
							</table>
                            <?
			}
			?>
            </td>
          </tr>
          <tr>
            <td colspan="6" align="left" valign="top">&nbsp;</td>
          </tr>
         
          <tr>
            <td colspan="6" align="left" valign="top">
            </td>
          </tr>
          
          
          <tr>
            <td colspan="6" align="left" valign="top" ><label>
              <input type="submit" id="submit_button" value="Enviar - Send" />
            </label></td>
          </tr>
        </table>
			
     </form>
     
</div>

<div style="height:40px;"> </div>
