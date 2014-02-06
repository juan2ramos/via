		<?
			$tipo_anterior="";
			while($evento=$db->sql_fetchrow($qEventos)){
				if($evento["id_tipo"]!=$tipo_anterior){
				}
				$tipo_anterior=$evento["id_tipo"];
			
				if($evento["mmdd_imagen_filename"]!="") $imgSrc=$CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=eventos&field=imagen&id=" . $evento["id_evento"]) . "&amp;w=180";
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
			?>
       <?=$fecha?>
          <h1 class="<?=$tipo?>"><?=$evento["nombre"]?></h1>
          <?
		  if(isset($tipo) && isset($id)){
		  ?>
          <p><?=nl2br(translate($evento,"descripcion"))?></p>
		  <?					   
		}
	      if($evento["ubicacion"]!="") echo "<strong>Lugar:</strong> $evento[ubicacion] <br />";
          if($evento["direccion"]!="") echo "<strong>Direcci&oacute;n:</strong> $evento[direccion] <br />";
          if($evento["ciudad"]!="") echo "<strong>Ciudad:</strong> $evento[ciudad] <br />";
          if($evento["pais"]!="") echo "<strong>Pa&iacute;s:</strong> $evento[pais] <br />";
          if($evento["telefonos"]!="") echo "<strong>Tel:</strong> $evento[telefonos] <br />";
        	
				?>
		 <p><strong>Precios:</strong><br /><?=nl2br($evento["precios"])?></p>
        <p><?=$link?></p>
          
          
		<? }?>
		