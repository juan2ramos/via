<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Sexta Fiesta de las Artes Escénicas de Medellín <?if(isset($titulo)) echo ":: " . $titulo?></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(../imagenes/mae_fondo.gif);
}
#contenedor #cabezote #menu {
	background-color:#2352C3;
}
#contenedor #cabezote #menu #entrar{
	display:inline;
}
#contenedor #contenido #texto #bandera a,
#contenedor .eventos a,
a {
	color:#2352C3;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function review(select){
	url=select.options[select.selectedIndex].value;
	if(url!='') window.location.href=url;
}
//-->
</script>
</head>

<?
if(simple_me($ME)=="promotores.php") $target="promotores.php";
else $target="grupos.php";

$arrTitulos["inicio"]="Inicio";
$arrTitulos["en_inicio"]="Home";
$arrTitulos["grupos"]="Agrupaciones musicales";
$arrTitulos["en_gruposr"]="Musicians";
$arrTitulos["sobre_rueda"]="Sobre la rueda";
$arrTitulos["en_sobre_rueda"]="About business roundtable";
$arrTitulos["contacto"]="Contacto";
$arrTitulos["en_contacto"]="Contact";
$arrTitulos["buscar"]="Buscar";
$arrTitulos["en_buscar"]="Search";
$arrTitulos["entrar"]="Entrar";
$arrTitulos["en_entrar"]="Login";
$arrTitulos["idioma"]="English";
$arrTitulos["en_idioma"]="Español";
$arrTitulos["lenguaje"]="en";
$arrTitulos["en_lenguaje"]="es";

$arrTitulos["menu"]="Menú";
$arrTitulos["en_menu"]="Menu";
$arrTitulos["miperfil"]="Mi Perfil";
$arrTitulos["en_miperfil"]="My Profile";
$arrTitulos["misobras"]="Mis Obras";
$arrTitulos["en_misobras"]="My Works";
$arrTitulos["misfotografias"]="Mis Fotografías";
$arrTitulos["en_misfotografias"]="My Pictures";
$arrTitulos["misvideos"]="Mis Videos";
$arrTitulos["en_misvideos"]="My Videos";
$arrTitulos["miseventos"]="Mis Eventos";
$arrTitulos["en_miseventos"]="My Events";
$arrTitulos["miagenda"]="Mi Agenda";
$arrTitulos["en_miagenda"]="My Agenda";
$arrTitulos["salir"]="Salir";
$arrTitulos["en_salir"]="Close";

?>

<body>
<div id="contenedor">
  
<div id="cabezote">

<?php /*?><form id="usuarioMae" name="usuarioMae" method="post" action="">
    <label>
    <?
				if(!isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])) echo "<input type=\"button\" onClick=\"window.location.href='login.php'\" value=\"Entrar\">\n";
				else{
					echo "<select name=\"select\" id=\"select\" onChange=\"review(this)\">\n";
					echo "<option value=\"\">Men&uacute;</option>";
					if($_SESSION[$CFG->sesion]["user"]["id_nivel"]==10){//Promotor
						$prom=$_SESSION[$CFG->sesion]["user"];
						if(simple_me($ME)=="promotores.php") $selected=" SELECTED";
						else $selected="";
						echo "<option value='promotores.php?mode=perfil&id=$prom[id]'$selected>Mi perfil</option>";
						if(simple_me($ME)=="agenda.php") $selected=" SELECTED";
						else $selected="";
						echo "<option value='agenda.php?id_mercado=" . $CFG->id_mercado_2 . "'$selected>Mi agenda</option>";
//						echo "<a href=\"promotores.php?mode=perfil&id=$prom[id]\">$prom[nombre] $prom[apellido]</a> | ";
					}
					elseif(in_array($_SESSION[$CFG->sesion]["user"]["id_nivel"],array(4,5,6,7,8,9))){//Artista
						$art=$_SESSION[$CFG->sesion]["user"];
						$tipo=$art["grupo_tipo"];
						if(simple_me($ME)=="perfil.php") $selected=" SELECTED";
						else $selected="";
						echo "<option value='perfil.php?id=$art[grupo_id]&tipo=$tipo'$selected>Mi perfil</option>";

						$qObras=$db->sql_query("SELECT COUNT(*) as total FROM obras_$tipo WHERE id_grupos_$art[grupo_tipo]='$art[grupo_id]'");
						$result=$db->sql_fetchrow($qObras);
						if(simple_me($ME)=="obras.php") $selected=" SELECTED";
						else $selected="";
						if($result["total"]>0) echo "<option value='obras.php?tipo=$tipo&id=$art[grupo_id]'$selected>Mis obras</option>";

						$qFotografias=$db->sql_query("
							SELECT COUNT(*) as total FROM (
								SELECT id FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='$art[grupo_id]' AND tipo=1 AND mmdd_archivo_filename IS NOT NULL
								UNION SELECT id FROM archivos_obras_$tipo WHERE id_obras_$tipo IN (SELECT id FROM obras_$tipo WHERE id_grupos_$tipo = '$art[grupo_id]') AND tipo=1 AND mmdd_archivo_filename IS NOT NULL
							) as foo
						");
						$result=$db->sql_fetchrow($qFotografias);
						if(simple_me($ME)=="fotografias.php" || simple_me($ME)=="detalle.php") $selected=" SELECTED";
						else $selected="";
						if($result["total"]>0) echo "<option value='fotografias.php?tipo=$art[grupo_tipo]&id=$art[grupo_id]'$selected>Mis fotograf&iacute;as</option>";

						$qVideos=$db->sql_query("
							SELECT COUNT(*) as total FROM (
								SELECT id FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='$art[grupo_id]' AND tipo=3 AND url IS NOT NULL
								UNION SELECT id FROM archivos_obras_$tipo WHERE id_obras_$tipo IN (SELECT id FROM obras_$tipo WHERE id_grupos_$tipo = '$art[grupo_id]') AND tipo=3 AND url IS NOT NULL
							) as foo
						");
						$result=$db->sql_fetchrow($qVideos);
						if(simple_me($ME)=="videos.php") $selected=" SELECTED";
						else $selected="";
						if($result["total"]>0) echo "<option value='videos.php?tipo=$art[grupo_tipo]&id=$art[grupo_id]'$selected>Mis videos</option>";

						$hoy=date("Y-m-d");
						$qMercados=$db->sql_query("SELECT * FROM mercados WHERE fecha_inicio<='$hoy' AND fecha_final>='$hoy' AND id IN (SELECT id_mercado FROM mercado_artistas WHERE id_grupo_$art[grupo_tipo]='$art[grupo_id]')");
						if($result=$db->sql_fetchrow($qMercados)){
							if(simple_me($ME)=="agenda.php") $selected=" SELECTED";
							else $selected="";
							echo "<option value='agenda.php'$selected>Mi agenda</option>";
						}
					}
					echo "<option value='login.php'>Salir</option>\n";
					echo "</select>\n";
				}
			?>
    </label>
  </form><?php */?>

 <img src="../imagenes/cabezote_mae2010.jpg" width="1000" height="95" border="0" usemap="#Menu" />
  <form id="busqueda" name="busqueda" method="get" action="<?=$target?>">
    <? if(isset($_GET["artistas"])) echo "<input type=\"hidden\" name=\"artistas\" value=\"$_GET[artistas]\" />\n";?>
    <label>
      <input name="querystring" type="text" id="textfield" size="20" />
    </label>
    <label>
      <input type="submit" class="botonBusqueda" id="button" value="Buscar" />
    </label>
  </form>
  <div id="menu"> 
  <a href="index.php">Inicio</a> | 
   <a href="sobre.php">Sobre el Mercado</a>  | 
  <a href="grupos.php?artistas=teatro">Portafolio Teatro</a>  | 
  <a href="grupos.php?artistas=danza">Portafolio Danza</a>  | 
  <a href="promotores.php">Promotores</a>  | 
  <a href="http://www.medellinenescena.com/index.html" target="_blank">Medellín en Escena</a>  | 
  <?php /*?><a href="<?=$CFG->ME . hallar_querystring("lang",translate($arrTitulos,"lenguaje"))?>"><?=translate($arrTitulos,"idioma")?></a><?php */?>
  <form id="entrar" name="entrar" method="post" action="">
    <label>
    <?
				if(!isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])) echo "<input type=\"button\" onClick=\"window.location.href='login.php'\" value=\"".translate($arrTitulos,"entrar")."\">\n";
				else{
					echo "<select name=\"select\" id=\"select\" onChange=\"review(this)\">\n";
					echo "<option value=\"\">".translate($arrTitulos,"menu")."</option>";
					if($_SESSION[$CFG->sesion]["user"]["id_nivel"]==10){//Promotor
						$prom=$_SESSION[$CFG->sesion]["user"];
						if(simple_me($ME)=="promotores.php") $selected=" SELECTED";
						else $selected="";
						echo "<option value='promotores.php?mode=perfil&id=$prom[id]'$selected>".translate($arrTitulos,"miperfil")."</option>";
						if(simple_me($ME)=="agenda.php") $selected=" SELECTED";
						else $selected="";
						echo "<option value='agenda.php?id_mercado=" . $CFG->id_mercado . "'$selected>".translate($arrTitulos,"miagenda")."</option>";
//						echo "<a href=\"promotores.php?mode=perfil&id=$prom[id]\">$prom[nombre] $prom[apellido]</a> | ";
					}
					elseif(in_array($_SESSION[$CFG->sesion]["user"]["id_nivel"],array(4,5,6,7,8,9))){//Artista
						$art=$_SESSION[$CFG->sesion]["user"];
						$tipo=$art["grupo_tipo"];
						if(simple_me($ME)=="perfil.php") $selected=" SELECTED";
						else $selected="";
						echo "<option value='perfil.php?id=$art[grupo_id]&tipo=$tipo'$selected>".translate($arrTitulos,"miperfil")."</option>";

						$qObras=$db->sql_query("SELECT COUNT(*) as total FROM obras_$tipo WHERE id_grupos_$art[grupo_tipo]='$art[grupo_id]'");
						$result=$db->sql_fetchrow($qObras);
						if(simple_me($ME)=="obras.php") $selected=" SELECTED";
						else $selected="";
						if($result["total"]>0) echo "<option value='obras.php?tipo=$tipo&id=$art[grupo_id]'$selected>".translate($arrTitulos,"misobras")."</option>";

						$qFotografias=$db->sql_query("
							SELECT COUNT(*) as total FROM (
								SELECT id FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='$art[grupo_id]' AND tipo=1 AND mmdd_archivo_filename IS NOT NULL
								UNION SELECT id FROM archivos_obras_$tipo WHERE id_obras_$tipo IN (SELECT id FROM obras_$tipo WHERE id_grupos_$tipo = '$art[grupo_id]') AND tipo=1 AND mmdd_archivo_filename IS NOT NULL
							) as foo
						");
						$result=$db->sql_fetchrow($qFotografias);
						if(simple_me($ME)=="fotografias.php" || simple_me($ME)=="detalle.php") $selected=" SELECTED";
						else $selected="";
						if($result["total"]>0) echo "<option value='fotografias.php?tipo=$art[grupo_tipo]&id=$art[grupo_id]'$selected>".translate($arrTitulos,"misfotografias")."</option>";

						$qVideos=$db->sql_query("
							SELECT COUNT(*) as total FROM (
								SELECT id FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='$art[grupo_id]' AND tipo=3 AND url IS NOT NULL
								UNION SELECT id FROM archivos_obras_$tipo WHERE id_obras_$tipo IN (SELECT id FROM obras_$tipo WHERE id_grupos_$tipo = '$art[grupo_id]') AND tipo=3 AND url IS NOT NULL
							) as foo
						");
						$result=$db->sql_fetchrow($qVideos);
						if(simple_me($ME)=="videos.php") $selected=" SELECTED";
						else $selected="";
						if($result["total"]>0) echo "<option value='videos.php?tipo=$art[grupo_tipo]&id=$art[grupo_id]'$selected>".translate($arrTitulos,"misvideos")."</option>";

						$hoy=date("Y-m-d");
						$qMercados=$db->sql_query("SELECT * FROM mercados WHERE fecha_inicio<='$hoy' AND fecha_final>='$hoy' AND id IN (SELECT id_mercado FROM mercado_artistas WHERE id_grupo_$art[grupo_tipo]='$art[grupo_id]')");
						if($result=$db->sql_fetchrow($qMercados)){
							if(simple_me($ME)=="agenda.php") $selected=" SELECTED";
							else $selected="";
							echo "<option value='agenda.php'$selected>".translate($arrTitulos,"miagenda")."</option>";
						}
					}
					echo "<option value='login.php'>".translate($arrTitulos,"salir")."</option>\n";
					echo "</select>\n";
				}
			?>
    </label>
  </form>
  </div>
</div>

