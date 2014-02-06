<?php
/***************************************************************************
 *                                 mysql.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if(!defined("SQL_LAYER"))
{

define("SQL_LAYER","mysql");

//if(!defined("END_TRANSACTION"))
//	define("END_TRANSACTION","END_TRANSACTION");
//if(!defined("BEGIN_TRANSACTION"))	define("BEGIN_TRANSACTION",1);
//if(!defined("END_TRANSACTION"))	define("END_TRANSACTION",0);


class sql_db
{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;
	var $error="";
	var $debug = 1;
	var $logDebug= 0;
	var $logFile="";
	var $logLevel=1;
	var $instantiationFile="";
	var $instantiationLine="";
	var $CFG;

	//
	// Constructor
	//
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = false)
	{

		GLOBAL $CFG;
		$this->CFG=$CFG;

		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		if($this->persistency)
		{
			$this->db_connect_id = mysql_pconnect($this->server, $this->user, $this->password);
		}
		else
		{
			$this->db_connect_id = mysql_connect($this->server, $this->user, $this->password);
		}
		if($this->db_connect_id)
		{
			if($database != "")
			{
				$this->dbname = $database;
				$dbselect = mysql_select_db($this->dbname);
				if(!$dbselect)
				{
					mysql_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}
			return $this->db_connect_id;
		}
		else
		{
			return false;
		}
	}

	//
	// Other base methods
	//
	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				mysql_free_result($this->query_result);
			}
			$result = mysql_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	function sql_row($query){
		if($qid=$this->sql_query($query)){
			return($this->sql_fetchrow($qid));
		}
		return(FALSE);
	}

	function sql_field($query){
		if($result=$this->sql_row($query)){
			return($result[0]);
		}
		return(FALSE);
	}
	//
	// Base query method
	//
	function sql_query($query = "", $transaction = FALSE)
	{
//		echo $query."<br>";
		// Remove any pre-existing queries
		if($this->logDebug && $this->logDebug==1){
			if($this->logFile==""){
				echo "Error:<br>\n";
				echo "La opción logDebug de la base de datos está activada, pero no se específicó el archivo del log.<br>\n";
				echo "Por favor escriba una instrucción similar a ésta:<br>\n";
				echo "\$db->logFile=\"/path/del/archivo/log\";<br>\n";
				echo "En " . $this->instantiationFile . " (" . $this->instantiationLine . ").";
				die();
			}
			if((file_exists($this->logFile) && !is_writable($this->logFile)) || (!file_exists($this->logFile) && !is_writable(dirname($this->logFile))) ){
				echo "Error:<br>\n";
				echo "La opción logDebug de la base de datos está activada, pero el archivo logFile especificado (" . $this->logFile . ") no tiene los permisos suficientes.<br>\n";
				die();
			}
		}
		unset($this->query_result);

		$inicio=microtime();
		$ar=explode(" ",$inicio);
		$inicio=$ar[0]+$ar[1];

		if($query != "")
		{
			$this->num_queries++;
			$this->query_result = mysql_query($query, $this->db_connect_id);
		}

		$fin=microtime();
		$ar=explode(" ",$fin);
		$fin=$ar[0]+$ar[1];
		$diferencia=$fin-$inicio;
		$minutos=floor($diferencia/60);
		$segundos=$diferencia%60;
		$microsegundos=$diferencia-floor($diferencia);
		$segundos=$segundos+$microsegundos;
		$segundos=number_format($segundos,10);
		$segundos=str_pad($segundos,13,"0",STR_PAD_LEFT);
		$minutos=str_pad($minutos,2,"0",STR_PAD_LEFT);

		if($this->logDebug){
			$trQuery=trim($query);
			$trQuery=preg_replace("/[ \t\r\n]+/"," ",$trQuery);
			if($this->logLevel>1 || preg_match("/^(update|delete|insert)/i",$trQuery)){
				if(isset($_SESSION[$this->CFG->sesion]["user"]["login"])) $usuario=$_SESSION[$this->CFG->sesion]["user"]["login"];
				else $usuario="UNKNOWN";
				$flog=fopen($this->logFile,"a+");
				$file=xdebug_call_file();
				$line=xdebug_call_line();
				if($file==__FILE__){
					$arrayStack=xdebug_get_function_stack();
					$file=$arrayStack[sizeof($arrayStack)-2]["file"];
					$line=$arrayStack[sizeof($arrayStack)-2]["line"];
				}
				$file=preg_replace("/".preg_quote($this->CFG->dirroot . "/","/")."/","",$file);
				$requesturi=$_SERVER["REQUEST_URI"];
				$requesturi=preg_replace("/".preg_quote($this->CFG->wwwroot . "/","/")."/","",$requesturi);
				$method="GET";
				if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST"){
					$method="POST";
					$arrQuery=array();
					if(isset($_POST["id"])) array_push($arrQuery,"id=" . $_POST["id"]);
					if(isset($_POST["mode"])) array_push($arrQuery,"mode=" . $_POST["mode"]);
					if(isset($_POST["module"])) array_push($arrQuery,"module=" . $_POST["module"]);
					if(sizeof($arrQuery)!=0) $requesturi.="?" . implode("&",$arrQuery);
				}
				$remote_address="CLI";
				if(isset($_SERVER["REMOTE_ADDR"])) $remote_address=$_SERVER["REMOTE_ADDR"];
				fwrite($flog,date("Y-m-d H:i:s") . "\t" . $minutos . ":" . $segundos . "\t" . $usuario . "\t" . $remote_address . "\t" . $method . "\t" . $requesturi . "\t" . $file . "(" . $line . ")" . "\t" . $trQuery ."\n");
				fclose($flog);
			}
		}
			

//		echo $this->query_result;
		if($this->query_result)
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			return $this->query_result;
		}
		else
		{
/* por lo de los jáquers
			$this->error="<h2>No se puede ejecutar la consulta:</h2>";
			$this->error.="<pre>" . htmlspecialchars($query) . "</pre>";
			$this->error.="<p><b>Error mySQL</b>: ". mysql_error();
*/
			$this->error="No se puede ejecutar la consulta:\n$query\n". mysql_error();
			$errlines = explode("\n",$this->error);
			foreach ($errlines as $txt) { error_log($txt); }

//			error_log($this->error);
			mysql_close($this->db_connect_id);
			die();

			return ( $transaction == END_TRANSACTION ) ? true : false;
		}
	}

	//
	// Other query methods
	//
	function sql_escape($string){
		return(mysql_real_escape_string($string));
	}
	
	function sql_numrows($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysql_num_rows($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_affectedrows()
	{
		if($this->db_connect_id)
		{
			$result = mysql_affected_rows($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysql_num_fields($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysql_field_name($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysql_field_type($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrow($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
//			$this->row[$query_id] = mysql_fetch_array($query_id);
//			return $this->row[$query_id];
			return(mysql_fetch_array($query_id));
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrowset($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);
			while($this->rowset[$query_id] = mysql_fetch_array($query_id))
			{
				$result[] = $this->rowset[$query_id];
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if($rownum > -1)
			{
				$result = mysql_result($query_id, $rownum, $field);
			}
			else
			{
				if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))
				{
					if($this->sql_fetchrow())
					{
						$result = $this->row[$query_id][$field];
					}
				}
				else
				{
					if($this->rowset[$query_id])
					{
						$result = $this->rowset[$query_id][$field];
					}
					else if($this->row[$query_id])
					{
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysql_data_seek($query_id, $rownum);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_nextid(){
		if($this->db_connect_id)
		{
			$result = mysql_insert_id($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}

		if ( $query_id )
		{
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			mysql_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}
	}
	function sql_error($query_id = 0)
	{
		$result["message"] = mysql_error($this->db_connect_id);
		$result["code"] = mysql_errno($this->db_connect_id);

		return $result;
	}


	function sql_query_loop($query, $prefix, $suffix, $found_str, $default="") {
		/* ésta es una función interna, y normalmente no es llamada por el usuario.
		 * itera por los resultados de una consulta $query seleccionada e imprime HTML
		 * a su alrededor, para usarse en cosas como listboxes y selecciones radio
		 */
		$output = "";
		$result = $this->sql_query($query);
		while($result=$this->sql_fetchrow()){
			list($val, $label) = $result;
			if (is_array($default))
				$selected = empty($default[$val]) ? "" : $found_str;
			else
				$selected = $val == $default ? $found_str : "";
			$output .= "$prefix value='$val' $selected>$label$suffix";
		}
		return $output;
	}

	function sql_listbox($query, $select="", $default="", $suffix="\n") {
		/* genera los elementos <option> para la parte <select> de un listbox, basado en los
		 * resultados de una consulta SELECT ($query).  cualquier resultado que cumpla $default
		 * son preseleccionados, $default puede ser una cadena o un arreglo en el caso de
		 * listboxes de selección múltiple.  $suffix se imprime al final de cada instrucción <option>
		 * y normalmente es un salto de línea */

		$string="";
		if($select!="") $string="<option value='%'>" . $select . $suffix;
		return $string . $this->sql_query_loop($query, "<option", $suffix, "selected", $default);
	}

	function build_recursive_tree($table, &$output, $preselected, $parentIdField="id", $field="id_superior", $label="nombre", $id=-1,$indent="-", $condicionQuery="true") {
		/* recorre recursivamente las categorías */

		if($id==-1) $condicion="IS NULL";
		else $condicion="='$id'";
		$strQuery="SELECT $parentIdField, $label FROM $table WHERE $field $condicion AND $condicionQuery ORDER BY $label";
		$qid = $this->sql_query($strQuery);
		while ($result =  $this->sql_fetchrow($qid)) {
			if ($result[0] == $preselected) $selected = "selected";
			else $selected = "";
			if ($result[0] =="") {$tab="";} else {$tab=$indent;};
			$output .= "<option value=\"" . $result[0] . "\" $selected>$tab" . $result[1] . "\n";
			if ($result[0] != $id) $this->build_recursive_tree($table, $output, $preselected, $parentIdField="id", $field, $label, $result[0], $tab."-&nbsp;", $condicionQuery);
		}
	}

	function sql_update($tabla, $frm, $pk="id"){
		$id=$frm[$pk];
		$qid=$this->sql_query("SHOW COLUMNS FROM $tabla");
		$arrayFieldsDB=array();
		$arrayFieldsFrm=array_keys($frm);
		while($fila=$this->sql_fetchrow($qid)){
			$field=$fila["Field"];
			if($field!=$pk && in_array($field,$arrayFieldsFrm)){
				if($frm[$field]=="" || $frm[$field]=="NULL") array_push($arrayFieldsDB,$field . "=NULL");
				else array_push($arrayFieldsDB,$field . "='" . mysql_real_escape_string($frm[$field]) . "'");
			}
		}
		$strSql="UPDATE $tabla SET " . implode(",",$arrayFieldsDB) . " WHERE $pk='$id'";
		$this->sql_query($strSql);
	}

	function sql_insert($tabla, $frm){
		$qid=$this->sql_query("SHOW COLUMNS FROM $tabla");
		$arrayFieldsDB=array();
		$arrayValuesDB=array();
		$arrayFieldsFrm=array_keys($frm);
		while($fila=$this->sql_fetchRow($qid)){
			$field=$fila["Field"];
			if(in_array($field,$arrayFieldsFrm)){
				array_push($arrayFieldsDB,"`" . $field . "`");
			 	if($frm[$field]=="" || $frm[$field]=="NULL") array_push($arrayValuesDB,"NULL");
				else array_push($arrayValuesDB,"'" . mysql_real_escape_string($frm[$field]) . "'");
			}
		}
		$strSql="INSERT INTO $tabla (" . implode(",",$arrayFieldsDB) . ") \nVALUES (" . implode(",",$arrayValuesDB) . ")";
		$this->sql_query($strSql);
		return($this->sql_nextid());
	}



	
} // class sql_db

} // if ... define

?>
