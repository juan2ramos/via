  <img src="<? $CFG->wwwroot ?>/imagenes/texto_superior.jpg" />
  <div id="contenido">
		<? //include("../templates/menu_promotores.php");?>
        <div id="menu">
        <a href="#">M&uacute;sica</a>
         <img src="<? $CFG->wwwroot ?>/imagenes/boton_inferior.jpg" width="190" height="15" />
</div>
        <div id="texto">
<?
	while($promotor=$db->sql_fetchrow($qPromotor)){
?>
      <div id="alineacion">
        <h1><?=$promotor["nombre"] . " " . $promotor["apellido"]?></h1>
        <em><?=$promotor["cargo"]?></em>
        <p><?=nl2br($promotor["resena"])?></p>
		<a href="promotores.php?id=<?=$promotor["id"]?>">&gt;&gt;más información</a>
      </div>
<?}?>
    <img src="<? $CFG->wwwroot ?>/imagenes/texto_inferior.jpg" width="810" height="10" /></div>
  </div>

 
