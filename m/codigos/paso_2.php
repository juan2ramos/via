<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
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
					$("#resena_corta").limiter(1024, elem);
					
					var elem = $("#chars3");
					$("#en_resena_corta").limiter(1024, elem);
					
					
					
					
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
<style>
input[type="checkbox"] {
	width:30px;}
</style>
		<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>&a=<?php echo$_GET["a"];?>" method="POST" enctype="multipart/form-data" id="entryform">
		  <input type="hidden" name="modo" value="<?=$seccion?>" />
          <input type="hidden" name="mode" value="paso_3">
		  <input type="hidden" name="id_grupo" value="<?=nvl($frm["id_grupo"])?>">
		  <input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
		  <input type="hidden" name="area" value="<?=$frm["area"]?>">
		  <input type="hidden" name="login" value="<?=$frm["login"]?>">
    
        <table width="1020" height="2599" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td colspan="3" align="left" valign="top">
          
			  <h2>Datos B&aacute;sicos 
		      (*) Campos requeridos</h2>
		   </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="310" rowspan="7" align="left" valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" id="imagenGrupo">
              <tr>
                <td align="center" valign="middle" style="height:400px;"><iframe scrolling="no" width="100%" height="400px" frameborder="0" src="../m/codigos/artista_imagen.php?item=<?=$frm["id_grupo"]?>&area=<?=$frm["area"]?>"></iframe></td>
              </tr>
            </table></td>
            <td width="235" align="left" valign="top" class="colorTexto">(*) Nombre del grupo o del artista:</td>
            <td colspan="2" align="right" valign="top" ><table class="nombre"width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><input name="nombre" type="text" id="nombre" size="58" value="<?=nvl($frm["nombre"])?>" onkeypress="return soloLetras(event)" onblur="limpia()"/></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto"><p>(*) Descripci&oacute;n o rese&ntilde;a:<br />
              (700 car&aacute;cteres)
            </p></td>
            <td colspan="2" align="right" valign="top" ><table class="resena" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><textarea name="resena_corta" id="resena_corta" cols="45" rows="15"><?=nvl($frm["resena_corta"])?></textarea></td>
                </tr>
              </table>
            <div id="chars" style="text-align:left; margin-left:30px;"></div>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Descripci&oacute;n o rese&ntilde;a en ingles:<br />
(700 caracteres)</td>
            <td colspan="2" align="center" valign="top"><table  class="resena2" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="center"><textarea name="en_resena_corta" id="en_resena_corta" cols="45" rows="15"><?=nvl($frm["en_resena_corta"])?></textarea></td>
              </tr>
              </table>
            <div id="chars3" style="text-align:left; margin-left:30px;"></div></td>
          </tr>
          
          
          <tr>
            <td align="left" valign="top" class="colorTexto generos">(*) G&eacute;nero: </td>
            <td colspan="2" align="left" valign="top" class="generos">
           <div style="margin-left:25px;">
            <?php 
					
			if($frm["area"]=="teatro"){
				
				$g1=0; $g2=0; $g3=0; $g4=0; $g5=0; $g6=0; $g7=0; $g8=0; $g9=0; $g10=0;
								 
			   $generos=$db->sql_query("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$frm["id_grupo"]."'");
				
				while($generos_artista=$db->sql_fetchrow($generos)){
			   	   if($generos_artista["id_generos_teatro"]==5){$g1=1;} 
				   if($generos_artista["id_generos_teatro"]==1){$g2=1;} 
				   if($generos_artista["id_generos_teatro"]==7){$g3=1;} 
				   if($generos_artista["id_generos_teatro"]==3){$g4=1;} 
				   if($generos_artista["id_generos_teatro"]==8){$g5=1;} 
				   if($generos_artista["id_generos_teatro"]==10){$g6=1;} 
				   if($generos_artista["id_generos_teatro"]==6){$g7=1;} 
				   if($generos_artista["id_generos_teatro"]==11){$g8=1;} 
				   if($generos_artista["id_generos_teatro"]==9){$g9=1;} 
				   if($generos_artista["id_generos_teatro"]==2){$g10=1;} 				}
				?>
                  <input type="checkbox" name="genero1" id="genero1" <?php  if($g1==1){echo "checked='checked'";}else{}?>  />Callejero
            <br /><input type="checkbox" name="genero2" id="genero2" <?php if($g2==1){echo "checked='checked'";}else{}?>  />Circo
            <br /><input type="checkbox" name="genero3" id="genero3" <?php if($g3==1){echo "checked='checked'";}else{}?>  />Clown
            <br /><input type="checkbox" name="genero4" id="genero4" <?php if($g4==1){echo "checked='checked'";}else{}?>  />Contempor�neo
            <br /><input type="checkbox" name="genero5" id="genero5" <?php if($g5==1){echo "checked='checked'";}else{}?>  />Espacios no convencionales
            <br /><input type="checkbox" name="genero6" id="genero6" <?php if($g6==1){echo "checked='checked'";}else{}?>  />Infantil
            <br /><input type="checkbox" name="genero7" id="genero7" <?php if($g7==1){echo "checked='checked'";}else{}?>  />Mimo
            <br /><input type="checkbox" name="genero8" id="genero8" <?php if($g8==1){echo "checked='checked'";}else{}?>  />Narraci�n Oral
            <br /><input type="checkbox" name="genero9" id="genero9" <?php if($g9==1){echo "checked='checked'";}else{}?>  />Teatro de sala
            <br /><input type="checkbox" name="genero10" id="genero10" <?php if($g10==1){echo "checked='checked'";}else{}?>  />T�teres y marionetas
           <?php
			}
			
			if($frm["area"]=="danza"){
				
				$g1=0; $g2=0; $g3=0; $g4=0; $g5=0; $g6=0; $g7=0; 
								 
			   $generos=$db->sql_query("SELECT * FROM generos_grupo_danza WHERE id_grupos_danza='".$frm["id_grupo"]."'");
				
				while($generos_artista=$db->sql_fetchrow($generos)){
			   	   if($generos_artista["id_generos_danza"]==12){$g1=1;} 
				   if($generos_artista["id_generos_danza"]==10){$g2=1;} 
				   if($generos_artista["id_generos_danza"]==2){$g3=1;} 
				   if($generos_artista["id_generos_danza"]==6){$g4=1;} 
				   if($generos_artista["id_generos_danza"]==11){$g5=1;} 
				   if($generos_artista["id_generos_danza"]==9){$g6=1;} 
				   if($generos_artista["id_generos_danza"]==8){$g7=1;} 
 				}
				?>
                <input type="checkbox" name="genero1" id="genero1" <?php  if($g1==1){echo "checked='checked'";}else{}?>  />�rabe
            <br /><input type="checkbox" name="genero2" id="genero2" <?php if($g2==1){echo "checked='checked'";}else{}?>  />Ballet cl�sico y neocl�sico
            <br /><input type="checkbox" name="genero3" id="genero3" <?php if($g3==1){echo "checked='checked'";}else{}?>  />Contempor�nea
            <br /><input type="checkbox" name="genero4" id="genero4" <?php if($g4==1){echo "checked='checked'";}else{}?>  />Danza Teatro
            <br /><input type="checkbox" name="genero5" id="genero5" <?php if($g5==1){echo "checked='checked'";}else{}?>  />Experimental
            <br /><input type="checkbox" name="genero6" id="genero6" <?php if($g6==1){echo "checked='checked'";}else{}?>  />Folcl�rica
            <br /><input type="checkbox" name="genero7" id="genero7" <?php if($g7==1){echo "checked='checked'";}else{}?>  />Moderna
            <?php	
			}
			?></div>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Pa&iacute;s:</td>
            <td colspan="2" align="left" valign="top" class="id_pais"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_pais">
              <tr>
                  <td align="center">
                  <select name="id_pais" id="id_pais" style="width:365px; padding:10px">
                    <option value="%"  <?php if($frm["id_pais"]==0){echo "selected";}else{}?>>Seleccione...</option>
                    <option value="1" <?php if($frm["id_pais"]==1){echo "selected";}else{}?>>Argentina</option>
                    <option value="2" <?php if($frm["id_pais"]==1){echo "selected";}else{}?>>Bolivia</option>
                    <option value="23" <?php if($frm["id_pais"]==23){echo "selected";}else{}?> >Brasil</option>
                    <option value="3" <?php if($frm["id_pais"]==3){echo "selected";}else{}?>>Chile</option>
                    <option value="4" <?php if($frm["id_pais"]==4){echo "selected";}else{}?>>Colombia</option>
                    <option value="5" <?php if($frm["id_pais"]==5){echo "selected";}else{}?>>Costa Rica</option>
                    <option value="6" <?php if($frm["id_pais"]==6){echo "selected";}else{}?>>Cuba</option>
                    <option value="7" <?php if($frm["id_pais"]==7){echo "selected";}else{}?>>Ecuador</option>
                    <option value="8" <?php if($frm["id_pais"]==8){echo "selected";}else{}?>>El Salvador</option>
                    <option value="9" <?php if($frm["id_pais"]==9){echo "selected";}else{}?>>Espa�a</option>
                    <option value="24" <?php if($frm["id_pais"]==24){echo "selected";}else{}?>>Francia</option>
                    <option value="10" <?php if($frm["id_pais"]==10){echo "selected";}else{}?>>Guatemala</option>
                    <option value="11" <?php if($frm["id_pais"]==11){echo "selected";}else{}?>>Honduras</option>
                    <option value="12" <?php if($frm["id_pais"]==12){echo "selected";}else{}?>>M�xico</option>
                    <option value="13" <?php if($frm["id_pais"]==13){echo "selected";}else{}?>>Nicaragua</option>
                    <option value="14" <?php if($frm["id_pais"]==14){echo "selected";}else{}?>>Panam�</option>
                    <option value="15" <?php if($frm["id_pais"]==15){echo "selected";}else{}?>>Paraguay</option>
                    <option value="16" <?php if($frm["id_pais"]==16){echo "selected";}else{}?>>Per�</option>
                    <option value="17" <?php if($frm["id_pais"]==17){echo "selected";}else{}?>>Puerto Rico</option>
                    <option value="18" <?php if($frm["id_pais"]==18){echo "selected";}else{}?>>Rep�blica Dominicana</option>
                    <option value="19" <?php if($frm["id_pais"]==19){echo "selected";}else{}?>>Uruguay</option>
                    <option value="20" <?php if($frm["id_pais"]==20){echo "selected";}else{}?>>Venezuela</option>
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
            <td align="left" valign="top"><span class="colorTexto">(*) Direcci&oacute;n:</span></td>
            <td colspan="3" align="left" valign="top" class="colorTexto"><table class="direccion" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input name="direccion" type="text" id="direccion" size="58" value="<?=nvl($frm["direccion"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Tel&eacute;fono:<br /></td>
            <td colspan="2" align="center" valign="top" >Incluir el prefijo del pa&iacute;s  y de la ciudad. Ejemplo: 57 1 XXXXXX<br />
              <table class="telefono" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input name="telefono" type="text" id="telefono" size="58" value="<?=nvl($frm["telefono"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Tel&eacute;fono dos:</td>
            <td colspan="2" align="center" valign="top">Incluir el prefijo del pa&iacute;s  y de la ciudad. Ejemplo: 57 1 XXXXXX<br />              
            <input name="telefono2" type="text" id="telefono2" size="58" value="<?=nvl($frm["telefono2"])?>" /></td>
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
            <td height="70" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">(*) Nombre del Contacto:</span></td>
            <td colspan="2" align="left" valign="top" ><table class="contacto" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input name="contacto" id="contacto" size="58" value="<?=nvl($frm["contacto"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="51" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Documento de identidad del contacto:</td>
            <td colspan="2" align="left" valign="top" ><table class="cc1" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input name="contacto_cc" id="contacto_cc" size="58" value="<?=nvl($frm["contacto_cc"])?>" /></td>
              </tr>
            </table>
            <br />
            <br /></td>
          </tr>
          <tr>
            <td height="69" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Cargo del contacto:</td>
            <td colspan="2" align="left" valign="top" ><table class="cc1" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input name="contacto_cargo" id="contacto_cargo" size="58" value="<?=nvl($frm["contacto_contacto"])?>" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="88" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto" >(*) Trayectoria en pdf:</td>
            <td colspan="2"  valign="top" align="center"><iframe width="355px" height="170px" src="../m/codigos/artistas_trayectoria.php?item=<?=$frm["id_grupo"]?>&area=<?=$frm["area"]?>" scrolling="no" frameborder="0"></iframe></td>
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
            <td colspan="2" align="center" valign="top" class="rut"><br />
            <em><strong>(Entidades o empresas que lo representan legalmente)</strong></em></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">N&uacute;mero de identificaci&oacute;n de la empresa:<br /></td>
            <td colspan="2" align="center" valign="top" class=""><span class="colorTexto"><br />
            <strong><em>(Colombia NIT o RUT)</em></strong><em></em></span></td>
          </tr>


          <tr>
            <td height="129" align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top" class="colorTexto personas"><hr />
            Iindique el nombre y documento de la(s) persona(s) que lo(s) representar&aacute;(n) en las citas de la Rueda de Negocios.<br />
            <br /></td>
          </tr>
          
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
          </tr>


          <tr>
            <td height="49" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="124" align="left" valign="top"><br />
            </td>
            <td width="291" align="left" valign="top">&nbsp;</td>
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
      
