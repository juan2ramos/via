<?
	if($frm["mode"]=="curadores"){
        				echo "<h2>Datos básicos</h2>\n";
						echo "<p>\n";
					}

	$infoContacto= "";
	if($frm["mode"]=="curadores"){
	if(isset($grupo["empresa"])) $infoContacto.="Empresa: <strong>$grupo[empresa]</strong><br />";
	if(isset($grupo["nit"])) $infoContacto.="Nit: <strong>$grupo[nit]</strong><br />";
	if(isset($grupo["rut"])) $infoContacto.="Rut: <strong>$grupo[rut]</strong><br />";
	if(isset($grupo["manager"])) $infoContacto.="Representante, manager o contacto: <strong>$grupo[manager]</strong><br />";
	if(isset($grupo["contacto_cc"])) $infoContacto.="Documento identificación contacto: <strong>$grupo[contacto_cc]</strong><br />";
	if(isset($grupo["ciudad"])) $infoContacto.="Ciudad: <strong>$grupo[ciudad]</strong><br />";
	if(isset($grupo["direccion"])) $infoContacto.="Ciudad: <strong>$grupo[direccion]</strong><br />";
	}
    if(isset($grupo["telefono"])) $infoContacto.="Teléfonos: <strong>$grupo[telefono]</strong><br />";
    if(isset($grupo["email"])) $infoContacto.="Correo: <strong><a href=\"mailto:$grupo[email]\" class=\"$tipo\">$grupo[email]</a></strong><br/>";
	if(isset($grupo["website"])) $infoContacto.="Website: <strong><a href=\"http://$grupo[website]\" target=\"_blank\" class=\"$tipo\">$grupo[website]</a></strong><br />";
	if(isset($grupo["mmdd_ficha_filename"])) $infoContacto.="Ficha:  <strong><a href=\"http://circulart.org/admin/fileFS.php?table=grupos_musica&field=ficha&id=$grupo[id]\" target=\"_blank\" class=\"$tipo\"><img style=\"margin-top:5px;\" src=\"$CFG->wwwroot/images/iconos/descarga.png\" border=\"0\" /></a></strong>";
	if(isset($grupo["mmdd_ficha_filename"])) $infoContacto.=" o <strong><a href=\"http://circulart.org/admin/file.php?table=grupos_musica&field=ficha&id=$grupo[id]\" target=\"_blank\" class=\"$tipo\"><img style=\"margin-top:5px;\" src=\"$CFG->wwwroot/images/iconos/descarga.png\" border=\"0\" /></a></strong><br/>";
	if(isset($grupo["mmdd_trayectoria_filename"])) $infoContacto.="Trayectoria:  <strong><a href=\"http://circulart.org/admin/fileFS.php?table=grupos_musica&field=trayectoria&id=$grupo[id]\" target=\"_blank\" class=\"$tipo\"><img style=\"margin-top:5px;\" src=\"$CFG->wwwroot/images/iconos/descarga.png\" border=\"0\" /></a></strong>";
	if(isset($grupo["mmdd_trayectoria_filename"])) $infoContacto.=" o <strong><a href=\"http://circulart.org/admin/file.php?table=grupos_musica&field=trayectoria&id=$grupo[id]\" target=\"_blank\" class=\"$tipo\"><img style=\"margin-top:5px;\" src=\"$CFG->wwwroot/images/iconos/descarga.png\" border=\"0\" /></a></strong><br />";
	$cadena=$grupo["trayectoria_url"];   
    $buscar="http://";  
	if (strrpos($cadena, $buscar))
	{
		$url=$grupo["trayectoria_url"];
	}else{  
		$url=$buscar.$grupo["trayectoria_url"];
	}
	
	if(isset($grupo["trayectoria_url"]))$infoContacto.="Trayectoria Url:  <strong><a href=\"".$grupo["trayectoria_url"]."\" target=\"_blank\" class=\"$tipo\">".$grupo["trayectoria_url"]."</a></strong><br />";
    echo  $infoContacto;
       
			$filePath="/" . $CFG->filesdir . "/grupos_$tipo/demo/" . $grupo["id"];
		
					if(file_exists("/var/www/vhosts/circulart.org/httpdocs" . $filePath)){
						echo "<table cellspacing=\"0\"  cellpadding=\"0\"><tr><td>Demo:</td><td>";
						echo "<object type=\"application/x-shockwave-flash\" data=\"" . $CFG->dirwww . "/audio_base/player.swf\" id=\"audioplayer" . $grupo["id"] . "\" height=\"18\" width=\"217\">
							  	<param name=\"movie\" value=\"" . $CFG->dirwww . "/audio_base/player.swf\">
							  	<param name=\"FlashVars\" value=\"playerID=" . $grupo["id"] . "&amp;soundFile=http://circulart.org/" . $filePath . "\">
							  	<param name=\"bgcolor\" value=\"#FFFFFF\" />
							  	<param name=\"quality\" value=\"high\">
							  	<param name=\"menu\" value=\"false\">
								<param name=\"wmode\" value=\"transparent\">
							  </object></td></tr></table>\n";
					}
				?>
                
                <?php if($frm["mode"]=="curadores"){
					
					    echo "<p>&nbsp;</p>";
        				echo "<h2>Descripción</h2>\n";
						echo "<p>\n";
					
					} ?>
        		<p><?=nl2br(translate($grupo,"resena"))?></p>
                
               <?php if($frm["mode"]=="curadores"){
					
					    echo "<p>&nbsp;</p>";
        				echo "<h2>Descripción Ingles</h2>\n";
						echo "<p>\n";
					echo nl2br(translate($grupo,"en_resena"));
					} ?>
                <p></p>
                
                
                
                
                
         		<? 
				$cadena=$grupo["myspace"];   
				$buscar="http://";  
				if (strrpos($cadena, $buscar))
				{
					$url=$grupo["myspace"];
				}else{  
					$url=$buscar.$grupo["myspace"];
				}
				
				if($grupo["myspace"]!=""){?><a href="<?=$url?>" target="_blank"><img src="http://circulart.org/circulart2012/portafolios/images/iconos/myspace.png" border="0" /></a>&nbsp;&nbsp;<?}?>
         		<? 
				$cadena=$grupo["facebook"]; 
				$buscar="http://";  
				if (strrpos($cadena, $buscar))
				{
					$url=$grupo["facebook"];
				}else{  
					$url=$buscar.$grupo["facebook"];
				}
				
				
				if($grupo["facebook"]!=""){?><a href="<?=$url?>" target="_blank"><img src="http://circulart.org/circulart2012/portafolios/images/iconos/facebook.png" border="0" /></a>&nbsp;&nbsp;<?}?>
		 		<? 
				$cadena=$grupo["lastfm"]; 
				$buscar="http://";  
				if (strrpos($cadena, $buscar))
				{
					$url=$grupo["lastfm"];
				}else{  
					$url=$buscar.$grupo["lastfm"];
				}
				
				
				if($grupo["lastfm"]!=""){?><a href="<?=$grupo["lastfm"]?>" target="_blank"><img src="http://circulart.org/circulart2012/portafolios/images/iconos/lastfm.png" border="0" /></a>&nbsp;&nbsp;<?}?>
		 		<? 
				
				$cadena=$grupo["twitter"]; 
				$buscar="http://";  
				if (strrpos($cadena, $buscar))
				{
					$url=$grupo["twitter"];
				}else{  
					$url=$buscar.$grupo["twitter"];
				}
				
				
				if($grupo["twitter"]!=""){?><a href="<?=$url?>" target="_blank"><img src="http://circulart.org/circulart2012/portafolios/images/iconos/twitter.png" border="0" /></a><?}?>
                
                
                <br />
                <? if($frm["mode"]!="curadores"){ ?>
                <a href="#" onclick="MM_openBrWindow('recomendar.php?tipo=<?=$tipo?>&id=<?=$id?>','Circulart','width=260,height=160')"><img src="http://circulart.org/images/botones/<?=$tipo?>.gif" width="182" height="25" vspace="5" border="0" /></a>
				<? } ?>
                <?
					if($tipo=="musica"){
						echo "<p>&nbsp;</p>";
        				echo "<h2>Informaci&oacute;n t&eacute;nica</h2>\n";
						echo "<p>\n";
						echo "País: <strong>" . $grupo["pais"] . "</strong><br />\n";
						if($grupo["tipo_propuesta"]=="1") echo "Tipo Propuesta: <strong>Vocal</strong><br />\n";
						elseif($grupo["tipo_propuesta"]=="2") echo "Tipo Propuesta: <strong>Instrumental</strong><br />\n";
						elseif($grupo["tipo_propuesta"]=="3") echo "Tipo Propuesta: <strong>Vocal e Instrumental</strong><br />\n";
						if($grupo["num_personas_gira"]!="") echo "No. de personas en gira: <strong>" . $grupo["num_personas_gira"] . "</strong><br />\n";
						if($grupo["num_personas_escenario"]!="") echo "No. personas en escenario: <strong>" . $grupo["num_personas_escenario"] . "</strong><br />\n";
						if($CFG->lang=="en" && $grupo["en_instrumentos"]!="") echo "Instrumentos utilizados en el escenario: <strong>" . $grupo["en_instrumentos"] . "</strong><br />\n";
						elseif($grupo["instrumentos"]!="") echo "Instrumentos utilizados en el escenario: <strong>" . $grupo["instrumentos"] . "</strong><br />\n";
						echo "</p>\n";
					}
					
				
					
				if($frm["mode"]!="curadores"){					
						if($db->sql_numrows($qObras)>0){
							echo "<p>&nbsp;</p>";
							echo "<h2>Obras</h2>\n";
							echo "<p>\n";
							echo "<ul>";
							while($obra=$db->sql_fetchrow($qObras)){
								echo "<li><a href=\"index.php?mercado=".$CFG->mercado."&mercado=".$CFG->mercado."&modo=obras&tipo=".$tipo."&id=". $grupo["id"] ."\" class=".$tipo.">";
								if($tipo=="musica") echo $obra["produccion"]; else echo $obra["obra"]; 
								echo " ".$obra["anio"] . "</a></li>\n";
																
								$qidTr = $db->sql_query("SELECT id,etiqueta,mmdd_archivo_filename FROM tracklist WHERE id_obras_musica =".$obra["id"]." ORDER BY orden");
								//$tracks.="<table width='100%'>";
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
								 //$tracks.="</table><br/><br/>\n";
							}
							echo "</ul>";
						}
					
				}else{
						if($db->sql_numrows($qObras)>0){
							echo "<p>&nbsp;</p>";
							echo "<h2>Obras</h2>\n";
							echo "<p>\n";
							echo "<ul>";
							while($obra=$db->sql_fetchrow($qObras)){
								echo "<li><a href=\"index.php?mercado=".$CFG->mercado."&mercado=".$CFG->mercado."&modo=obras&mode=curadores&tipo=".$tipo."&id=". $grupo["id"] ."\" class=".$tipo.">";
								if($tipo=="musica") echo $obra["produccion"]; else echo $obra["obra"]; 
								echo " ".$obra["anio"] . "</a></li>\n";
								$qidTr = $db->sql_query("SELECT id,etiqueta,mmdd_archivo_filename FROM tracklist WHERE id_obras_musica =".$obra["id"]." ORDER BY orden");
								//$tracks.="<table width='100%'>";
								while($track = $db->sql_fetchrow($qidTr)){
									$filePath="/musica/audio/" . $grupo["id"] . "/obras/" . $track["id"] . "/" . $track["mmdd_archivo_filename"];
									 $CFG->dirroot."<br>";
									 $filePath."<br>";
									$urlServer="/var/www/vhosts/circulart.org/httpdocs";
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
							}
							echo "</ul>";
						}
					
					}
					
					
					
					if($db->sql_numrows($qImagenes)>1){
        				echo "<p>&nbsp;</p>";
						echo "<h2>Fotograf&iacute;as</h2>\n";
						echo "<p>\n";
						$db->sql_rowseek(0,$qImagenes);
						echo "<div id='gallery'><ul>";
						while($imagen = $db->sql_fetchrow($qImagenes)){
							echo "<li><a href='" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=" . $imagen["tabla"] . "&field=archivo&id=" . $imagen["id"]) . "&h=700' onclick=\"scrollWindow();\" >";
							echo "<img border=\"0\" src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=" . $imagen["tabla"] . "&field=archivo&id=" . $imagen["id"]) . "&amp;h=90\" border=\"0\" />";
							echo "</a></li>";
						}
						echo "</ul></div>";
					}
					
					
					
				
				if($frm["mode"]!="curadores"){			
						if($db->sql_numrows($qVideos)>0){
							echo "<p>&nbsp;</p>";
							echo "<h2>Videos</h2>\n";
							echo "<p>\n";
							echo "<ul>";
							while($video=$db->sql_fetchrow($qVideos)){
								echo "<li><a href=\"index.php?mercado=".$CFG->mercado."&modo=videos&tipo=".$tipo."&id=". $grupo["id"] ."\" class=".$tipo.">". $video["etiqueta"] . "</a></li>\n";
							}
							echo "</ul>";
						}
				}else{
						if($db->sql_numrows($qVideos)>0){
							echo "<p>&nbsp;</p>";
							echo "<h2>Videos</h2>\n";
							echo "<p>\n";
							echo "<ul>";
							while($video=$db->sql_fetchrow($qVideos)){
								echo "<li><a href=\"index.php?mercado=".$CFG->mercado."&modo=videos&mode=curadores&tipo=".$tipo."&id=". $grupo["id"] ."\" class=".$tipo.">". $video["etiqueta"] . "</a></li>\n";
							}
							echo "</ul>";
						}
					}
					
					echo "<p>&nbsp;</p>";
					echo "<h2>Audios</h2>\n";
					echo "<p>\n";
					echo "<table width='100%'>";
					
					
					while($track = $db->sql_fetchrow($qAudios)){
						
									$filePath="/musica/audio/" . $grupo["id"] . "/grupo/" . $track["id"] . "/" . $track["mmdd_archivo_filename"];
									 $CFG->dirroot."<br>";
									 $filePath."<br>";
									$urlServer="/var/www/vhosts/redlat.org/circulart.org";
									if(file_exists($urlServer . $filePath)){
										$tracks.="<tr><td>$track[etiqueta]</td><td>";
										$tracks.="
										<object type=\"application/x-shockwave-flash\" data=\"" . $CFG->dirwww . "/audio_base/player.swf\" id=\"audioplayer" . $track["id"] . "\" height=\"20\" width=\"180\">
											<param name=\"movie\" value=\"" . $CFG->dirwww . "/audio_base/player.swf\">
											<param name=\"FlashVars\" value=\"playerID=" . $track["id"] . "&amp;soundFile=" . $CFG->dirwww . "/musica/audio/" . $grupo["id"] . "/grupo/" . $track["id"] . "/" . $track["mmdd_archivo_filename"] . "\">
											<param name=\"bgcolor\" value=\"#FFFFFF\" />
											<param name=\"quality\" value=\"high\">
											<param name=\"menu\" value=\"false\">
											<param name=\"wmode\" value=\"transparent\">
										</object></td></tr>\n";
									}
								}
								
					echo $tracks;
					echo "</table></p>\n";
					
					/*if($frm["mode"]=="curadores"){		
						echo "<p>&nbsp;</p>";
						echo "<h2>En caso de quedar seleccionados indique el nombre y documento de las personas que los representarán en las citas de la Rueda de Negocios. </h2>\n";
						echo "<p>\n";
					    while($pc = $db->sql_fetchrow($qPersonasContacto)){
							if($pc['mmdd_foto_filename']!=''){
						 echo "<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=../files/vinculados/foto/" . $pc ["id"] . "&amp;w=300\"><br>\n";}
						 echo "Nombre:<strong>".$pc['nombre']."</strong><br>";
						 echo "Documento:<strong>".$pc['documento']."</strong><br><br>";

						}

						
					
					
					
					
					}*/
					echo "<p>&nbsp;</p>";
					/*echo "<h2>Grupos similares</h2>\n";
					while($grupo=$db->sql_fetchrow($qGruposRelacionados)){
						if($grupo["id_archivo"]!=""){
					  		$link="index.php?mercado=".$CFG->mercado."&modo=perfil&id=".$grupo["id_grupos_" . $tipo]."&tipo=$tipo";
							$img="<img src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_grupos_$tipo&field=archivo&id=" . $grupo["id_archivo"]) . "&amp;h=80\" class=\"similares\" border=\"0\" />";
							echo "<a href=\"$link\" title=\"" . $grupo["nombre"] . "\" alt=\"" . $grupo["nombre"] . "\">";
							echo $img;
							echo "</a>";
						}
					}*/
				?>
