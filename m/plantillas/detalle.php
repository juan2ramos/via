<? if(isset($_GET["id_circuito"])){
	$qCircuitos=$db->sql_query("
			SELECT cir.id, cir.id_tipo, cir.nombre, cir.inicio, cir.fin, cir.descripcion, cir.link, cir.pais, cir.ciudad, cir.circulart, cir.mmdd_imagen_filename, t.nombre as tipo
			FROM circuitos cir LEFT JOIN circ_tipos t ON cir.id_tipo=t.id
			WHERE cir.id ='".$_GET["id_circuito"]."'
		");
	
	?>
<div id="disciplina">
<? while($circuito=$db->sql_fetchrow($qCircuitos)){?>    
<? if($circuito["mmdd_imagen_filename"]!="") echo "<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=circuitos&field=imagen&id=" . $circuito["id"]) . "&amp;w=175\" />"; ?>
</div>
<div class ="artista">
						<h1><?=$circuito['nombre']?></h1>
						<em>
						<? 
						echo $circuito['tipo'].": ";
						$inicio=ucfirst(strftime("%A %e de %B de %Y",strtotime($circuito["inicio"])));
						$fin=strftime("%A %e de %B de %Y",strtotime($circuito["fin"]));
						if(date("Y-m-d",strtotime($circuito["inicio"])) == date("Y-m-d",strtotime($circuito["fin"]))){//Empieza y termina el mismo día
							$fecha=$inicio;
						}elseif(date("Y-m",strtotime($circuito["inicio"])) == date("Y-m",strtotime($circuito["fin"]))){//Empieza y termina el mismo mes
							$fecha=strftime("%e",strtotime($circuito["inicio"])) . " al " . strftime("%e de %B de %Y",strtotime($circuito["fin"]));
						}elseif(date("Y",strtotime($circuito["inicio"])) == date("Y",strtotime($circuito["fin"]))){//Empieza y termina el mismo año
							$fecha=strftime("%e de %B",strtotime($circuito["inicio"])) . " al " . strftime("%e de %B de %Y",strtotime($circuito["fin"]));
						}else $fecha=strftime("%e de %B de %Y",strtotime($circuito["inicio"])) . " al " . strftime("%e de %B de %Y",strtotime($circuito["fin"]));
						echo $fecha;
						?>
                        </em><br />
                     
                
      			<strong>Ciudad: </strong><?= $circuito["ciudad"]?><br />
                <p><?= $circuito["descripcion"]?></p>
                <? if ($circuito["link"]!="") echo "<a href='".$circuito["link"]."' target='_blank'>[+] informaci&oacute;n </a>"; ?>
       
  <? }?>
 </div>
 <? }?> 
  
 
 <? if(isset($_GET["id_evento"])){
	 $qEventos=$db->sql_query("
			SELECT DISTINCT ev.id,ev.id_tipo,ev.nombre,ev.id_mercado,ev.ubicacion,ev.ciudad, ev.pais,ev.telefonos,ev.descripcion,ev.mmdd_imagen_filename,ev.precios,ev.link,ev.inicio, ev.fin, t.nombre as tipo
			FROM eventos ev LEFT JOIN ev_tipos t ON ev.id_tipo=t.id
			WHERE ev.id ='".$_GET["id_evento"]."'
		");
	 ?>
 


<div id="disciplina">
<? while($evento=$db->sql_fetchrow($qEventos)){?>
<? if($evento["mmdd_imagen_filename"]!="") echo "<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=eventos&field=imagen&id=" . $evento["id"]) . "&amp;w=175\" />"; ?>
</div>
<div class ="artista">
<h1><?=$evento['nombre']?></h1>
<? echo $evento['tipo']." :"; 
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
	echo $fecha;
						?>
      			<strong>Ubicaci&oacute;n: </strong><?= $evento["ubicacion"]?><br />
                <strong>Ciudad: </strong><?= $evento["ciudad"]?><br />
                <strong>Precio: </strong><?= $evento["precios"]?><br />
                <p><?= $evento["descripcion"]?></p>
                <? if ($evento["link"]!="") echo "<a href='".$evento["link"]."' target='_blank'>[+] informaci&oacute;n </a>"; ?>
      		
 <? }?>
  </div>
 <? }?>

