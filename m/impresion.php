<?
include("application.php");
/*if(!isset($_SESSION[$CFG->sesion]["user"]["id_nivel"]) && !isset($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"])){
	$goto = "login.php";
	header("Location: $goto");
	die();
}*/
$frm=$_GET;
setlocale (LC_TIME, "es_ES");
include("templates/header_impresion.php");
switch($frm["mode"]){
	case "detalle_cita_grupo":
		detalle_cita($frm,"grupo");
		break;
	case "detalle_cita_promotor":
		detalle_cita($frm,"promotor");
		break;
	case "agenda_promotor":
		agenda_promotor($frm);
		break;
	case "agenda_artista":
		agenda_artista($frm);
		break;
	default:
		echo $frm["mode"];
		break;
}


function agenda_artista($frm){
GLOBAL $CFG, $db, $ME;
	$format = '%Y-%m-%d %H:%M:%S';
	

	setlocale (LC_TIME, "es_ES");
	$qDatosBasicos=$db->sql_query("
		SELECT g.nombre as grupo, m.nombre as mercado
		FROM mercado_artistas ma LEFT JOIN mercados m ON ma.id_mercado=m.id
			LEFT JOIN grupos_" . $frm["tipo"] . " g ON ma.id_grupo_" . $frm["tipo"] . "=g.id
		WHERE ma.id_grupo_" . $frm["tipo"] . "='$frm[id_grupo]' AND ma.id_mercado='$frm[id_mercado]'
	");
	$datosBasicos=$db->sql_fetchrow($qDatosBasicos);
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
	");
	while($sesion=$db->sql_fetchrow($qSesiones)){
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);
		while($desde<$hasta){
			$fecha=date("Y-m-d",$desde);
			$hora=date("H:i",$desde);
			$arrayDias[$fecha]="-";
			$arrayHoras[$hora]="-";
			$qCita=$db->sql_query("SELECT * FROM citas WHERE id_sesion='$sesion[id_sesion]' AND id_grupo_" . $frm["tipo"] . "='$frm[id_grupo]' AND fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'");
			if($cita=$db->sql_fetchrow($qCita)){
				
				$mPromotor=$db->sql_query("SELECT * FROM mercado_promotores WHERE id_mercado='$frm[id_mercado]' and id_promotor='$cita[id_promotor]'");
				$numMesapromotor=$db->sql_fetchrow($mPromotor);
				
				$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id='$cita[id_promotor]'");
				$promotor=$db->sql_fetchrow($qPromotor);

				$arrayCitas[$fecha][$hora]=$promotor["nombre"] . " " . $promotor["apellido"];
				if($cita["aceptada_promotor"]!=1 || $cita["aceptada_grupo"]!=1) $arrayCitas[$fecha][$hora].="<span title=\"Pendiente\"> (Por confirmar)</span>";
				$arrayCitas[$fecha][$hora].=" (Mesa " . $numMesapromotor["mesa"] . ")";
			}			

			$desde+=60*20;
		}
	}
	
	$string="<br><br><table border=\"1\" width=\"100%\">\n";
	$string.="<tr><td colspan=\"" . (sizeof($arrayDias)+1) . "\"><b>";
	$string.=$datosBasicos["mercado"] . "<br>\n";
	$string.=$datosBasicos["grupo"] . "\n";
	$string.="</b></td></tr>";
	$string.="<tr><th>Hora</th>";
	foreach($arrayDias AS $key=>$val){
		$string.="<th>" . strftime("%B %d de %Y",strtotime($key)) . "</th>";
	}
	$string.="</tr>\n";
	foreach($arrayHoras AS $key=>$val){
		$hora=$key;
		$string.="<tr><th>$key</th>";
		foreach($arrayDias AS $key=>$val){
			$dia=$key;
			if(isset($arrayCitas[$dia][$hora])) $string.="<td bgcolor=\"#cccccc\">" . $arrayCitas[$dia][$hora] . "</td>";
			else $string.="<td>&nbsp;</td>";
		}
		$string.="</tr>\n";
	}
	$string.="</table>\n";
	$string.="<script>\nwindow.print();\n</script>\n";
	echo $string;
}

function agenda_promotor($frm){
GLOBAL $CFG, $db, $ME;
	$format = '%Y-%m-%d %H:%M:%S';
	

	setlocale (LC_TIME, "es_ES");
	$qDatosBasicos=$db->sql_query("
		SELECT CONCAT(prom.nombre, ' ', prom.apellido) as promotor, m.nombre as mercado, mp.mesa as mesa
		FROM mercado_promotores mp LEFT JOIN mercados m ON mp.id_mercado=m.id
			LEFT JOIN promotores prom ON mp.id_promotor=prom.id
		WHERE mp.id_promotor='$frm[id_promotor]' AND mp.id_mercado='$frm[id_mercado]'
	");
	$datosBasicos=$db->sql_fetchrow($qDatosBasicos);
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
	");
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);
		while($desde<$hasta){
			$fecha=date("Y-m-d",$desde);
			$hora=date("H:i",$desde);
			$arrayDias[$fecha]="-";
			$arrayHoras[$hora]="-";
			
			$qCita=$db->sql_query("SELECT * FROM citas WHERE id_sesion='$sesion[id_sesion]' AND id_promotor='$frm[id_promotor]' AND fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'");
			if($cita=$db->sql_fetchrow($qCita)){
				
			  if($cita["id_grupo_musica"]!=0){
					$tipo="musica";
					$id=$cita["id_grupo_musica"];
					}else if($cita["id_grupo_teatro"]!=0){
					   $tipo="teatro";
					   $id=$cita["id_grupo_teatro"];
					}else if($cita["id_grupo_danza"]!=0){
					  $tipo="danza";
					  $id=$cita["id_grupo_danza"];
				    }else if($cita["id_promotor2"]!=0){
					  $tipo="promotor";
					  $id=$cita["id_promotor2"];
					  $mPromotor=$db->sql_query("SELECT * FROM mercado_promotores WHERE id_mercado='$frm[id_mercado]' and id_promotor='$cita[id_promotor2]'");
				      $numMesapromotor=$db->sql_fetchrow($mPromotor); 
					  //echo $numMesapromotor["mesa"];
			  }
			  
			  
				
			  if($tipo!='promotor'){
				$qGrupo=$db->sql_query("SELECT * FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);
				$arrayCitas[$fecha][$hora]=$grupo["nombre"];
				if($cita["aceptada_promotor"]!=1 || $cita["aceptada_grupo"]!=1){
					$arrayCitas[$fecha][$hora].="<span title=\"Pendiente\"> (Por confirmar)</span>";}
				}else{
					$qGrupo=$db->sql_query("SELECT * FROM promotores WHERE id='$id'");
					$grupo=$db->sql_fetchrow($qGrupo);
					$arrayCitas[$fecha][$hora]=$grupo["nombre"]." ".$grupo["apellido"];
					if($cita["aceptada_promotor"]!=1 || $cita["aceptada_promotor2"]!=1 ){ 
					    $arrayCitas[$fecha][$hora].="<span title=\"Pendiente\"> (Por confirmar)</span>";// . " (Mesa " . $cita["mesa"] . ")";
						//$arrayCitas[$fecha][$hora].=" (Mesa " . $numMesapromotor["mesa"] . ")";
				    }
				$arrayCitas[$fecha][$hora].=" (Mesa " . $numMesapromotor["mesa"] . ")";
			  }
			}	
			
			$qCita=$db->sql_query("SELECT * FROM citas WHERE id_sesion='$sesion[id_sesion]' AND id_promotor2='$frm[id_promotor]' AND fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'");
			if($cita=$db->sql_fetchrow($qCita)){
				
			  if($cita["id_grupo_musica"]!=0){
					$tipo="musica";
					$id=$cita["id_grupo_musica"];
					}else if($cita["id_grupo_teatro"]!=0){
					   $tipo="teatro";
					   $id=$cita["id_grupo_teatro"];
					}else if($cita["id_grupo_danza"]!=0){
					  $tipo="danza";
					  $id=$cita["id_grupo_danza"];
				    }else if($cita["id_promotor"]!=0){
					  $tipo="promotor";
					  $id=$cita["id_promotor"];
					  $mPromotor=$db->sql_query("SELECT * FROM mercado_promotores WHERE id_mercado='$frm[id_mercado]' and id_promotor='$cita[id_promotor]'");
				      $numMesapromotor=$db->sql_fetchrow($mPromotor); 
					  //echo $numMesapromotor["mesa"];
			  }
			  
			  
				
			  if($tipo!='promotor'){
				$qGrupo=$db->sql_query("SELECT * FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);
				$arrayCitas[$fecha][$hora]=$grupo["nombre"];
				if($cita["aceptada_promotor"]!=1 || $cita["aceptada_grupo"]!=1){
					$arrayCitas[$fecha][$hora].="<span title=\"Pendiente\"> (Por confirmar)</span>";}
				}else{
					$qGrupo=$db->sql_query("SELECT * FROM promotores WHERE id='$id'");
					$grupo=$db->sql_fetchrow($qGrupo);
					$arrayCitas[$fecha][$hora]=$grupo["nombre"]." ".$grupo["apellido"];
					if($cita["aceptada_promotor"]!=1 || $cita["aceptada_promotor2"]!=1 ){ 
					    $arrayCitas[$fecha][$hora].="<span title=\"Pendiente\"> (Por confirmar)</span>";// . " (Mesa " . $cita["mesa"] . ")";
						//$arrayCitas[$fecha][$hora].=" (Mesa " . $numMesapromotor["mesa"] . ")";
				    }
				$arrayCitas[$fecha][$hora].=" (Mesa " . $numMesapromotor["mesa"] . ")";
			  }
			}			
					

			$desde+=60*20;
		}
	}
	
	$string="<br><br><table border=\"1\" width=\"100%\">\n";
	$string.="<tr><td colspan=\"" . (sizeof($arrayDias)+1) . "\"><b>";
	$string.=$datosBasicos["mercado"] . "<br>\n";
	$string.=$datosBasicos["promotor"] . "\n";
	$string.="mesa: ".$datosBasicos["mesa"] . "\n";
	$string.="</b></td></tr>";
	$string.="<tr><th>Hora</th>";
	foreach($arrayDias AS $key=>$val){
		$string.="<th>" . strftime("%B %d de %Y",strtotime($key)) . "</th>";
	}
	$string.="</tr>\n";
	foreach($arrayHoras AS $key=>$val){
		$hora=$key;
		$string.="<tr><th>$key</th>";
		foreach($arrayDias AS $key=>$val){
			$dia=$key;
			if(isset($arrayCitas[$dia][$hora])) $string.="<td bgcolor=\"#cccccc\">" . $arrayCitas[$dia][$hora] . "</td>";
			else $string.="<td>&nbsp;</td>";
		}
		$string.="</tr>\n";
	}
	$string.="</table>\n";
	$string.="<script>\nwindow.print();\n</script>\n";
	echo $string;
}

function detalle_cita_grupo($frm){
GLOBAL $CFG, $db, $ME;

}

function detalle_cita($frm,$plantilla){//El promotor le hace clic a una cita
GLOBAL $CFG, $db, $ME;
	$strQuery="
		SELECT c.*,
			CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN 'danza'
			WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN 'musica'
			WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN 'teatro'
			END AS tipo,
			CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN c.id_grupo_danza
			WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN c.id_grupo_musica
			WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN c.id_grupo_teatro
			END AS id_grupo,
			CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
			WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
			WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
			END AS grupo,
			CONCAT(p.nombre,' ',p.apellido) as promotor
		FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
			LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
			LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
			LEFT JOIN promotores p ON c.id_promotor=p.id
		WHERE c.id='$frm[id_cita]'
	";
	$qid=$db->sql_query($strQuery);
	$result=$db->sql_fetchrow($qid);
	$numero_de_cita=$frm["id_cita"];
	$promotor=$result["promotor"];
	$fecha=strftime("%A, %e de %B de %Y",strtotime($result["fecha_inicial"]));
	$hora=strftime("%H:%M ",strtotime($result["fecha_inicial"])) . date("a",strtotime($result["fecha_inicial"]));
	$artista=$result["grupo"];

	if($result["aceptada_promotor"]==1 && $result["aceptada_grupo"]==1) $estado="Confirmada";
	else $estado="Por confirmar";

	$qImagen=$db->sql_query("
		SELECT id,mmdd_archivo_filename 
		FROM archivos_grupos_" . $result["tipo"] . " 
		WHERE id_grupos_" . $result["tipo"] . "='".$result["id_grupo"]."' AND tipo=1 AND mmdd_archivo_filename IS NOT NULL LIMIT 1
	");
	if($imagen = $db->sql_fetchrow($qImagen)){
		//$img="<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_grupos_".$result["tipo"]."&field=archivo&id=" . $imagen["id"]) . "&amp;w=140\" class=\"artista\" />";
	}
	else $img="";
	include("templates/detalle_cita_" . $plantilla . ".php");
}
?>
