<!--<a href="index.php?modo=informacion"><img src="images/mercados/mercado_<?=$CFG->mercado;?>.jpg" border="0" hspace="25"></a>-->
<table width="850" border="0"  cellpadding="0" cellspacing="0" bgcolor="#DCE49D">
	<tr>
    	<td>
    		<img src="images/estructura/actualizaciones.jpg" width="850" height="50" />
    		<? 	
				if($CFG->mercado==0){
					$qidGr = $db->sql_query("SELECT * FROM grupos_musica WHERE ingresado_por=1 ORDER BY nombre");
				}
				while($musica =$db->sql_fetchrow($qidGr)){
			?>
			<table width="120" border="0" class="portada" cellpadding="0" cellspacing="0">
  				<tr>
    				<td>
            			<?
							$qidImg=$db->sql_query("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica=".$musica["id"]." AND tipo=1 ORDER BY orden LIMIT 1");
							if($imagen = $db->sql_fetchrow($qidImg)){
								$urlImagen=urlencode($CFG->servidor . "/" . $CFG->wwwroot . "/admin/imagen.php?table=archivos_grupos_musica&field=archivo&id=" . $imagen["id"]);
								$imgurl="<img src=\"".$CFG->wwwroot."/phpThumb/phpThumb.php?src=".$urlImagen."&w=120\" border=0 >";
								echo "<a href=\"index.php?modo=perfil&tipo=musica&id=".$musica["id"]."\">$imgurl</a>";
							}
						?>
            		</td>
  				</tr>
  				<tr>
    				<td bgcolor="#99CC00" height="10px"></td>
  				</tr>
  				<tr>
    				<td>
            			<table width="120" border="0" cellpadding="5px" bgcolor="#333333">
            				<tr><td><? echo "<a href='index.php?modo=perfil&tipo=musica&id=".$musica["id"]."'>".$musica["nombre"]."</a>";?></td></tr>
						</table>
            		</td>
  				</tr>
		  </table>
			<? }?>
   	  </td>
	</tr>
  	<tr>
    	<td>&nbsp;</td>
  	</tr>
</table>
<p>&nbsp;</p>