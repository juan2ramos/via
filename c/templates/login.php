<?php
$mercado=25;
$CFG->mercado=$mercado;
?>
<div class ="artista">

<?
if (isset($_POST["username"])) {
	$user = verify_login($_POST["username"], $_POST["password"]);

	if ($user) {
		$_SESSION[$CFG->sesion]["user"] = $user;
		$_SESSION[$CFG->sesion]["username"]=$_POST["username"];
		$_SESSION[$CFG->sesion]["pass"]= $_POST["password"];
		$_SESSION[$CFG->sesion]["ip"] = $_SERVER["REMOTE_ADDR"];
		
		if($user["id_nivel"]==10){ 
		
		
		$goto="index.php?act=0&modo=agenda&id_mercado=" . $CFG->mercado."&id_promotor=".$user["id"]."&mercado=".$mercado;
		
		
		
		}else{
			$inMercado = false;
			$tipos = array("danza","musica","teatro");
			foreach($tipos as $area)
			{
				$consulta = "SELECT ma.* 
					FROM mercado_artistas ma
					LEFT JOIN usuarios_grupos_".$area." u ON u.id_grupo_".$area." = ma.id_grupo_".$area."
					WHERE ma.id_mercado=".$CFG->mercado." AND u.id_usuario=".$user["id"];
				$qidInM = $db->sql_query($consulta);
				if($db->sql_numrows($qidInM) > 0) $inMercado = true;
			}
			
			if(!$inMercado)
			{
				echo "Este usuario no est� registrado en el mercado.";
				echo "<script>setTimeout(\"location.href='m/index.php?modo=login&mercado=".$mercado."'\", 3000)</script>";
				die;
			}

			$qGruposDanza=$db->sql_query("SELECT g.* FROM usuarios_grupos_danza ug LEFT JOIN grupos_danza g ON ug.id_grupo_danza = g.id WHERE ug.id_usuario='" . $user["id"] . "'");
			if($grupo=$db->sql_fetchrow($qGruposDanza)){
				$tipo="danza";
			}
			else{
				$qGruposMusica=$db->sql_query("SELECT g.* FROM usuarios_grupos_musica ug LEFT JOIN grupos_musica g ON ug.id_grupo_musica = g.id WHERE ug.id_usuario='" . $user["id"] . "'");
				if($grupo=$db->sql_fetchrow($qGruposMusica)){
					$tipo="musica";
				}
				else{
					$qGruposTeatro=$db->sql_query("SELECT g.* FROM usuarios_grupos_teatro ug LEFT JOIN grupos_teatro g ON ug.id_grupo_teatro = g.id WHERE ug.id_usuario='" . $user["id"] . "'");
					if($grupo=$db->sql_fetchrow($qGruposTeatro)){
						$tipo="teatro";
					}
					else{
						die("Este usuario no tiene ning�n grupo relacionado.");
					}
				}
			}
			$id_grupo=$grupo["id"];
			$_SESSION[$CFG->sesion]["user"]["grupo_id"]=$grupo["id"];
			$_SESSION[$CFG->sesion]["user"]["grupo_tipo"]=$tipo;
			
			$goto="index.php?act=1&modo=agenda&tipo=".$tipo."&id_artista=".$grupo["id"]."&id_mercado=". $CFG->mercado."&mercado=".$mercado;
		}
		echo "<script>\nwindow.location.href=\"" . $goto . "\";\n</script>\n";
		die();
	}
	else {
		$errormsg = "Login inv�lido, por favor intente de nuevo.";
		$frm["username"] = $_POST["username"];
	}
}

if(isset($_SESSION[$CFG->sesion])) unset($_SESSION[$CFG->sesion]);
function verify_login($username, $password) {
	GLOBAL $db,$CFG;
	$pass = md5($password);
	$qid = $db->sql_query("SELECT * FROM usuarios WHERE login = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid)){
		$user["tipo_usuario"]="grupo";
		return($user);
	}

	$qid = $db->sql_query("SELECT p.id,'10' as id_nivel,p.nombre,p.apellido,p.email1 as login,p.password,p.email1 as email 
			FROM mercado_promotores m
			LEFT JOIN promotores p ON p.id=m.id_promotor
			WHERE m.id_mercado='".$CFG->mercado."' AND p.login= '$username' AND p.password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid)){
		$user["tipo_usuario"]="promotor";
		return($user);
	}
	return(FALSE);
}
?>

<style>
#contenedor #contenido .artista {
	float:none;
	
	}
</style>
<table width="916px" border="0" cellspacing="5" cellpadding="5" style="background-color:#E6D7B0">
  <tr>
    <td width="490" valign="top" style="text-align:justify; padding-left:20px"><br />
<br />

    <div style="font-size:28px; color:#3D1211"><strong>Entrada de agendamiento</strong></div>
    <div class="azul">
      <p><span style="color:#3D1211; font-size:18px;">AGENDA ARTISTAS/GRUPOS Y PROFESIONALES</span><br />
        <br />
        <strong>Gracias por agendar con nosotros, en los pr&oacute;ximos d&iacute;as espere un correo con su agenda.</strong></p>
<p>&nbsp;</p>
    </div>
    </td>
    <td width="435" valign="top"><br />
<br />
<? if (isset($errormsg)) echo $errormsg; ?>
	     
<form id="login" name="login" method="post" action="<?=$ME?>?mercado=<?=$mercado?>">
	<input type="hidden" name="modo" value="login" />
	<!--<table width="285" border="0" align="left" cellpadding="5" cellspacing="5" style="margin-left:40px;">
    	<tr>
        	<td width="90" align="right" scope="col">
              <strong style="color:#3D1211">Login</strong>:
            </td>
        	<td width="195" align="right" scope="col"><label><input type="text" name="username" value="<?=nvl($frm["username"])?>" /></label></td>
      </tr>
        <tr>
        	<td align="right" scope="row">
            <strong style="color:#3D1211">Password</strong>:</td>
        	<td align="right"><label><input type="password" name="password" /></label></td>
        </tr>
        <tr>
        	<td scope="row">&nbsp;</td>
            <td align="right"><label><input type="submit" value="Entrar"  style="cursor:pointer"/></label></td>
        </tr>
        
  </table>-->
</form></td>
  </tr>
</table>
</div>