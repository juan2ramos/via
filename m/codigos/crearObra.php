 
 <?php
include("../application2.php");
GLOBAL $CFG, $ME, $db;
$frm["id_grupos_musica"]=$_GET["id_grupo"];

/*** determinacion de si es una obra nueva o una antigua ***/
if($_GET["id_obra"]==0){
	$frm["id_obra"]=$db->sql_insert("obras_musica",$frm);
}else{
	$frm["id_obra"]=$_GET["id_obra"];
	$obras = $db->sql_query("SELECT * FROM obras_musica WHERE id_grupos_musica ='".$frm["id_grupos_musica"]."' AND id = '".$frm["id_obra"]."'");
	$obra=$db->sql_fetchrow($obras);
	}


?> 

  <!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/lib/jquery.scrollTo-1.4.3.1-min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo $CFG->dirwww;?>circulart2013/m/js/source/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->dirwww;?>circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<style>
body{
	margin:0;
	background:#E7D8B1;
	color: #3D1211;}
	#carga{
		display:none;}
</style>

<script>
function revisar(frm){
	document.getElementById('submit_button').value='Guardando.....';
	document.getElementById('submit_button').disabled=true;
	return(true);
}
</script>
<script type="text/javascript">
			
	 $(document).ready(function() {
		 
		 $.fn.extend( {
						limiter: function(limit, elem) {
							$(this).on("keyup focus", function() {
								setCount(this, elem);
							});
							function setCount(src, elem) {
								var chars = src.value.length;
								if (chars > limit) {
									src.value = src.value.substr(0, limit);
									chars = limit;
								}
								elem.html( limit - chars );
							}
							setCount($(this)[0], elem);
						}
					});
					
					var elem = $("#chars");
					$("#resena").limiter(700, elem);
					
					var elem = $("#chars2");
					$("#musicos").limiter(500, elem);
					
					var elem = $("#chars3");
					$("#productor").limiter(500, elem);
	
	  });



</script>

<body>
<form action="crearO.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return revisar(this)">
<input type="hidden" id="id_obra" name="id_obra" value="<?php echo $frm["id_obra"];?>">
<input type="hidden" id="id_grupos_musica" name="id_grupos_musica" value="<?php echo $frm["id_grupos_musica"]?>">



			<input type="hidden" name="id_usuario" value="<?=$_GET["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$_GET["area"]?>">
			<input type="hidden" name="id_grupo" value="<?=$_GET["id_grupo"]?>">
            <input type="hidden" name="a" value="<?=$_GET["a"]?>">


<table width="770" border="0" align="center" cellpadding="6" cellspacing="5" class="blanco">
<tr bgcolor="#3D1211">
						<td colspan="2" style="font-weight: bold; text-align: center; font-size: 18px; color: #fff;">Agregar Obra</td>
	</tr>
<tr>
  <td width="312" class="colorTexto">(*) G&eacute;nero: </td>
  <td width="419"><select name="id_generos_musica" style="width:95%">
    <?=$db->sql_listbox("SELECT id,genero FROM generos_musica ORDER BY genero","Seleccione...",nvl($obra["id_generos_musica"]))?>
  </select></td>
</tr>
  <tr>
            <td  align="left" valign="top" class="colorTexto">(*) Nombre de la producci&oacute;n:</td>
            <td  align="left" valign="top"><label>
             <input name="obra" type="text" id="obra" size="58" value="<?=nvl($obra["produccion"])?>" />
      </label></td>
   </tr>
  <tr>
            <td align="left" valign="top" class="colorTexto">(*) A&ntilde;o de la producci&oacute;n:</td>
            <td align="left" valign="top">
      
            <input name="anio" type="text" id="anio" size="58" value="<?=nvl($obra["anio"])?>" /></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="colorTexto">&iquest;Cu&aacute;ntas personas viajan con la producci&oacute;n?:</td>
    <td align="left" valign="top"><input name="num_viajantes" type="text" id="num_viajantes" size="58" value="<?=nvl($obra["num_viajantes"])?>" /></td>
  </tr>
   <tr>
            <td height="212" align="left" valign="top" class="colorTexto">
					(*) Descrpci&oacute;n de la obra:<br>
					<em>(700 caracteres)</em> <br>
							
			</td>
            <td align="left" valign="top"><label>
              <textarea name="resena" id="resena" cols="45" rows="10"><?=nvl($obra["resena"])?></textarea><br /><em><div id="chars" style=""></div>
              <br></td>
    </tr>
          <tr>
            <td height="20" align="left" valign="top" class="colorTexto">(*) Sello discogr&aacute;fico:</td>
            <td align="left" valign="top"><input name="sello_disquero" type="text" id="sello_disquero" size="58" value="<?=nvl($obra["sello_disquero"])?>" /></td>
          </tr>
          <tr>
            <td height="45" align="left" valign="top" class="colorTexto">(*) Caratula:</td>
            <td align="left" valign="top">
            
            <?php $caratula=$db->sql_row("SELECT * FROM archivos_obras_musica WHERE id_obras_musica='".$frm["id_obra"]."' AND etiqueta='Caratula'");
					if($caratula["id"]!=""){
					  $cara=$caratula["id"]."_musica_a_".$caratula["mmdd_archivo_filename"];
					}else{
					  $cara="";
					}
			?>
            <?php if($cara!=""){?>
          
            <img src="http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/tmp/<?php echo $cara;?>&amp;w=100" border="0">
			<?php }?>
         
            <br>
<input name="caratula" type="file" id="caratula" size="40" />
<br>
<em><strong>Recuerde que el archivo  debe ser inferior de 2M de peso, sus dimensiones  [600X400] y el formato [jpg, gif o png].</strong></em><strong></strong></td>
          </tr>
  <tr bgcolor="#3D1211">
            <td colspan="2" align="left" valign="top" bgcolor="#3D1211" style="font-weight: bold; text-align: center; font-size: 18px; color: #fff; p">Audios</td>
    </tr>
          <tr>
            <td colspan="2" align="left" valign="top" style="border:solid 1px #3D1211;"><iframe width="100%" height="400" frameborder="0" src="cargaAudio.php?item=<?php echo $frm["id_obra"]; ?>"></iframe></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" bgcolor="#3D1211" style="font-weight: bold; text-align: center; font-size: 18px; color: #fff;">Video [Yotube - Vimeo]</td>
    </tr>
          <tr>
            <td colspan="2" align="left" valign="top" bordercolor="#D31245" style="border:solid 1px #3D1211"><iframe width="100%" height="400" frameborder="0" src="cargaVideo.php?item=<?php echo $frm["id_obra"]; ?>"></iframe></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" bgcolor="#3D1211" style="font-weight: bold; text-align: center; font-size: 18px; color: #fff;"><strong>Imagenes</strong></td>
    </tr>
          <tr>
            <td colspan="2" align="left" valign="top" bordercolor="#D31245" style="border:solid 1px #3D1211;"><iframe width="100%" height="400" frameborder="0" src="cargaImagen.php?item=<?php echo $frm["id_obra"]; ?>"></iframe></td>
          </tr>
          <tr>
            <td align="left" valign="top"></td>
            <td align="right" valign="top"></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="right" valign="top"><input type="submit" value="Guardar Datos" id="submit_button" /></td>
          </tr>
</table>
</form>
</body>
