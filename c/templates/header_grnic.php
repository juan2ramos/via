<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Gran Rueda de Negocios de las Industrias Culturales <?if(isset($titulo)) echo ":: " . $titulo?></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(../imagenes/grnic_fondo.gif);
}
#contenedor #cabezote {
	background-image: url(../imagenes/grnic_cabezote_fondo.gif);
}
#contenedor #cabezote #menu {
	background-color:#13BDCE;
}
#contenedor #cabezote #menu #entrar{
	display:inline;
}
#contenedor #contenido #texto #bandera a,
#contenedor .eventos a,
a {
	color:#13BDCE;
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
$arrTitulos["buscar"]="Buscar";
$arrTitulos["en_buscar"]="Search";
$arrTitulos["entrar"]="Entrar";
$arrTitulos["en_entrar"]="Login";
$arrTitulos["idioma"]="English";
$arrTitulos["en_idioma"]="Español";
$arrTitulos["lenguaje"]="en";
$arrTitulos["en_lenguaje"]="es";

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
$arrTitulos["promotores"]="Promotores";
$arrTitulos["en_promotores"]="Promotores";

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

$arrTitulos["musica"]="M&uacute;sica";
$arrTitulos["en_musica"]="Music";
$arrTitulos["teatro"]="Teatro";
$arrTitulos["en_teatro"]="Theatre";
$arrTitulos["danza"]="Danza";
$arrTitulos["en_danza"]="Dance";

?>

<body>
<div id="contenedor">
  
<div id="cabezote">
  <? if(isset($_GET["artistas"])) {
	 	//echo "<img src=\"".translate_imagen("cabezote_grnic_".$_GET["artistas"].".jpg")."\" width=\"960\" height=\"95\" border=\"0\" usemap=\"#Menu\" />";
  	 }else{
	 	//echo "<img src=\"".translate_imagen("cabezote_grnic.jpg")."\" width=\"960\" height=\"95\" border=\"0\" usemap=\"#Menu\" />";
	 }
	 echo "<img src='../imagenes/cabezote_mercado.jpg' width=\"960\" height=\"95\" border=\"0\" />"
  ?>
  <map name="Menu" id="Menu">
    <area shape="rect" coords="83,0,295,101" href="index.php" />
    <area shape="rect" coords="832,22,937,37" href="grupos.php?artistas=teatro" />
    <area shape="rect" coords="832,39,937,54" href="grupos.php?artistas=danza" />
    <area shape="rect" coords="832,56,938,71" href="grupos.php?artistas=musica" />
    <area shape="rect" coords="832,74,939,89" href="eventos.php?artistas=eventos" />
  </map>
  <form id="busqueda" name="busqueda" method="get" action="<?=$target?>">
    <? if(isset($_GET["artistas"])) echo "<input type=\"hidden\" name=\"artistas\" value=\"$_GET[artistas]\" />\n";?>
    <label>
      <input name="querystring" type="text" id="textfield" size="20" />
    </label>
    <label>
      <input type="submit" class="botonBusqueda" id="button" value="<?=translate($arrTitulos,"buscar")?>" />
    </label>
  </form>
  <div id="menu"> 
  <?php /*?><a href="index.php"><?=translate($arrTitulos,"inicio")?></a> | <?php */?>
  <a href="informacion.php"><?=translate($arrTitulos,"sobre_rueda")?></a> | 
  <a href="reglamento.php"><?=translate($arrTitulos,"reglamento")?></a> | 
  <a href="cronograma.php"><?=translate($arrTitulos,"cronograma")?></a> | 
  <a href="grupos.php?artistas=musica"><?=translate($arrTitulos,"musica")?></a> | 
  <a href="grupos.php?artistas=teatro"><?=translate($arrTitulos,"teatro")?></a> | 
   <a href="grupos.php?artistas=danza"><?=translate($arrTitulos,"danza")?></a> | 
  <?php /*?><a href="inscripciones.php"><?=translate($arrTitulos,"inscripciones")?></a> |  <?php */?>
  <a href="promotores.php"><?=translate($arrTitulos,"promotores")?></a> | 
  <a href="contacto.php"><?=translate($arrTitulos,"contacto")?></a> | 
  <a href="<?=$CFG->ME . hallar_querystring("lang",translate($arrTitulos,"lenguaje"))?>"><?=translate($arrTitulos,"idioma")?></a>
  <form id="entrar" name="usuario" method="post" action="">
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
						echo "<option value='agenda.php?id_mercado=" . $CFG->id_mercado_8 . "&id_promotor=$prom[id] '$selected>".translate($arrTitulos,"miagenda")."</option>";
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

