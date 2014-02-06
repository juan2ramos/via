    <div id="menu">
<?
	while($tipo=$db->sql_fetchrow($qTipos)){
		echo "<a href=\"circuitos.php?id_tipo=" . $tipo["id"] . "\">" . $tipo["nombre"] . "</a>\n";
	}
?>
    <img src="imagenes/boton_inferior.jpg" width="190" height="15" />
    </div>
