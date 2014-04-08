<?
$arrTitulos["perfil"]="Perfil";
$arrTitulos["en_perfil"]="Profile";
$arrTitulos["obras"]="Obras";
$arrTitulos["en_obras"]="Works";
$arrTitulos["fotografias"]="Fotografías";
$arrTitulos["en_fotografias"]="Pictures";
$arrTitulos["videos"]="Videos";
$arrTitulos["en_videos"]="Videos";
$arrTitulos["eventos"]="Eventos";
$arrTitulos["en_eventos"]="Events";
?>

<div id="menu">
<?

if( 
    isset($_SESSION[$CFG->sesion]["user"]["id_nivel"]) && 
	$_SESSION[$CFG->sesion]["user"]["id_nivel"]==10 && 
	simple_me($ME)=="agenda.php" &&
	(nvl($_GET["mode"])=="" || $_GET["mode"]=="rechazar_cita_promotor" || $_GET["mode"]=="confirmar_cita_promotor")
){//Promotor
	//echo "<a href=\"promotores.php?mode=perfil&id=$prom[id]\">". translate($arrTitulos,"perfil") ."</a>";
}
if(isset($_GET["id_promotor"]) && isset($id_mercado)){
	echo "<a href=\"promotores.php?id=$_GET[id_promotor]&mode=perfil&id_mercado=$id_mercado\">". translate($arrTitulos,"perfil") ."</a>\n";
}
elseif(isset($tipo) && isset($id)){
  echo "<a href=\"perfil.php?tipo=$tipo&id=$id\">". translate($arrTitulos,"perfil") ."</a>\n";
  if(isset($qObras) && $db->sql_numrows($qObras)!=0) echo "<a href=\"obras.php?tipo=$tipo&id=$id\">". translate($arrTitulos,"obras") ."</a>\n";
  if(isset($qImagenes) && $db->sql_numrows($qImagenes)>0) echo "<a href=\"fotografias.php?tipo=$tipo&id=$id\">". translate($arrTitulos,"fotografias") ."</a>\n";
  if(isset($qVideos) && $db->sql_numrows($qVideos)!=0) echo "<a href=\"videos.php?tipo=$tipo&id=$id\">". translate($arrTitulos,"videos") ."</a>\n";
  if(isset($qEventos) && $db->sql_numrows($qEventos)!=0) echo "<a href=\"eventos.php?tipo=$tipo&id=$id\">". translate($arrTitulos,"eventos") ."</a>\n"; 
}
if(isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])){
	while(isset($qMercados) && $mercado=$db->sql_fetchrow($qMercados)){
		if(isset($tipo) && isset($id)) $link="agenda.php?mode=agenda_artista&tipo=$tipo&id_artista=$id&id_mercado=$mercado[id]";
		else $link="agenda.php?id_mercado=" . $mercado["id"];
		echo "<a href=\"$link\"> ". $mercado["nombre"] ." </a>\n";
	}
}
?>
<img src="<? $CFG->wwwroot ?>/imagenes/boton_inferior.jpg" width="190" height="15" />
</div>
