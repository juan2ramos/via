<script language="JavaScript" type="text/javascript">
	function revisar(frm){
		if(frm.nombre.value==""){
			window.alert('Por favor escriba el nombre de su amigo/a');
			return(false);
		}
		if(frm.email.value==""){
			window.alert('Por favor escriba el correo de su amigo/a');
			return(false);
		}
		if(frm.remitente.value==""){
			window.alert('Por favor escriba su nombre');
			return(false);
		}
	}
</script>


<form name="entryform" action="<?=$ME?>" method="post" onSubmit="return revisar(this);">
  <input type="hidden" name="id" value="<?=$frm["id"]?>">
  <input type="hidden" name="tipo" value="<?=$frm["tipo"]?>">
  <input type="hidden" name="mode" value="enviar">
  <table border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td>Para: </td>
      <td><input type="text" name="nombre" /></td>
    </tr>
    <tr>
      <td>Correo: </td>
      <td><input type="text" name="email" /></td>
    </tr>
    <tr>
      <td>De:</td>
      <td><input type="text" name="remitente" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
