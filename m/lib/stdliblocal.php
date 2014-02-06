<?php
function horaNormal($hora){
  if(preg_match("/^([0-2][0-9]):([0-5][0-9])$/",$hora,$matches)){
    $horas=round($matches[1]);
    $minutos=$matches[2];
    if($horas==12) $ampm="M";
    elseif($horas < 12) $ampm="A.M.";
    else{
      $ampm="P.M.";
      $horas=$horas-12;
    }
    return($horas . ":" . $minutos . " " . $ampm);
  }
  return("ERROR ($hora)");
}

function print_calendario($tipo,$id_mercado=0){
GLOBAL $db,$CFG;
	$fecha=date("Y-m-d");
	$string="";
	if($tipo=="danza") $id_area=1;
	elseif($tipo=="musica") $id_area=2;
	elseif($tipo=="teatro") $id_area=3;
	if($id_mercado==0){
		$from="circ_circuitos_areas ca LEFT JOIN circuitos cir ON ca.id_circuito=cir.id LEFT JOIN circ_tipos t ON cir.id_tipo=t.id";
		$condicion="cir.fin >= '" . $fecha . "' AND cir.bandera='1'";
		$condicion.=" AND ca.id_area='$id_area'";
		$qCircuitos=$db->sql_query("
			SELECT cir.id, cir.id_tipo, cir.nombre, cir.inicio, cir.fin, cir.descripcion, cir.link, cir.pais, 
			cir.ciudad, cir.circulart, cir.mmdd_imagen_filename, t.nombre as tipo, t.abreviatura
			FROM $from
			WHERE $condicion
			ORDER BY cir.id_tipo,cir.inicio
		");
		$tipo_anterior="";
		while($circuito=$db->sql_fetchrow($qCircuitos)){
			if($circuito["id_tipo"]!=$tipo_anterior){
				$string.="<p><img src=\"" . $CFG->wwwroot . "/imagenes/pestanas/" . $tipo . "_" . $circuito["abreviatura"] . ".gif\" width=\"80\" height=\"15\" /></p>\n";
			}
			$tipo_anterior=$circuito["id_tipo"];
			// =====================
			$fecha=redactar_fecha($circuito["inicio"],$circuito["fin"]);
			$qAreas=$db->sql_query("
				SELECT ar.id,ar.nombre
				FROM circ_circuitos_areas ca LEFT JOIN pr_areas ar ON ca.id_area=ar.id
				WHERE ca.id_circuito='$circuito[id]'
			");
			$arrayAreas=array();
			while($area=$db->sql_fetchrow($qAreas)){
				array_push($arrayAreas,$area["nombre"]);
			}
			$areas=implode(", ",$arrayAreas);
			// =====================
			$string.="<p>\n";
			$string.="<a href=\"circuitos.php?id_area=$id_area&id_tipo=$circuito[id_tipo]\" class=\"$tipo\">$circuito[nombre]</a><br />\n";
			$string.="<strong>" . $fecha . "</strong><br />\n";
			$string.=$areas . ", <br />\n";
			$string.=$circuito["ciudad"] . ", <br />\n";
			$string.=$circuito["pais"] . "<br />\n";
			$string.="</p>\n";
		}
	}

	$from="ev_eventos_areas ea LEFT JOIN eventos ev ON ea.id_evento=ev.id LEFT JOIN ev_tipos t ON ev.id_tipo=t.id";
	$condicion="ev.fin >= '" . $fecha . "'";
	$condicion.=" AND ea.id_area='$id_area'";
	if($id_mercado!=0) $condicion.=" AND ev.id_mercado='$id_mercado'";
	$qEventos=$db->sql_query("
		SELECT DISTINCT ev.id,ev.id_tipo,ev.nombre,ev.id_mercado,ev.ubicacion,ev.ciudad,
			ev.pais,ev.telefonos,ev.descripcion,ev.mmdd_imagen_filename,ev.precios,ev.link,ev.inicio, ev.fin, t.nombre as tipo, t.abreviatura
		FROM $from
		WHERE $condicion
		ORDER BY ev.id_tipo,ev.inicio
	");
	$tipo_anterior="";
	while($evento=$db->sql_fetchrow($qEventos)){
		if($evento["id_tipo"]!=$tipo_anterior){
			if($id_mercado==0) $string.="<p><img src=\"" . $CFG->wwwroot . "/imagenes/pestanas/" . $tipo . "_" . $evento["abreviatura"] . ".gif\" width=\"80\" height=\"15\" /></p>\n";
			else $string.="<p><span class=\"teatro\"><b>" . $evento["tipo"] . "</b></span></p>\n";
		}
		$tipo_anterior=$evento["id_tipo"];
		$fecha=redactar_fecha($evento["inicio"],$evento["fin"]);
		$qAreas=$db->sql_query("
			SELECT ar.id,ar.nombre
			FROM ev_eventos_areas ea LEFT JOIN pr_areas ar ON ea.id_area=ar.id
			WHERE ea.id_evento='$evento[id]'
		");
		$arrayAreas=array();
		while($area=$db->sql_fetchrow($qAreas)){
			array_push($arrayAreas,$area["nombre"]);
		}
		$areas=implode(", ",$arrayAreas);
		$string.="<p>\n";
		if($id_mercado==0) $string.="<a href=\"eventos_detalle.php?id_evento=$evento[id]\" class=\"$tipo\">$evento[nombre]</a><br />\n";
		else $string.="<a href=\"eventos_detalle.php?id_evento=$evento[id]\" class=\"teatro\">$evento[nombre]</a><br />\n";
    $string.="<strong>" . $fecha . "</strong><br />\n";
		$string.=$areas . ", <br />\n";
		$string.=$evento["ubicacion"] . ", <br />\n";
		$string.=$evento["ciudad"] . ", <br />\n";
		$string.=$evento["pais"] . "<br />\n";
		$string.="</p>\n";
	}

	return($string);
}

function redactar_fecha($fecha_inicio,$fecha_fin){
	$inicio=ucfirst(strftime("%A %e de %B de %Y",strtotime($fecha_inicio)));
	$fin=strftime("%A %e de %B de %Y",strtotime($fecha_fin));
	if(date("Y-m-d",strtotime($fecha_inicio)) == date("Y-m-d",strtotime($fecha_fin))){//Empieza y termina el mismo día
		$fecha=$inicio . " " . strftime("%H:%M %P",strtotime($fecha_inicio));
		$fecha.=" - " . strftime("%H:%M %P",strtotime($fecha_fin));
	}
	elseif(date("Y-m",strtotime($fecha_inicio)) == date("Y-m",strtotime($fecha_fin))){//Empieza y termina el mismo mes
		$fecha=strftime("%e",strtotime($fecha_inicio)) . " al " . strftime("%e de %B de %Y",strtotime($fecha_fin));
	}
	elseif(date("Y",strtotime($fecha_inicio)) == date("Y",strtotime($fecha_fin))){//Empieza y termina el mismo año
		$fecha=strftime("%e de %B",strtotime($fecha_inicio)) . " al " . strftime("%e de %B de %Y",strtotime($fecha_fin));
	}
	else $fecha=strftime("%e de %B de %Y",strtotime($fecha_inicio)) . " al " . strftime("%e de %B de %Y",strtotime($fecha_fin));
	return($fecha);
}

function imagen_home($area,$ubicacion="home"){
GLOBAL $db,$CFG;
	$string="";
//	if($_SERVER["REMOTE_ADDR"]=="190.25.229.74") die("SELECT id,nombre,codigo,mmdd_imagen_mercado_filename,link_mercado FROM pr_areas WHERE codigo='" . $area . "'");
	if($ubicacion=="home"){
		$field="imagen";
		$qAreas=$db->sql_query("SELECT id,nombre,codigo,mmdd_imagen_filename,link FROM pr_areas WHERE codigo='" . $area . "'");
	}
	elseif($ubicacion=="mercado"){
		$field="imagen_mercado";
		$qAreas=$db->sql_query("SELECT id,nombre,codigo,mmdd_imagen_mercado_filename,link_mercado as link FROM pr_areas WHERE codigo='" . $area . "'");
	}
	if($result=$db->sql_fetchrow($qAreas)){
		$string.="<a href=\"" . htmlentities($result["link"]) . "\">";
		$string.="<img src=\"" . $CFG->wwwroot . "/admin/imagen.php?table=pr_areas&amp;field=$field&amp;id=" . $result["id"] . "\" border=\"0\" />";
		$string.="</a>";
	}
	return($string);
}

function translate($arreglo,$variable){
  GLOBAL $CFG;

	if(isset($arreglo[$CFG->lang . "_" . $variable]) && trim($arreglo[$CFG->lang . "_" . $variable]) != "") return($arreglo[$CFG->lang . "_" . $variable]);
	if(isset($arreglo[$variable])) return($arreglo[$variable]);
	return("XX");
}

function translate_imagen($strImagen){
  GLOBAL $CFG;

	$rootPath=$CFG->dirroot . "/imagenes/";
	$wwwPath=$CFG->wwwroot . "/imagenes/";
	if(file_exists($rootPath . $CFG->lang . "_" . $strImagen)) return($wwwPath . $CFG->lang . "_" . $strImagen);
	elseif(file_exists($rootPath . $strImagen)) return($wwwPath . $strImagen);
	else return("");

}

?>
