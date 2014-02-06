<script>

function cambiaColor(){
	window.document.documentElement.scrollTop;
	}

</script>
<?
	$db->sql_rowseek(0,$qImagenes);
	echo "<div id='gallery' style='margin-bottom:400px'><ul>";
	while($imagen = $db->sql_fetchrow($qImagenes)){
		echo "<li><a href='" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=" . $imagen["tabla"] . "&field=archivo&id=" . $imagen["id"]) . "&h=700' onclick=\"cambiaColor()\" >";
		echo "<img border=\"0\" src=\"" . $CFG->wwwroot . "/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=" . $imagen["tabla"] . "&field=archivo&id=" . $imagen["id"]) . "&amp;h=90\" border=\"0\" />";
		echo "</a></li>";
	}
	echo "</ul></div>";
?>
