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
        <p><strong>Correo:</strong> <a href="mailto:<?=$promotor["email1"]?>"> <?=$promotor["email1"]?></a><strong><br />
  					Website:</strong><a href="http://<?=$promotor["web"]?>"> <?=$promotor["web"]?></a><br />
					<strong>Ciudad:</strong> <?=$promotor["ciudad"]?>.<br />
 					<strong>País:</strong> <?=$promotor["pais"]?>.<br />
         	<strong>Áreas de interés:</strong> <?=$promotor["areas"]?>.<br />
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
    <img src="<? $CFG->wwwroot ?>/imagenes/texto_inferior.jpg" width="810" height="10" /></div>
  </div>

