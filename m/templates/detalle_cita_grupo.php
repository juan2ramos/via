<br />
<h2><?=$artista?></h2>
<?if(nvl($result["mesa_artista"])!="" && nvl($result["mesa_artista"])!=" - ") echo "<h3>Mesa: $result[mesa_artista]</h3>";?>
<h1>Detalle cita # <?=$numero_de_cita?> </h1>
<h3>Estado: <?=$estado?> </h3>
<h3>Fecha: <?=$fecha?> </h3>
<h3>Hora: <?=$hora?> </h3>
<h3>Promotor: <?=$promotor?> </h3>
<?if(nvl($result["mesa_promotor"])!="" && nvl($result["mesa_promotor"])!=" - ") echo "<h3>Mesa: $result[mesa_promotor]</h3>";?>

<table width="100%" border="1">
	<tr><th colspan="2">Evaluaci�n</th></tr>
	<tr><td align="right"><b>Asistencia:</b></td><td> S� <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>�Entrega de Material de Apoyo?:</b></td><td> S� <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>�Fue pertinente el encuentro?:</b></td><td> S� <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>�Le gustar�a recibir informaci�n via e-mail de este promotor?:</b></td><td> S� <input type="checkbox">&nbsp;&nbsp;&nbsp;No <input type="checkbox"></td></tr>
	<tr><td align="right"><b>Comentarios:</b></td><td><textarea cols="50" rows="5"></textarea></td></tr>
</table>
 
<script>
	window.print();
</script>
