<?
$arrTitulos["sobre_rueda"]="Sobre la rueda";
$arrTitulos["en_sobre_rueda"]="About business roundtable";
$arrTitulos["cronograma"]="Cronograma";
$arrTitulos["en_cronograma"]="Cronograma";
$arrTitulos["reglamento"]="Reglamento";
$arrTitulos["en_reglamento"]="Reglamento";
$arrTitulos["inscripciones"]="Inscripciones";
$arrTitulos["en_inscripciones"]="Inscripciones";
$arrTitulos["contacto"]="Contacto";
$arrTitulos["en_contacto"]="Contact";
?>

  <img src="../../imagenes/texto_superior.jpg" width="1000" height="15" />
  <div id="contenido">
  <div id="menu">
  	  <a href="informacion.php"><?=translate($arrTitulos,"sobre_rueda")?></a> 
      <a href="reglamento.php"><?=translate($arrTitulos,"reglamento")?></a> 
      <a href="cronograma.php"><?=translate($arrTitulos,"cronograma")?></a> 
      <a href="inscripciones.php"><?=translate($arrTitulos,"inscripciones")?></a> 
      <a href="contacto.php"><?=translate($arrTitulos,"contacto")?></a> 
    <img src="../../imagenes/boton_inferior.jpg" width="190" height="15" />
    </div>

    <div id="texto">
      <div id="alineacion">
			<form name="entryform" action="<?=$ME?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar()">
			<input type="hidden" name="mode" value="procesar_inscripcion">
      <div class="bloque">
        <h1>Paso 1 de 3
        </h1>
        <p>Declaro que conozco el Reglamento para participar en la convocatoria de la Rueda de negocios de m&uacute;sica y artes esc&eacute;nicas de Bogot&aacute;, y manifiesto que lo acepto en su totalidad. En consecuencia, declaro que no presentar&eacute; en contra de la C&aacute;mara de Comercio de Bogot&aacute; ninguna reclamaci&oacute;n relacionada con mi participaci&oacute;n en la convocatoria. </p>
        <p>Declaro que conozco y dar&eacute; estricto cumplimiento a las normas de protecci&oacute;n de los derechos de autor y derechos conexos en relaci&oacute;n con todas y cada una de las obras literarias y art&iacute;sticas, interpretaciones o ejecuciones art&iacute;sticas y/o fonogramas que formen parte de mi propuesta. </p>
        <p>As&iacute; mismo, me obligo a dar estricto cumplimiento a los deberes que me son aplicables en esa materia, eximiendo y liberando de toda la responsabilidad a la C&aacute;mara de Comercio de Bogot&aacute; ante el suscrito, el titular de los derechos y terceros, por el incumplimiento de mis obligaciones (i) ante la Direcci&oacute;n Nacional de Derecho de Autor (ii) las sociedades que protejan los mismos o (iii) ante cualquier persona natural o jur&iacute;dica que resulte afectada. De igual manera, acepto y asumo que los eventuales da&ntilde;os y perjuicios causados por la inobservancia de dichas disposiciones, o por mi falta de cuidado y diligencia, me har&aacute; responsable por todos los perjuicios y da&ntilde;os causados, exonerando a la C&aacute;mara de Comercio de Bogot&aacute; de cualquier posible responsabilidad. </p>
        <p>El incumplimiento de las obligaciones pactadas en el presente documento me excluir&aacute; inmediatamente de participar en la rueda de negocios, independiente de la indemnizaci&oacute;n de perjuicios que por este efecto corresponda a La C&aacute;mara de Comercio de Bogot&aacute;. </p>
        <p>Declaro que he le&iacute;do, entendido y aceptado el contenido de este documento en su integridad. Asumir&eacute; las implicaciones que se ocasionen con la presentaci&oacute;n de mi propuesta, sin implicar en alg&uacute;n tipo de responsabilidad a la C&aacute;mara de Comercio de Bogot&aacute;.</p>
        <table width="500" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td width="100">Usuario:</td>
            <td width="365"><label>
              <input type="text" name="textfield" id="textfield" />
            </label></td>
          </tr>
          <tr>
            <td>Contrase&ntilde;a:</td>
            <td><label>
              <input type="text" name="textfield2" id="textfield2" />
            </label></td>
          </tr>
          <tr>
            <td>&Aacute;rea art&iacute;stica:</td>
            <td><label>
              <select name="select" id="select">
                <option value="danza">Danza</option>
                <option value="musica">M&uacute;sica</option>
                <option value="teatro">Teatro</option>
              </select>
            </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><label>
              <input type="submit" name="button" id="button" value="Participar" />
            </label></td>
          </tr>
        </table>
        <h1>Paso 2 de 3 </h1>
        <table width="500" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td width="100" align="left" valign="top">Agrupaci&oacute;n:</td>
            <td width="365" align="left" valign="top"><label>
              <input name="textfield3" type="text" id="textfield3" size="40" />
            </label></td>
          </tr>
          <tr>
            <td align="left" valign="top">Empresa, fundaci&oacute;n o corporaci&oacute;n: </td>
            <td align="left" valign="top"><input name="textfield6" type="text" id="textfield4" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">NIT:</td>
            <td align="left" valign="top"><input name="textfield4" type="text" id="textfield5" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">RUT:</td>
            <td align="left" valign="top"><input name="textfield5" type="text" id="textfield6" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">Rese&ntilde;a (Espa&ntilde;ol):</td>
            <td align="left" valign="top"><label>
              <textarea name="textarea" id="textarea" cols="45" rows="10"></textarea>
            </label></td>
          </tr>
          <tr>
            <td align="left" valign="top">Rese&ntilde;a (Ingl&eacute;s):</td>
            <td align="left" valign="top"><textarea name="textarea2" id="textarea2" cols="45" rows="10"></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top">Representante, manager o contacto:</td>
            <td align="left" valign="top"><input name="textfield7" type="text" id="textfield7" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">Documento identificaci&oacute;n contacto:</td>
            <td align="left" valign="top"><input name="textfield8" type="text" id="textfield8" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">Ciudad:</td>
            <td align="left" valign="top"><input name="textfield9" type="text" id="textfield9" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">Direcci&oacute;n:</td>
            <td align="left" valign="top"><input name="textfield10" type="text" id="textfield10" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">Tel&eacute;fono:</td>
            <td align="left" valign="top"><input name="textfield11" type="text" id="textfield11" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Soportes trayectoria:</td>
            <td align="left" valign="top"><label>
              <input name="fileField" type="file" id="fileField" size="40" />
            </label></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><label>
              <input type="submit" name="button2" id="button2" value="Enviar" />
            </label></td>
          </tr>
        </table>
        <h2>* S&oacute;lo requerido para m&uacute;sica</h2>
        <h1>Paso 3 de 3 </h1>
        <table width="500" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td align="left" valign="top">Obra o producci&oacute;n:</td>
            <td align="left" valign="top"><label>
              <input name="textfield13" type="text" id="textfield13" size="40" />
            </label></td>
          </tr>
          <tr>
            <td align="left" valign="top">Rese&ntilde;a (Espa&ntilde;ol)</td>
            <td align="left" valign="top"><label>
              <textarea name="textarea3" id="textarea3" cols="45" rows="10"></textarea>
            </label></td>
          </tr>
          <tr>
            <td align="left" valign="top">Rese&ntilde;a (Ingl&eacute;s):</td>
            <td align="left" valign="top"><textarea name="textarea3" id="textarea4" cols="45" rows="10"></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top">Fecha de producci&oacute;n:</td>
            <td align="left" valign="top"><input name="textfield13" type="text" id="textfield17" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Sello discogr&aacute;fico:</td>
            <td align="left" valign="top"><input name="textfield13" type="text" id="textfield18" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Imagen car&aacute;tula &aacute;lbum:</td>
            <td align="left" valign="top"><input name="fileField3" type="file" id="fileField3" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Audio:</td>
            <td align="left" valign="top"><input name="fileField4" type="file" id="fileField4" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Audio:</td>
            <td align="left" valign="top"><input name="fileField4" type="file" id="fileField5" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Audio:</td>
            <td align="left" valign="top"><input name="fileField4" type="file" id="fileField6" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Audio:</td>
            <td align="left" valign="top"><input name="fileField4" type="file" id="fileField7" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">*Audio:</td>
            <td align="left" valign="top"><input name="fileField4" type="file" id="fileField8" size="40" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">**C&oacute;digo de video:</td>
            <td align="left" valign="top"><textarea name="textarea4" id="textarea5" cols="45" rows="10"></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top">**Soportes trayectoria:</td>
            <td align="left" valign="top"><label>
              <input name="fileField2" type="file" id="fileField2" size="40" />
            </label></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><label>
              <input type="submit" name="button3" id="button3" value="Enviar" />
            </label></td>
          </tr>
        </table>
        <h2>* S&oacute;lo requerido para m&uacute;sica</h2>
        <h2>** S&oacute;lo requerido para danza y teatro</h2>
      </div>
			</form>
      </div>
      <h2><img src="../../imagenes/texto_inferior.jpg" width="810" height="20" /></h2>
    </div>
  </div>

