<?
setlocale(LC_TIME, "es_ES");
$from="circuitos cir LEFT JOIN circ_tipos t ON cir.id_tipo=t.id";
$condicion="cir.fin >= '" . date("Y-m-d") . "' AND cir.bandera='1'";
if(isset($_GET["tipo"])){
	if($tipo=="danza") $id_area=1;
	elseif($tipo=="musica") $id_area=2;
	elseif($tipo=="teatro") $id_area=3;
	$from="circ_circuitos_areas ca LEFT JOIN circuitos cir ON ca.id_circuito=cir.id LEFT JOIN circ_tipos t ON cir.id_tipo=t.id";
	$condicion.=" AND ca.id_area='$id_area'";
}

$from="eventos ev LEFT JOIN ev_tipos t ON ev.id_tipo=t.id";
$condicion="ev.fin>='" . date("Y-m-d H:i:s") . "'";
if(!preg_match("/\.php\$/",simple_me($ME)) || simple_me($ME)=="index.php"){//Home
	$condicion.=" AND ev.id_mercado='" . $CFG->id_mercado . "'";
}
else{
	$condicion.="
	AND
	ev.id IN (
	SELECT DISTINCT id_evento
	FROM ev_grupos
	WHERE 
		id_grupo_musica IN (SELECT id_grupo_musica FROM mercado_artistas WHERE id_mercado='" . $CFG->id_mercado . "') OR
		id_grupo_danza IN (SELECT id_grupo_danza FROM mercado_artistas WHERE id_mercado='" . $CFG->id_mercado . "') OR
		id_grupo_teatro IN (SELECT id_grupo_teatro FROM mercado_artistas WHERE id_mercado='" . $CFG->id_mercado . "')
	)
	";
}
$strQuery="
	SELECT DISTINCT ev.id,ev.id_tipo,ev.nombre,ev.id_mercado,ev.ubicacion,ev.ciudad,
		ev.pais,ev.telefonos,ev.descripcion,ev.mmdd_imagen_filename,ev.precios,ev.link,ev.inicio, ev.fin, t.nombre as tipo
	FROM $from
	WHERE $condicion
	ORDER BY ev.id_tipo,ev.inicio
";
$qEventos=$db->sql_query($strQuery);
$tipo_anterior="";
while($evento=$db->sql_fetchrow($qEventos)){
	if($evento["id_tipo"]!=$tipo_anterior){
		echo "<h1>$evento[tipo]</h1>\n";
		echo "<hr />\n";
	}
	$tipo_anterior=$evento["id_tipo"];
	if($evento["mmdd_imagen_filename"]!="") $imgSrc="<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=eventos&field=imagen&id=" . $evento["id"]) . "&amp;w=50\" class=\"artista\" />";
	else $imgSrc="";
	if($evento["link"]!="") $link=$evento["link"];
	else $link="";
	$inicio=ucfirst(strftime("%A %e de %B de %Y",strtotime($evento["inicio"])));
	$fin=strftime("%A %e de %B de %Y",strtotime($evento["fin"]));
	if(date("Y-m-d",strtotime($evento["inicio"])) == date("Y-m-d",strtotime($evento["fin"]))){//Empieza y termina el mismo día
		$fecha=$inicio . " " . strftime("%H:%M %P",strtotime($evento["inicio"]));
		$fecha.=" - " . strftime("%H:%M %P",strtotime($evento["fin"]));
	}
	elseif(date("Y-m",strtotime($evento["inicio"])) == date("Y-m",strtotime($evento["fin"]))){//Empieza y termina el mismo mes
		$fecha=strftime("%e",strtotime($evento["inicio"])) . " al " . strftime("%e de %B de %Y",strtotime($evento["fin"]));
	}
	elseif(date("Y",strtotime($evento["inicio"])) == date("Y",strtotime($evento["fin"]))){//Empieza y termina el mismo año
		$fecha=strftime("%e de %B",strtotime($evento["inicio"])) . " al " . strftime("%e de %B de %Y",strtotime($evento["fin"]));
	}
	else $fecha=strftime("%e de %B de %Y",strtotime($evento["inicio"])) . " al " . strftime("%e de %B de %Y",strtotime($evento["fin"]));

	echo "<p>\n";
	echo $imgSrc . "<strong><a href=\"eventos_detalle.php?id_evento=" . $evento["id"] . "\">" . $evento["nombre"] . "</a></strong><br />\n";
	echo "<strong>$fecha</strong><br />\n";
	echo $evento["ubicacion"] . ", <br />\n";
	echo $evento["ciudad"] . ", <br />\n";
	echo $evento["pais"] . "<br />\n";
	echo "</p>\n";
	echo "\n";
}
?>
<p>&nbsp;</p>
