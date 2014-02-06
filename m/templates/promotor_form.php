<?
	if(
		!isset($_SESSION[$CFG->sesion]["user"]["id_nivel"]) ||
		$_SESSION[$CFG->sesion]["user"]["id_nivel"]!=10 ||
		$_SESSION[$CFG->sesion]["user"]["id"]!=$frm["id"]
	){//Promotor
		die("Sólo puede modificar sus datos");
	}

	include($CFG->modulesdir . "/promotores.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;
	$entidad->load($frm["id"]);
	$entidad->set("newMode","update");
	$entidad->set("bgColorFieldValue","#FFFFFF");
	$entidad->links=array();
	$att=$entidad->getAttributeByName("vigente");
	$att->set("inputType","hidden");

	$string_entidad=$entidad->getForm($frm);
	$javascript_entidad=$entidad->getJavaScript();

?>
	<img src="<? $CFG->wwwroot ?>/imagenes/texto_superior.jpg" />
  <div id="contenido">
	<?=$javascript_entidad?>
		<? include("../templates/menu_promotores.php");?>
    <div id="texto">
    <div id="perfil">
			<form name="entryform" method="post" onSubmit="return revisar()" action="<?=$ME?>">
			<input type="hidden" name="mode" value="update">
			<input type="hidden" name="id" value="<?=$frm["id"]?>">
				<table width="800">
					<tr align="left">
						<td width="400" valign="top">
                        <h2>Datos personales</h2>
                        <table>
						<?=$string_entidad?></table>
  					
                        <?
						echo "<br/><h2>Actividades</h2>";

						$qTareas=$db->sql_query("SELECT * FROM pr_tareas");
						while($tarea=$db->sql_fetchrow($qTareas)){
							$qTarea=$db->sql_query("SELECT * FROM pr_promotores_tareas WHERE id_promotor='$frm[id]' AND id_tarea='$tarea[id]'");
							if($db->sql_numrows($qTarea)>0) $checked=" CHECKED";
							else $checked="";
							echo "<input type=\"checkbox\" name=\"pr_promotores_tareas[]\" value=\"" . $tarea["id"]. "\"" . $checked . ">";
							echo "" . $tarea["nombre"] . "<br/>";
						}
						echo "<br/><h2>&Aacute;reas</h2>";
						echo "<table>\n";
						$qAreas=$db->sql_query("SELECT id,nombre,en_nombre,codigo,link_mercado FROM pr_areas");
						$i=0;
						while($area=$db->sql_fetchrow($qAreas)){
							$qArea=$db->sql_query("SELECT * FROM pr_promotores_areas WHERE id_promotor='$frm[id]' AND id_area='$area[id]'");
						//preguntar($area);
							if($db->sql_numrows($qArea)>0) $checked=" CHECKED";
							else $checked="";

							if(($i%3)==0) echo "<tr>";
							echo "<td><input type=\"checkbox\" name=\"pr_promotores_areas[]\" value=\"" . $area["id"] . "\"" . $checked . "></td>\n";	
							echo "<td>" . $area["nombre"] . "</td>\n";
							$i++;
							if(($i%3)==0) echo "</tr>";
							
						
						}
						echo "</table>\n";
						echo "<br/><h2>Idiomas</h2>";
						echo "<table>\n";
						$qIdiomas=$db->sql_query("SELECT * FROM pr_idiomas");
						$i=0;
						while($idioma=$db->sql_fetchrow($qIdiomas)){
							$qIdioma=$db->sql_query("SELECT * FROM pr_promotores_idiomas WHERE id_promotor='$frm[id]' AND id_idioma='$idioma[id]'");
						//preguntar($area);
							if($db->sql_numrows($qIdioma)>0) $checked=" CHECKED";
							else $checked="";

							if(($i%2)==0) echo "<tr>";
							echo "<td><input type=\"checkbox\" name=\"pr_promotores_idiomas[]\" value=\"" . $idioma["id"] . "\"" . $checked . "></td>\n";	
							echo "<td>" . $idioma["idioma"] . "</td>\n";
							$i++;
							if(($i%2)==0) echo "</tr>";
						}
						echo "</table>\n";
						?>
                        </td>
						<td valign="top">
						<?
						$qEmpresas=$db->sql_query("
							SELECT emp.*
							FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
							WHERE ep.id_promotor='$frm[id]'
						");
						if($db->sql_numrows($qEmpresas)>0) echo "<h2>Organizaciones</h2>\n";

						while($empresa=$db->sql_fetchrow($qEmpresas)){
							$naturalezasOptions=$db->sql_listbox("SELECT id,nombre FROM emp_naturalezas","Seleccione...",$empresa["id_naturaleza"]);
							echo "<table>\n";
							echo "<tr><td>Nombre:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][empresa]\" value=\"" . $empresa["empresa"] . "\"></td></tr>\n";
							echo "<tr><td>Naturaleza:</td><td><select name=\"empresa[" . $empresa["id"] . "][id_naturaleza]\">" . $naturalezasOptions . "</select></td></tr>\n";
							echo "<tr><td>Nit:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][nit]\" value=\"" . $empresa["nit"] . "\"></td></tr>\n";
							echo "<tr><td>Dirección:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][direccion]\" value=\"" . $empresa["direccion"] . "\"></td></tr>\n";
							echo "<tr><td>Teléfono 1:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][telefono]\" value=\"" . $empresa["telefono"] . "\"></td></tr>\n";
							echo "<tr><td>Teléfono 2:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][telefono2]\" value=\"" . $empresa["telefono2"] . "\"></td></tr>\n";
							echo "<tr><td>Página web:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][web]\" value=\"" . $empresa["web"] . "\"></td></tr>\n";
							echo "<tr><td>E-mail:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][email]\" value=\"" . $empresa["email"] . "\"></td></tr>\n";
							echo "<tr><td>Ciudad:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][ciudad]\" value=\"" . $empresa["ciudad"] . "\"></td></tr>\n";
							echo "<tr><td>País:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][pais]\" value=\"" . $empresa["pais"] . "\"></td></tr>\n";
							//actividades
							echo "<tr><td colspan=\"2\"><h3>Actividades de la Organización</h2></td></tr>\n";
							$actividades = array();
							$qidActIn = $db->sql_query("SELECT * FROM empresas_razones WHERE id_empresa=".$empresa["id"]);
							while($queryActIn = $db->sql_fetchrow($qidActIn))
							{
								$actividades[] = $queryActIn["id_emp_razon_social"];
							}
							$qAct=$db->sql_query("SELECT * FROM emp_razon_social ORDER BY nombre");
							while($act=$db->sql_fetchrow($qAct)){
								$checked="";
								if(in_array($act["id"],$actividades))
									$checked="checked";

								echo "<tr><td colspan=\"2\"><input type=\"checkbox\" name=\"empresas_razones[]\" value=\"" . $act["id"] . "\"" . $checked . ">" . $act["nombre"] . "</td></tr>\n";
							}
							//ventas	
							$qidV = $db->sql_query("SELECT * FROM empresas_ventas WHERE id_empresa=".$empresa["id"]." ORDER BY ano");
							if($db->sql_numrows($qidV))
							{
								echo "<tr><td colspan=\"2\"><br><h3>Ventas últimos años</h3></td></tr>\n";
								while($val = $db->sql_fetchrow($qidV))
								{
									echo "<input type=\"hidden\" name=\"valores[" . $val["id"] . "][ano]\" value=\"".$val["ano"]."\">";
									echo "<input type=\"hidden\" name=\"valores[" . $val["id"] . "][id_empresa]\" value=\"".$empresa["id"]."\">";
									echo "<tr><td colspan=\"2\"><h4>".$val["ano"]."</h4></td></tr>\n";
									?>
									<tr><td>Monto USD:</td><td><select name="valores[<?=$val["id"]?>][monto]">
										<option value='%'>Seleccione...</option>
										<option value='1' <?if($val["monto"]==1) echo "selected";?>>Menos de US$50.000</option>
										<option value='2' <?if($val["monto"]==2) echo "selected";?>>US$50.000 - US$100.000</option>
										<option value='3' <?if($val["monto"]==3) echo "selected";?>>US$100.000 - US$250.000</option>
										<option value='4' <?if($val["monto"]==4) echo "selected";?>>US$250.000 - US$500.000</option>
										<option value='5' <?if($val["monto"]==5) echo "selected";?>>US$500.000 - US$1.000.000</option>
										<option value='6' <?if($val["monto"]==6) echo "selected";?>>US$1.000.000 - US$5.000.000</option>
										<option value='7' <?if($val["monto"]==7) echo "selected";?>>Más de US$5.000.000</option>
										</td></tr>
									<?
									echo "<tr><td>% Mercado Nacional:</td><td><input type=\"text\" name=\"valores[" . $val["id"] . "][mercado_nal]\" value=\"" . $val["mercado_nal"] . "\"></td></tr>\n";
									echo "<tr><td>% Mercado Internacional:</td><td><input type=\"text\" name=\"valores[" . $val["id"] . "][mercado_int]\" value=\"" . $val["mercado_int"] . "\"></td></tr>\n";
								}
							}

							echo "<tr><td colspan=\"2\"><hr /></td></tr>\n";
							echo "</table>\n";
						}	
						?>
						</td>
					</tr>
					<tr>
					  <td colspan="2" align="center">&nbsp;</td>
				  </tr>
					<tr><td colspan="2" align="center"><input type="submit" value="Guardar Cambios"></td></tr>
				</table>
			</form>
    </div>
    <img src="<? $CFG->wwwroot ?>/imagenes/texto_inferior.jpg" width="810" height="10" />
  </div></div>

