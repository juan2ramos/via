<script>
function revisar(frm){
	if(frm.login.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: usuario');
		frm.login.focus();
		return(false);
	}
	if(frm.password.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: password');
		frm.password.focus();
		return(false);
	}
	return(true);
}
</script>
<!--<form name="entryform" action="index.php?mercado=<?=$CFG->mercado?>" method="post" enctype="multipart/form-data" onSubmit="return revisar(this)">-->

 </br>
 </br>    
 <table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="#E7D8B1" >
   <tr>
     <td><form  style=" " name="entryform" action="index.php?modo=curadores&mode=listar_grupos&mercado=0" method="post" enctype="multipart/form-data" onSubmit="return revisar(this)">
<input type="hidden" name="modo" value="<?=$seccion?>" />
<input type="hidden" name="mode" value="<?=$newMode?>" /><br />
<br />
	
<p align="center" style="font-size:18px; font-weight:bold">Éste es el acceso para los curadores.  Desde aquí se realiza la evaluación a los grupos.</p>
<?if(isset($frm["error"])) echo "<h2 style=\"margin-left:100px;\"><font color=\"#FF0000\">Error: $frm[error]</font></h2>"?>
        <table  width="500" border="0" align="center" cellpadding="5" cellspacing="5">
          <tr>
            <td width="160" ><strong>(*) Usuario (login):</strong></td>
            <td width="305"><label>
              <input type="text" name="login" id="login" value="<?=nvl($frm["login"])?>" />
            </label></td>
          </tr>
          <tr>
            <td ><strong>(*) Contrase&ntilde;a:</strong></td>
            <td><label><input type="password" name="password" id="password" /></label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><label><input type="submit" id="button" value="Acceso" /></label></td>
          </tr>
        </table>
        <br />
     </form></td>
   </tr>
 </table>
