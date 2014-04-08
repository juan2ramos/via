<p><img src="<? $CFG->wwwroot ?>/imagenes/titulo_evaluacion.jpg" width="550" height="21" /></p>
<form name="entryform" action="<?=$ME?>" method="post">
<input type="hidden" name="mode" value="update_encuesta_promotor">
<table width="550" border="0" cellpadding="5" cellspacing="5">
	<tr><th scope="col">¿Cuántas citas exitosas tuvo?</th></tr>
	<tr><td height="36" scope="row"><label><input name="num_citas_exitosas" type="text" size="5" value="<?=nvl($encuesta["num_citas_exitosas"])?>" /></label></td></tr>
	<tr><th height="36" scope="row">¿Cuántas citas le fueron canceladas o incumplidas? </th></tr>
	<tr><td height="36" scope="row"><input name="num_citas_incumplidas" type="text" size="5" value="<?=nvl($encuesta["num_citas_incumplidas"])?>" /></td></tr>
	<tr><th height="36" scope="row">¿Por qué razones le fueron canceladas o incumplidas sus citas?</th></tr>
	<tr><td height="36" scope="row"><textarea name="razones_incumplimiento" cols="50" rows="4"><?=nvl($encuesta["razones_incumplimiento"])?></textarea></td></tr>
	<tr><th height="36" scope="row">¿Cuántos grupos consideraría contratar?</th></tr>
	<tr><td height="36" scope="row"><input name="num_grupos_contratar" type="text" size="5" value="<?=nvl($encuesta["num_grupos_contratar"])?>" /></td></tr>
	<tr><th height="36" scope="row">¿Cómo juzga, en general, la calidad de los productos presentados?</th></tr>
	<tr><td height="36" scope="row"><textarea name="calidad_productos" cols="50" rows="4"><?=nvl($encuesta["calidad_productos"])?></textarea></td></tr>
	<tr><th height="36" scope="row">¿Participaría en otros eventos similares a este?</th></tr>
	<tr><td height="36" scope="row"><label>
		<select name="eventos_similares">
			<option value="1"<?if(nvl($encuesta["eventos_similares"])=="1") echo " SELECTED"?>>Si</option><option value="0"<?if(nvl($encuesta["eventos_similares"])=="0") echo " SELECTED"?>>No</option>
		</select>
	</label></td></tr>
	<tr><th height="36" scope="row">¿Por qué?</th></tr>
	<tr><td height="36" scope="row"><textarea name="es_por_que" cols="50" rows="4"><?=nvl($encuesta["es_por_que"])?></textarea></td></tr>
	<tr><th height="36" scope="row">Comentarios</th></tr>
	<tr><td height="36" scope="row"><textarea name="comentarios" cols="50" rows="4"><?=nvl($encuesta["comentarios"])?></textarea></td></tr>
	<tr><th height="36" scope="row">Recomendaciones o sugerencias</th></tr>
	<tr><td height="36" scope="row"><textarea name="recomendaciones" cols="50" rows="4"><?=nvl($encuesta["recomendaciones"])?></textarea></td></tr>
	<tr><td><input type="submit" value="Enviar"></td></tr>
</table>
</form>

