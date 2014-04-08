<script>
function revisar(frm){
	document.getElementById('submit_button').value='Enviando información...';
	document.getElementById('submit_button').disabled=true;
	return(true);
}
</script>

<!-- este codigo es para VIA 2012 --->
	<? if ($CFG->mercado==21){?>
		<style>
			#contenedor #contenido .artista h1 {
				background-color:#fff;
				padding:5px;
				font-weight:normal;
				margin:0px;
				font-size:14pt;
			}
			.azul{
				background-color:#0066FF;
				color:#FFF;
				font-size:20px;
				padding:5px;}
			.margenp{
				margin-left:10px;
				font-size:12px;
				
				}	
        </style>
 <? }?>  
<!-- finde código --> 

		<form name="entryform" action="index.php?modo=inscripciones&mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			<input type="hidden" name="modo" value="<?=$seccion?>" />
			<input type="hidden" name="mode" value="confirmar_inscripcion">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
			<h1>Env&iacute;o definitivo de la inscripci&oacute;n</h1>
			
			<p class="margenp">Haga clic en 'Confirmar inscripción' para enviar su solicitud. Al hacerlo entiende que NO podrá editar, borrar ni adjuntar más la información de su cuenta y que el jurado recibirá su inscripción tal y como usted la ha elaborado hasta este punto. Recibirá un correo electrónico notificándole su inscripción definitiva a la Ventana Internacional de las Artes -VIA- del Festival Iberoamericano de teatro de Bogotá</p>
			<label>
			  <input type="submit" id="submit_button" value="Confirmar inscripción" />
</label>
			<label>
			  <input type="button" value="Continuar más tarde" onClick="window.location.href='index.php?modo=inscripciones&mode=login&mercado=<?=$CFG->mercado?>'" />
</label>
			
