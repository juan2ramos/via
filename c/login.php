<?
include("application.php");
if (isset($_POST["username"])) {
	$user = verify_login($_POST["username"], $_POST["password"]);

	if ($user) {
		$_SESSION[$CFG->sesion]["user"] = $user;
		$_SESSION[$CFG->sesion]["ip"] = $_SERVER["REMOTE_ADDR"];
		if($user["id_nivel"]==10) $goto="promotores.php?mode=perfil&id=" . $user["id"];
		else{
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
						die("Este usuario no tiene ningún grupo relacionado.");
					}
				}
			}
			$id_grupo=$grupo["id"];
			$_SESSION[$CFG->sesion]["user"]["grupo_id"]=$grupo["id"];
			$_SESSION[$CFG->sesion]["user"]["grupo_tipo"]=$tipo;
			$goto="perfil.php?id=$id_grupo&tipo=$tipo";
		}
		header("Location: $goto");
		die();
	}
	else {
		$errormsg = "Login inválido, por favor intente de nuevo.";
		$frm["username"] = $_POST["username"];
	}
}
if(isset($_SESSION[$CFG->sesion])) unset($_SESSION[$CFG->sesion]);
include("templates/header.php");
include("templates/login_form.php");



/*	********************	*/
function verify_login($username, $password) {
	GLOBAL $db;

	$pass = md5($password);
//Verificar si es usuario de sucursal:

	$username = $db->sql_escape($username);

	$qid = $db->sql_query("SELECT * FROM usuarios WHERE login = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid)){
		$user["tipo_usuario"]="grupo";
		return($user);
	}
	$qid = $db->sql_query("SELECT id,'10' as id_nivel,nombre,apellido,email1 as login,password,email1 as email FROM promotores WHERE email1 = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid)){
		$user["tipo_usuario"]="promotor";
		return($user);
	}
	return(FALSE);
}

include("templates/footer.php"); //templates/footer.php

?>


