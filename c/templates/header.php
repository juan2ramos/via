<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Circulart <?if(isset($titulo)) echo ":: " . $titulo?></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<?if(isset($_GET["artistas"])){?>
	<link href="estilos_<?=$_GET["artistas"]?>.css" rel="stylesheet" type="text/css" />
<?}?>
<?if(isset($_GET["tipo"])){?>
	<link href="estilos_<?=$_GET["tipo"]?>.css" rel="stylesheet" type="text/css" />
<?}?>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<?
if(simple_me($ME)=="promotores.php") $target="promotores.php";
else $target="grupos.php";
?>

<body>
<div id="contenedor">
  
<div id="cabezote">
<img src="imagenes/cabezote_general.jpg" width="960" height="100" border="0" usemap="#Menu" />
<map name="Menu" id="Menu">
<area shape="rect" coords="0,0,130,100" href="index.php" />
<area shape="rect" coords="608,1,704,18" href="grupos.php?artistas=teatro" />
<area shape="rect" coords="709,-1,801,19" href="grupos.php?artistas=danza" />
<area shape="rect" coords="810,0,897,16" href="grupos.php?artistas=musica" />
<area shape="rect" coords="903,2,950,18" href="eventos.php" />
</map>



    <form id="busqueda" name="busqueda" method="get" action="<?=$target?>">
      
	  <?if(isset($_GET["artistas"])) echo "<input type=\"hidden\" name=\"artistas\" value=\"$_GET[artistas]\" />\n";?>
    <label><input name="querystring" type="text" id="textfield" size="20" />
      </label>
      <label><input type="submit" class="botonBusqueda" id="button" value="Buscar" /></label>
    </form>
    <div id="menu">
	<a href="index.php">Inicio</a> |  
     <a href="quienes.php">Quienes Somos </a> |  
      <a href="enlaces.php">Enlaces </a> |   
      <a href="preguntas.php">Preguntas frecuentes </a> |  
<?
				if(!isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])) echo "<a href=\"login.php\">Entrar</a>";
				else{
					if($_SESSION[$CFG->sesion]["user"]["id_nivel"]==10){//Promotor
						$prom=$_SESSION[$CFG->sesion]["user"];
						//echo "<a href=\"promotores.php?mode=perfil&id=$prom[id]\">$prom[nombre] $prom[apellido]</a> | ";
					}
					elseif(in_array($_SESSION[$CFG->sesion]["user"]["id_nivel"],array(4,5,6,7,8,9))){//Artista
						$art=$_SESSION[$CFG->sesion]["user"];
						//echo "<a href=\"perfil.php?id=$art[grupo_id]&tipo=$art[grupo_tipo]\">$art[nombre] $art[apellido]</a> | ";
					}
					//echo "<a href=\"login.php\">Salir</a>\n";
				}
			?>
  </div>
</div>

