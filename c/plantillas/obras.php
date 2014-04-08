		<?
			while($obra=$db->sql_fetchrow($qObras)){
				$infoExtra="";
				$infoTecnica="";
				$qFotos=$db->sql_query("SELECT id,mmdd_archivo_filename,archivo FROM archivos_obras_$tipo WHERE tipo='1' AND id_obras_$tipo='$obra[id]' AND mmdd_archivo_filename !='' AND archivo IS NOT NULL AND id!='$obra[id_archivo]' ORDER BY orden");
				$fotos="<div id='gallery'><ul>";
				while($foto=$db->sql_fetchrow($qFotos)){
					$fotos.= "<li><a href='" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_obras_$tipo&field=archivo&id=" . $foto["id"]) . "&h=700' >";
					$fotos.= "<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_obras_$tipo&field=archivo&id=" . $foto["id"]) . "&amp;w=100\" class=\"similares\" />";
					$fotos.= "</a></li>";
				}
				$fotos.="</ul></div>";
				$qVideos=$db->sql_query("SELECT id,etiqueta,mmdd_archivo_filename FROM archivos_obras_$tipo WHERE tipo='3' AND id_obras_$tipo='$obra[id]' ORDER BY orden");
				$videos="<ul>";
				if($frm["mode"]!="curadores"){	
				while($video=$db->sql_fetchrow($qVideos)){
					$videos.="<li><a href=\"index.php?mercado=".$CFG->mercado."&modo=videos&tipo=$tipo&id=" . $id . "#archivos_grupos_" . $tipo . "_" . $video["id"] . "\" class=".$tipo.">" . $video["etiqueta"] . "</a></li>\n";
				}}else{
					while($video=$db->sql_fetchrow($qVideos)){
					$videos.="<li><a href=\"index.php?mercado=".$CFG->mercado."&modo=videos&mode=curadores&tipo=$tipo&id=" . $id . "#archivos_grupos_" . $tipo . "_" . $video["id"] . "\" class=".$tipo.">" . $video["etiqueta"] . "</a></li>\n";
				   }}
				
				$videos.="</ul>";
				if($tipo=="musica"){
					$nombre=$obra["produccion"];
					$qProductores=$db->sql_query("
						SELECT art.nombres, art.apellidos
						FROM productores_musica pm LEFT JOIN artistas art ON pm.id_artista=art.id
						WHERE pm.id_obras_musica='$obra[id]'
					");
					if($db->sql_numrows($qProductores)!=0) $infoExtra.="<strong>Productores</strong><br />\n";
					while($productor=$db->sql_fetchrow($qProductores)){
						$infoExtra.=$productor["nombres"] . " " . $productor["apellidos"] . "<br />\n";
					}
					$qMusicos=$db->sql_query("
						SELECT art.nombres, art.apellidos, am.instrumento, am.actividad
						FROM artistas_musicos am LEFT JOIN artistas art ON am.id_artista=art.id
						WHERE am.id_obras_musica='$obra[id]'
					");
					if($db->sql_numrows($qMusicos)!=0) $infoExtra.="<br /> <strong>". translate($arrTitulos,"artistas") ."</strong><br />\n";
					while($musico=$db->sql_fetchrow($qMusicos)){
						if($musico["actividad"]==1) $actividad="Músico";
						elseif($musico["actividad"]==2) $actividad="Ingeniero de sonido";
						else $actividad="Roadie";
						$infoExtra.=$musico["nombres"] . " " . $musico["apellidos"] . " ($actividad - $musico[instrumento])<br />\n";
					}
					$infoTecnica.="
						<strong>Año:</strong> $obra[anio]<br />
						<strong>Sello disquero:</strong> $obra[sello_disquero]<br />
						<strong>Número de personas que viajan con la producción:</strong> $obra[num_viajantes]<br />
					";
					$qidTr = $db->sql_query("SELECT id,etiqueta,mmdd_archivo_filename FROM tracklist WHERE id_obras_musica =".$obra["id"]." ORDER BY orden");
					$tracks="<table width='100%'>";
					while($track = $db->sql_fetchrow($qidTr)){
						$filePath="/musica/audio/" . $grupo["id"] . "/obras/" . $track["id"] . "/" . $track["mmdd_archivo_filename"];
						 $CFG->dirroot."<br>";
						 $filePath."<br>";
						$urlServer="/var/www/vhosts/redlat.org/circulart.org";
						if(file_exists($urlServer . $filePath)){
							$tracks.="<tr><td>$track[etiqueta]</td><td>";
							$tracks.="
							<object type=\"application/x-shockwave-flash\" data=\"" . $CFG->dirwww . "/audio_base/player.swf\" id=\"audioplayer" . $track["id"] . "\" height=\"20\" width=\"180\">
								<param name=\"movie\" value=\"" . $CFG->dirwww . "/audio_base/player.swf\">
								<param name=\"FlashVars\" value=\"playerID=" . $track["id"] . "&amp;soundFile=" . $CFG->dirwww . "/musica/audio/" . $grupo["id"] . "/obras/" . $track["id"] . "/" . $track["mmdd_archivo_filename"] . "\">
								<param name=\"bgcolor\" value=\"#FFFFFF\" />
								<param name=\"quality\" value=\"high\">
								<param name=\"menu\" value=\"false\">
								<param name=\"wmode\" value=\"transparent\">
							</object></td></tr>\n";
						}
					}
					$tracks.="</table><br/><br/>\n";
				}
				elseif($tipo=="danza"){
					$nombre=$obra["obra"];
					$qArtistas=$db->sql_query("
						SELECT art.nombres, art.apellidos, ad.actividad
						FROM artistas_danza ad LEFT JOIN artistas art ON ad.id_artista=art.id
						WHERE ad.id_obras_danza='$obra[id]'
					");
					if($db->sql_numrows($qArtistas)!=0) $infoExtra.="<br /> <strong>". translate($arrTitulos,"artistas") ."</strong><br />\n";
					while($artista=$db->sql_fetchrow($qArtistas)){
						if($artista["actividad"]==1) $actividad="Director";
						elseif($artista["actividad"]==2) $actividad="Bailarín";
						elseif($artista["actividad"]==3) $actividad="Técnico";
						elseif($artista["actividad"]==4) $actividad="Actor/actriz";
						elseif($artista["actividad"]==5) $actividad="Músico";
						$infoExtra.=$artista["nombres"] . " " . $artista["apellidos"] . " ($actividad)<br />\n";
					}
					if($obra["tipo_publico"]==1) $tipo_publico="Adultos";
					elseif($obra["tipo_publico"]==2) $tipo_publico="Infantil";
					elseif($obra["tipo_publico"]==3) $tipo_publico="Familiar";
					else $tipo_publico="";
						if(isset($obra["anio"])) $infoTecnica.="<strong>Año:</strong> $obra[anio]<br />";
						if(isset($obra["autor"])) $infoTecnica.="<strong>Autor:</strong> $obra[autor]<br />";
						if(isset($obra["musica"])) $infoTecnica.="<strong>Música:</strong> $obra[musica]<br />";
						if(isset($obra["duracion"])) $infoTecnica.="<strong>Duración:</strong> $obra[duracion]<br />";
						if(isset($obra["$tipo_publico"])) $infoTecnica.="<strong>Tipo de público:</strong> $tipo_publico<br />";
						if(isset($obra["num_viajantes"])) $infoTecnica.="<strong>No. de personas que viajan:</strong> $obra[num_viajantes]<br />";
						if(isset($obra["horas_montaje"])) $infoTecnica.="<strong>Horas de Montaje:</strong> $obra[horas_montaje]<br />";
						if(isset($obra["horas_desmontaje"])) $infoTecnica.="<strong>Horas desmontaje:</strong> $obra[horas_desmontaje]<br />";
						if(isset($obra["ensayos"])) $infoTecnica.="<strong>Ensayos:</strong> $obra[ensayos]<br />";
						if($CFG->lang=="en" && $obra["en_responsable_carga"]!="") $infoTecnica.="<strong>Responsable de carga:</strong> $obra[en_responsable_carga]<br />";
						elseif(isset($obra["responsable_carga"])) $infoTecnica.="<strong>Responsable de carga:</strong> $obra[responsable_carga]<br />";
						if(isset($obra["piezas"])) $infoTecnica.="<strong>Piezas:</strong> $obra[piezas]<br />";
						if(isset($obra["volumen"])) $infoTecnica.="<strong>Volumen:</strong> $obra[volumen]<br />";
						if(isset($obra["peso"])) $infoTecnica.="<strong>Peso:</strong> $obra[peso]<br />";
						if(isset($obra["direccion_recogida"])) $infoTecnica.="<strong>Dirección recogida:</strong> $obra[direccion_recogida]<br />";
						if(isset($obra["direccion_regreso"])) $infoTecnica.="<strong>Dirección regreso:</strong> $obra[direccion_regreso]<br />";
						if($CFG->lang=="en" && $obra["en_espacio"]!="") $infoTecnica.="<strong>Espacio:</strong> $obra[en_espacio]<br />";
						elseif(isset($obra["espacio"])) $infoTecnica.="<strong>Espacio:</strong> $obra[espacio]<br />";
						if($CFG->lang=="en" && $obra["en_iluminacion"]!="") $infoTecnica.="<strong>Iluminación:</strong> $obra[en_iluminacion]<br />";
						elseif(isset($obra["iluminacion"])) $infoTecnica.="<strong>Iluminación:</strong> $obra[iluminacion]<br />";
						if(isset($obra["plano_luces"])) $infoTecnica.="<strong>Plano de luces:</strong> $obra[plano_luces]<br />";
						if($CFG->lang=="en" && $obra["en_sonido"]!="") $infoTecnica.="<strong>Sonido:</strong> $obra[en_sonido]<br />";
						elseif(isset($obra["sonido"])) $infoTecnica.="<strong>Sonido:</strong> $obra[sonido]<br />";
						if($CFG->lang=="en" && $obra["en_equipos_adicionales"]!="") $infoTecnica.="<strong>Equipos adicionales:</strong> $obra[en_equipos_adicionales]<br />";
						elseif(isset($obra["equipos_adicionales"])) $infoTecnica.="<strong>Equipos adicionales:</strong> $obra[equipos_adicionales]<br />";
						if($CFG->lang=="en" && $obra["en_comentarios"]!="") $infoTecnica.="<strong>Comentarios:</strong> $obra[en_comentarios]<br />";
						elseif(isset($obra["comentarios"])) $infoTecnica.="<strong>Comentarios:</strong> $obra[comentarios]<br />";
						if(isset($obra["documento"])) $infoTecnica.= "<strong>Documento:</strong> <a href=\"/admin/file.php?field=documento&table=obras_$frm[tipo]&id=$obra[id]\" target=\"_blank\">Descargar</a><br />";
				}
				elseif($tipo=="teatro"){
					$nombre=$obra["obra"];
					$qArtistas=$db->sql_query("
						SELECT art.nombres, art.apellidos, at.actividad
						FROM artistas_teatro at LEFT JOIN artistas art ON at.id_artista=art.id
						WHERE at.id_obras_teatro='$obra[id]'
					");
					if($db->sql_numrows($qArtistas)!=0) $infoExtra.="<br /> <strong>".translate($arrTitulos,"artistas")."</strong><br />\n";
					while($artista=$db->sql_fetchrow($qArtistas)){
						if($artista["actividad"]==1) $actividad="Director";
						elseif($artista["actividad"]==2) $actividad="Actor/Actriz";
						elseif($artista["actividad"]==3) $actividad="Técnico";
						elseif($artista["actividad"]==4) $actividad="Productor";
						elseif($artista["actividad"]==5) $actividad="Músico";
						elseif($artista["actividad"]==6) $actividad="Bailarín/a";
						elseif($artista["actividad"]==7) $actividad="Titiritero/a";
						$infoExtra.=$artista["nombres"] . " " . $artista["apellidos"] . " ($actividad)<br />\n";
					}
					if($obra["tipo_publico"]==1) $tipo_publico="Adultos";
					elseif($obra["tipo_publico"]==2) $tipo_publico="Infantil";
					elseif($obra["tipo_publico"]==3) $tipo_publico="Familiar";
					else $tipo_publico="";

					if(isset($obra["anio"])) $infoTecnica.="<strong>" . translate($arrTitulos,"ano") . ":</strong> $obra[anio]<br />";
					if(isset($obra["autor"])) $infoTecnica.="<strong>" . translate($arrTitulos,"autor") . ":</strong> $obra[autor]<br />";
					if(isset($obra["musica"])) $infoTecnica.="<strong>". translate($arrTitulos,"musica") ."</strong> $obra[musica]<br />";
					if(isset($obra["duracion"])) $infoTecnica.="<strong>Duración:</strong> $obra[duracion]<br />";
					if(isset($obra["$tipo_publico"])) $infoTecnica.="<strong>Tipo de público:</strong> $tipo_publico<br />";
					if(isset($obra["num_viajantes"])) $infoTecnica.="<strong>No. de personas que viajan:</strong> $obra[num_viajantes]<br />";
					if(isset($obra["horas_montaje"])) $infoTecnica.="<strong>Horas de Montaje:</strong> $obra[horas_montaje]<br />";
					if(isset($obra["horas_desmontaje"])) $infoTecnica.="<strong>Horas desmontaje:</strong> $obra[horas_desmontaje]<br />";
					if(isset($obra["ensayos"])) $infoTecnica.="<strong>Ensayos:</strong> $obra[ensayos]<br />";
					if($CFG->lang=="en" && $obra["en_responsable_carga"]!="") $infoTecnica.="<strong>Responsable de carga:</strong> $obra[en_responsable_carga]<br />";
					elseif(isset($obra["responsable_carga"])) $infoTecnica.="<strong>Responsable de carga:</strong> $obra[responsable_carga]<br />";
					if(isset($obra["piezas"])) $infoTecnica.="<strong>Piezas:</strong> $obra[piezas]<br />";
					if(isset($obra["volumen"])) $infoTecnica.="<strong>Volumen:</strong> $obra[volumen]<br />";
					if(isset($obra["peso"])) $infoTecnica.="<strong>Peso:</strong> $obra[peso]<br />";
					if(isset($obra["direccion_recogida"])) $infoTecnica.="<strong>Dirección recogida:</strong> $obra[direccion_recogida]<br />";
					if(isset($obra["direccion_regreso"])) $infoTecnica.="<strong>Dirección regreso:</strong> $obra[direccion_regreso]<br />";
					if($CFG->lang=="en" && $obra["en_espacio"]!="") $infoTecnica.="<strong>Espacio:</strong> $obra[en_espacio]<br />";
					elseif(isset($obra["espacio"])) $infoTecnica.="<strong>Espacio:</strong> $obra[espacio]<br />";
					if($CFG->lang=="en" && $obra["en_iluminacion"]!="") $infoTecnica.="<strong>Iluminación:</strong> $obra[en_iluminacion]<br />";
					elseif(isset($obra["iluminacion"])) $infoTecnica.="<strong>Iluminación:</strong> $obra[iluminacion]<br />";
					if(isset($obra["plano_luces"])) $infoTecnica.="<strong>Plano de luces:</strong> $obra[plano_luces]<br />";
					if($CFG->lang=="en" && $obra["en_sonido"]!="") $infoTecnica.="<strong>Sonido:</strong> $obra[en_sonido]<br />";
					elseif(isset($obra["sonido"])) $infoTecnica.="<strong>Sonido:</strong> $obra[sonido]<br />";
					if($CFG->lang=="en" && $obra["en_equipos_adicionales"]!="") $infoTecnica.="<strong>Equipos adicionales:</strong> $obra[en_equipos_adicionales]<br />";
					elseif(isset($obra["equipos_adicionales"])) $infoTecnica.="<strong>Equipos adicionales:</strong> $obra[equipos_adicionales]<br />";
					if($CFG->lang=="en" && $obra["en_comentarios"]!="") $infoTecnica.="<strong>Comentarios:</strong> $obra[en_comentarios]<br />";
					elseif(isset($obra["comentarios"])) $infoTecnica.="<strong>Comentarios:</strong> $obra[comentarios]<br />";
					if(isset($obra["documento"])) $infoTecnica.="<strong>Documento:</strong> <a href=\"/admin/file.php?field=documento&table=obras_$frm[tipo]&id=$obra[id]\" target=\"_blank\">Descargar</a><br />";
				}
				if($obra["id_archivo"]!="") $img="<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_obras_$tipo&field=archivo&id=" . $obra["id_archivo"]) . "&amp;w=280\"/>";
											
				else $img="";
				
			?>
        
        <h1 class="<?=$tipo?>"><?=$nombre?></h1>
		<br /><? echo $img; ?>
      	<p><?=nl2br(translate($obra,"resena"))?></p>
		<p><?=$infoExtra?></p>
		<?if($tipo!="musica"){?>
        <br/>
        <h2>Informaci&oacute;n t&eacute;cnica</h2>
        <p><?=$infoTecnica?></p>
			<? }?>
				<?
				if($fotos!=""){
					echo "<h2>Fotograf&iacute;as</h2>";
					echo "<p>$fotos</p>\n";
				}
				if($videos!="<ul></ul>"){
					echo "<h2>Videos</h2>";
					echo "<p>$videos</p>\n";
				}
				if(isset($qidTr) && $db->sql_numrows($qidTr)!=0){
					echo "<h2>Canciones</h2>";
					echo "<p>$tracks</p>\n";
				}
				?>
			<? }?>