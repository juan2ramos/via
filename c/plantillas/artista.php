<?
$arrTitulos["perfil"]="Perfil";
$arrTitulos["en_perfil"]="Profile";
$arrTitulos["obras"]="Obras";
$arrTitulos["en_obras"]="Productions";
$arrTitulos["fotografias"]="Fotografías";
$arrTitulos["en_fotografias"]="Pictures";
$arrTitulos["videos"]="Videos";
$arrTitulos["en_videos"]="Videos";
$arrTitulos["eventos"]="Eventos";
$arrTitulos["en_eventos"]="Events";
$arrTitulos["obras"]="Obras";
$arrTitulos["ano"]="Año";
$arrTitulos["en_ano"]="Year";
$arrTitulos["autor"]="Autor";
$arrTitulos["en_autor"]="Author";
$arrTitulos["musica"]="Música";
$arrTitulos["en_musica"]="Music";
$arrTitulos["artistas"]="Artistas";
$arrTitulos["en_artistas"]="Performers";

$frm=$_GET;
if(!isset($frm["tipo"])) die("No viene información sobre el tipo de grupo");
if(!isset($frm["id"])) die("No viene el identificador del grupo");

$tipo=$frm["tipo"];
$id=$frm["id"];

if($tipo=="musica"){
	$campos="
		g.id,g.nombre,g.resena,g.en_resena,g.ciudad,g.direccion,g.telefono,g.email,g.contacto,
		g.curado,g.website,g.resena_corta,g.id_pais,g.telefono2,g.email2,g.tipo_propuesta,
		g.manager,g.booking,g.editor,g.num_personas_gira,g.num_personas_escenario,g.instrumentos,g.en_instrumentos,
		g.equipos_adicionales,g.comentarios,g.mmdd_ficha_filename,g.mmdd_ficha_filetype,
		g.mmdd_ficha_filesize,g.myspace,g.facebook,g.lastfm,g.twitter,g.booking_uno,g.booking_dos,g.booking_tres,
		g.fecha_actualizacion, g.mmdd_demo_filename, g.mmdd_demo_filetype, g.mmdd_demo_filesize
	";
	$campo="produccion";
} elseif($tipo=="teatro"){
	$campos="g.id,g.nombre,g.resena,g.en_resena,g.ciudad,g.direccion,g.telefono,g.email,g.website,g.curado,g.contacto,g.resena_corta,g.id_pais,g.telefono2,g.email2,g.fecha_actualizacion,g.facebook,g.myspace,g.lastfm,g.twitter";
	$campo="obra";
} elseif($tipo=="danza"){
	$campos="g.id,g.nombre,g.resena_corta,g.resena,g.en_resena,g.id_pais,g.ciudad,g.direccion,g.telefono,g.telefono2,g.email,g.email2,g.contacto,g.website,g.facebook,g.facebook,g.myspace,g.lastfm,g.twitter,g.curado,g.fecha_actualizacion";
	$campo="obra";
}

$qid=$db->sql_query("
	SELECT $campos, p.pais
	FROM grupos_$tipo g LEFT JOIN paises p ON g.id_pais=p.id
	WHERE g.id='$id'
");

if(!$grupo=$db->sql_fetchrow($qid)) die("El grupo no se encuentra en la base de datos.");

$titulo=$grupo["nombre"];

$qObras=$db->sql_query("
	SELECT ob.*,
	  (SELECT id FROM archivos_obras_$tipo WHERE tipo='1' AND mmdd_archivo_filename IS NOT NULL AND id_obras_$tipo=ob.id LIMIT 1) as id_archivo
	FROM obras_$tipo ob WHERE ob.id_grupos_$tipo = '$id'
");

$qImagenes=$db->sql_query("
	SELECT id,mmdd_archivo_filename,'archivos_grupos_$tipo' as tabla, 0 as 'imagen_obra'
	FROM archivos_grupos_$tipo
	WHERE id_grupos_$tipo='".$grupo["id"]."' AND tipo=1 AND mmdd_archivo_filename IS NOT NULL
	UNION
	SELECT aot.id,aot.mmdd_archivo_filename,'archivos_obras_$tipo' as tabla, 1 as 'imagen_obra'
	FROM archivos_obras_$tipo aot LEFT JOIN obras_$tipo ot ON aot.id_obras_$tipo=ot.id
	WHERE ot.id_grupos_$tipo='".$grupo["id"]."' AND aot.tipo=1 AND aot.mmdd_archivo_filename IS NOT NULL
");

if($imagen = $db->sql_fetchrow($qImagenes)){
	$img="<img src=\"http://www.bogotamusicmarket.com/m/admin/imagen.php?table=$imagen[tabla]&field=archivo&id=" . $imagen["id"] . "\"/>";
} else $img="";

$qVideos=$db->sql_query("
	(SELECT id, etiqueta, orden, '1' as tabla FROM archivos_grupos_$tipo WHERE id_grupos_$tipo = '$id' AND tipo='3')
	UNION 
	(SELECT ao.id,ao.etiqueta, ao.orden, '2' as tabla
	FROM archivos_obras_$tipo ao LEFT JOIN obras_$tipo o ON ao.id_obras_$tipo = o.id
	WHERE o.id_grupos_$tipo='".$id."' AND ao.tipo=3 AND ao.url IS NOT NULL)
	ORDER BY tabla,orden
");

$qGruposRelacionados=$db->sql_query("
	SELECT DISTINCT g.nombre, gg.id_grupos_$tipo, (SELECT id FROM archivos_grupos_$tipo WHERE id_grupos_$tipo=gg.id_grupos_$tipo AND tipo='1' LIMIT 1) as id_archivo
	FROM generos_grupo_$tipo gg LEFT JOIN grupos_$tipo g ON gg.id_grupos_$tipo=g.id
	WHERE gg.id_grupos_$tipo!='$id' AND gg.id_generos_$tipo IN (SELECT id_generos_$tipo FROM generos_grupo_$tipo WHERE id_grupos_$tipo='$id' )
	LIMIT 8
");

setlocale(LC_TIME, "es_ES");
$condicion="ev.fin>='" . date("Y-m-d H:i:s") . "'";
$qTipos=$db->sql_query("
	SELECT DISTINCT t.*
	FROM eventos ev LEFT JOIN ev_tipos t ON ev.id_tipo=t.id
	WHERE $condicion
	ORDER BY t.nombre
");
$from="eventos ev";
if(isset($frm["id_tipo"])) $condicion.=" AND ev.id_tipo='$frm[id_tipo]'";
if(isset($frm["id"]) && isset($frm["tipo"])){
	$from="ev_grupos eg LEFT JOIN eventos ev ON eg.id_evento=ev.id";
	$condicion.="  AND eg.id_grupo_" . $frm["tipo"]. "='" . $frm["id"] . "'";
}
$from.=" LEFT JOIN ev_tipos t ON ev.id_tipo=t.id";
$qEventos=$db->sql_query("
	SELECT DISTINCT ev.id as id_evento,ev.id_tipo,ev.nombre,ev.id_mercado,ev.ubicacion,ev.ciudad,
		ev.pais,ev.telefonos,ev.descripcion,ev.en_descripcion,ev.mmdd_imagen_filename,ev.precios,ev.link,ev.inicio, ev.fin, t.nombre as tipo
	FROM $from
	WHERE $condicion
	ORDER BY ev.fin
");
?>

<div id="disciplina">
	<?=$img?>
    <h1 class="<?=$tipo?>"><?=$grupo["nombre"]?></h1>
    <? 
		if($_GET["modo"]=="perfil") echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=perfil&tipo=$tipo&id=$id\" class=\"$tipo\">". translate($arrTitulos,"perfil") ."</a>\n";
		else echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=perfil&tipo=$tipo&id=$id\">". translate($arrTitulos,"perfil") ."</a>\n";
		
  		if(isset($qObras) && $db->sql_numrows($qObras)!=0) {
			if($_GET["modo"]=="obras") echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=obras&tipo=$tipo&id=$id\" class=\"$tipo\">". translate($arrTitulos,"obras") ."</a>\n";
			else echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=obras&tipo=$tipo&id=$id\">". translate($arrTitulos,"obras") ."</a>\n";
		}
		
  		if(isset($qImagenes) && $db->sql_numrows($qImagenes)>0) {
			if($_GET["modo"]=="fotografias") echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=fotografias&tipo=$tipo&id=$id\" class=\"$tipo\">". translate($arrTitulos,"fotografias") ."</a>\n";
			else echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=fotografias&tipo=$tipo&id=$id\">". translate($arrTitulos,"fotografias") ."</a>\n";
		}
		
  		if(isset($qVideos) && $db->sql_numrows($qVideos)!=0) {
			if($_GET["modo"]=="videos") echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=videos&tipo=$tipo&id=$id\" class=\"$tipo\">". translate($arrTitulos,"videos") ."</a>\n";
			else echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=videos&tipo=$tipo&id=$id\">". translate($arrTitulos,"videos") ."</a>\n";
		}
		
		if(isset($qEventos) && $db->sql_numrows($qEventos)!=0) {
			if($_GET["modo"]=="eventos") echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=eventos&tipo=$tipo&id=$id\" class=\"$tipo\">". translate($arrTitulos,"eventos") ."</a>\n";
			else echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=eventos&tipo=$tipo&id=$id\">". translate($arrTitulos,"eventos") ."</a>\n";
		}
  	?>
</div>
<div class="artista">
	<table width="440" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td>
            <? include("plantillas/".$_GET['modo'].".php"); ?>
           	</td>
		</tr>
	</table>
</div>
