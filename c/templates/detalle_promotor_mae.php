  <img src="<? $CFG->wwwroot ?>/imagenes/texto_superior.jpg" />
  <div id="contenido">
		<? include("../templates/menu_promotores.php");?>
    <div id="texto">
<?
	while($promotor=$db->sql_fetchrow($qPromotor)){
?>
      <div id="alineacion">
        <h1><?=$promotor["nombre"] . " " . $promotor["apellido"]?></h1>
        <em><?=$promotor["cargo"]?></em>
        <p><strong>Pa&iacute;s:</strong><a href="http://<?=$promotor["web"]?>">
        <?=$promotor["pais"]?>
        <br />
        </a><strong>Website:</strong><a href="http://<?=$promotor["web"]?>"> <?=$promotor["web"]?></a><br />
          <strong>�reas de inter�s:</strong> <?=$promotor["areas"]?>.<br />
          <strong>Actividades</strong>: <?=$promotor["actividades"]?>.</p>
        <p><?=nl2br($promotor["resena"])?></p>
        <p>&nbsp;</p>
				<?
				if(isset($_SESSION[$CFG->sesion]["user"]["id_nivel"]) && $_SESSION[$CFG->sesion]["user"]["id_nivel"]==10 && $_SESSION[$CFG->sesion]["user"]["id"]==$promotor["id"]){
					echo "<input type=\"button\" value=\"Editar mi perfil\" onClick=\"window.location.href='promotores.php?mode=edit&id=$promotor[id]'\">";
				}
				?>
      </div>
<?}?>
    <img src="<? $CFG->wwwroot ?>/imagenes/texto_inferior.jpg" width="815" height="10" /></div>
  </div>

