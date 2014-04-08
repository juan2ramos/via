<h1>Entrada de Usuarios</h1>

<? if (isset($errormsg)) {?>
<div align=center><b><?=$errormsg?></b></div>
<? }?>
	     
<form id="login" name="login" method="post" action="<?=$ME?>">
	<table width="285" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td width="90" align="right" scope="col">Login:</td>
        	<td width="195" align="right" scope="col"><label><input type="text" name="username" value="<?=nvl($frm["username"])?>" /></label></td>
        </tr>
        <tr>
        	<td align="right" scope="row">Password:</td>
        	<td align="right"><label><input type="password" name="password" /></label></td>
        </tr>
        <tr>
        	<td scope="row">&nbsp;</td>
            <td align="right"><label><input type="submit" value="Entrar" /></label></td>
        </tr>
     </table>
</form>        