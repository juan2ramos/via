<?
	function is_logged() {

		global $CFG;
		return isset($_SESSION[$CFG->sesion_admin])
			&& isset($_SESSION[$CFG->sesion_admin]["user"])
			&& isset($_SESSION[$CFG->sesion_admin]["nivel"])
			&& $_SESSION[$CFG->sesion_admin]["nivel"] == "admin"
			&& isset($_SESSION[$CFG->sesion_admin]["ip"])
			&& $_SESSION[$CFG->sesion_admin]["ip"] == $_SERVER["REMOTE_ADDR"];
	}

?>
