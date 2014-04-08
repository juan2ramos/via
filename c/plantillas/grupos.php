<?
	if(isset($_GET["querystring"])){
		$condicion.=" g.nombre LIKE '%$_GET[querystring]%'";
		
		$strSQL="
		(SELECT g.id,g.nombre,g.resena_corta,g.en_resena_corta,g.resena, g.telefono, g.email, g.website, g.myspace,g.facebook,g.lastfm,g.twitter, 'musica' as tipo
		FROM grupos_musica g
		WHERE $condicion ";
		if($CFG->mercado==0) $strSQL.= "AND g.curado AND g.resena IS NOT NULL ";
		else  $strSQL.= "AND g.id IN (SELECT id_grupo_musica FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		$strSQL.=") UNION (
		SELECT g.id,g.nombre,g.resena_corta,g.en_resena_corta,g.resena, g.telefono, g.email, g.website, g.myspace,g.facebook,g.lastfm,g.twitter, 'danza' as tipo
		FROM grupos_danza g
		WHERE $condicion ";
		if($CFG->mercado==0) $strSQL.= "AND g.curado AND g.resena IS NOT NULL ";
		else  $strSQL.= "AND g.id IN (SELECT id_grupo_danza FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		$strSQL.=") UNION (
		SELECT g.id,g.nombre,g.resena_corta,g.en_resena_corta,g.resena, g.telefono, g.email, g.website, g.myspace,g.facebook,g.lastfm,g.twitter, 'teatro' as tipo
		FROM grupos_teatro g
		WHERE $condicion ";
		if($CFG->mercado==0) $strSQL.= "AND g.curado AND g.resena IS NOT NULL ";
		else  $strSQL.= "AND g.id IN (SELECT id_grupo_teatro FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		
		/*$strSQL.=") UNION (
		SELECT * 
		FROM empresas 
		WHERE empresa LIKE '%$_GET[querystring]%'";*/
		

		$strSQL.=") ORDER BY nombre";
		
		
		$qidGr = $db->sql_query($strSQL);
	}elseif(isset($_GET["id_genero"])){
		$strSQL="
		SELECT distinct(g.id),g.nombre,g.resena_corta,g.en_resena_corta,g.resena, g.telefono, g.email, g.website, g.myspace,g.facebook,g.lastfm,g.twitter, '$tipo' as tipo
		FROM grupos_".$tipo." g
		LEFT JOIN generos_grupo_".$tipo." gg ON gg.id_grupos_".$tipo." = g.id
		WHERE gg.id_generos_".$tipo." = ".$_GET["id_genero"]." AND 1 ";
		if($CFG->mercado==0) $strSQL.= "AND g.curado AND g.resena IS NOT NULL ";
		else if($CFG->mercado==22) 
		  if($tipo=='teatro')$strSQL.= "AND g.id IN (SELECT id_grupo_teatro FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		  else if($tipo=='danza')$strSQL.= "AND g.id IN (SELECT id_grupo_danza FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		  else if($tipo=='musica')$strSQL.= "AND g.id IN (SELECT id_grupo_musica FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		//else  $strSQL.= "AND g.id IN (SELECT id_grupo_musica FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		$strSQL.="ORDER BY g.nombre";
		
		$qidGr = $db->sql_query($strSQL);
	}else{
		$strSQL="
		SELECT g.id,g.nombre,g.resena_corta,g.en_resena_corta,g.resena, g.telefono, g.email, g.website, g.myspace,g.facebook,g.lastfm,g.twitter, '$tipo' as tipo
		FROM grupos_".$tipo." g
		WHERE ";
		if($CFG->mercado==0) $strSQL.= "g.curado AND g.resena IS NOT NULL ";
		else  $strSQL.= "g.id IN (SELECT id_grupo_".$tipo." FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "') ";
		$strSQL.= "ORDER BY g.nombre";
		
		$qidGr = $db->sql_query($strSQL);
	}
?>
<script type="text/javascript">
 document.domain = 'circulart.org'; 
 </script>
 <? if($CFG->mercado==21){ ?>
	 <? if($tipo=='teatro'){ ?>
     <style>
	 #contenedor #contenido #interna #disciplina a{
		 background-color:#F7941E;
		 color:#ffffff;}
		 
	 #contenedor #contenido #interna .artista table tr td h1{
		 background-color:#F7941E;
		 color:#ffffff;}
	 #contenedor #contenido #interna .artista table tr td h1 .teatro{
		 color:#ffffff;}	 
	 </style>
     <? } ?>
    <? if($tipo=='danza'){ ?>
     <style>
	 #contenedor #contenido #interna #disciplina a{
		 background-color:#41A5C1;
		 color:#ffffff;}
		 
	 #contenedor #contenido #interna .artista table tr td h1{
		 background-color:#41A5C1;
		 color:#ffffff;}
	 #contenedor #contenido #interna .artista table tr td h1 .danza{
		 color:#ffffff;}
		 
	 </style>
     <? } ?> 
 <? } ?>
 
 <? if($CFG->mercado==22){ ?>
	
     <style>
	 #contenedor #contenido #interna #disciplina a{
		 font-family:Helvetica;
		 font-size:14px;
		 background-color:#c0243b;
		 color:#ffffff;}
	 #contenedor #contenido #interna .artista table tr td h1 {
		 font-family:Helvetica;
		 background-color:#c0243b;
		 font-size:14px;
		 color:#ffffff;}
	 #contenedor #contenido #interna .artista table tr td h1 .musica{
         font-family:Helvetica;
		 background-color:#c0243b;
		 font-size:14px;
		 font-weight:bold;
		 text-decoration:none;
		 text-align:right;
		 color:#ffffff;}	
	#contenedor #contenido #interna .artista table tr td p a{
         font-family:Helvetica;
		 font-size:12px;
		 text-decoration:none;
		 text-align:right;
		 color:#c0243b}	  
	 </style>
    
 <? } ?>
<div id="disciplina">
	
    <? if(isset($CFG->mercado)){ ?>
         <? if($CFG->mercado==21){ ?>
         <img src="../images/disciplina/<? echo $tipo.'_'.$CFG->mercado;?>.jpg" width="175" height="49"/>
         <? }else if($CFG->mercado==22){}else{ ?>
         <img src="../images/disciplina/<? if(isset($_GET["querystring"])) echo "informacion"; else echo $tipo;?>.jpg" width="175" height="230"/>
         <? } ?>
	<? }else{ ?>
         <img src="../images/disciplina/<? if(isset($_GET["querystring"])) echo "informacion"; else echo $tipo;?>.jpg" width="175" height="230"/>
    <? } ?>
	
	<?
		if(isset($_GET["querystring"])){
			$qidAreas = $db->sql_query("SELECT * FROM pr_areas ORDER BY nombre");
			while($area = $db->sql_fetchrow($qidAreas)){
				echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=grupos&tipo=".$area["codigo"]."\">".$area["nombre"]."</a>\n";
			}
		}else{
			$strSQL="
			SELECT id,genero 
			FROM generos_".$tipo." ";
			if($CFG->mercado!=0) $strSQL.= "WHERE id IN (SELECT id_generos_".$tipo." FROM generos_grupo_".$tipo." WHERE id_grupos_".$tipo." IN (SELECT id_grupo_".$tipo." FROM mercado_artistas WHERE id_mercado='" . $CFG->mercado . "'))";
			$strSQL.="ORDER BY genero";

			$qidG = $db->sql_query($strSQL);
			while($generos = $db->sql_fetchrow($qidG)){
				if($generos["id"] == $_GET["id_genero"]) echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=grupos&tipo=".$tipo."&id_genero=".$generos["id"]."\" class=\"".$tipo."\">".$generos["genero"]."</a>\n";
				else echo "<a href=\"index.php?mercado=".$CFG->mercado."&modo=grupos&tipo=".$tipo."&id_genero=".$generos["id"]."\">".$generos["genero"]."</a>\n";
			}
		}
	?>	
</div>
<?
	if($db->sql_numrows($qidGr) == 0) echo "<div class\"artista\">No hay resultados de la b&uacute;squeda.</div>";		
	while($grupo = $db->sql_fetchrow($qidGr)){
		$disciplina=$grupo["tipo"];
		$qidImg=$db->sql_query("SELECT id,mmdd_archivo_filename FROM archivos_grupos_".$disciplina." WHERE id_grupos_".$disciplina."=".$grupo["id"]." AND tipo=1 LIMIT 1");		
		if($imagen = $db->sql_fetchrow($qidImg)){
?>
<div class="artista">

  <table width="660" border="0" cellspacing="0" cellpadding="5">
	<tr>
	    <td width="200" valign="top">
        	 <a href="index.php?mercado=<?=$CFG->mercado?>&modo=perfil&id=<?=$grupo["id"]?>&amp;tipo=<?=$disciplina?>"><img src="<?=$CFG->wwwroot?>/phpThumb/phpThumb.php?src=<?=urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_grupos_" . $disciplina . "&field=archivo&id=" . $imagen["id"])?>&amp;w=200" border=\"0\" /></a>
        </td>
		<td valign="top">
       	  	<h1><a href="index.php?mercado=<?=$CFG->mercado?>&modo=perfil&id=<?=$grupo["id"]?>&amp;tipo=<?=$disciplina?>" class="<?=$grupo["tipo"]?>" onclick="javascript:window.parent.arriba();"><?=$grupo["nombre"]?></a></h1>
			<?
				$infoContacto= "";
        		if(isset($grupo["telefono"]))  $infoContacto.="Tel&eacute;fonos: <strong>$grupo[telefono]</strong><br />";
        		if(isset($grupo["email"]))  $infoContacto.="Correo: <strong><a href=\"mailto:$grupo[email]\" class=".$grupo["tipo"].">$grupo[email]</a></strong><br />";
        		if(isset($grupo["website"]))  $infoContacto.="Website: <strong><a href=\"http://$grupo[website]>\" target=\"_blank\" class=".$grupo["tipo"].">$grupo[website]</a></strong>";
	    	?>	
        	<p><?=$infoContacto?></p>
        	<p><?=nl2br(translate($grupo,"resena_corta"))?></p> 
            <p><a href="index.php?mercado=<?=$CFG->mercado?>&modo=perfil&id=<?=$grupo["id"]?>&amp;tipo=<?=$disciplina?>" class="<?=$disciplina?>" onclick="javascript:window.parent.arriba();">[ + ] M&aacute;s info</a></p>
            <? if($grupo["myspace"]!=""){?><a href="http://<?=$grupo["myspace"]?>" target="_blank"><img src="<? $CFG->wwwroot ?>/images/iconos/myspace.jpg" border="0" /></a>&nbsp;&nbsp;<?}?>
         	<? if($grupo["facebook"]!=""){?><a href="http://<?=$grupo["facebook"]?>" target="_blank"><img src="<? $CFG->wwwroot ?>/images/iconos/facebook.jpg" border="0" /></a>&nbsp;&nbsp;<?}?>
		 	<? if($grupo["lastfm"]!=""){?><a href="http://<?=$grupo["lastfm"]?>" target="_blank"><img src="<? $CFG->wwwroot ?>/images/iconos/lastfm.jpg" border="0" /></a>&nbsp;&nbsp;<?}?>
		 	<? if($grupo["twitter"]!=""){?><a href="http://twitter.com/#!/<?=$grupo["twitter"]?>" target="_blank"><img src="<? $CFG->wwwroot ?>/images/iconos/twitter.jpg" border="0" /></a><?}?>
            <br />
            <a href="#" onclick="MM_openBrWindow('recomendar.php?tipo=<?=$disciplina?>&id=<?=$grupo["id"]?>','Circulart','width=260,height=160')"><img src="../images/botones/<?=$disciplina?>.gif" width="182" height="25" vspace="5" border="0"/></a>
	  </td>
	</tr>
	</table>
    <p>&nbsp;</p>
</div>
<?
		}
	}
?>
