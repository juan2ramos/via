  <img src="<? $CFG->wwwroot ?>/imagenes/texto_superior.jpg" />
  <div id="contenido">
		<? include("templates/menu_promotores.php");?>
    <div id="texto">
<?
	while($promotor=$db->sql_fetchrow($qPromotor)){
?>
      <div id="alineacion">
        <h1><?=$promotor["nombre"] . " " . $promotor["apellido"]?></h1>
        <em><?=$promotor["cargo"]?></em>
        <p><strong>Correo:</strong> <a href="mailto:<?=$promotor["email1"]?>"> <?=$promotor["email1"]?></a><strong><br />
  Website:</strong><a href="http://<?=$promotor["web"]?>"> <?=$promotor["web"]?></a><br />
          <strong>Áreas de interés:</strong> <?=$promotor["areas"]?>.<br />
          <strong>Actividades</strong>: <?=$promotor["actividades"]?>.</p>
        <p><?=nl2br($promotor["resena"])?></p>
        <p>&nbsp;</p>
      </div>
<?}?>
    <img src="<? $CFG->wwwroot ?>/imagenes/texto_inferior.jpg" width="815" height="10" /></div>
  </div>

