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
			<form name="entryform" method="post" onSubmit="return revisar()" action="<?=$ME?>">
			<input type="hidden" name="mode" value="update">
			<input type="hidden" name="id" value="<?=$frm["id"]?>">
				<table width="100%">
					<tr>
						<td valign="top" align="center"><h2>Datos personales</h2><table><?=$string_entidad?></table></td>
						<td valign="top" align="center">
						<?
						$qEmpresas=$db->sql_query("
							SELECT emp.*
							FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
							WHERE ep.id_promotor='$frm[id]'
						");
						if($db->sql_numrows($qEmpresas)>0) echo "<h2>Empresa(s)</h2>\n";

						while($empresa=$db->sql_fetchrow($qEmpresas)){
							$razonesOptions=$db->sql_listbox("SELECT id,nombre FROM emp_razon_social","Seleccione...",$empresa["id_razon"]);
							$naturalezasOptions=$db->sql_listbox("SELECT id,nombre FROM emp_naturalezas","Seleccione...",$empresa["id_naturaleza"]);
							echo "<table>\n";
							echo "<tr><td>Nombre:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][empresa]\" value=\"" . $empresa["empresa"] . "\"></td></tr>\n";
							echo "<tr><td>Razón social:</td><td><select name=\"empresa[" . $empresa["id"] . "][id_razon]\">" . $razonesOptions . "</select></td></tr>\n";
							echo "<tr><td>Naturaleza:</td><td><select name=\"empresa[" . $empresa["id"] . "][id_naturaleza]\">" . $naturalezasOptions . "</select></td></tr>\n";
							echo "<tr><td>Nit:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][nit]\" value=\"" . $empresa["nit"] . "\"></td></tr>\n";
							echo "<tr><td>Dirección:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][direccion]\" value=\"" . $empresa["direccion"] . "\"></td></tr>\n";
							echo "<tr><td>Teléfono:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][telefono]\" value=\"" . $empresa["telefono"] . "\"></td></tr>\n";
							echo "<tr><td>Página web:</td><td><input type=\"text\" name=\"empresa[" . $empresa["id"] . "][web]\" value=\"" . $empresa["web"] . "\"></td></tr>\n";
							echo "<tr><td colspan=\"2\"><hr /></td></tr>\n";
							echo "</table>\n";
						}
						?>
						</td>
					</tr>
					<tr><td colspan="2" align="center"><input type="submit" value="Guardar Cambios"></td></tr>
				</table>
			</form>
    
    <img src="<? $CFG->wwwroot ?>/imagenes/texto_inferior.jpg" width="810" height="10" />
  </div></div>

