    <div id="menu">
		<?
			while($tipo=$db->sql_fetchrow($qTipos)){
				echo "<a href=\"eventos.php?id_tipo=$tipo[id]\">$tipo[nombre]</a>\n";
			}
		?>
    <img src="<? $CFG->wwwroot ?>/imagenes/boton_inferior.jpg" width="190" height="15" />
    </div>

