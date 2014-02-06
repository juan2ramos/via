<script>
function revisar(frm){

	//document.getElementById('submit_button').value='Enviando información...';
	//document.getElementById('submit_button').disabled=true;
	return(true);
}
</script>
   <!-- este codigo es para VIA 2012 --->
	<? if ($CFG->mercado==21){?>
		<style>
			#contenedor #contenido .artista h1 {
				background-color:#fff;
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
        </style>
 <? }?>  
<!-- finde código --> 
			<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			 <input type="hidden" name="modo" value="<?=$seccion?>" />
            <input type="hidden" name="mode" value="paso_3">
			  <input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
              <input  name="tipoEntrada" value="<?=$frm["tipoEntrada"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="password" value="<?=nvl($frm["password"])?>">
            <input type="hidden" name="vigente" value="1">
     
        <h1>Paso 2 de 4</h1>
        <table width="599" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td width="160" align="left" valign="top"><strong>Nombre (*) :</strong></td>
            <td width="404" align="left" valign="top"><label><input name="nombre" type="text" id="nombre" size="40" value="<?=nvl($frm["nombre"])?>" /></label></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>Apellido (*): </strong></td>
            <td align="left" valign="top"><input name="apellido" type="text" id="apellido" size="40" value="<?=nvl($frm["apellido"])?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>(*) Rese&ntilde;a:</strong></td>
            <td align="left" valign="top"><label>
              <textarea name="resena" id="resena" cols="45" rows="10"><?=nvl($frm["resena"])?> </textarea>
              <br />
              <em>Breve rese&ntilde;a artistica de la agrupaci&oacute;n. Indique origen, g&eacute;neros y trayectoria (1024 caracteres)            </em></label></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>(*) Independiente:</strong></td>
            <td align="left" valign="top"><?=nvl($frm["independiente"])?> No
              <input name="independiente" type="radio" value="0" />
              S&iacute;
              <input name="independiente" type="radio" value="1" />
            </td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>(*) Cargo:</strong></td>
            <td align="left" valign="top"><input name="cargo" type="text" id="cargo" size="40" value="<?=nvl($frm["cargo"])?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>(*) Telefono1:</strong></td>
            <td align="left" valign="top"><input name="telefono1" type="text" id="telefono1" size="40" value="<?=nvl($frm["telefono1"])?>" /></td>
          </tr>

          <tr>
            <td align="left" valign="top"><strong> Telefono2:</strong></td>
            <td align="left" valign="top"><input name="telefono2" type="text" id="telefono2" size="40" value="<?=nvl($frm["telefono2"])?>" /></td>
          </tr>

          <tr>
            <td align="left" valign="top"> <strong>(*) e-mail 1:</strong></td>
            <td align="left" valign="top"><input name="email1" type="text" id="email1" size="40" value="<?=nvl($frm["email1"])?>" /></td>
          </tr>
          
          <tr>
            <td align="left" valign="top"> <strong>e-mail 2:</strong></td>
            <td align="left" valign="top"><input name="email2" type="text" id="email2" size="40" value="<?=nvl($frm["email2"])?>" /></td>
          </tr>

           <tr>
            <td align="left" valign="top"> <strong>(*) Pais:</strong></td>
            <td align="left" valign="top"><input name="pais" type="text" id="pais" size="40" value="<?=nvl($frm["pais"])?>" /></td>
          </tr>
          
           <tr>
            <td align="left" valign="top"> <strong>(*) Ciudad:</strong></td>
            <td align="left" valign="top"><input name="ciudad" type="text" id="ciudad" size="40" value="<?=nvl($frm["ciudad"])?>" /></td>
          </tr>
          
          
          <tr>
            <td align="left" valign="top"> <strong>(*) Dirección:</strong></td>
            <td align="left" valign="top"><input name="direccion" type="text" id="direccion" size="40" value="<?=nvl($frm["direccion"])?>" /></td>
          </tr>
          
           <tr>
            <td align="left" valign="top"> <strong>Web:</strong></td>
            <td align="left" valign="top"><input name="web" type="text" id="web" size="40" value="<?=nvl($frm["web"])?>" /></td>
          </tr>
          
          
          <tr>
            <td align="left" valign="top"> <strong>Actividades:</strong></td>
            <td align="left" valign="top"><? $qTareas=$db->sql_query("SELECT * FROM pr_tareas");
						while($tarea=$db->sql_fetchrow($qTareas)){
							$qTarea=$db->sql_query("SELECT * FROM pr_promotores_tareas WHERE id_promotor='$frm[id]' AND id_tarea='$tarea[id]'");
							if($db->sql_numrows($qTarea)>0) $checked=" CHECKED";
							else $checked="";
							echo "<input type=\"checkbox\" name=\"pr_promotores_tareas[]\" value=\"" . $tarea["id"]. "\"" . $checked . ">";
							echo "" . $tarea["nombre"] . "<br/>";
						} ?></td>
          </tr>
          
          
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><label>
              <input type="submit" id="submit_button" value="Enviar" />
            </label></td>
          </tr>
        </table>
        <h2>(*) Campos requeridos</h2>
    
			</form>
      
