<script>
function revisar(frm){
	document.getElementById('submit_button').value='Enviando informaci�n...';
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
<!-- finde c�digo --> 

		<form name="entryform" action="index.php?modo=inscripciones&mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar(this)">
			<input type="hidden" name="modo" value="<?=$seccion?>" />
			<input type="hidden" name="mode" value="confirmar_inscripcion">
			<input type="hidden" name="id_usuario" value="<?=$frm["id_usuario"]?>">
			<input type="hidden" name="area" value="<?=$frm["area"]?>">
			<input type="hidden" name="login" value="<?=$frm["login"]?>">
			<input type="hidden" name="id_grupo" value="<?=$frm["id_grupo"]?>">
			<h1>Env&iacute;o definitivo de la inscripci&oacute;n</h1>
			
			<p class="margenp">Haga clic en 'Confirmar inscripci�n' para enviar su solicitud. Al hacerlo entiende que NO podr� editar, borrar ni adjuntar m�s la informaci�n de su cuenta y que el jurado recibir� su inscripci�n tal y como usted la ha elaborado hasta este punto. Recibir� un correo electr�nico notific�ndole su inscripci�n definitiva a la Ventana Internacional de las Artes -VIA- del Festival Iberoamericano de teatro de Bogot�</p>
			<label>
			  <input type="submit" id="submit_button" value="Confirmar inscripci�n" />
</label>
			<label>
			  <input type="button" value="Continuar m�s tarde" onClick="window.location.href='index.php?modo=inscripciones&mode=login&mercado=<?=$CFG->mercado?>'" />
</label>
			
