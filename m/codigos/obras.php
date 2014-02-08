<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:0;
	background:#fff;
	text-align:center;
		background-color:#383838
	}
	#carga{
		display:none;}
		a{color:#fff;}
table{
	margin-bottom:10px;}
	input{
		
		margin-left:0px;
		}	
	textarea{
		margin-left:-3px}
	.titulo_registro,textarea,input{width:350px;}	
	.titulo_registro{
		padding:5px;}		
.titulo_registro1 {width:350px;}
.titulo_registro1 {		padding:5px;}
</style>
<script>
function regreso(){
	alert("ssss");
	 window.parent.refrescar();
	// window.frameElement.ownerDocument.parentWindow.refrescar();
	 window.parent.location="http://redlat.org/via/m/index.php?modo=inscripciones&mode=paso_3muestra&id_usuario=<?=$_GET["id_usuario"]?>&area=<?=$_GET["area"]?>&id_grupo=<?=$_GET["item"]?>";
	}
	

function revisar(frm){
	if(frm.obra.value==0){
		window.alert('Por favor ingrese el nombre de la obra');
		return(false);
	}
	
	if(frm.anio.value==0){
		window.alert('Por favor ingrese año de la producción');
		return(false);
	}
	
	<?php 
	if($_GET["area"]=="teatro"){
	?>
	if(frm.id_generos_teatro.value=='%'){
		window.alert('Por favor selleccione el género');
		return(false);
		}
	<?php 
	}
	?>
	
	<?php 
	if($_GET["area"]=="danza"){
	?>
	if(frm.id_generos_danza.value=='%'){
		window.alert('Por favor selleccione el género');
		return(false);
		}
	<?php 
	}
	?>
	
	
	if(frm.resena.value==0){
		window.alert('Por favor la reseña de la obra');
		return(false);
	}
	
	if(frm.en_resena.value==0){
		window.alert('Por favor la reseña de la obra en inglés');
		return(false);
	}
	
	return(true);
}		
	
	
$(document).ready(function() {
	$("#regresar").click(function(){
		regreso();
		})
	});

</script>
<?php
include("../application.php");
GLOBAL $CFG, $ME, $db;

$frm["area"]=$_GET["area"];
$frm["paso"]=$_GET["paso"];
$frm["id_grupos_".$frm["area"]]=$_GET["item"];
$frm["id_obra"]=$_GET["id_obra"];
$bandera=0;
if($frm["paso"]==1){
	if($frm["id_obra"]==0){
		$bandera=0;
 		$frm["id_obra"]=$db->sql_insert("obras_".$frm["area"],$frm);
 	}else{
		$bandera=1;
		$obras = $db->sql_query("SELECT * FROM obras_".$frm["area"]." WHERE id_grupos_".$frm["area"]."='".$frm["id_grupos_".$frm["area"]]."' AND id = '".$frm["id_obra"]."'");
		$obra=$db->sql_fetchrow($obras);
	 }
?>
<form action="obras.php?item=<?=$frm["id_grupos_".$frm["area"]]?>&area=<?=$frm["area"]?>&paso=2&id_obra=<?=$frm["id_obra"]?>&id_usuario=<?=$_GET["id_usuario"]?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)"> 
<input type="hidden" id="id_obra" name="id_obra" value="<?=$frm["id_obra"];?>">
<input type="hidden" id="id_grupos_<?=$frm["area"]?>" name="id_grupos_<?=$frm["area"]?>" value="<?=$frm["id_grupos_".$frm["area"]]?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5"><p><br>
      <br>
    </p></td>
  </tr>
  <tr>
    <td width="350" valign="top"><div class="titulo_registro">DATOS DE LA PRODUCCI&Oacute;N ESC&Eacute;NICA</div><p>
      Nombre de la obra *<br>      
        <input type="text" size="20" name="obra" value="<?=nvl($obra["obra"])?>">
        <br>
<br>
    A&ntilde;o *<br>      
    <input type="text" size="20" name="anio" value="<?=nvl($obra["anio"])?>">
    <br>
<br>
    Autor(a)<br>      
    <input type="text" size="20" name="autor" value="<?=nvl($obra["autor"])?>">
    <br>
<br>
    Director(a)<br>      
    <input type="text" size="20" name="director" value="<?=nvl($obra["director"])?>">
    <br>
    <? if($frm["area"]=="danza"){?>
<br>
    Core&oacute;grafo(a)<br>      
    <input type="text" size="20" name="coreografo" value="<?=nvl($obra["coreografo"])?>">
    <br> 
    <? }?>  
<br>
    G&eacute;nero *<br>
      <select name="id_generos_<?=$frm["area"]?>" style="width:350px">
        <?=$db->sql_listbox("SELECT id,genero FROM generos_".$frm["area"]." ORDER BY genero","Seleccione...",nvl($obra["id_generos_".$frm["area"]]))?>
      </select>      
      <br>
      <br>
      Rese&ntilde;a  *<br>      
    <textarea rows="10" cols="50" name="resena"><?=nvl($obra["resena"])?></textarea>
    <br>
    <br>
    Rese&ntilde;a (Ingl&eacute;s) *<br>
    <textarea rows="10" cols="50" name="en_resena"><?=nvl($obra["en_resena"])?></textarea>
    <br>
    <br>
    M&uacute;sica<br>
<input type="text" size="20" name="musica" value="<?=nvl($obra["musica"])?>">
<br>
<br>
Duraci&oacute;n total<br>
<input type="text" size="20" name="duracion" value="<?=nvl($obra["duracion"])?>">
<br>
    </p></td>
    <td width="137" valign="top">&nbsp;</td>
    <td width="414" rowspan="15" valign="top"><div class="titulo_registro">MONTAJE</div><p> No. de actos<br>
<input type="text" size="20" name="num_actos" value="<?=nvl($obra["num_actos"])?>">
<br>
<br>
No. de intermedios<br>
<input type="text" size="20" name="num_intermedios" value="<?=nvl($obra["num_intermedios"])?>">
<br>
<br>
Tipo de p&uacute;blico <br>
<select id="tipo_publico" name="tipo_publico">
  <option value="%" >Seleccione... </option>
  <option value="1" <? if($obra["tipo_publico"]==1){echo "selected";} ?>>Adultos </option>
  <option value="2" <? if($obra["tipo_publico"]==1){echo "selected";} ?>>Infantil </option>
  <option value="3" <? if($obra["tipo_publico"]==1){echo "selected";} ?>>Familiar </option>
</select>
<br>
<br>
&iquest;Cu&aacute;ntas personas viajan con la producci&oacute;n?
<input type="text" size="10" name="num_viajantes" value="<?=nvl($obra["num_viajantes"])?>">
<br>
<br>
No. de horas de montaje<br>
<input type="text" size="20" name="horas_montaje" value="<?=nvl($obra["horas_montaje"])?>">
<br>
<br>
No. de horas de desmontaje<br>
<input type="text" size="20" name="horas_desmontaje" value="<?=nvl($obra["horas_desmontaje"])?>">
<br>
Espacio esc&eacute;nico requerido<br>
      <input type="text" size="20" name="espacio" value="<?=nvl($obra["espacio"])?>">
      <br>
      <br>
      Espacio esc&eacute;nico requerido (Ingl&eacute;s)<br>
  <input type="text" size="20" name="en_espacio" value="<?=nvl($obra["en_espacio"])?>">
  <br>
  <br>
      Iluminaci&oacute;n<br>
  <input type="text" size="20" name="iluminacion" value="<?=nvl($obra["iluminacion"])?>">
  <br>
  <br>
      Iluminaci&oacute;n (Ingl&eacute;s)<br>
  <input type="text" size="20" name="en_iluminacion" value="<?=nvl($obra["en_iluminacion"])?>">
  <br>
  <br>
Plano Luces (Subir PDF)</p>
      <p><iframe width="100%" height="250px" frameborder="0" scrolling="no" src="subirIluninacion.php?item=<?=$frm["id_grupos_".$frm["area"]]?>&area=<?=$frm["area"]?>&id_obra=<?=$frm["id_obra"]?>"></iframe></p>
      <p>      
      <p>        <br>
    </p></td>
    <td width="88" rowspan="15" valign="top">&nbsp;</td>
    <td width="874" rowspan="15" valign="top">
      <div class="titulo_registro">CARGA</div>
      <p><br>
        Sonido<br>
  <input type="text" size="20" name="sonido" value="<?=nvl($obra["sonido"])?>">
  <br>
  <br>
        Sonido (Ingl&eacute;s)<br>
  <input type="text" size="20" name="en_sonido" value="<?=nvl($obra["en_sonido"])?>">
  <br>
<br>
        No. de piezas<br>
  <input type="text" size="20" name="piezas" value="<?=nvl($obra["piezas"])?>">
  <br>
  <br>
        Volumen total (en m3)<br>
  <input type="text" size="20" name="volumen" value="<?=nvl($obra["volumen"])?>">
  <br>
  <br>
        Peso total (en kilos)<br>
  <input type="text" size="20" name="peso" value="<?=nvl($obra["peso"])?>">
  <br>
  <br>
        Equipos adicionales y/o efectos especiales<br>
        <textarea rows="5" cols="50" name="equipos_adicionales"><?=nvl($obra["equipos_adicionales"])?>
        </textarea>
  <br>
  <br>
  <br>
        Equipos adicionales y/o efectos especiales (Ingl&eacute;s) :<br>
        <textarea rows="5" cols="50" name="en_equipos_adicionales"><?=nvl($obra["en_equipos_adicionales"])?>
        </textarea>
  <br>
  <br>
  <br>
        Comentarios adicionales <br>
        <textarea rows="5" cols="50" name="comentarios"><?=nvl($obra["comentarios"])?>
        </textarea>
  <br>
  <br>
  <br>
        Comentarios adicionales (Ingl&eacute;s)<br>
        <textarea rows="5" cols="50" name="en_comentarios"><?=nvl($obra["en_comentarios"])?>
        </textarea>
      </p></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5"><div class="titulo_registro" style="width:92%">ARCHIVO DE LA OBRA</div></td>
  </tr>
  <tr>
    <td width="51%"><iframe width="600px" height="500" frameborder="0" scrolling="auto" src="cargaVideo.php?item=<?=$frm["id_obra"]?>&area=<?=$frm["area"]?>"></iframe></td>
    <td width="0%" rowspan="4">&nbsp;</td>
    <td colspan="3"><iframe width="600px" height="500" frameborder="0" src="cargaImagen.php?item=<?=$frm["id_obra"]?>&area=<?=$frm["area"]?>"></iframe></td>
  </tr>
  <tr>
    <td><br>
      <br>
      <br></td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>
    <?php if($bandera==0){?>
        <a href="obras.php?item=<?=$frm["id_grupos_".$frm["area"]]?>&area=<?=$frm["area"]?>&paso=3&id_obra=<?=$frm["id_obra"]?>" id="regresarInsetar" style="padding:17px; color:#FFF; background-color:#F00; text-transform:uppercase; font-size:14px">Regresar</a>
    <?php }?>
    <?php if($bandera==1){?>
        <a href="#" id="regresar" style="padding:17px; color:#FFF; background-color:#F00; text-transform:uppercase; font-size:14px">Regresar</a>
    <?php }?>
    </td>
    <td width="15%" align="left">&nbsp;</td>
    <td width="12%" align="right">&nbsp;</td>
    <td width="22%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      <input  type="submit" name="Submit" id="Submit" value="Guardar Datos"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<br>
<br>
</form>
<?php
}

if($paso==2){
	$db->sql_query("UPDATE obras_".$frm["area"]." SET id_generos_".$frm["area"]."='".$_POST["id_generos_".$frm["area"]]."' WHERE id='".$_POST["id_obra"]."'");
    $db->sql_query("UPDATE obras_".$frm["area"]." SET anio='".$_POST["anio"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET obra='".$_POST["obra"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET anio='".$_POST["anio"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET autor='".$_POST["autor"]."' WHERE id='".$_POST["id_obra"]."'");
	//$db->sql_query("UPDATE obras_".$frm["area"]." SET director='".$_POST["director"]."' WHERE id='".$_POST["id_obra"]."'");
	if($frm["area"]=="danza"){
	 $db->sql_query("UPDATE obras_".$frm["area"]." SET coreografo='".$_POST["coreografo"]."' WHERE id='".$_POST["id_obra"]."'");
	}
	$db->sql_query("UPDATE obras_".$frm["area"]." SET resena='".$_POST["resena"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET en_resena='".$_POST["en_resena"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET musica='".$_POST["musica"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET duracion='".$_POST["duracion"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET num_actos='".$_POST["num_actos"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET num_intermedios='".$_POST["num_intermedios"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET tipo_publico='".$_POST["tipo_publico"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET num_viajantes='".$_POST["num_viajantes"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET horas_montaje='".$_POST["horas_montaje"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET horas_desmontaje='".$_POST["horas_desmontaje"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET espacio='".$_POST["espacio"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET en_espacio='".$_POST["en_espacio"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET iluminacion='".$_POST["iluminacion"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET en_iluminacion='".$_POST["en_iluminacion"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET resena='".$_POST["resena"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET sonido='".$_POST["sonido"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET en_sonido='".$_POST["en_sonido"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET piezas='".$_POST["piezas"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET volumen='".$_POST["volumen"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET peso='".$_POST["peso"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET equipos_adicionales='".$_POST["equipos_adicionales"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET en_equipos_adicionales='".$_POST["en_equipos_adicionales"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET comentarios='".$_POST["comentarios"]."' WHERE id='".$_POST["id_obra"]."'");
	$db->sql_query("UPDATE obras_".$frm["area"]." SET en_comentarios='".$_POST["en_comentarios"]."' WHERE id='".$_POST["id_obra"]."'");
	
	?>
 	<script>
		regreso();
	</script>    
    <?php
	}
	
if($paso==3){
	$db->sql_query("delete from obras_".$frm["area"]." where id='".$frm["id_obra"]."'");
	?>
    <script>
		regreso();
	</script> 
    <?php
	
	}	
?>