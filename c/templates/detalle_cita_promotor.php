<br />
<h2><?=$promotor?></h2>
<?if(nvl($result["mesa_promotor"])!="" && nvl($result["mesa_promotor"])!=" - ") echo "<h3>Mesa: $result[mesa_promotor]</h3>";?>
<h1>Detalle cita # <?=$numero_de_cita?> </h1>
<h3>Estado: <?=$estado?> </h3>
<h3>Fecha: <?=$fecha?> </h3>
<h3>Hora: <?=$hora?> </h3>
<h3>Artista: <?=$artista?> </h3>
<?if(nvl($result["mesa_artista"])!="" && nvl($result["mesa_artista"])!=" - ") echo "<h3>Mesa: $result[mesa_artista]</h3>";?>
<?=$img?>
<table width="100%" border="1">
	<tr><th colspan="2">Evaluación</th></tr>
	<tr><td align="right"><b>Asistencia:</b></td><td> Sí <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>¿Entrega de Material de Apoyo?:</b></td><td> Sí <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>¿Consideraría contratar a este grupo?:</b></td><td> Sí <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>¿Por qué?:</b></td><td><textarea cols="50" rows="5"></textarea></td></tr>
	<tr><td align="right"><b>¿Le gustaría recibir información via e-mail de este grupo?:</b></td><td> Sí <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>Comentarios:</b></td><td><textarea cols="50" rows="5"></textarea></td></tr>
</table>
 
<script>
	window.print();
</script>
