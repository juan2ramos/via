<br />
<h2><?=$promotor2["nombre"] . " " . $promotor2["apellido"]?></h2>
<h1>Detalle cita # <?=$frm["id_cita"]?> </h1>
<h3>Estado: <?=$estado?> </h3>
<h3>Rueda: <?=$result["rueda"]?> </h3>
<h3>Lugar: <?=$result["lugar"]?> </h3>
<h3>Fecha: <?=$fecha?> </h3>
<h3>Hora: <?=$hora?> </h3>
<h3>Promotor: <?=$promotor["nombre"] . " " . $promotor["apellido"]?> </h3>

<script>
	window.print();
</script>
