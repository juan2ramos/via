<?
include("application.php");
setlocale(LC_TIME, "es_ES");

if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
else $frm=$_GET;

if(nvl($frm["tipo"]) == "danza") $tipo="danza";
elseif(nvl($frm["tipo"]) == "musica") $tipo="musica";
else $tipo="teatro";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Circulart :: Plataforma de Exportaci&oacute;n de las artes esc&eacute;nicas y musicales</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" media="screen" />    
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>    
<script type="text/javascript">
	function MM_openBrWindow(theURL,winName,features) {
  		window.open(theURL,winName,features);
	};

	$(function() {
        $('#gallery a').lightBox();
    });

	function cambiarMercado(opciones){
		document.location.href = "index.php?mercado="+opciones.options[opciones.selectedIndex].value;	  
 	}
</script>
<style type="text/css">
body {
	background-image:url(../images/estructura/fondo_<?=$CFG->mercado;?>.gif);
}
</style>
</head>

<body>
<div id="contenedor">
	<div id="cabezote">
<div id="logo"><a href="index.php?modo=inicio"><img src="images/estructura/logo_<?=$CFG->mercado;?>.jpg" width="185" height="125" border="0" /></a></div>

<div id="menu">
  <a href="index.php?modo=informacion"><img src="images/menu/informacion.jpg" alt="" width="160" height="75" border="0" name="informacion" onmouseover="informacion.src='images/menu/informacion_R.jpg';" onmouseout="informacion.src='images/menu/informacion.jpg';" /></a>
  <a href="index.php?modo=grupos&amp;tipo=teatro"><img src="images/menu/teatro.jpg" width="115" height="75" border="0" name="teatro" onmouseover="teatro.src='images/menu/teatro_R.jpg';" onmouseout="teatro.src='images/menu/teatro.jpg';" /></a>
  <a href="index.php?modo=grupos&tipo=danza"><img src="images/menu/danza.jpg" width="125" height="75" border="0" name="danza" onmouseover="danza.src='images/menu/danza_R.jpg';" onmouseout="danza.src='images/menu/danza.jpg';" /></a>
  <a href="index.php?modo=grupos&tipo=musica"><img src="images/menu/musica.jpg" width="125" height="75" border="0" name="musica" onmouseover="musica.src='images/menu/musica_R.jpg';" onmouseout="musica.src='images/menu/musica.jpg';" /></a>
  <? if ($CFG->mercado==0) {?>
  <a href="index.php?modo=organizaciones"><img src="images/menu/organizaciones.png" width="155" height="75" border="0" name="organizaciones" onmouseover="organizaciones.src='images/menu/organizaciones_R.png';" onmouseout="organizaciones.src='images/menu/organizaciones.png';" /></a>
  <? } else {?>
  <a href="index.php?modo=promotores"><img src="images/menu/promotores.png" width="155" height="75" border="0" name="promotores" onmouseover="promotores.src='images/menu/promotores_R.png';" onmouseout="promotores.src='images/menu/promotores.png';" /></a>
  <? } ?>
</div>
<div id="mercado">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="385" valign="middle">
    <form method="post" action="">
    <select name="mercados" onChange="cambiarMercado(this.form.mercados)" style="background-color:#444; width:380px; height:25px; color:#FFF">
      <option value="0" <? if ($CFG->mercado==0) echo "selected";?>>Plataforma para las artes esc&eacute;nicas y musicales</option>
      <option value="19"<? if ($CFG->mercado==19) echo "selected";?>>Circulart 2011: Segundo Mercado Cultural de Medell&iacute;n</option>
    </select>
    </form>
    </td>
    <td width="80" valign="middle"><img src="images/menu/ingles.gif" width="75" height="25" /></td>
    <td width="235" valign="middle"><img src="images/menu/entrar.jpg" width="225" height="25" /></td>
  </tr>
</table>
</div>
  </div>
	<div id="contenido">
		<div id="lema"> <a href="index.php"><img src="images/menu/inicio.jpg" width="75" height="25" border="0" /></a><img src="images/estructura/lema.jpg" width="485" height="25" /></div>
		<div id="buscar">
		  <form id="motor" name="motor" method="get" action="index.php">
		    <input name="modo" type="hidden" id="modo" value="grupos" />
		    <table width="315" border="0" cellspacing="0" cellpadding="0">
		      <tr>
		        <td><label for="querystring"></label>
	            <input type="text" name="querystring" id="querystring" style="background-color:#CCC; border:0px; width:240px; padding-right:5px; padding-left:5px;" /></td>
		        <td width="70" align="right"><img src="images/estructura/buscar.jpg" alt="" width="70" height="25" onClick="document.motor.submit()"/></td>
	          </tr>
	        </table>
	      </form>
        </div>
        <div id="interna">
		<? 
			if($frm["modo"]=="perfil" || $frm["modo"]=="obras" || $frm["modo"]=="fotografias" || $frm["modo"]=="videos" || $frm["modo"]=="eventos") include("plantillas/artista.php"); 
			else if($frm["modo"]=="quienes" || $frm["modo"]=="preguntas" || $frm["modo"]=="enlaces"  || $frm["modo"]=="2011" ||  $frm["modo"]=="2010"  || $frm["modo"]=="redlat"  || $frm["modo"]=="equipo"  || $frm["modo"]=="contacto" || $frm["modo"]=="reglamento" || $frm["modo"]=="inscripciones" || $frm["modo"]=="curadores") include("plantillas/informacion.php");
			else include("plantillas/".$frm["modo"].".php"); 
			
			if($frm["modo"]=="") include("plantillas/inicio.php"); 
		?>
	</div>
    </div>
	<div id="pie"><img src="images/estructura/pie_<?=$CFG->mercado;?>.jpg" width="900" height="140" /></div>     
</div>
</body>
</html>