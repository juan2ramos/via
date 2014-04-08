<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="height: 100%">
<head>
<title><?=$CFG->siteTitle?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF" style="margin: 0; height: 100%">
<table align="center" border="0" cellspacing="1" cellpadding="5" width="100%" style="height: 100%">
	<tr>
		<td height="90%" align="center" valign="middle">
			<form name="entryform" method="post" action="login.php">
			<input type="hidden" name="goto" value="<?=nvl($frm["goto"])?>" />
			<table align="center" border="0" cellspacing="1" cellpadding="5" width="100%" style="height: 100%">
				<tr>
					<td height="30" width="100%" align=center valign=middle>
						<table align="center" border="0" class="tabla_externa">
							<tr>
								<td height="104" align="center" colspan=2>
									<IMG BORDER="0" ALT="<?=$CFG->siteTitle?>" SRC="<?=$CFG->siteLogo?>"/>
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle"  width="60%">
									<p>&nbsp;</p>
									<? if (! empty($errormsg)) { ?>
										<div align=center><b><?=nvl($errormsg) ?></b></div>
									<?}?>
									<table width="214" border="0" align="center" cellpadding="0" cellspacing="1" style="height: 50">
											<tr>
												<th width="98" align="right" >Usuario :&nbsp;</th>
												<td width="113" align="center" valign="middle"><input value="<?=nvl($frm["username"]) ?>" type="text" name="username" size="16" /></td>
											</tr>
											<tr>
												<th align="right">Clave :&nbsp;</th>
												<td align="center" valign="middle"><input type=password name="password" size="16" /></td>
											</tr>
											<tr> 
												<td align="center" valign="middle" colspan="2"><br/><input type="submit" name="Submit" value="entrar" /></td>
											</tr>
									</table>
								</td>
								<td>
                                <? if ($CFG->mercado!=20){?>
									<table border="0" cellspacing="1" cellpadding="0" style="height: 50" align="center">
										<tr>
											<td align="center" valign="middle">
												Teniendo un usuario, usted <br>puede entrar los datos de su grupo.<br><br>
												<a href="javascript:abrir()"><font color="red">Registrarse</font></a>
												
											</td>

									</table>
                                <? }?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td width="100%" height="60" <? if ($CFG->mercado!=20){?>bgcolor="#cbe1f8">
        
			<table align="center" border="0" cellspacing="1" cellpadding="1" width="100%">
				<tr>
					<td align="right" valign="middle" width="50">
					</td>
					<td align="left" valign="middle" width="30">
					</td>
					<td align="center">
						<a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=200139&amp;t=210"><img border="0" alt="Firefox 2" title="Firefox 2" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox2/firefox-spread-btn-1b.png"/></a>
					</td>
					<td align="right" valign="top" width="100">
						<A HREF="http://www.postgresql.net/"><IMG BORDER="0" ALT="PostgreSQL Powered" SRC="<?=$CFG->imagedir?>/postgresql_powered.gif"/></A>
						<A HREF="http://php.net/"><IMG BORDER="0" ALT="PHP Powered" SRC="<?=$CFG->imagedir?>/php-power-micro2.png"/></A>
						<A HREF="http://www.apache.org/"><IMG BORDER="0" ALT="Apache Powered" SRC="<?=$CFG->imagedir?>/apache_powered.gif"/></A>
					</td>
				</tr>
			</table>
       <? }else{?>  
       >
          <? }?>     
		</td>
	</tr>
</table>
<!--ACA VA EL PIE DEL DISEÑO-->
<script type="text/javascript">
	document.entryform.username.focus();
</script>

<script>
function abrir()
{
	ruta='<?=$CFG->wwwroot?>/registro_grupo.php';
	ventana = 'registro';
	window.open(ruta,ventana,'scrollbars=yes,width=600,height=350,screenX=100,screenY=100,scrollbar=yes');
}
</script>

</body>
</html>

