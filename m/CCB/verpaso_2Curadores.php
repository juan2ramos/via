    <!-- Add jQuery library -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/lib/jquery.scrollTo-1.4.3.1-min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
<?php 
 $frm["id_grupo"]=$_GET["id_grupo"];
?>

<script>
function ver(obj){
	url="codigos/verObra.php?modo=inscripciones&mode=paso_3muestra&id_usuario=<?=$_GET["id_grupo"]?>&area=musica&id_grupo=<?=$_GET["id_grupo"]?>&id_obra="+obj;
	/*$.fancybox.open({
							href : url,
							padding : 5,
							height :500,
							width  :800,
							autoSize: false,
							type : 'iframe'
							
    });*/
	

	myWindow=window.open(url,'Obras','width=870,height=550')
	myWindow.focus()
}
</script>
<style type="text/css">
.margenp {				margin-left:10px;
				font-size:12px;
}


</style>


		
     
      
        <table width="910"  border="0" cellpadding="12" cellspacing="5" style="color: #3D1211; font-weight: bold;text-align:justify" bgcolor="#E7D8B1" >
          <tr>
            <td colspan="4" align="left" valign="top"><a href="http://2013.circulart.org/m/index.php?modo=curadores&amp;mode=listar_grupos&amp;a=1">Regresar al listado de grupos
			
          </a></tr>
          <tr>
            <td width="220" rowspan="7" align="left" valign="top" ><table width="100%" border="0" cellspacing="5" cellpadding="5" id="imagenGrupo">
              <tr>
                <td align="justify" style="font-weight:normal" valign="middle"><?php
				
				
			$caratula=$db->sql_row("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica='".$frm["id_grupo"]."' AND etiqueta='Imagen' AND orden='0'");
			
			$frm=$trayectoria=$db->sql_row("SELECT * FROM grupos_musica WHERE id='".$frm["id_grupo"]."'");
			
			 if($caratula["id"]!=""){
			 ?>
                  <img src="http://2013.circulart.org/m/admin/imagen.php?table=archivos_grupos_musica&amp;field=archivo&amp;id=<?php echo $caratula["id"];?>" width="200" />
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php } else
			  {  
			  ?>
                  <img src="http://circulart.org/circulart2013/m/images/mercados/imagen.jpg" width="200" />
                  <input name="imagen" type="hidden" id="nombre2" size="20" value="<?php echo $caratula["mmdd_archivo_filename"];?>" />
                  <br />
                  <br />
                  <?php  
				  }?></td>
              </tr>
            </table></td>
            <td width="147" align="left" valign="top" class="colorTexto">(*) Nombre del grupo o del artista:</td>
            <td width="451" colspan="2" align="left" valign="top" ><table class="nombre"width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal" style="font-weight:normal"><?=nvl($frm["nombre"])?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto"><p>(*) Breve descripci&oacute;n:<br />
              (700 caracteres)
            </p></td>
            <td colspan="2" align="left" valign="top" ><table class="resena" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal" ><?=nvl($frm["resena_corta"])?>
                  </td>
                </tr>
              </table>
            <em><div id="chars" style=""></div></em></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Breve descripci&oacute;n en ingles:<br />
(700 caracteres)</td>
            <td colspan="2" align="left" valign="top"><table  class="resena2"width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["en_resena_corta"])?>
                  </td>
              </tr>
              </table>
            <em><div id="chars3" style=""></div></em></td>
          </tr>
          
          <tr>
            <td align="left" valign="top" class="colorTexto"><span class="colorTexto ">(*) Tipo de propuesta:</span></td>
            <td colspan="2" align="left" valign="top" ><span>
              <?php 
			 
			$propuesta=$db->sql_row("SELECT * FROM grupos_musica WHERE id='".$_GET["id_grupo"]."'");
			?>
            </span>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="propuesta">
                <tr>
                  <td align="justify" style="font-weight:normal">
                    <?php if($propuesta["tipo_propuesta"]==0){echo "Seleccione...";}else{}?>
                    <?php if($propuesta["tipo_propuesta"]==1){echo "Vocal";}else{}?>
                    <?php if($propuesta["tipo_propuesta"]==2){echo "Instrumental";}else{}?>
                    <?php if($propuesta["tipo_propuesta"]==3){echo "Vocal e Instrumental";}else{}?>
                  </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto generos">(*) G&eacute;nero: </td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top" class="generos">
             <?php 
					
					$g1=0; $g2=0; $g3=0; $g4=0; $g5=0; $g6=0; $g7=0; $g8=0; $g9=0; $g10=0; $g11=0; $g12=0; $g13=0; $g14=0; $g15=0; $g16=0; $g17=0; $g18=0; $g19=0; 
								 
			   $generos=$db->sql_query("SELECT * FROM generos_grupo_musica WHERE id_grupos_musica='".$_GET["id_grupo"]."'");
				
				while($generos_artista=$db->sql_fetchrow($generos)){
			   	   if($generos_artista["id_generos_musica"]==42){$g1=1;} 
				   if($generos_artista["id_generos_musica"]==10){$g2=1;} 
				   if($generos_artista["id_generos_musica"]==11){$g3=1;} 
				   if($generos_artista["id_generos_musica"]==6){$g4=1;} 
				   if($generos_artista["id_generos_musica"]==5){$g5=1;} 
				   if($generos_artista["id_generos_musica"]==22){$g6=1;} 
				   if($generos_artista["id_generos_musica"]==20){$g7=1;} 
				   if($generos_artista["id_generos_musica"]==45){$g8=1;} 
				   if($generos_artista["id_generos_musica"]==38){$g9=1;} 
				   if($generos_artista["id_generos_musica"]==46){$g10=1;} 
				   if($generos_artista["id_generos_musica"]==44){$g11=1;} 
				   if($generos_artista["id_generos_musica"]==41){$g12=1;} 
				   if($generos_artista["id_generos_musica"]==7){$g13=1;} 
				   if($generos_artista["id_generos_musica"]==37){$g14=1;} 
				   if($generos_artista["id_generos_musica"]==4){$g15=1;} 
				   if($generos_artista["id_generos_musica"]==43){$g16=1;} 
				   if($generos_artista["id_generos_musica"]==13){$g17=1;} 
				   if($generos_artista["id_generos_musica"]==39){$g18=1;} 
				   if($generos_artista["id_generos_musica"]==40){$g19=1;} 
				}
				
			?>
             <?php  if($g1==1){echo "Acústico";}else{}?>  
             <?php if($g2==1){echo "<br />Contemporánea";}else{}?> 
             <?php if($g3==1){echo "<br />Electrónica";}else{}?>  
             <?php if($g4==1){echo "<br />Electrónico Latino";}else{}?> 
             <?php if($g5==1){echo "<br />Fusión";}else{}?>  
             <?php if($g6==1){echo "<br />Hip Hop &amp; Rap";}else{}?>  
             <?php if($g7==1){echo "<br />Jazz'";}else{}?>  
             <?php if($g8==1){echo "<br />Metal";}else{}?> 
             <?php if($g9==1){echo "<br />Pop";}else{}?>  
             <?php if($g10==1){echo "<br />Pop alternativo";}else{}?>  
             <?php if($g11==1){echo "<br />Punk/Hardcore";}else{}?>  
             <?php if($g12==1){echo "<br />Reggae";}else{}?> 
             <?php if($g13==1){echo "<br />Rock &amp; Alternative";}else{}?> 
             <?php if($g14==1){echo "<br />Rock Latino";}else{}?>  
             <?php if($g15==1){echo "<br />Salsa &amp; Son";}else{}?>  
             <?php if($g16==1){echo "<br />Ska";}else{}?> 
             <?php if($g17==1){echo "<br />Tradicional";}else{}?>  
             <?php if($g18==1){echo "<br />Tropical";}else{}?> 
             <?php if($g19==1){echo "<br />Vocal &amp; Capella";}else{}?>  
</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Pa&iacute;s:</td>
            <td colspan="2" align="left" valign="top" class="id_pais">
              
                <?php 
			$pais=$db->sql_row("SELECT * FROM grupos_musica WHERE id='".$frm["id_grupo"]."'");
			?>
             
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_pais">
                <tr>
                  <td align="justify" style="font-weight:normal">
                    <?php if($propuesta["id_pais"]==0){echo "Seleccione...";}else{}?>
                    <?php if($propuesta["id_pais"]==1){echo "Argentina";}else{}?>
                    <?php if($propuesta["id_pais"]==1){echo "Bolivia";}else{}?>
                    <?php if($propuesta["id_pais"]==23){echo "Brasil";}else{}?> 
                    <?php if($propuesta["id_pais"]==3){echo "Chile";}else{}?>
                    <?php if($propuesta["id_pais"]==4){echo "Colombia";}else{}?>
                    <?php if($propuesta["id_pais"]==5){echo "Costa Rica";}else{}?>
                    <?php if($propuesta["id_pais"]==6){echo "Cuba";}else{}?>
                    <?php if($propuesta["id_pais"]==7){echo "Ecuador";}else{}?>
                    <?php if($propuesta["id_pais"]==8){echo "El Salvador";}else{}?>
                    <?php if($propuesta["id_pais"]==9){echo "España";}else{}?>
                    <?php if($propuesta["id_pais"]==24){echo "Francia";}else{}?>
                    <?php if($propuesta["id_pais"]==10){echo "Guatemala";}else{}?>
                    <?php if($propuesta["id_pais"]==11){echo "Honduras";}else{}?>
                    <?php if($propuesta["id_pais"]==12){echo "México";}else{}?>
                    <?php if($propuesta["id_pais"]==13){echo "Nicaragua";}else{}?>
                    <?php if($propuesta["id_pais"]==14){echo "Panamá";}else{}?>
                    <?php if($propuesta["id_pais"]==15){echo "Paraguay";}else{}?>
                    <?php if($propuesta["id_pais"]==16){echo "Perú";}else{}?>
                    <?php if($propuesta["id_pais"]==17){echo "Puerto Rico";}else{}?>
                    <?php if($propuesta["id_pais"]==18){echo "República Dominicana";}else{}?>
                    <?php if($propuesta["id_pais"]==19){echo "Uruguay";}else{}?>
                    <?php if($propuesta["id_pais"]==20){echo ">Venezuela";}else{}?>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Ciudad:</td>
            <td colspan="2" align="left" valign="top" ><table class="ciudad" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["ciudad"])?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Direcci&oacute;n:</td>
            <td colspan="2" align="left" valign="top" ><table class="direccion" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["direccion"])?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Tel&eacute;fono:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top" ><table class="telefono" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["telefono"])?><br />
</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Tel&eacute;fono dos:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["telefono2"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Correo: </td>
            <td colspan="2" align="left" valign="top" ><table class="email" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["email"])?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Correo dos:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["email2"])?></td>
          </tr>
          <tr>
            <td  align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">(*) Nombre del Contacto:</span></td>
            <td colspan="2" align="left" valign="top" ><table class="contacto" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["contacto"])?></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td  align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) C&eacute;dula del contacto:</td>
            <td colspan="2" align="left" valign="top" ><table class="cc1" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["contacto_cc"])?></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td  align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Trayectoria URL:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top">
            <?
              
			 $buscar = "http";
			 $cadena = $frm["trayectoria_url"];
			 $resultado = strpos($cadena, $buscar);
			 
			 if($frm["trayectoria_url"]!=""){
			 if($resultado !== FALSE){
				 echo "<a href='". $frm["trayectoria_url"]."' target='_blank'>Ver la trayectoria online</a>";
				 }else{
				 echo  "<a href='http://".$frm["trayectoria_url"]."' target='_blank'>Ver la trayectoria online</a>";
					 }
			 }
			  ?>
             </td>
          </tr>
          <tr>
            <td  align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto" >(*) Trayectoria en pdf:</td>
            <td colspan="2" align="left" valign="top">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="trayec" >
                <tr>
    <td align="justify" style="font-weight:normal"><!-- se activa si el artista ya subio una trayectoria ---><a href="http://2013.circulart.org/m/fileFSpdf.php?table=grupos_musica&field=trayectoria&id=<?php echo $_GET["id_grupo"]?>" target="_blank" >Ver archivo</a>
     </td>
  </tr>
</table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*)Website:</td>
            <td colspan="2" align="left" valign="top" ><table class="website1" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal">
                  <? 
			  $buscarWeb = "http";
			  $cadenaWeb = $frm["website"];
			  $resultadoWeb = strpos($cadenaWeb, $buscarWeb);
			 
			 if($frm["website"]!=""){
			 if($resultadoWeb!== FALSE){
				 echo "<a href='". $frm["website"]."' target='_blank'>Ir a la página del grupo o artista</a>";
				 }else{
				 echo  "<a href='http://".$frm["website"]."' target='_blank'>Ir a la página del grupo o artista</a>";
					 }
			 }

			?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">MySpace:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top">
            <?
			
			  $buscarMy = "http";
			  $cadenaMy = $frm["myspace"];
			  $resultadoMy = strpos($cadenaMy, $buscarMy);
			 
			 if($frm["myspace"]!=""){
			 if($resultadoMy !== FALSE){
				 echo "<a href='". $frm["myspace"]."' target='_blank'>Ir a la página de myspace del grupo o artista</a>";
				 }else{
				 echo  "<a href='http://".$frm["myspace"]."' target='_blank'>Ir a la página de myspace del grupo o artista</a>";
					 }
			 }

			?>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Facebook:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top">
            <?
			
			 if($frm["facebook"]!=""){
				 
			  $buscarFace = "http";
			  $cadenaFace = $frm["facebook"];
			  $resultadoFace = strpos($cadenaFace, $buscarFace);
			 
			
			 if($resultadoFace !== FALSE){
				 echo "<a href='". $frm["facebook"]."' target='_blank'>Ir a la página de Facebook del grupo o artista</a>";
				 }else{
				 echo  "<a href='http://".$frm["facebook"]."' target='_blank'>Ir a la página de Facebook del grupo o artista</a>";
					 }
					 
					 
			 
				 
			 ?>
             <br />
             <br />
            <div id="fb-root" style="z-index:-1; background-color:#fff"></div>
			<script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-like-box" data-href="<?=nvl($frm["facebook"])?>" data-width="292" data-show-faces="true" data-stream="true" data-show-border="true" data-header="true" style="background-color:#fff">...Cargando</div>
            <?php }?>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Twitter:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top">
            <?
			
			 if($frm["twitter"]!=""){
				 
			  $buscarTwitter = "https://twitter.com/";
			  $cadenaTwitter = $frm["twitter"];
			  $resultadoTwitter = strpos($cadenaTwitter, $buscarTwitter);
			 
			
			 if($resultadoTwitter !== FALSE){
				 echo "<a href='". $frm["twitter"]."' target='_blank'>Ir a la página de twitter del grupo o artista</a>";
				 $ruta=$frm["twitter"];
				 }else{
					 $buscarTwitter = "https://";
			         $cadenaTwitter = $frm["twitter"];
			         $resultadoTwitter = strpos($cadenaTwitter, $buscarTwitter);
			         if($resultadoTwitter !== FALSE){
				        echo  "<a href='".$frm["twitter"]."' target='_blank'>Ir a la página de twitter del grupo o artista</a>";
						$ruta=$frm["twitter"];
					 }else{
						 $buscarTwitter = "twitter.com";
						 $cadenaTwitter = $frm["twitter"];
						 $resultadoTwitter = strpos($cadenaTwitter, $buscarTwitter);
						 if($resultadoTwitter !== FALSE){
							echo  "<a href='https://".$frm["twitter"]."' target='_blank'>Ir a la página de twitter del grupo o artista</a>";
							$ruta="https://".$frm["twitter"];
							   }else{
								   	echo  "<a href='https://twitter.com/".$frm["twitter"]."' target='_blank'>Ir a la página de twitter del grupo o artista</a>";
							         $ruta="https://twitter.com/".$frm["twitter"];
								   
								   }
						 }
				   }
			 }
			?>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Last.fm:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><? if($frm["lastfm"]!=""){?><a href="<?=$frm["lastfm"]?>" target="_blank">ver lasfm</a><? } ?></td>
          </tr>
          <tr>
            <td align="left" valign="top"></td>
            <td colspan="3" align="left" valign="top" class="colorTexto "><hr /></td>
          </tr>
          <tr>
            <td  align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto rut"><span class="colorTexto ">Entidades o empresas:</span></td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top" class="rut"><?=nvl($frm["empresa"])?>
              <br />
              <em><strong>(Entidades o empresas que lo representan legalmente)</strong></em></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">N&uacute;mero de identificaci&oacute;n de la empresa:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top" class=""><span class="rut">
             <?=nvl($frm["nit"])?>
            </span><br />
            <em><strong>(Colombia NIT o RUT)</strong></em><strong></strong></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Manager:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["manager"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Agente de Booking 1:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["booking"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Agente de Booking 2:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["booking_uno"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Agente de Booking 3:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["booking_dos"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Agente de Booking 4:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["booking_tres"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto ">Editor:</td>
            <td colspan="2" align="justify" style="font-weight:normal" valign="top"><?=nvl($frm["editor"])?></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) No. de personas en gira:</td>
            <td colspan="2" align="left" valign="top"><table class="nop" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["num_personas_gira"])?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) No. de personas en escenario:</td>
            <td colspan="2" align="left" valign="top" ><table class="nope" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal"><?=nvl($frm["num_personas_escenario"])?></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td rowspan="2" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top" class="colorTexto">(*) Ficha:</td>
            <td colspan="2" align="left" valign="top" ><table class="ficha" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td align="justify" style="font-weight:normal" valign="middle">
                  <a href="http://2013.circulart.org/m/fileFSpdf.php?table=grupos_musica&field=ficha&id=<?php echo $_GET["id_grupo"]?>" target="_blank" >Ver archivo</a></td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="colorTexto">(*) Demo:</td>
            <td colspan="2" align="left" valign="top" ><table class="demo" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td  align="justify" style="font-weight:normal" valign="middle"><object type="application/x-shockwave-flash" data="http://circulart.org//audio_base/player.swf" id="audioplayer<?php echo $_GET["id_grupo"]?>" height="30" width="217">
							  	<param name="movie" value="http://circulart.org//audio_base/player.swf">
							  	<param name="FlashVars" value="playerID=<?php echo $frm["id_grupo"]?>&amp;soundFile=http://circulart.org//files/grupos_musica/demo/<?php echo $_GET["id_grupo"]?>">
							  	<param name="bgcolor" value="#FFFFFF">
							  	<param name="quality" value="high">
							  	<param name="menu" value="false">
								<param name="wmode" value="transparent">
							  </object></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top" class="colorTexto personas"><hr />
            En caso de quedar seleccionado(s) indique el nombre y documento de la(s) persona(s) que lo(s) representar&aacute;(n) en las citas de la Rueda de Negocios.</td>
          </tr>
          
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top"><input type="hidden" name="personas"  id="personas" size="20" value="<?php 
			
			$numero=$db->sql_query("select count(*) from vinculados WHERE id_grupo_musica='".$_GET["id_grupo"]."' ORDER BY id");
			$resultado=$db->sql_fetchrow($numero);
			echo $resultado[0];?>" />
              <?php 
		  
		  $id_persona=$db->sql_query("SELECT * FROM vinculados WHERE id_grupo_musica='".$_GET["id_grupo"]."' ORDER BY id");
			
		  while($vinculo=$db->sql_fetchrow($id_persona)){
			  
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="29%">&nbsp;</td>
    <td width="35%">&nbsp;</td>
    <td width="36%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="colorTexto ">Foto:</td>
    <td width="35%"><img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/files/vinculados/foto/<?php echo $vinculo["id"]; ?>&amp;w=80" border="0"></td>
    <td width="36%">&nbsp;</td>
  </tr>
  <tr>
    <td class="colorTexto ">Nombre:</td>
    <td><?php echo $vinculo["nombre"]; ?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="colorTexto ">Documento:</td>
    <td><?php echo$vinculo["documento"]; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>

        <br />
        
        <?php 
			  
			  }
		  
		  ?>&nbsp;</td>
          </tr>

        </table>

