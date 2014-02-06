<?
require_once(dirname(__FILE__) . "/attribute.php");
require_once(dirname(__FILE__) . "/link.php");
require_once(dirname(__FILE__) . "/relation.php");
require_once(dirname(__FILE__) . "/button.php");

	class entity{
		var $CFG;
		var $database="";
		var $table="";
		var $name="";
		var $labelModule="";
		var $mode="";
		var $tableParent; 
		var $idParent;
		var $fieldTitleTable;
		var $strSQL;
		var $where;
		var $strSQLCompleta;
		var $editable=TRUE;
		var $rowColor="#000000";					//Color de fondo de las filas
		var $rowColor1="";					//Color de fondo alterno de las filas
		var $pageBgColor="#000000";				//Color de fondo de la página
		var $darkBgColor="#000000";				//Color oscuro de la página
		var $lightBgColor="#000000";			//Color claro de la página
		var $maxRows=20;
		var $currentPage=1;
		var $numRows;
		var $sqlQid=FALSE;
		var $iframe=FALSE;
		var $iframeHeight=250;
		var $previousPage="";
		var $nextPage="";
		var $primaryKey="id";
		var $id;
		var $leftButton;
		var $rightButton;
		var $totalPages=1;
		var $longFormat="TRUE";						//Para ver si los listados van completos o parciales...
		var $newMode;
		var $errorString;
		var $iconsPath="";								//El path para los íconos
		var $db;
		var $db2;
		var $attributes=array();
		var $relationships=array();
		var $links=array();
		var $buttons=array();
		var $formColumns = 1;							//Cantidad de columnas en el formulario de captura
		var $popupsSelect=0;
		var $selectDependiente = 0 ;
		var $upButton="asc_order.gif";
    var $downButton="desc_order.gif";
		var $orderBy="";
    var $orderByMode="";

		var $JSComplementaryRevision="";	//Revisiones adicionales de javascript para validar en el formulario de captura.
		var $needsAutoComplete=FALSE;
		var $ACURL="http://yui.yahooapis.com/2.6.0/build";
		var $needsGLocation=FALSE;
		var $needsACPopup=FALSE;//Si necesita que algún AutoComplete tenga popup
	//	ESTILOS / DECORACIÓN:
		var $fieldLabelClass=""; //La clase de la celda donde va la etiqueta en los formularios
		var $cellInputClass=""; //La clase de la celda donde va el input en los formularios
		var $textInputClass=""; //La clase de los inputs de tipo texto
		var $selectInputClass=""; //La clase de los inputs de tipo select

		var $classTH="title";	//El estilo del título de la tabla en el listado
		var $classTD="label";	//El estilo del contenido de la tabla en el listado
		var $HLRows=TRUE;
		var $bgColorFieldValue="";//El color del fondo de la celda donde va el input en los formularios
		var $bgColorLabelFieldValue="";//El color del fondo de la celda donde va la etiqueta en los formularios
		var $bgColorIFrame="";
		var $altoImagen = "";

// Atributos para almacenar el armado de la consulta.
		var $ar_condiciones=array();
		var $ar_fields=array();
		var $ar_tables=array();

		var $hiddenQuery="";

/*	*******************************************************	*/
/*	Para hacer el log de actividades en el nivel del objeto	*/
/*	*******************************************************	*/
		var $log=FALSE;

/*	***************************************	*/
/*	Para configurar botones en los listados	*/
/*	***************************************	*/
		var $btnAdd=TRUE;
		var $btnEdit=TRUE;
		var $btnDelete=TRUE;
		var $btnDetails=TRUE;
		var $btnSearch=TRUE;
		var $btnDownload=TRUE;

// Para el módulo WYSIWYG html ckeditor
		var $needsWYSIWYG=FALSE;

// Condición adicional en el WHERE
		var $filter=NULL;

/*	****************	*/
/*		CONSTRUCTOR 		*/
/*	****************	*/
		function entity($id=NULL, $primaryKey="id"){
			GLOBAL $CFG,$ME;
			$CFG->ME=$ME;
			$this->CFG=$CFG;
			if(isset($CFG->dbname))	$this->database=$CFG->dbname;
			else $this->database=$CFG->dbname_postgres;

			if(isset($CFG->segundadb)) $this->database2=$CFG->segundadb;

			$this->primaryKey=$primaryKey;
			if($id == NULL){	//Es genérica
				$atributo=new attribute($this);
				$atributo->set("field",$this->primaryKey);
				$atributo->set("sqlType","SERIAL");
				$atributo->set("visible",FALSE);
				$atributo->set("primaryKey",TRUE);
				$atributo->set("searchable",FALSE);
				$atributo->set("mandatory",TRUE);
				$this->addAttribute($atributo);
			}
		}

		function dropTable(){
			if(!$this->tableExists()) return;
			$strSQL="DROP TABLE " . $this->get("table");;
			$this->db->sql_query($strSQL);
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("sqlType")=="geometry"){
					$table=$this->get("table");
					if(preg_match("/(.*)\.(.*)/",$table,$matches)){
						$schema=$matches[1];
						$table=$matches[2];
					}
					else $schema="public";
					$strSQL="
						DELETE FROM geometry_columns 
						WHERE f_table_schema='" . $schema . "'
						AND f_table_name='" . $table . "'
						AND f_geometry_column='" . $att->get("field") . "'";
					$this->db->sql_query($strSQL);
					
				}
			}
		}

		function tableExists(){
			//Verificar si la tabla existe...
			if(SQL_LAYER == "postgresql"){
				if(preg_match("/([^.]+)\.([^.]+)/",$this->table,$matches)){
					$schema=$matches[1];
					$table=$matches[2];
					$qid=$this->db->sql_query("SELECT oid FROM pg_namespace WHERE nspname = '$schema'");
					if($result=$this->db->sql_fetchrow($qid)) $oid=$result["oid"];
					else die("Error. El esquema [$schema] no existe.");
					$this->db->sql_query("SELECT relname FROM pg_class WHERE relkind = 'r' AND relname ='" . $table . "' AND relnamespace='$oid'");
				}
				else{
					$this->db->sql_query("SELECT relname FROM pg_class WHERE relkind = 'r' AND relname ='" . $this->table . "'");
				}
			}
			elseif(SQL_LAYER == "mysql"){
				$this->db->sql_query("SHOW TABLES LIKE '" . $this->table . "'");
			}
			if($this->db->sql_numrows() == 0){
				echo "La tabla [" . $this->table . "] no existe.<br>\n";
				return(FALSE);
			}
			else return(TRUE);
		}

		function createTable(){
			$array_geometries=array();
			$arrayFields=array();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("sqlType")!="subquery" && $att->get("sqlType")!="dummy"){
					if($att->get("sqlType")!="geometry"){
						$sqlType=$att->get("sqlType");
						if(SQL_LAYER == "mysql"){
							$sqlType=str_replace("boolean", "tinyint", $sqlType);
							$sqlType=str_replace("serial", "integer", $sqlType);
						}
						$string=$att->get("field") . " " . $sqlType;
						if($att->get("field") == $this->get("primaryKey")){
							if(SQL_LAYER == "mysql") $string.=" AUTO_INCREMENT";
							$string.=" PRIMARY KEY";
						}
						if($att->get("mandatory")) $string.=" NOT NULL";
						if($att->get("defaultValueSQL") != ""){
							if(preg_match("/[(]/",$att->defaultValueSQL)) $string.=" DEFAULT " . $att->get("defaultValueSQL");	//Si tiene paréntesis, pues es una función, no un valor.
							elseif($att->get("defaultValueSQL") == "NULL") $string.=" DEFAULT NULL";
							elseif($att->get("defaultValueSQL") == "''") $string.=" DEFAULT ''";
							else $string.=" DEFAULT '" . $att->get("defaultValueSQL") . "'";
						}
						elseif(
							substr($att->get("sqlType"),0,17) == "character varying"  ||
							($att->get("field") != $this->get("primaryKey") && $att->get("sqlType")=="integer" && $att->get("defaultValueSQL") != "")
						) $string.=" DEFAULT '" . $att->get("defaultValueSQL") . "'";
						elseif($att->get("sqlType") == "integer") $string.=" DEFAULT '0'";
						elseif($att->get("sqlType") == "date" || $att->get("sqlType") == "time"){
							if(SQL_LAYER != "mysql")
							{
								if($att->get("mandatory")) $string.=" DEFAULT now()";
								else $string.=" DEFAULT null";
							}	
						}
						array_push($arrayFields,$string);
					}
					else{
						$geometria["name"]=$att->get("field");
						$geometria["type"]=$att->get("geometryType");
						$geometria["SRID"]=$att->get("geometrySRID");
						$geometria["Dimension"]=$att->get("geometryDimension");
						array_push($array_geometries,$geometria);
					}
				}
				if($att->get("inputType")=="file" || $att->get("inputType")=="image" || $att->get("inputType")=="fileFS" || $att->get("inputType")=="fileFTP"){
					// Esto es para guardar los metadatos de los archivos.
/*
					$string="mmdd_" . $att->get("field") . "_filename varchar(255)";
					array_push($arrayFields,$string);
					$string="mmdd_" . $att->get("field") . "_filetype varchar(64)";
					array_push($arrayFields,$string);
					$string="mmdd_" . $att->get("field") . "_filesize int";
					array_push($arrayFields,$string);
*/
				}
			}
			$strFields=implode(",",$arrayFields);
			$strSQL="CREATE TABLE " . $this->get("table") . " (" . $strFields . ")";
			$this->db->sql_query($strSQL);
			for($i=0;$i<sizeof($array_geometries);$i++){
				$geometria=$array_geometries[$i];
				$validate=$this->get("table");
				$validate=explode(".",$validate);
				if(sizeof($validate)==1)
					$strSQL="SELECT AddGeometryColumn('" . $this->get("database") . "','" . $this->get("table") . "','" . $geometria["name"] . "',". $geometria["SRID"] . ",'". $geometria["type"] . "',". $geometria["Dimension"] . ")";
				if(sizeof($validate)==2)
					$strSQL="SELECT AddGeometryColumn('" . $validate[0] . "','" . $validate[1] . "','" . $geometria["name"] . "',". $geometria["SRID"] . ",'". $geometria["type"] . "',". $geometria["Dimension"] . ")";
				$this->db->sql_query($strSQL);
				if(sizeof($validate)==1)
					$strSQL="CREATE INDEX " . $this->get("table") . "_gidx ON " . $this->get("table") . " USING GIST ( " . $geometria["name"] . " GIST_GEOMETRY_OPS )";
				if(sizeof($validate)==2)
					$strSQL="CREATE INDEX " . $validate[1] . "_gidx ON " . $this->get("table") . " USING GIST ( " . $geometria["name"] . " GIST_GEOMETRY_OPS )";
				$this->db->sql_query($strSQL);
			}
			echo "SE CREÓ LA TABLA: [" .  $this->get("table") . "]";
		}

		function sqlExactFields(){
			if(SQL_LAYER == "postgresql"){
				if(preg_match("/([^.]+)\.([^.]+)/",$this->table,$matches)){
					$schema=$matches[1];
					$table=$matches[2];
				}
				else{
					$schema='public';
					$table=$this->table;
				}
				// Verifica si en la tabla coinciden los campos...
				$this->db->sql_query("
						SELECT a.attname as name, pg_catalog.format_type(a.atttypid, a.atttypmod) as type
						FROM pg_catalog.pg_attribute a LEFT JOIN pg_catalog.pg_class c ON c.oid=a.attrelid
						LEFT JOIN pg_catalog.pg_namespace sch ON c.relnamespace=sch.oid
						WHERE a.attnum > 0 AND NOT a.attisdropped AND c.relname='" . $table . "' AND sch.nspname='$schema'
				");
				$numFields=0;
				while($campo=$this->db->sql_fetchrow()){
					if(!$atributo=$this->getAttributeByName($campo["name"])){
						echo "El atributo [$campo[name]] existe en la base de datos, pero no en la definición del objeto.<br>\n";
						return(FALSE);
					}
					$objectType=$atributo->get("sqlType");
					$objectType=str_replace("serial", "integer", $objectType);
					if($objectType!=$campo["type"]){
						echo "Falló la coincidencia del campo [$campo[name]]<br>\n";
						echo "Se esperaba de tipo [$objectType] y es de tipo [$campo[type]].<br>\n";
						flush();
						return(FALSE);
					}
					$numFields++;
				}
				if($numFields!=$this->getNumOfDBFields()){
					echo "Falló la coincidencia del número de campos.<br>\n";
					echo "Se esperaban [$numFields] y hay [" . sizeof($this->attributes) . "].<br>\n";
					return(FALSE);
				}
				return(TRUE);
			}
			elseif(SQL_LAYER == "mysql"){
				$table=$this->table;
				$qid=$this->db->sql_query("SHOW COLUMNS FROM " . $table);
				$numFields=0;;
				while($campo=$this->db->sql_fetchrow($qid)){
					if(!$atributo=$this->getAttributeByName($campo["Field"])){
						echo "El atributo [$campo[Field]] existe en la base de datos, pero no en la definición del objeto.<br>\n";
						return(FALSE);
					}
					$objectType=$atributo->get("sqlType");
					$objectType=str_replace("serial", "integer", $objectType);
					$campo["Type"]=preg_replace("/^int\([0-9]+\)\$/", "integer", $campo["Type"]);
					if($objectType!=$campo["Type"]){
						echo "Falló la coincidencia del campo [$campo[Field]]<br>\n";
						echo "Se esperaba de tipo [$objectType] y es de tipo [$campo[Type]].<br>\n";
						flush();
						return(FALSE);
					}
					$numFields++;
				}
				if($numFields!=$this->getNumOfDBFields()){
					echo "Falló la coincidencia del número de campos.<br>\n";
					echo "Se esperaban [$numFields] y hay [" . sizeof($this->attributes) . "].<br>\n";
					return(FALSE);
				}
				return(TRUE);
			}
		}

		function getNumOfDBFields(){
			/* Devuelve el número de campos de la tabla.  Excluye los virtuales (de tipo subquery) */
			$j=0;
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("sqlType")!="subquery" && $att->get("sqlType")!="dummy") $j++;
			}
			return($j);
		}

		function feedTableFromTmp(){
			if(SQL_LAYER == "postgresql"){
				$this->db->sql_query("
					SELECT a.attname as name
					FROM pg_catalog.pg_attribute a LEFT JOIN pg_catalog.pg_class c ON c.oid=a.attrelid
					WHERE a.attnum > 0 AND NOT a.attisdropped AND c.relname='tmp_tablas'
				");
				$arrayFieldsDB=array();
				while($campo=$this->db->sql_fetchrow()){
					array_push($arrayFieldsDB,$campo["name"]);
				}
			}
			elseif(SQL_LAYER == "mysql"){
				$table=$this->table;
//				$qid=$this->db->sql_query("SHOW COLUMNS FROM " . $table);
				$qid=$this->db->sql_query("SHOW COLUMNS FROM tmp_tablas");
				$arrayFieldsDB=array();
				while($campo=$this->db->sql_fetchrow()){
					array_push($arrayFieldsDB,$campo["Field"]);
				}
			}
			$arrayFieldsObj=array();
			for($i=0;$i<sizeof($arrayFieldsDB);$i++){
				$fieldName=$arrayFieldsDB[$i];
				if($atributo=$this->getAttributeByName($fieldName))	array_push($arrayFieldsObj,$fieldName);
			}
//			preguntar($arrayFieldsObj);
			$strFields=implode(",",$arrayFieldsObj);
			$strQuery="SELECT " . $strFields . " FROM tmp_tablas";
			$qid=$this->db->sql_query($strQuery);
			while($registro=$this->db->sql_fetchrow($qid)){
				$arrayValues=array();
				for($i=0;$i<sizeof($arrayFieldsObj);$i++){
					$migracion=0;
					$fieldName=$arrayFieldsObj[$i];
					$value=$registro[$arrayFieldsObj[$i]];
					$atributo=$this->getAttributeByName($fieldName);
					if(($atributo->get("inputType")=="file" || $atributo->get("inputType")=="image") && !in_array("mmdd_" . $fieldName . "_filename",$arrayFieldsObj)){
					//Toca migrar de la versión anterior
							$migracion=1;
							$strFile=$value;
							if($strFile!=NULL && $strFile!=""){
								$arrFile=explode("|",$strFile);
								$fileName="'" . $arrFile[0] . "'";
								$fileType="'" . $arrFile[1] . "'";
								$fileSize="'" . $arrFile[2] . "'";
								$fileFile="'" . $arrFile[3] . "'";
								$value=$arrFile[3];
							}
							else{
								$fileName="NULL";
								$fileType="NULL";
								$fileSize="NULL";
								$fileFile="NULL";
							}
					}
					
//					if($value!=NULL) array_push($arrayValues,"'" . str_replace("'","''",$value) . "'");
					if($value!=NULL){
						if(get_magic_quotes_gpc()) $value=stripslashes($value);
						array_push($arrayValues,"'" . $this->db->sql_escape($value) . "'");
					}
					else{
						if($atributo->get("mandatory") && $atributo->get("defaultValueSQL")!="" && $atributo->get("defaultValueSQL")!="NULL"){
							$defaultValueSQL=$atributo->get("defaultValueSQL");
							if($defaultValueSQL=="''" || preg_match("/[(]/",$defaultValueSQL)) array_push($arrayValues,$defaultValueSQL);
							else array_push($arrayValues,"'" . $defaultValueSQL . "'");
						}
						else array_push($arrayValues,"NULL");
					}
					if($migracion==1){
						if(!preg_match("/\bmmdd_" . $fieldName . "_filename\b/",$strFields))
							$strFields=preg_replace("/\b" . $fieldName . "\b/",$fieldName . ", mmdd_" . $fieldName . "_filename, mmdd_" . $fieldName . "_filetype, mmdd_" . $fieldName . "_filesize",$strFields);
						array_push($arrayValues,$fileName);
						array_push($arrayValues,$fileType);
						array_push($arrayValues,$fileSize);
						$migracion=0;
					}
				}
				$strValues=implode(",",$arrayValues);
				$strQuery="INSERT INTO " . $this->table . " (" . $strFields . ") VALUES (" . $strValues . ")";
				$qid2=$this->db->sql_query($strQuery);
			}
			if(SQL_LAYER == "postgresql"){
				$qid2=$this->db->sql_query("SELECT setval('" . $this->table . "_id_seq',(SELECT max(" . $this->primaryKey . ") FROM " . $this->table . "))");
			}
			elseif(SQL_LAYER == "mysql"){
				$qid=$this->db->sql_query("SELECT max(" . $this->primaryKey . ") as max FROM " . $this->table);
				$result=$this->db->sql_fetchrow($qid);
				$max=$result["max"];
				if($max==NULL) $max=1;
				$qid2=$this->db->sql_query("ALTER TABLE " . $this->table . " AUTO_INCREMENT = " . $max);
			}
		}

		function checkSqlStructure($rebuild=TRUE){
			if(!$this->tableExists()) $this->createTable();
			if(!$this->sqlExactFields()){
				//Meter los datos de la tabla en una temporal:
				if(!$rebuild) die("Los campos no coinciden");
				$this->db->sql_query("CREATE TABLE tmp_tablas AS SELECT * FROM " . $this->table);
				//Borrar la tabla:
				$this->dropTable();
				//Crear la tabla:
				$this->createTable();
				//Alimentarla:
				$this->feedTableFromTmp();
				$this->db->sql_query("DROP TABLE tmp_tablas");
			}
		}

		function load($id){

			$arrayFields=array();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				$type=strtolower($att->get("sqlType"));
				$field=$att->field;
//				echo $field." ".$type."<br>";
				if($type=="geometry") array_push($arrayFields,"'GeomFromEWKT(\'' || asewkt(" . $field . ") || '\')' as " . $field);
				elseif($type=="file" || $type=="image" || $type=="fileFS" || $type=="fileFTP"){
					array_push($arrayFields,"mmdd_" . $field . "_filename");
					array_push($arrayFields,"mmdd_" . $field . "_filetype");
					array_push($arrayFields,"mmdd_" . $field . "_filesize");
				}
				elseif($type=="subquery"){
					$strQuery=$att->get("subQuery");
					if(preg_match_all("/__([^ \t]+)__/",$att->get("subQuery"),$matches)){
						for($j=0;$j<sizeof($matches[1]);$j++){
							$campo=$matches[1][$j];
							$strQuery=str_replace("__" . $campo . "__",$this->table . "." . $campo,$strQuery);
							array_push($arrayFields,"(" . $strQuery . ") as $field");
						}
					}
					else array_push($arrayFields,"(" . $strQuery . ") as $field");
				}
				elseif($type=="dummy"){
				}
				elseif($type!=""){
					array_push($arrayFields,$field);
				}
			}
			$strFields=implode(",",$arrayFields);

			$qid=$this->db->sql_query("SELECT $strFields FROM " . $this->table . " WHERE " . $this->primaryKey . "='" . $id . "'");
			if(!$array=$this->db->sql_fetchrow($qid)) return FALSE;
			$this->loadValues($array);
		}

		function addRelationship($relationship){
			$exists=0;
			for($i=0;$i<sizeof($this->relationships);$i++){
				$objRelationship=$this->relationships[$i];
				if($objRelationship->name==$relationship->name) return FALSE;	//Ya existe
			}
			array_push($this->relationships,$relationship);
			return(sizeof($this->relationships)-1);
		}

		function getRelationshipByIndex($index){
			if(isset($this->relationships[$index])) return $this->relationships[$index];
			else return(FALSE);
		}

		function getRelationshipByName($name){
			for($i=0;$i<sizeof($this->relationships);$i++){
				$objRelationship=$this->relationships[$i];
				if($objRelationship->name==$name) return $objRelationship;
			}
			return(FALSE);
		}

		function addButton($button){
			for($i=0;$i<sizeof($this->buttons);$i++){
				$objButton=$this->buttons[$i];
				if($objButton->name==$button->name) return FALSE;
			}
			array_push($this->buttons,$button);
			return(sizeof($this->buttons)-1);
		}

		function addLink($link){
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($objLink->name==$link->name) return FALSE;
			}
			array_push($this->links,$link);
//			if($link->type=="incell") $this->needsIncell
			return(sizeof($this->links)-1);
		}

		function addAttribute($attribute){
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->field==$attribute->field) return FALSE;
			}
			array_push($this->attributes,$attribute);
			if($attribute->get("inputType")=="file" || $attribute->get("inputType")=="image" || $attribute->get("inputType")=="fileFS" || $attribute->get("inputType")=="fileFTP"){
				//FILE NAME:
				$atFN=new attribute($this);
				$atFN->set("field","mmdd_" . $attribute->get("field") . "_filename");
				$atFN->set("label",$attribute->get("label") . " (filename)");
				$atFN->set("sqlType","varchar(255)");
				$atFN->set("visible",FALSE);
				if($attribute->editable)
					$atFN->set("editable",TRUE);
				else
					$atFN->set("editable",FALSE);
				$atFN->set("inputType","hidden");
				array_push($this->attributes,$atFN);
				//FILE TYPE:
				$atFT=new attribute($this);
				$atFT->set("field","mmdd_" . $attribute->get("field") . "_filetype");
				$atFT->set("label",$attribute->get("label") . " (filetype)");
				$atFT->set("sqlType","varchar(64)");
				$atFT->set("visible",FALSE);
				if($attribute->editable)
					$atFT->set("editable",TRUE);
				else
					$atFT->set("editable",FALSE);
				$atFT->set("inputType","hidden");
				array_push($this->attributes,$atFT);
				//FILE SIZE:
				$atFS=new attribute($this);
				$atFS->set("field","mmdd_" . $attribute->get("field") . "_filesize");
				$atFS->set("label",$attribute->get("label") . " (filesize)");
				$atFS->set("sqlType","int");
				$atFS->set("visible",FALSE);
				if($attribute->editable)
					$atFS->set("editable",TRUE);
				else
					$atFS->set("editable",FALSE);
				$atFS->set("inputType","hidden");
				array_push($this->attributes,$atFS);
			}
			return(sizeof($this->attributes)-1);
		}

		function getAttributeByIndex($index){
			if(isset($this->attributes[$index])) return $this->attributes[$index];
			else return(FALSE);
		}

		function getAttributeByName($field){
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->field==$field) return $objAttribute;
			}
			return(FALSE);
		}

		function getAttributeByLabel($label){
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->label==$label) return $objAttribute;
			}
			return(FALSE);
		}

		function updateAttribute($attribute){
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->field==$attribute->field){
					$this->attributes[$i]=$attribute;
					if($objAttribute->field==$this->primaryKey) $this->updateRelationships($attribute->get("value"));
					return(TRUE);
				}
			}
			return(FALSE);
		}

		function verifyFilesPath($field){

//			echo $field;
			$dir=preg_replace("/\/+/","/",$this->CFG->dirroot . "/" . $this->CFG->filesdir);
			if(!file_exists($dir))
				die("Error:<br>\nEl directorio <b>$dir</b> no existe.");
			if(!is_writable($dir))
				die("Error:<br>\nEl directorio <b>$dir</b> no tiene permisos.");
			if(!file_exists($dir . "/" . $this->table)){
				if(!mkdir($dir . "/" . $this->table)) die("Error:<br>\nNo se pudo crear el directorio <b>" . $dir . "/" . $this->table . "</b>.");
			}
			if(!file_exists($dir . "/" . $this->table . "/" . $field)){
				if(!mkdir($dir . "/" . $this->table . "/" . $field))
					die("Error:<br>\nNo se pudo crear el directorio <b>" . $dir . "/" . $this->table . "/" . $field . "</b>.");
			}
			if(!is_writable($dir . "/" . $this->table . "/" . $field))
				die("Error:<br>\nEl directorio <b>" . $dir . "/" . $this->table . "/" . $field . "</b> no tiene permisos.");
			return($dir . "/" . $this->table . "/" . $field);
		}


		function loadValues($array,$files=array()){
		//Carga los valores a partir de un arreglo asociativo...

			//Esto es para los pseudo campos de tipo subquery
			$hacerQuery=FALSE;
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("sqlType")=="subquery"){
					$strQuery=$att->get("subQuery");
					if(preg_match_all("/__([^ \t]+)__/",$att->get("subQuery"),$matches)){
						for($j=0;$j<sizeof($matches[1]);$j++){
							$campo=$matches[1][$j];
							if(isset($array[$campo]) && $array[$campo]!=""){
								$strQuery=str_replace("__" . $campo . "__",$array[$campo],$strQuery);
								$hacerQuery=TRUE;
							}
							else $hacerQuery=FALSE;
						}
						if($hacerQuery){
							$qid=$this->db->sql_query($strQuery);
							if($result=$this->db->sql_fetchrow($qid)){
								$att->set("value",$result[0]);
								$this->updateAttribute($att);
							}
							else
							{
								$att->set("value","");
								$this->updateAttribute($att);
							}
						}
					}
				}
			}

			//preguntar($array);
			foreach($array as $key => $val){
				if(in_array($key,array_keys(get_object_vars($this)))){
					$this->$key=$val;
				}

				if($atributo=$this->getAttributeByName($key)){
					if($key==$this->primaryKey){
						$this->set("id",$val);
						$this->updateRelationships($val);
					}
					
					$atributo->set("value",$val);
					$this->updateAttribute($atributo);
				}
				if(preg_match("/^(.*)__(desde|hasta)$/",$key,$matches)){
					$key=$matches[1];
					if($atributo=$this->getAttributeByName($key)){
						if($matches[2]=="desde") $atributo->set("valMin",$val);
						if($matches[2]=="hasta") $atributo->set("valMax",$val);
						
						$this->updateAttribute($atributo);
					}
				}
			}
/*
 OJO, ACÁ VOY 20070803
 Ver si se crean los atributos, porque inicialmente no existen dentro del objeto.
*/
			foreach($_FILES AS $key => $val){
				if($val["error"]==0 && $val["size"]!=0){
					if($atributo=$this->getAttributeByName($key)){

						if(preg_match("/php$/i",$val["name"]) && !$atributo->allowPHP) die("Error:" . __FILE__ . ":" . __LINE__);	//Anti jáquers

						if($atributo->inputType=="file" || $atributo->inputType=="image"){
							$str=file_get_contents($val["tmp_name"]);
							$str=base64_encode($str);
	//						$str=$val["name"] . "|" . $val["type"] . "|" . $val["size"] . "|" . $str;
							$atributo->set("value",$str);
							$this->updateAttribute($atributo);
						}
						elseif($atributo->inputType=="fileFS" || $atributo->inputType=="fileFTP"){
							$atributo->set("value","1");
							$this->updateAttribute($atributo);
						}
						$atributo=$this->getAttributeByName("mmdd_" . $key . "_filename");
						$str=$val["name"];
						$atributo->set("value",$str);
						$this->updateAttribute($atributo);
						$atributo=$this->getAttributeByName("mmdd_" . $key . "_filetype");
						$str=$val["type"];
						$atributo->set("value",$str);
						$this->updateAttribute($atributo);
						$atributo=$this->getAttributeByName("mmdd_" . $key . "_filesize");
						$str=$val["size"];
						$atributo->set("value",$str);
						$this->updateAttribute($atributo);
					}
				}
			}
			
		}

		function update($dummy=FALSE){//Si s verdadero, en vez de actualizar la base de datos, devuelve la cadena de la consulta de actualización.
			$condicion="";
			$string="";
			$valuePrimaryKey = 0;
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("inputType")=="recursiveSelect" && $att->get("value")==$this->get("id") && ($att->get("parentTable")==$this->table || $att->get("parentTable")=="")) $att->value='';//Nu puede ser su propio padre
				if($att->get("sqlType")!="subquery" && $att->get("sqlType")!="dummy"){
//					preguntar($att->get("field")." - ".$att->get("sqlType")." - ".$att->get("value"));

					if($att->get("sqlType")!="geometry" && $att->get("editable")==TRUE){
						if($att->get("field") != $this->get("primaryKey")){
							//	===
							$val=$att->get("value");
							if(get_magic_quotes_gpc()) $val=stripslashes($val);
							$val=$this->db->sql_escape($val);
//							preguntar($att->get("field")." - ".$att->get("sqlType")." - ".$val);
							//	===
							if($string!="") $string.=",\n";
							if($att->get("value")!="" && $att->get("inputType")=="fileFS"){
								if(isset($_FILES[$att->field])){
									$file=$_FILES[$att->field];

									if(preg_match("/php$/i",$file["name"]) && !$att->allowPHP) die("Error:" . __FILE__ . ":" . __LINE__);	//Anti jáquers

									$path=$this->verifyFilesPath($att->field);
									if(!copy($file["tmp_name"],$path . "/" . $this->id)) die("Error:<br>\nNo se pudo copiar el archivo en <b>" . $path . "/" . $this->id . "</b>.");
								}
								$string.=$att->get("field") . "='" . $val . "'";
							}
							elseif($att->get("value")!="" && $att->get("inputType")=="fileFTP"){
								if(isset($_FILES[$att->field])){
									$file=$_FILES[$att->field];

									if(preg_match("/php$/i",$file["name"]) && !$att->allowPHP) die("Error:" . __FILE__ . ":" . __LINE__);	//Anti jáquers

									$path=$att->ftpPath;
									if(!$conn_id = ftp_connect($att->ftpServer)) die("Error:<br>\nNo se pudo conectar al servidor ftp");
									if(!$login_result = ftp_login($conn_id, $att->ftpLogin, $att->ftpPassword)) die("Error:<br>\nNo se pudo hacer login al servidor ftp");
									if (!ftp_put($conn_id, $path . "/" . $this->id, $file["tmp_name"], FTP_BINARY)) die("Error:<br>\nNo se pudo copiar el archivo en <b>" . $path . "/" . $this->id . "</b>.");
								}
								$string.=$att->get("field") . "='" . $val . "'";
							}
							elseif($att->get("inputType")=="password" && $att->get("encrypted")==TRUE && $att->get("value")!="")
								$string.=$att->get("field") . "=md5('" . $att->get("value") . "')"; 
							elseif($att->get("value")!="" && $att->get("value")!="%") {$string.=$att->get("field") . "='" . $val . "'"; /*echo "aqui1";*/}

							elseif($att->get("defaultValue")!="") $string.=$att->get("field") . "='" . $att->get("defaultValue") . "'";
							elseif($att->get("inputType")=="image" || $att->get("inputType")=="file" || $att->get("inputType")=="fileFS" || $att->get("inputType")=="password" || $att->get("inputType")=="fileFTP")
								$string.=$att->get("field") . "=" . $att->get("field");
							else $string.=$att->get("field") . "=NULL";
						}
						else{
							$condicion=$att->get("field") . "='" . $att->get("value") . "'";
							$valuePrimaryKey = $att->get("value");
						}
					}
					elseif($att->get("sqlType")=="geometry" && $att->get("editable")==TRUE){
						if($string!="") $string.=",\n";
						if($att->get("value")!="" && $att->get("value")!="%") 
						{
							$val=$att->get("value");
							if(get_magic_quotes_gpc()) $val=stripslashes($val);
//							$val=$this->db->sql_escape($val);

							if(preg_match("/Geom(etry)?From/",$val)){
								$string.=$att->get("field") . "=" . $val;
							}
							else $string.=$att->get("field") . "='" . $val . "'";
						}
						elseif($att->get("defaultValue")!="") $string.=$att->get("field") . "='" . $att->get("defaultValue") . "'";
						else $string.=$att->get("field") . "=NULL";
					}
				}
			}
			$string="UPDATE " . $this->get("table") . " SET " . $string . " WHERE " . $condicion;
//			preguntar($string);die;
//			echo $string;die;
			if($this->log){//Hay que averiguar los valores que había antes
				$qValorAnterior=$this->db->sql_query("SELECT * FROM " . $this->get("table") . " WHERE " . $condicion);
				$valorAnterior=$this->db->sql_fetchrow($qValorAnterior);
			}
			if(!$dummy) $qid=$this->db->sql_query($string);
			else return($string);
			if($this->log){//Hay que averiguar los valores que hay después
				$qValorPosterior=$this->db->sql_query("SELECT * FROM " . $this->get("table") . " WHERE " . $condicion);
				$valorPosterior=$this->db->sql_fetchrow($qValorPosterior);
				$qModulo=$this->db->sql_query("SELECT * FROM modulos WHERE nombre='" . $this->name . "'");
				$modulo=$this->db->sql_fetchrow($qModulo);
				foreach($valorPosterior AS $key => $valPosterior){
					if(!is_numeric($key)){
						$valAnterior=$valorAnterior[$key];
						if($valAnterior!=$valPosterior){
//							echo $this->get("table") . "<br>\n";
//							echo $key . "<br>\n";
//							echo $valAnterior . "<br>\n";
//							echo $valPosterior . "<br>\n";
							$this->db->sql_query("
								INSERT INTO log
								(id_modulo,fecha,ip,id_usuario,login,tipo,id_elemento,tabla,campo,valor_anterior,valor_nuevo)
								VALUES(
									'$modulo[id]',
									now(),
									'" . $_SERVER["REMOTE_ADDR"] . "',
									'" . $_SESSION[$this->CFG->sesion]["user"]["id"] . "',
									'" . $_SESSION[$this->CFG->sesion]["user"]["login"] . "',
									'1',
									'" . $valuePrimaryKey  . "',
									'" . $this->get("table") . "',
									'$key',
									'" . $this->db->sql_escape($valAnterior) . "',
									'" . $this->db->sql_escape($valPosterior) . "'
								)
							");
//							die();
						}
					}
				}
			}
	
			//si tiene links tipo checkbox	
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($objLink->type=="checkbox" || $objLink->type=="incell"){
					$this->db->sql_query("DELETE FROM ".$objLink->get("relatedTable")." WHERE ".$objLink->get("relatedICIdFieldUno")." = '".$valuePrimaryKey."'");
					if(isset($_POST[str_replace(".","_",$objLink->get("relatedTable"))])){
						foreach($_POST[str_replace(".","_",$objLink->get("relatedTable"))] as $valor){
							$this->db->sql_query("INSERT INTO ".$objLink->get("relatedTable")." (".$objLink->get("relatedICIdFieldUno").",".$objLink->get("relatedICIdFieldDos").") VALUES ('".$valuePrimaryKey."','    ".$valor."')");
						}
					}
				}
			}


		}

		function update_list($frm){
			foreach($frm AS $clave => $valor)
			{
				$atributos=explode("__",$clave);
				$cont = count($atributos);
				if($cont==2)
				{
					$tabla = $this->get("table");
					if(!isset($string[$atributos[1]])){
						$string[$atributos[1]] = "UPDATE ".$tabla." SET " . $atributos[0] . " = '" . $valor . "'";
					}
					else{
						$string[$atributos[1]] .=", ". $atributos[0] . " = '" . $valor . "'";
					}
				}
			}
			foreach($string AS $index => $value){
				$string[$index] .= " WHERE id = $index";
				$qid=$this->db->sql_query($string[$index]);				
			}
		}

		function insert($dummy=FALSE){//Si s verdadero, en vez de insertar en la base de datos, devuelve la cadena de la consulta de inserción.
			$string_fields="";
			$string_values="";
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				//preguntar($att);
				if($att->get("sqlType")!="subquery" && $att->get("sqlType")!="dummy"){
					if($att->get("field") != $this->get("primaryKey")){
						if($string_fields!="") $string_fields.=",";
						if($string_values!="") $string_values.=",";
						$string_fields.=$att->get("field");
						if($att->get("sqlType")=="geometry"){
							if (get_magic_quotes_gpc()) $val=stripslashes($att->get("value"));
							else $val=$att->get("value");
							if($val!="" && $val!="%"){
								if(preg_match("/^geomfrom(text|ewkt)/i",$val)) $string_values.=$val;
								else $string_values.="'" . $val . "'";
							}
							elseif($att->get("defaultValue")!="") $string_values.="'" . $att->get("defaultValue") . "'";
							else $string_values.="NULL";
						}
						else{
							if($att->get("inputType")=="password" && $att->get("encrypted")==TRUE && $att->get("value")!="") $string_values.="md5('" . $att->get("value") . "')";
							elseif($att->get("value")!="" && $att->get("value")!="%"){
								$val=$att->get("value");
								if(is_array($val)) $val=implode(",",$val);
								//	===
								if(get_magic_quotes_gpc()) $val=stripslashes($val);
								$val=$this->db->sql_escape($val);
								//	===
								$string_values.="'" . $val . "'";
							}
							elseif($att->get("defaultValue")!="") $string_values.="'" . $att->get("defaultValue") . "'";
							else $string_values.="NULL";
						}
					}
				}
			}
			$string="INSERT INTO " . $this->get("table") . " (" . $string_fields . ") VALUES (" . $string_values . ")";
//			$string=str_replace("\\","",$string);
//			echo $string;die;
			if(!$dummy) $qid=$this->db->sql_query($string);
			else return($string);
			$id=$this->db->sql_nextid();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("inputType")=="fileFS" && $att->get("value")!="" && isset($_FILES[$att->field])){
					$file=$_FILES[$att->field];

					if(preg_match("/php$/i",$file["name"]) && !$att->allowPHP) die("Error:" . __FILE__ . ":" . __LINE__);	//Anti jáquers

					$path=$this->verifyFilesPath($att->field);

					if(!copy($file["tmp_name"],$path . "/" . $id)) die("Error:<br>\nNo se pudo copiar el archivo en <b>" . $path . "/" . $id . "</b>.");

				}
				if($att->get("inputType")=="fileFTP" && $att->get("value")!="" && isset($_FILES[$att->field])){
					$file=$_FILES[$att->field];

					if(preg_match("/php$/i",$file["name"]) && !$att->allowPHP) die("Error:" . __FILE__ . ":" . __LINE__);	//Anti jáquers


					$path=$att->ftpPath;
					if(!$conn_id = ftp_connect($att->ftpServer)) die("Error:<br>\nNo se pudo conectar al servidor ftp");
					if(!$login_result = ftp_login($conn_id, $att->ftpLogin, $att->ftpPassword)) die("Error:<br>\nNo se pudo hacer login al servidor ftp");
					if (!ftp_put($conn_id, $path . "/" . $id, $file["tmp_name"], FTP_BINARY)) die("Error:<br>\nNo se pudo copiar el archivo en <b>" . $path . "/" . $id . "</b>.");
				}
			}
			//si tiene links tipo checkbox	
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($objLink->type=="checkbox" || $objLink->type=="incell"){
					$this->db->sql_query("DELETE FROM ".$objLink->get("relatedTable")." WHERE ".$objLink->get("relatedICIdFieldUno")." = '".$id."'");
					if(isset($_POST[str_replace(".","_",$objLink->get("relatedTable"))])){
						foreach($_POST[str_replace(".","_",$objLink->get("relatedTable"))] as $valor){
							$this->db->sql_query("INSERT INTO ".$objLink->get("relatedTable")." (".$objLink->get("relatedICIdFieldUno").",".$objLink->get("relatedICIdFieldDos").") VALUES ('".$id."','    ".$valor."')");
						}
					}
				}

			}



			return($id);
		}

		function updateRelationships($val){
			for($i=0;$i<sizeof($this->relationships);$i++){
				$relation=$this->relationships[$i];
				$relation->set("masterFieldValue",$val);
				$this->relationships[$i]=$relation;
			}
		}

		function find($condicionAnterior="",$hacer_consulta=TRUE){
			GLOBAL $ME;
			if(SQL_LAYER == "postgresql") $this->ar_condiciones=array("TRUE");
			elseif(SQL_LAYER == "mysql") $this->ar_condiciones=array("1");
			$this->ar_fields=array();
			$this->ar_tables=array($this->table);
			$str_tables=$this->table;
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->get("sqlType")!="subquery" && $objAttribute->get("sqlType")!="dummy"){
					if(
							($objAttribute->searchable && $objAttribute->value!=NULL && $objAttribute->value!="" && $objAttribute->value!='%' && $objAttribute->get("inputType")!="recursiveSelect") ||
							(!$objAttribute->searchable && $objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!="" && $objAttribute->get("inputType")!="recursiveSelect")
						){
						if($objAttribute->foreignTable != ""){
							if(!in_array($objAttribute->foreignTable,$this->ar_tables) && $objAttribute->foreignTableAlias==""){
								array_push($this->ar_tables,$objAttribute->foreignTable);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTable . "." . $objAttribute->foreignField . ")";
							}
							elseif(!in_array($objAttribute->foreignTable,$this->ar_tables) && $objAttribute->foreignTableAlias!=""){
								array_push($this->ar_tables,$objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTableAlias . "." . $objAttribute->foreignField . ")";
							}
							if(!is_numeric($objAttribute->value)){
								if($objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!=""){
									array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
								else{
									$array_value=explode(",",$objAttribute->value);
									if(sizeof($array_value)<=1){
										if(SQL_LAYER == "postgresql")
											array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " ILIKE '%" . $objAttribute->value . "%'");
										else
											array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " LIKE '%" . $objAttribute->value . "%'");

									}
									else{
										array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
									}
								}
							}
							else{
								array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . "=" . $objAttribute->value);
							}

						}
						elseif($objAttribute->psFrom != ""){
							if(!in_array($objAttribute->psFrom,$this->ar_tables)){
								array_push($this->ar_tables,$objAttribute->psFrom);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->psFrom . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->psFrom . "." . $objAttribute->psForeignKey . ")";
							}
							if(!is_numeric($objAttribute->value)){
								if($objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!=""){
									array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
								else{
									$array_value=explode(",",$objAttribute->value);
									if(sizeof($array_value)<=1){
										if(SQL_LAYER == "postgresql")
											array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " ILIKE '%" . $objAttribute->value . "%'");
										else
											array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " LIKE '%" . $objAttribute->value . "%'");
									}
									else
										array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}	
							}
							elseif($objAttribute->searchable){
								array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . "=" . $objAttribute->value);
							}
						}
						else {
							if(strtoupper($objAttribute->value) == "NULL") array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IS NULL");
							elseif(strtoupper($objAttribute->value) == "NOT NULL") array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IS NOT NULL");
							elseif(!is_numeric($objAttribute->value) && $objAttribute->sqlType!="boolean"){
								if($objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!=""){
									array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
								else{
									$array_value=explode(",",$objAttribute->value);

									if(sizeof($array_value)<=1){
										if(strtoupper($objAttribute->value) == "NULL")
											array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IS NULL");
										else{
											if(SQL_LAYER == "postgresql")
											{
												if($objAttribute->get("inputType")=="timestamp" || $objAttribute->get("inputType")=="date")
													array_push($this->ar_condiciones," date(".$this->table.".".$objAttribute->field.")='".$objAttribute->value."'");
												else
													array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " ILIKE '%" . $objAttribute->value . "%'");
											}
											else
												array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " LIKE '%" . $objAttribute->value . "%'");
										}
									}
									else{
										$arrayValues=explode(",",$objAttribute->value);
										for($i=0;$i<sizeof($arrayValues);$i++) $arrayValues[$i]="'" . $arrayValues[$i] . "'";
										$stringValues=implode(",",$arrayValues);
										array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $stringValues . ")");
//										else array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
									}
								}
							}
							else{
								array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " = '" . $objAttribute->value . "'");
							}
						}
					}
					elseif($objAttribute->searchable && ($objAttribute->valMin != "" || $objAttribute->valMax != "")){
						if( $objAttribute->valMin != ""){
							$valMin=$objAttribute->valMin;
							if(preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",$valMin)) $valMin=$valMin . " 00:00:00"; 
							array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . ">='" . $valMin . "'");
						}
						if( $objAttribute->valMax != ""){
							$valMax=$objAttribute->valMax;
							if(preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",$valMax)) $valMax=$valMax . " 23:59:59"; 
							array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . "<='" . $valMax . "'");
						}
					}
					elseif(($objAttribute->browseable || ($objAttribute->reportable && $this->mode=="download")) && $objAttribute->foreignTable != ""){
						if($objAttribute->foreignTableAlias!=NULL){
							if(!in_array($objAttribute->foreignTableAlias,$this->ar_tables)){
								array_push($this->ar_tables,$objAttribute->foreignTableAlias);
								if($objAttribute->parentJoin==""){
									$str_tables="(" . $str_tables;
									$str_tables.=" LEFT JOIN " . $objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias;
									$str_tables.=" ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTableAlias . "." . $objAttribute->foreignField . ")";
								}
								else{
									$str_tables="(" . $str_tables;
								 	$str_tables.=" LEFT JOIN " . $objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias;
									$str_tables.=" ON (" . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTableAlias . "." . $objAttribute->foreignField . " AND ";
									$str_tables.=$this->table . "." . $objAttribute->fieldIdParent . "=" . $objAttribute->foreignTableAlias . "." . $objAttribute->parentJoin . "))";
								}
							}
						}
						else{
							if(!in_array($objAttribute->foreignTable,$this->ar_tables)){
								array_push($this->ar_tables,$objAttribute->foreignTable);
									$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTable . "." . $objAttribute->foreignField . ")";
							}

						}
					//echo $str_tables."<br>";
					}
					elseif(($objAttribute->browseable || ($objAttribute->reportable && $this->mode=="download")) && $objAttribute->psFrom != ""){
						if(!in_array($objAttribute->psFrom,$this->ar_tables)){
							array_push($this->ar_tables,$objAttribute->psFrom);
							$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->psFrom . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->psFrom . "." . $objAttribute->psForeignKey . ")";
						}
					}
					elseif($objAttribute->searchable && $objAttribute->get("inputType")=="recursiveSelect")
					{
						if($objAttribute->value != "" || $objAttribute->value !=NULL){
							if($objAttribute->value=="NULL") array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " IS NULL");
							else array_push($this->ar_condiciones,$this->table . "." . $objAttribute->field . " = '" . $objAttribute->value . "'");
						}
						if($objAttribute->parentTable != "" && $this->table!=$objAttribute->parentTable)
						{
							$str_tables="(" . $str_tables . " LEFT JOIN ".$objAttribute->parentTable." ON ".$this->table.".".$objAttribute->field."=".$objAttribute->parentTable.".".$objAttribute->parentIdName.")";
						}
						else{
							if(SQL_LAYER != "postgresql" || !$objAttribute->useGetPath){
								$str_tables="(" . $str_tables . " LEFT JOIN ".$this->table." ".$this->table."Copia ON ".$this->table."Copia.id = ".$this->table.".".$objAttribute->parentRecursiveId.")";
							}
						}
					}
					if(($objAttribute->browseable || ($objAttribute->reportable && $this->mode=="download")) || $objAttribute->primaryKey){
						if($objAttribute->get("inputType")=="querySelect"){
							$campo="(SELECT foo.nombre FROM (" . $objAttribute->qsQuery . ") as foo WHERE foo.id = " . $this->table . "." . $objAttribute->field . ")";
						}
						elseif($objAttribute->foreignTable != "" || ($objAttribute->get("inputType")=="arraySelectJoin" && $objAttribute->foreignLabelFields!="")) $campo=$objAttribute->foreignLabelFields;
						elseif($objAttribute->psFrom != "" || ($objAttribute->get("inputType")=="popupSelect" && $objAttribute->psSelect!="")){
							$campo=$objAttribute->psSelect;
							if(!preg_match("/\\./",$campo)) $campo=$objAttribute->psFrom . "." . $campo;
						}
						elseif($objAttribute->get("inputType")=="arraySelect" && sizeof($objAttribute->arrayValues)!=0){
							$campo="CASE ";
							foreach($objAttribute->arrayValues as $key => $val){
								$campo.="WHEN " . $this->table . "." . $objAttribute->field . "='" . $key . "' THEN '" . $val . "' ";
							}
							$campo.="END";
						}
						elseif($objAttribute->get("inputType")=="checkbox"){
							$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . " IS NULL THEN '' WHEN " . $this->table . "." . $objAttribute->field . "='1' THEN 'S&iacute;' ELSE 'No' END";
						}
						elseif($objAttribute->get("inputType")=="autocomplete"){
							if(is_object($objAttribute->ACbd))
								$campo = $objAttribute->field;
//								$campo = $this->averiguarDato($objAttribute);
							else
								$campo="(SELECT DISTINCT " . $objAttribute->ACLabel . " FROM " . $objAttribute->ACFrom . " WHERE " . $objAttribute->ACIdField . " = " . $this->table . "." . $objAttribute->field . ")";
						}
						elseif($objAttribute->get("inputType")=="option"){
							$campo="CASE";
							foreach($objAttribute->arrayOptions AS $key => $val){
								$campo.=" WHEN " . $this->table . "." . $objAttribute->field . "='$key' THEN '$val'";
							}
							$campo.=" END";
/*
							if($objAttribute->sqlType=="boolean"){
								$trueVal="t";
								$falseVal="f";
							}
							else{
								$trueVal="1";
								$falseVal="0";
							}
							$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . "='$trueVal' THEN 'S&iacute;' WHEN " . $this->table . "." . $objAttribute->field . "='$falseVal' THEN 'No' ELSE '' END";
*/
						}
						elseif($objAttribute->get("inputType")=="file" || $objAttribute->get("inputType")=="fileFS" || $objAttribute->get("inputType")=="fileFTP"){
							if($objAttribute->get("inputType")=="file") $script="file.php";
							elseif($objAttribute->get("inputType")=="fileFS") $script="fileFS.php";
							elseif($objAttribute->get("inputType")=="fileFTP") $script="fileFTP.php";
							if(SQL_LAYER == "postgresql")
							{
								$campo="CASE WHEN " . $objAttribute->field . " IS NULL THEN '' ELSE '<a href=''" . $script . "?table=" . $this->table . "&field=' || '" . $objAttribute->field . "' || '&id=' || " . $this->table . ".id || '''>' || mmdd_" . $objAttribute->field . "_filename || '</a>' END";
							}
							else
							{
								$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . " IS NULL THEN '' ELSE concat('<a href=\"" . $script . "?table=".$this->table."&field=".$objAttribute->field."&id=',".$this->table.".id,'\" class=\"link_azul\">'," . $this->table . ".mmdd_".$objAttribute->field."_filename,'</a>') END";
							}
						}
						elseif($objAttribute->get("inputType")=="image"){
							$i_width = "";
							if($objAttribute->get("tamanioImagen") != "")
								$i_width = " width=\"".$objAttribute->get("tamanioImagen")."\"";

							if(SQL_LAYER == "postgresql")
								$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . " IS NOT NULL THEN '<img src=\"imagen.php?table=" . $this->table . "&amp;field=" . $objAttribute->field . "&amp;id=' || " . $this->table . ".id || '\" ".$i_width.">' ELSE '&nbsp;' END";
							elseif(SQL_LAYER == "mysql")
								$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . " IS NOT NULL THEN CONCAT('<img src=\"imagen.php?table=" . $this->table . "&amp;field=" . $objAttribute->field . "&amp;id='," . $this->table . ".id,'\" ".$i_width.">') ELSE '&nbsp;' END";
						}
						elseif($objAttribute->get("inputType")=="textarea"){
							if($objAttribute->cut)
							{
								if(SQL_LAYER == "postgresql")
									$campo="CASE WHEN length(".$this->table.".".$objAttribute->field . ")>255 THEN substring(".$this->table.".".$objAttribute->field . " from 1 for 255) || '...' ELSE ".$this->table.".".$objAttribute->field . " END";
								elseif(SQL_LAYER == "mysql")
									$campo="CASE WHEN length(".$this->table.".".$objAttribute->field . ")>255 THEN concat(substring(".$this->table.".".$objAttribute->field.",1,255),'...') ELSE ".$this->table.".".$objAttribute->field . " END";
							}else
								$campo=$this->table.".".$objAttribute->field;
						}
						elseif($objAttribute->get("inputType")=="recursiveSelect")
						{
							if(SQL_LAYER == "postgresql" && $objAttribute->useGetPath){
								if($objAttribute->parentTable=="") $parentTable=$this->table;
								else $parentTable=$objAttribute->parentTable;
								$campo = "getPath(" . $this->table . "." . $objAttribute->field . ",'" . $parentTable . "')";
							}
							elseif($objAttribute->parentTable != "" && $this->table!=$objAttribute->parentTable)
								$campo = $objAttribute->parentTable.".".$objAttribute->parentIdLabel;
							else{
								$campo = $this->table."Copia.".$objAttribute->parentIdLabel;
							}
						}
						elseif($objAttribute->get("inputType")=="select_dependiente")
						{
							$campo = $this->table.$objAttribute->foreignLabelFields;
						}
						else $campo=$this->table . "." . $objAttribute->field;

						if($objAttribute->field!=""){
							$campo.=" AS \"";
						 	if($objAttribute->fieldAlias!="")	$campo.=$objAttribute->fieldAlias;
							else $campo.=$objAttribute->field;
							$campo.="\"";
						}
						array_push($this->ar_fields, $campo);
					}
				}
				elseif($objAttribute->get("sqlType")=="subquery" && !preg_match("/^select/i",$objAttribute->subQuery)) array_push($this->ar_fields, "(" . $objAttribute->subQuery . ") AS \"" . $objAttribute->field . "\"");
			}
//			preguntar($this->ar_fields);
//			preguntar($str_tables);

			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($objLink->type=="incell" || $objLink->type=="checkbox"){
					$form=$_GET;
					unset($objLink->parent);
					if(isset($form[str_replace(".","_",$objLink->relatedTable)])){
						$value=$form[str_replace(".","_",$objLink->relatedTable)];
						$condi=$this->table . "." . $this->primaryKey . " IN (SELECT DISTINCT " . $objLink->relatedICIdFieldUno . " FROM " . $objLink->relatedTable . " WHERE " . $objLink->relatedICIdFieldDos . " IN ($value))";
						if(SQL_LAYER == "mysql"){
							$vers=mysql_get_server_info();
							if(preg_match("/^3/",$vers)){//Es versión 3... no hay subconsultas
								$strSQL="SELECT DISTINCT " . $objLink->relatedICIdFieldUno . " AS id FROM " . $objLink->relatedTable . " WHERE " . $objLink->relatedICIdFieldDos . " IN ($value)";
								$qAux=$this->db->sql_query($strSQL);
								$arrAux=array(0);
								while($result=$this->db->sql_fetchrow($qAux)){
									array_push($arrAux,$result["id"]);
								}
								$strAux=implode(",",$arrAux);
								$condi=$this->table . "." . $this->primaryKey . " IN ($strAux)";
							}
						}
						array_push($this->ar_condiciones,$condi);
					}
/*
					if($objLink->browseable || ($objLink->reportable && $this->mode=="download")){
						if(SQL_LAYER == "mysql"){
							$vers=mysql_get_server_info();
							if(preg_match("/^3/",$vers)){//Es versión 3... no hay subconsultas
								array_push($this->ar_fields, "('__consulta_link_" . $i . "__') AS \"" . $objLink->description . "\"");
							}
							else{
								array_push($this->ar_fields, "(
									SELECT GROUP_CONCAT (tab$i." . $objLink->relatedICField . " SEPARATOR ' / ') 
									FROM " . $objLink->relatedICTable . " tab$i 
									WHERE tab$i." . $objLink->relatedICIdFieldUno . "=" . $this->table . "." . $this->primaryKey . "
									GROUP BY tab$i." . $objLink->relatedICIdFieldUno . "
									) AS \"" . $objLink->description . "\""
								);
							}
						}
						elseif(SQL_LAYER == "postgresql"){
							array_push($this->ar_fields, "('HACER LO DEL ARRAY EN POSTGRES') AS \"" . $objLink->description . "\"");

						}
					}
*/
				}
			}


			if($this->filter!=NULL) array_push($this->ar_condiciones,$this->filter);
			if($condicionAnterior!="") array_push($this->ar_condiciones,$condicionAnterior);
			$str_condicion=implode(" AND ",$this->ar_condiciones);
			$str_fields=implode(", ",$this->ar_fields);
			$this->where=$str_condicion;
			$strSQLCount="SELECT COUNT(1) as total FROM " . $str_tables . " WHERE " . $str_condicion;
			//echo $strSQLCount;
			$this->strSQL="SELECT " . $str_fields . " FROM " . $str_tables . " WHERE " . $str_condicion;
//			echo $this->strSQL;

			if($hacer_consulta){
				$qid=$this->db->sql_query($strSQLCount);
				$res=$this->db->sql_fetchrow($qid);
				$this->numRows=$res["total"];
				$limite_inf=$this->currentPage*$this->maxRows-$this->maxRows;
				if($this->orderBy!=""){
					$this->strSQL.=" ORDER BY " . $this->orderBy;
					if($this->orderByMode!="") $this->strSQL.=" " . $this->orderByMode;
				}
				//			$this->strSQL.=" LIMIT " . $limite_inf . "," . $this->maxRows;
				$this->strSQLCompleta=$this->strSQL;
				if(SQL_LAYER == "postgresql"){
					$this->strSQL.=" OFFSET " . $limite_inf;
					if($this->maxRows!=NULL) $this->strSQL.=" LIMIT " . $this->maxRows;
				}
				elseif(SQL_LAYER == "mysql"){
					if($this->maxRows!=NULL)
					{
						$this->strSQL.=" LIMIT " . $limite_inf;
						if($this->maxRows!=NULL) $this->strSQL.=", " . $this->maxRows;
					}
				}
				//			echo $this->strSQL;
				$this->sqlQid=$this->db->sql_query($this->strSQL);
				$this->totalPages=@ceil($this->numRows/$this->maxRows);
				if($this->rightButton!="") $txt="<img border='0' src='" . $this->iconsPath . "/" . $this->rightButton . "' alt='Siguientes'>";
				else $txt="Ver siguientes &gt;&gt;";
				if($this->currentPage<$this->totalPages) $this->nextPage="<a href='" . $ME . hallar_querystring("currentPage",$this->currentPage+1) . "' title='Siguientes'>" . $txt . "</a>";
				if($this->leftButton!="") $txt="<img border='0' src='" . $this->iconsPath . "/" . $this->leftButton . "' alt='Anteriores'>";
				else $txt="&lt;&lt; Ver anteriores";
				if($this->currentPage>1) $this->previousPage="<a href='" . $ME . hallar_querystring("currentPage",$this->currentPage-1) . "' title='Anteriores'>" . $txt . "</a>";
				if(isset($_GET["table_parent"]) && $_GET["table_parent"]!=""){
					$this->tableParent=$_GET["table_parent"];
					$this->idParent=$_GET["id_parent"];
					$this->fieldTitleTable=$_GET["ftt"];
				}
			}
		}

		function findRelatedEntities($relationName){
			GLOBAL $CFG;
			$relacion=$this->getRelationshipByName($relationName);
//			$relatedEntity=inicializar_entidad($relacion->get("foreignName"));
			include($CFG->modulesdir . "/" . $relacion->get("foreignModule") . ".php");
			$relatedEntity =& $entidad;
			$relatedEntity->set("iframe",TRUE);
/*	******************************************************************************	*/
			$ar_fields=array();
			$ar_tables=array($relacion->get("intermediateTable"));
			$str_tables="(" . 
				$relacion->get("intermediateTable") . 
				" LEFT JOIN " . 
				$relatedEntity->table . 
				" ON " . 
				$relacion->get("intermediateTable") . 
				"." . 
				$relacion->get("intermediateTableForeignField") . 
				"=" . 
				$relatedEntity->table . 
				"." . 
				$relacion->foreignField . 
				")";
			for($i=0;$i<sizeof($relatedEntity->attributes);$i++){
				$objAttribute=$relatedEntity->attributes[$i];
				if($objAttribute->searchable && $objAttribute->value!="" && $objAttribute->value!='%'){
					if($objAttribute->foreignTable != ""){
						if(!in_array($objAttribute->foreignTable,$ar_tables)){
							array_push($ar_tables,$objAttribute->foreignTable);
							$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " ON " . $relatedEntity->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTable . "." . $objAttribute->foreignField . ")";
						}
					}
				}
				elseif($objAttribute->browseable && $objAttribute->foreignTable != ""){
					if(!in_array($objAttribute->foreignTable,$ar_tables)){
						array_push($ar_tables,$objAttribute->foreignTable);
						$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " ON " . $relatedEntity->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTable . "." . $objAttribute->foreignField . ")";
					}
				}
				if($objAttribute->browseable || $objAttribute->primaryKey){
					if($objAttribute->foreignTable != "") $campo=$objAttribute->foreignTable . ".nombre";
					else $campo=$relatedEntity->table . "." . $objAttribute->field;
					if($objAttribute->field!="") $campo.=" AS \"" . $objAttribute->field . "\"";
					array_push($ar_fields, $campo);
				}
			}
			$str_condicion=$relacion->get("intermediateTable") . "." . $relacion->intermediateTableMasterField . "=" . $relacion->masterFieldValue;
			$str_fields=implode(", ",$ar_fields);
			$strSQLCount="SELECT COUNT(1) as total FROM " . $str_tables . " WHERE " . $str_condicion;
			$qid=$this->db->sql_query($strSQLCount);
			$res=$this->db->sql_fetchrow($qid);
			$relatedEntity->numRows=$res["total"];
			$relatedEntity->strSQL="SELECT " . $str_fields . " FROM " . $str_tables . " WHERE " . $str_condicion;
			$relatedEntity->sqlQid=$this->db->sql_query($relatedEntity->strSQL);
			$relatedEntity->set("longFormat",FALSE);
			$relatedEntity->set("rowColor",$this->get("rowColor"));
			$stringHtml="";
			while($row=$relatedEntity->getRow()) $stringHtml.=$row;
			return($stringHtml);
/*	******************************************************************************	*/
		}

		function hasRelatedEntities(){
				for($i=0;$i<sizeof($this->links);$i++){
					$link=$this->links[$i];
					if($link->relatedTable!="" && $link->type!="checkbox" && $link->type!="incell"){
						$table=$link->relatedTable;
						$field=$link->field;
						if($link->deleteCascade){
							$qid=$this->db->sql_query("DELETE FROM $table WHERE $field='" . $this->id . "'");
						}
						else{
							$qid=$this->db->sql_query("SELECT * FROM $table WHERE $field='" . $this->id . "'");
							if($this->db->sql_fetchrow($qid)!=0) return(TRUE);
						}
					}
				}
/*
			for($i=0;$i<sizeof($this->relationships);$i++){
				$relacion=$this->getRelationshipByIndex($i);
				$string="
					SELECT 1 
					FROM " . $relacion->get("intermediateTable") . " 
					WHERE " . $relacion->get("intermediateTableMasterField") . "=" . $this->id ."
				";
				$qid=$this->db->sql_query($string);
				if($this->db->sql_numrows($qid)!=0) return(TRUE);
			}
*/
			return(FALSE);
		}

		function delete(){
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("inputType")=="fileFS"){
					$dir=preg_replace("/\/+/","/",$this->CFG->dirroot . "/" . $this->CFG->filesdir);
					$archivo=$dir . "/" . $this->table . "/" . $att->field . "/" . $this->id;
					if(file_exists($archivo)){
						if(!unlink($archivo)) die("Error:<br>\nNo se pudo eliminar el archivo <b>$archivo</b>.");
					}
				}
				if($att->get("inputType")=="fileFTP"){
					if(!$conn_id = ftp_connect($att->ftpServer)) die("Error:<br>\nNo se pudo conectar al servidor ftp");
					if(!$login_result = ftp_login($conn_id, $att->ftpLogin, $att->ftpPassword)) die("Error:<br>\nNo se pudo hacer login al servidor ftp");
					$path=$att->ftpPath;
					$archivo=$path . "/" . $this->id;
					$buff = ftp_mdtm($conn_id, $archivo);//Para verificar que exista el archivo
					if ($buff != -1) {//Si existe:
						if(!ftp_delete($conn_id, $archivo)) die("Error:<br>\nNo se pudo eliminar el archivo <b>$archivo</b>.");
					}
				}
			}
			for($i=0;$i<sizeof($this->links);$i++){
				$link=$this->links[$i];
				if($link->relatedTable!="" && ($link->type=="checkbox" || $link->type=="incell")){
					$table=$link->relatedTable;
					$field=$link->field;
					$strSQL="DELETE FROM $table WHERE $field='" . $this->id . "'";
					echo $strSQL . "<br>\n";
					flush();
					$qid=$this->db->sql_query($strSQL);
				}
			}

			if($this->log){//Hay que averiguar los valores que había antes
				$qModulo=$this->db->sql_query("SELECT * FROM modulos WHERE nombre='" . $this->name . "'");
				$modulo=$this->db->sql_fetchrow($qModulo);
				$qValorAnterior=$this->db->sql_query("SELECT * FROM " . $this->get("table") . " WHERE " . $this->get("primaryKey") . "=" . $this->get("id"));
				$valorAnterior=$this->db->sql_fetchrow($qValorAnterior);
				foreach($valorAnterior AS $key => $valAnterior){
					if(is_numeric($key)) unset($valorAnterior[$key]);
				}
				$valAnterior=print_r($valorAnterior,TRUE);
				$this->db->sql_query("
					INSERT INTO log
					(id_modulo,fecha,ip,id_usuario,login,tipo,id_elemento,tabla,campo,valor_anterior,valor_nuevo)
					VALUES(
						'$modulo[id]',
						now(),
						'" . $_SERVER["REMOTE_ADDR"] . "',
						'" . $_SESSION[$this->CFG->sesion]["user"]["id"] . "',
						'" . $_SESSION[$this->CFG->sesion]["user"]["login"] . "',
						'2',
						'" . $this->get("id") . "',
						'" . $this->get("table") . "',
						NULL,
						'" . $this->db->sql_escape($valAnterior) . "',
						NULL
					)
				");

			}

			$qid=$this->db->sql_query("DELETE FROM " . $this->get("table") . " WHERE " . $this->get("primaryKey") . "=" . $this->get("id"));
		}

		function getRow($marco=0){
			if($row=$this->db->sql_fetchrow($this->sqlQid)){
				$this->loadValues($row);
				$string="<tr ";
				$string.="bgcolor=\"" . $this->rowColor . "\" ";
				if($this->HLRows){
					$string.="onmouseover=\"setPointer(this,'" .  $row[$this->primaryKey] . "', 'over', '" . $this->rowColor . "', '#c9ece8', '#D93333');\" onmouseout=\"setPointer(this,'" . $row[$this->primaryKey] . "', 'out', '" . $this->rowColor . "', '#c9ece8', '#D93333');\"";
				}
				$string.=">";
				$objAttribute=$this->getAttributeByName($this->primaryKey);
				$string.=$objAttribute->getHtmlList();
				for($i=1;$i<sizeof($this->attributes);$i++){
					$objAttribute=$this->attributes[$i];
					if(($objAttribute->browseable && $this->get("longFormat") && $marco==0) || ($marco==1 && $objAttribute->get("shortList"))){
						$string.=$objAttribute->getHtmlList();
					}
				}
				if(!$this->get("iframe")){
					if($this->getNumOfVisibleLinks()>0){
						$string.="<td align='center' width='1'><table><tr bgcolor=\"" . $this->darkBgColor . "\">";
						for($i=0;$i<sizeof($this->links);$i++){
							$objLink=$this->links[$i];
							//if($objLink->popup) $string.=$objLink->getHtml($marco);
							$string.=$objLink->getHtml($marco);
						}
						$string.="</tr></table></td>";
					}
				}
				$string.="</tr>\n";
				return($string);
			}
			else return(FALSE); 
		}

		function getRowAsArray(){
			//echo $this->sqlQid;
			if($row=$this->db->sql_fetchrow($this->sqlQid)){
				$arrayValues=array();
				$this->loadValues($row);
				for($i=0;$i<sizeof($this->attributes);$i++){
					$objAttribute=$this->attributes[$i];
					if($objAttribute->primaryKey || $objAttribute->browseable || $objAttribute->reportable){
						$val=$objAttribute->value;
						$val=preg_replace("/<[^>]*>/"," ",$val);
						$val=html_entity_decode($val);
						array_push($arrayValues,$val);
					}
				}
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if(($objLink->type=="incell" || $objLink->type=="checkbox") && ($objLink->browseable || $objLink->reportable)){
						$strQuery="
							SELECT t2." . $objLink->relatedICField . "
							FROM " . $objLink->relatedTable . " t1 LEFT JOIN " . $objLink->relatedICTable . " t2 ON t1." . $objLink->relatedICIdFieldDos . "=t2.id
							WHERE t1." . $objLink->relatedICIdFieldUno . "='" . $this->id . "'
						";
						$qTemp=$this->db->sql_query($strQuery);
						$arrayVals=array();
						while($result=$this->db->sql_fetchrow($qTemp)){
							array_push($arrayVals,$result[0]);
						}
						array_push($arrayValues,implode(" / ",$arrayVals));
					}
				}
				return($arrayValues);
			}
			else return(FALSE);
		}

		function getRowCSV(){
			//echo $this->sqlQid;
			if($row=$this->db->sql_fetchrow($this->sqlQid)){
				$arrayValues=array();
				$this->loadValues($row);
				for($i=0;$i<sizeof($this->attributes);$i++){
					$objAttribute=$this->attributes[$i];
					if($objAttribute->primaryKey || $objAttribute->browseable || $objAttribute->reportable) array_push($arrayValues,"\"" . html_entity_decode($objAttribute->value) . "\"");
				}
				$string=implode(",",$arrayValues);
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if(($objLink->type=="incell" || $objLink->type=="checkbox") && ($objLink->browseable || $objLink->reportable)){
						$strQuery="
							SELECT t2." . $objLink->relatedICField . "
							FROM " . $objLink->relatedTable . " t1 LEFT JOIN " . $objLink->relatedICTable . " t2 ON t1." . $objLink->relatedICIdFieldDos . "=t2.id
							WHERE t1." . $objLink->relatedICIdFieldUno . "='" . $this->id . "'
						";
						$qTemp=$this->db->sql_query($strQuery);
						$arrayValues=array();
						while($result=$this->db->sql_fetchrow($qTemp)){
							array_push($arrayValues,$result[0]);
						}
						$string.=",\"" . implode(" / ",$arrayValues) . "\"";
					}
				}
				$string.="\n";
				return($string);
			}
			else return(FALSE);
		}

		function getExportRow(){
			if($row=$this->db->sql_fetchrow($this->sqlQid)){
				$this->loadValues($row);
				$arrayValues=array();
				for($i=0;$i<sizeof($this->attributes);$i++){
					$objAttribute=$this->attributes[$i];
					if($objAttribute->browseable) array_push($arrayValues,"\"".$objAttribute->get("value")."\"");
				}
				$string=implode(";",$arrayValues);
				return($string);
			}
			else return(FALSE);	
		}

		function getExportTitleRow(){
			$arrayValues=array();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->browseable) array_push($arrayValues,"\"".$objAttribute->get("label")."\"");
			}
			$string=implode(";",$arrayValues);
			return($string);
		}

		function getTitleRow($marco=0){
//			$string="<tr bgcolor='" . $this->rowColor . "'>";
			$string="<tr bgcolor='" . $this->darkBgColor . "' class='".$this->classTH."'>";
			if($this->editable) $string.="<td></td>";
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($marco==0){
					if($objAttribute->browseable && $this->get("longFormat"))
						$string.=$objAttribute->getHtmlLabel();
				}
				else{
					if($objAttribute->get("shortList"))
						$string.=$objAttribute->getHtmlLabel();
				}
			}
			if($this->getNumOfVisibleLinks() > 0) $string.="<td class='".$this->classTH."' align='center' width='1'><b>OPCIONES</b></td>";
			$string.="</tr>\n";
			return($string);
		}

		function getTitleRowAsArray(){
			$arrayTitle=array();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				$label=$objAttribute->label;
				$label=preg_replace("/<[^>]*>/"," ",$label);
				$label=preg_replace("/ +/"," ",$label);
				if($objAttribute->primaryKey || $objAttribute->browseable || $objAttribute->reportable) array_push($arrayTitle,$label);
			}
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if(($objLink->type=="incell" || $objLink->type=="checkbox") && ($objLink->browseable || $objLink->reportable)){
					array_push($arrayTitle,$objLink->description);
				}
			}
			return($arrayTitle);
		}

		function getTitleRowCSV(){
			$arrayTitle=array();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				$label=$objAttribute->label;
				$label=preg_replace("/<[^>]*>/"," ",$label);
				$label=preg_replace("/ +/"," ",$label);
				if($objAttribute->primaryKey || $objAttribute->browseable || $objAttribute->reportable) array_push($arrayTitle,"\"" . $label . "\"");
			}
			$string=implode(",",$arrayTitle);
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if(($objLink->type=="incell" || $objLink->type=="checkbox") && ($objLink->browseable || $objLink->reportable)){
					$string.=",\"" . $objLink->description . "\"";
				}
			}
			$string.="\n";
			return($string);
		}

		function getNumOfVisibleLinks(){
			$num=0;
			for($i=0;$i<sizeof($this->links);$i++){
				$link=$this->links[$i];
				if($link->get("visible")) $num++;
			}
			return($num);
		}

		function getForm(){
			GLOBAL $CFG, $ME;
			$string="";
			$atributosXFila = $this->get("formColumns");
			
			$contadorAtributos = 0;
			$contadorFilas=0;
			$valor = 0;
			for($i=0;$i<sizeof($this->attributes);$i++)
			{
				$objAttribute=$this->attributes[$i];
				if($objAttribute->primaryKey) $valor=$objAttribute->value;
				if((!$objAttribute->primaryKey || ($objAttribute->primaryKey && $this->mode=='consultar')) && (
							($objAttribute->visible && $objAttribute->parent->mode!='editar' && $objAttribute->parent->mode!='agregar') ||
							($objAttribute->editable && ($objAttribute->parent->mode=='editar' || $objAttribute->parent->mode=='agregar' ))
						)
					)
				{
					if($contadorAtributos == 0)
					{
						if($this->rowColor1!="" && $contadorFilas%2==1) $rowColor=$this->rowColor1;
						else $rowColor=$this->rowColor;

						if($objAttribute->inputType!="hidden") $string .= "\n<tr id='fila_$contadorFilas' bgcolor='" . $rowColor . "'>";
						$contadorAtributos++;
						$contadorFilas++;
					}
					elseif($contadorAtributos < $atributosXFila)
					{
						$contadorAtributos++;
					}
					//preguntar($objAttribute);
					$string .= $objAttribute->getHtml();
					if($contadorAtributos == $atributosXFila)
					{
						if($objAttribute->inputType!="hidden") $string .= "</tr>\n";
						$contadorAtributos = 0;
					}
				}
			}

			$contadorLinks=0;
//			if($this->mode!='agregar'){

			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($this->mode!='agregar' || $objLink->type=="incell" || $objLink->type=="checkbox"){

					if($objLink->type=="iframe" && $objLink->visible && $objLink->showInEdit){
						if($contadorLinks == 0){
							$string .= "<tr bgcolor='" . $this->rowColor . "'>\n";
							$contadorLinks++;
						}
						elseif($contadorLinks < $atributosXFila){
							$contadorLinks++;
						}
						$string .= "<td colspan='2' width='" . (100/$atributosXFila) . "%' bgcolor='".$this->bgColorIFrame."'>\n";
						$string .= "<iframe id='" . $objLink->name . "' src='".$objLink->url."&amp;".$objLink->field."=".$valor;
							if($this->mode=="consultar") $string .= "&amp;consultar";
							$string .= "&amp;iframe' width='100%' height='".$objLink->frameHeight."' frameborder='0'></iframe>";
						$string .= "</td>\n";
						if($contadorLinks == $atributosXFila){
							$string .= "</tr>\n";
							$contadorLinks = 0;
						}
					}
					if($objLink->type=="incell")
					{
						$string .= "<tr bgcolor='" . $this->rowColor . "' align='right'>\n<td>$objLink->name :</td><td align='left' bgcolor='".$this->bgColorIFrame."'>\n";
						$string .= $objLink->pintar_incell();
						$string.= "</td></tr>\n";
					}
					if($objLink->type=="checkbox")
					{
						$string .= "<tr bgcolor='" . $this->rowColor . "' align='right'>\n<td>$objLink->name :</td><td align='left' bgcolor='".$this->bgColorIFrame."'>\n";
						$string .= $objLink->pintar_checkbox();
						$string.= "</td></tr>\n";
					}
				}


			}
			
			return($string);
		}


	function getJavaScript($info)
		{
			global $CFG;
			$string="";
			
			//echo $info;
			if($this->get("editable")){
				if($this->needsAutoComplete){
/*
					$string.="<link href=\"" . $this->CFG->wwwroot . "/autocomplete/autocomplete.css\" rel=\"stylesheet\" type=\"text/css\">\n";
					$string.="<script language=\"javascript\" src=\"" . $this->CFG->wwwroot . "/autocomplete/autocomplete.js\" type=\"text/javascript\"></script>\n";
*/
					$string.='
						<link rel="stylesheet" type="text/css" href="' . $this->ACURL . '/autocomplete/assets/skins/sam/autocomplete.css" />
						<script type="text/javascript" src="' . $this->ACURL . '/yahoo-dom-event/yahoo-dom-event.js"></script>
						<script type="text/javascript" src="' . $this->ACURL . '/connection/connection-min.js"></script>

						<script type="text/javascript" src="' . $this->ACURL . '/datasource/datasource-min.js"></script>
						<script type="text/javascript" src="' . $this->ACURL . '/autocomplete/autocomplete-min.js"></script>

						<style type="text/css">
							.AutoComplete {
					    	width:25em; /* set width here or else widget will expand to fit its container */
					    	padding-bottom:2em;
							}
						</style>
					';
				}
				
				$cont=0;
				$contDos=0;
				/***************************************** codigo de validacion **********************************************************/
				$string.="<script language=\"javascript\" src=\"" . $this->CFG->wwwroot . "/js/jquery.min.js\" type=\"text/javascript\"></script>\n";
				$string.="<script language=\"javascript\" type=\"text/javascript\">\n";
				$string.="function ciudades(id){\n";
				
				$result = mysql_query("SELECT nombre, codigo_pais, id FROM ciudad");
			    $array=mysql_fetch_array($result);
				$string.="ciudades_nombre=new Array();\n ciudades_codigo=new Array();\n ciudades_id=new Array();\n pais_cod=new Array();\n";
			    $string.="ciudades_nombre['$cont']=\"".$array[0]."\";\n";
			    $string.="ciudades_codigo['$cont']=\"".$array[1]."\";\n";
				$string.="ciudades_id['$cont']=\"".$array[2]."\";\n";
		        while($array=mysql_fetch_array($result)){
					++$cont;	
					$string.="ciudades_nombre['$cont']=\"".$array[0]."\";\n";
					$string.="ciudades_codigo['$cont']=\"".$array[1]."\";\n";
					$string.="ciudades_id['$cont']=\"".$array[2]."\";\n";
				}
				
				$resultDos = mysql_query("SELECT codigo_pais FROM paises");
			    $arrayDos=mysql_fetch_array($resultDos);
				$string.="pais_cod['$contDos']=\"".$arrayDos[0]."\";\n";
				
		        while($arrayDos=mysql_fetch_array($resultDos)){
					++$contDos;	
					$string.="pais_cod['$contDos']=\"".$arrayDos["codigo_pais"]."\";\n";
				}
				
				$string.="
				 cod_pais='';
				 for(i=0;i<pais_cod.length;i++){
					 if(i==id){ 
					   cod_pais=pais_cod[i];
					   }
					 }
				 k=0;
		       
				 
				 $('#ciudad option').remove();
				 
				 for(j=0;j<ciudades_codigo.length;++j){
					 if(ciudades_codigo[j]==cod_pais){ 
					    if((j-1)==-1){
							num=0;
						}else{num=ciudades_id[j-1];}
					    $('#ciudad').append(new Option(ciudades_nombre[j], num,true, true));
					   }
					 }
				 $('#ciudad').append(new Option('Otras', '-1',true, true));
				
				}";
				$string.="
				function displayVals() {
					var singleValues = $('#pais').val();
					ciudades(singleValues)
					}
			    $(document).ready(function() {
					$('#pais').change(displayVals);";
				
				
				if($info!="editar"){	
				$string.="\n	$('#pais option:selected').removeAttr('selected');
					$('#ciudad option:selected').removeAttr('selected');";
				}
				
					
				$string.="	
				    $('#pub_publico_areas_css').hide();
					$('#pub_publico_idiomas_css').hide(); \n";
					
				if($info!="consultar"){	
				
				$string.="	if($('#Otras').attr('checked')){
						$('#pub_publico_areas').val($('#otrasAreas').val());
						$('#pub_publico_areas_css').show();
						}else{
							$('#pub_publico_areas').val('');
							}
						
					if($('#Otros').attr('checked')){
						 $('#pub_publico_idiomas').val($('#otrosIdiomas').val());
						 $('#pub_publico_idiomas_css').show();
						}else{
							$('#pub_publico_idiomas').val('');
							} ";
				if($info!="buscar"){			
				$string.="
					$('#Otras').click( 
						function() { 
						
						if($(this).attr('checked')){
							$('#pub_publico_areas_css').show();
						 }else{
						 $('#pub_publico_areas_css').hide();
						 $('#pub_publico_areas').val('');}
						} 
					);
					
					$('#Otros').click( 
						function() { 
						if($(this).attr('checked')){
							$('#pub_publico_idiomas_css').show();
						 }else{
						 $('#pub_publico_idiomas_css').hide();
						 $('#pub_publico_idiomas').val('');}
						} 
					);

$('#pais').append(new Option('Otro', '-1',true, true));
 $('#ciudad').append(new Option('Otras', '-1',true, true));

						if($('#identificacion').val()==''){
							$('#identificacion').val('-');
							}
						
						if($('#cargo').val()==''){
							$('#cargo').val('-');
							}
							
						if($('#telefono1').val()==''){
							$('#telefono1').val('-');
							}	
													
						if($('#resena').val()==''){
							$('#resena').val('-');
							}
								
						if($('#telefono2').val()==''){
							$('#telefono2').val('-');
							}
							
						if($('#email2').val()==''){
							$('#email2').val('-');
							}
							
						if($('#paisOtro').val()==''){
							$('#paisOtro').val('-');
							}
						
						if($('#ciudadOtra').val()==''){
							$('#ciudadOtra').val('-');
							}
								
						if($('#direccion').val()==''){
							$('#direccion').val('-');
							}
							
						if($('#web').val()==''){
							$('#web').val('-');
							}	
							
						if($('#pub_publico_areas').val()==''){
							$('#pub_publico_areas').val('-');
							}	
							
						if($('#pub_publico_idiomas').val()==''){
							$('#pub_publico_idiomas').val('-');
							}	



					$('#Aceptar').click( 
						function() { 				
						 $('#otrasAreas').val($('#pub_publico_areas').val());
						 $('#otrosIdiomas').val($('#pub_publico_idiomas').val());
						} 
					);  
					
					";
				}
					$string.="
					 $('#fila_16').hide();
					 $('#fila_17').hide();
					
					});";
				}else{
					$string.="
					 $('#fila_16').show();
					 $('#fila_17').show();});
      			   ";
					}
				
				$string.="</script>\n";

				$string.='<script type="text/javascript">' . "\n" . '<!--' . "\n";
				if($this->needsGLocation){
					$string.="
						function gLocate(input){
							inputName=input.name;
							formName=input.form.name;
							value=input.value
							width=500;
							height=500;
						  izq=(screen.width-width)/2;
						  arriba=(screen.height-height)/2;
						  ventana='popupGLocation';
							url='gLocation.php?module=" . $this->name . "&formName=' + formName + '&inputName=' + inputName + '&value=' + value;
							eval(\"if(input.form.\" + inputName + \"_zl != undefined) url+='&zoom_level=' + input.form.\" + inputName + \"_zl.value\");
						  vent=window.open(url,ventana,'scrollbars=yes,width=' + width +',height=' + height +',resizable=yes,left='+izq+',top='+arriba);
						  vent.focus();
						}
					";
				}
				if($this->popupsSelect){//Si tiene algún atributo de tipo popupSelect:
	        $string.="
						function psBuscar(select,from,where,order,field,input,edit){
							//select:Los campos (con sus respectivos alias) que se van a mostrar
							//field:El campo asociado al input
						  string='texto=document.entryform.' + input + '__1.value';
							select = select + ', ' + '" . $this->primaryKey . "';
						  eval(string);
						  url='busqueda.php?select=' + select + '&from=' + from + '&where=' + where + '&order=' + order + '&field=' + field + '&input=' + input + '&texto=' + texto + '&edit=' + edit;  
							psPopup(500,400,url);
						}
						function psPopup(width, height, url){
						  izq=(screen.width-width)/2;
						  arriba=(screen.height-height)/2;
						  ventana='popup';
						  vent=window.open(url,ventana,'scrollbars=yes,width=' + width +',height=' + height +',resizable=yes,left='+izq+',top='+arriba);
						  vent.focus();
	  				}
						function psEnviar(){
						  document.entryform.method='GET';
						  document.entryform.mode.value='" . $this->mode . "';
						  document.entryform.submit();
						} 
         ";
        }
				if($this->needsACPopup){//SI el AutoComplete necesita popup
					$string.="function addACPopup(module,inputName){\n";
					$string.="\tstring='ventana_' + module;\n";
					$string.="\teval(string + \"=abrirVentanaNueva('" . $this->CFG->ME . "?module=\" + module + \"&inputName=\" + inputName + \"&mode=agregar&callerModule=" . $this->name . "','ventana_\" + module + \"',700,500)\");\n";
					$string.="\teval(string + \".focus()\");\n";
					$string.="\treturn;\n";
					$string.="}\n";
				}
			   
				$string.="function addForeignItem(module,inputName,foreignTable,foreignField,foreignLabelFields){\n";
				$string.="\tstring='ventana_' + module;\n";
				$string.="\teval(string + \"=abrirVentanaNueva('" . $this->CFG->ME . "?module=\" + module + \"&inputName=\" + inputName + \"&foreignTable=\" + foreignTable + \"&foreignField=\" + foreignField + \"&foreignLabelFields=\" + foreignLabelFields + \"&mode=agregar','ventana_\" + module + \"',700,500)\");\n";
				$string.="\teval(string + \".focus()\");\n";
				$string.="\treturn;\n";
				$string.="}\n";
				$string.="function abrir(campo){\n";
			    $string.="ruta='".$CFG->wwwroot."/calendario/calendar.php?formulario=entryform&nomcampo=' + campo;\n";
			    $string.="ventana = 'v_calendar';\n";
                $string.="window.open(ruta,ventana,'scrollbars=yes,width=250,height=350,screenX=100,screenY=100');\n";
                $string.="}\n";
				$string.="function abrirWHora(campo){\n";
				$string.="ruta='".$CFG->wwwroot."/calendario/calendarAndHora.php?formulario=entryform&nomcampo=' + campo + '&mode=". $this->mode ."';\n";
				$string.="ventana = 'v_calendar';\n";
				$string.="window.open(ruta,ventana,'scrollbars=yes,width=250,height=400,screenX=100,screenY=100');\n";
				$string.="}\n";
				$string.='function revisar(){' . "\n";
				if($this->mode!="buscar"){
					for($i=0;$i<sizeof($this->attributes);$i++){
						$objAttribute=$this->attributes[$i];
//						if($objAttribute->get("visible") && $objAttribute->get("editable"))
//	OJO: TENGO QUE REVISAR POR QUË RAZÓN ACÁ VIENE VACÍO EL editable...
						if($objAttribute->get("visible"))
						{	
							$string.=$objAttribute->getJavaScript();
						}
						if($objAttribute->get("jsrevision")!= "")
						{
							$string.=$objAttribute->getJSCampoObligatorio();
						}	
					}
				}
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if($objLink->type=="incell"){
						$string.="incell_" . $objLink->relatedTable . "=document.getElementById('PickList_" . $objLink->relatedTable . "');\n";
						$string.="for(i=0;i<incell_" . $objLink->relatedTable . ".options.length;i++){\n";
						$string.="\tincell_" . $objLink->relatedTable . ".options[i].selected=true;\n";
						$string.="}\n";
					}
				}
				$string.=$this->JSComplementaryRevision;
				$string.="return(true);\n";
				$string.="}\n\n";
				if($this->selectDependiente){
					$string.="
						function GetHttpObject(handler){
							try
							{
								var oRequester = new ActiveXObject(\"Microsoft.XMLHTTP\");
								oRequester.onreadystatechange=handler;
								return oRequester;
							}
							catch (error){
								try{
									var oRequester = new XMLHttpRequest();
									oRequester.onload=handler;
									oRequester.onerror=handler;
									return oRequester;
								}
								catch (error){
									return false;
								}
							}
						}
					";

					for($i=0;$i<sizeof($this->attributes);$i++){
						$objAttribute=$this->attributes[$i];
						if($objAttribute->get("inputType")=="select_dependiente")
						{	

							$string.="
								var oXmlHttp_" . $objAttribute->get("field") . ";
								function updateRecursive_" . $objAttribute->get("field") . "(select){
									namediv='" . $objAttribute->get("namediv") . "';
									nameId='" . $objAttribute->get("field") . "';
									id=select.options[select.selectedIndex].value;
									width=document.getElementById(nameId).style.width;
									consulta='SELECT id, " . addslashes($objAttribute->get("foreignLabelFields")) . " FROM " . preg_replace("/[\n\r]/"," ",addslashes($objAttribute->get("foreignTable"))) . " WHERE " . $objAttribute->get("fieldIdParent") . "=\'' + id + '\'';
									document.getElementById(namediv).innerHTML='<select id=\"' + nameId + '\" style=\"width:' + document.getElementById(nameId).style.width + '\"><option>Actualizando...<\/select>';
									var consulta;
									query=escape(consulta);
//									var url=\"".$CFG->wwwroot."/lib/ajaxUpdateRecursive.php?module=" . $this->name . "&field=" . $objAttribute->get("field") . "&id=\" + id + \"&divid=\" + nameId + \"&width=\" + width;
									var url=\"".$CFG->wwwroot."/lib/ajaxUpdateRecursive.php?module=" . $this->name . "&field=" . $objAttribute->get("field") . "&id=\" + id + \"&divid=\" + namediv + \"&width=\" + width;
									oXmlHttp_" . $objAttribute->get("field") . "=GetHttpObject(cambiarRecursive_" . $objAttribute->get("field") . ");
									oXmlHttp_" . $objAttribute->get("field") . ".open(\"GET\", url , true);
									oXmlHttp_" . $objAttribute->get("field") . ".send(null);
								}
								function cambiarRecursive_" . $objAttribute->get("field") . "(){
									if (oXmlHttp_" . $objAttribute->get("field") . ".readyState==4 || oXmlHttp_" . $objAttribute->get("field") . ".readyState==\"complete\"){
										document.getElementById('" . $objAttribute->get("namediv") . "').innerHTML=oXmlHttp_" . $objAttribute->get("field") . ".responseText
									}
								}
							\n";
						}	
					}

				}
				
				$string.="-->\n</script>\n";
				if($this->needsWYSIWYG){
					$string.="<script type=\"text/javascript\" src=\"" . $this->CFG->wwwroot . "/ckeditor/ckeditor.js\"></script>\n";
				}

			}
			return($string);
		}



/***** ***/
function getJavaScriptDos()
		{
			global $CFG;
			$string="";
			if($this->get("editable")){
				if($this->needsAutoComplete){
/*
					$string.="<link href=\"" . $this->CFG->wwwroot . "/autocomplete/autocomplete.css\" rel=\"stylesheet\" type=\"text/css\">\n";
					$string.="<script language=\"javascript\" src=\"" . $this->CFG->wwwroot . "/autocomplete/autocomplete.js\" type=\"text/javascript\"></script>\n";
*/
					$string.='
						<link rel="stylesheet" type="text/css" href="' . $this->ACURL . '/autocomplete/assets/skins/sam/autocomplete.css" />
						<script type="text/javascript" src="' . $this->ACURL . '/yahoo-dom-event/yahoo-dom-event.js"></script>
						<script type="text/javascript" src="' . $this->ACURL . '/connection/connection-min.js"></script>

						<script type="text/javascript" src="' . $this->ACURL . '/datasource/datasource-min.js"></script>
						<script type="text/javascript" src="' . $this->ACURL . '/autocomplete/autocomplete-min.js"></script>

						<style type="text/css">
							.AutoComplete {
					    	width:25em; /* set width here or else widget will expand to fit its container */
					    	padding-bottom:2em;
							}
						</style>
					';
				}
				
				$cont=0;
				$contDos=0;
				/***************************************** codigo de validacion **********************************************************/
				$string.="<script language=\"javascript\" src=\"" . $this->CFG->wwwroot . "/js/jquery.min.js\" type=\"text/javascript\"></script>\n";
				$string.="<script language=\"javascript\" type=\"text/javascript\">\n";
				$string.="function ciudades(id){\n";
				
				$result = mysql_query("SELECT nombre, codigo_pais, id FROM ciudad");
			    $array=mysql_fetch_array($result);
				$string.="ciudades_nombre=new Array();\n ciudades_codigo=new Array();\n ciudades_id=new Array();\n pais_cod=new Array();\n";
			    $string.="ciudades_nombre['$cont']=\"".$array[0]."\";\n";
			    $string.="ciudades_codigo['$cont']=\"".$array[1]."\";\n";
				$string.="ciudades_id['$cont']=\"".$array[2]."\";\n";
		        while($array=mysql_fetch_array($result)){
					++$cont;	
					$string.="ciudades_nombre['$cont']=\"".$array[0]."\";\n";
					$string.="ciudades_codigo['$cont']=\"".$array[1]."\";\n";
					$string.="ciudades_id['$cont']=\"".$array[2]."\";\n";
				}
				
				$resultDos = mysql_query("SELECT codigo_pais FROM paises");
			    $arrayDos=mysql_fetch_array($resultDos);
				$string.="pais_cod['$contDos']=\"".$arrayDos[0]."\";\n";
				
		        while($arrayDos=mysql_fetch_array($resultDos)){
					++$contDos;	
					$string.="pais_cod['$contDos']=\"".$arrayDos["codigo_pais"]."\";\n";
				}
				
				$string.="
				 cod_pais='';
				 for(i=0;i<pais_cod.length;i++){
					 if(i==id){ 
					   cod_pais=pais_cod[i];
					   }
					 }
				 k=0;
		       
				 
				 $('#ciudad option').remove();
				 
				 for(j=0;j<ciudades_codigo.length;++j){
					 if(ciudades_codigo[j]==cod_pais){ 
					    if((j-1)==-1){
							num=0;
						}else{num=ciudades_id[j-1];}
					    $('#ciudad').append(new Option(ciudades_nombre[j], num,true, true));
					   }
					 }
				   $('#ciudad').append(new Option(\"Otros\", num,true, true));
				
				}";
				$string.="
				function displayVals() {
					var singleValues = $(\"#pais\").val();
					ciudades(singleValues)
					}
			    $(document).ready(function() {
					$(\"#pais\").change(displayVals);
					$(\"#pub_publico_areas_css\").hide();
					$(\"#pub_publico_idiomas_css\").hide();
					
					if($('#Otras').attr('checked')){
						$('#pub_publico_areas').val($('#otrasAreas').val());
						$('#pub_publico_areas_css').show();
						}
						
					if($(\"#Otros\").attr('checked')){
						 $('#pub_publico_idiomas').val($('#otrosIdiomas').val());
						 $(\"#pub_publico_idiomas_css\").show();
						} 
						
					
					$(\"#Otras\").click( 
						function() { 
						if($(this).attr('checked')){
						 $(\"#pub_publico_areas_css\").show();
						 }else{
						 $(\"#pub_publico_areas_css\").hide();}
						} 
					);
					
					$(\"#Otros\").click( 
						function() { 
						if($(this).attr('checked')){
						 $(\"#pub_publico_idiomas_css\").show();
						 }else{
						 $(\"#pub_publico_idiomas_css\").hide();}
						} 
					);

					$(\"#Aceptar\").click( 
						function() { 
						 $('#otrasAreas').val($('#pub_publico_areas').val());
						 $('#otrosIdiomas').val($('#pub_publico_idiomas').val());
						} 
					);
					
				     //$(\"#fila_14\").hide();
					 //$(\"#fila_15\").hide();
					
					});";
				$string.="</script>\n";

				$string.='<script type="text/javascript">' . "\n" . '<!--' . "\n";
				if($this->needsGLocation){
					$string.="
						function gLocate(input){
							inputName=input.name;
							formName=input.form.name;
							value=input.value
							width=500;
							height=500;
						  izq=(screen.width-width)/2;
						  arriba=(screen.height-height)/2;
						  ventana='popupGLocation';
							url='gLocation.php?module=" . $this->name . "&formName=' + formName + '&inputName=' + inputName + '&value=' + value;
							eval(\"if(input.form.\" + inputName + \"_zl != undefined) url+='&zoom_level=' + input.form.\" + inputName + \"_zl.value\");
						  vent=window.open(url,ventana,'scrollbars=yes,width=' + width +',height=' + height +',resizable=yes,left='+izq+',top='+arriba);
						  vent.focus();
						}
					";
				}
				if($this->popupsSelect){//Si tiene algún atributo de tipo popupSelect:
	        $string.="
						function psBuscar(select,from,where,order,field,input,edit){
							//select:Los campos (con sus respectivos alias) que se van a mostrar
							//field:El campo asociado al input
						  string='texto=document.entryform.' + input + '__1.value';
							select = select + ', ' + '" . $this->primaryKey . "';
						  eval(string);
						  url='busqueda.php?select=' + select + '&from=' + from + '&where=' + where + '&order=' + order + '&field=' + field + '&input=' + input + '&texto=' + texto + '&edit=' + edit;  
							psPopup(500,400,url);
						}
						function psPopup(width, height, url){
						  izq=(screen.width-width)/2;
						  arriba=(screen.height-height)/2;
						  ventana='popup';
						  vent=window.open(url,ventana,'scrollbars=yes,width=' + width +',height=' + height +',resizable=yes,left='+izq+',top='+arriba);
						  vent.focus();
	  				}
						function psEnviar(){
						  document.entryform.method='GET';
						  document.entryform.mode.value='" . $this->mode . "';
						  document.entryform.submit();
						} 
         ";
        }
				if($this->needsACPopup){//SI el AutoComplete necesita popup
					$string.="function addACPopup(module,inputName){\n";
					$string.="\tstring='ventana_' + module;\n";
					$string.="\teval(string + \"=abrirVentanaNueva('" . $this->CFG->ME . "?module=\" + module + \"&inputName=\" + inputName + \"&mode=agregar&callerModule=" . $this->name . "','ventana_\" + module + \"',700,500)\");\n";
					$string.="\teval(string + \".focus()\");\n";
					$string.="\treturn;\n";
					$string.="}\n";
				}
			   
				$string.="function addForeignItem(module,inputName,foreignTable,foreignField,foreignLabelFields){\n";
				$string.="\tstring='ventana_' + module;\n";
				$string.="\teval(string + \"=abrirVentanaNueva('" . $this->CFG->ME . "?module=\" + module + \"&inputName=\" + inputName + \"&foreignTable=\" + foreignTable + \"&foreignField=\" + foreignField + \"&foreignLabelFields=\" + foreignLabelFields + \"&mode=agregar','ventana_\" + module + \"',700,500)\");\n";
				$string.="\teval(string + \".focus()\");\n";
				$string.="\treturn;\n";
				$string.="}\n";
				$string.="function abrir(campo){\n";
			    $string.="ruta='".$CFG->wwwroot."/calendario/calendar.php?formulario=entryform&nomcampo=' + campo;\n";
			    $string.="ventana = 'v_calendar';\n";
                $string.="window.open(ruta,ventana,'scrollbars=yes,width=250,height=350,screenX=100,screenY=100');\n";
                $string.="}\n";
				$string.="function abrirWHora(campo){\n";
				$string.="ruta='".$CFG->wwwroot."/calendario/calendarAndHora.php?formulario=entryform&nomcampo=' + campo + '&mode=". $this->mode ."';\n";
				$string.="ventana = 'v_calendar';\n";
				$string.="window.open(ruta,ventana,'scrollbars=yes,width=250,height=400,screenX=100,screenY=100');\n";
				$string.="}\n";
				$string.='function revisar(){' . "\n";
				if($this->mode!="buscar"){
					for($i=0;$i<sizeof($this->attributes);$i++){
						$objAttribute=$this->attributes[$i];
//						if($objAttribute->get("visible") && $objAttribute->get("editable"))
//	OJO: TENGO QUE REVISAR POR QUË RAZÓN ACÁ VIENE VACÍO EL editable...
						if($objAttribute->get("visible"))
						{	
							$string.=$objAttribute->getJavaScript();
						}
						if($objAttribute->get("jsrevision")!= "")
						{
							$string.=$objAttribute->getJSCampoObligatorio();
						}	
					}
				}
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if($objLink->type=="incell"){
						$string.="incell_" . $objLink->relatedTable . "=document.getElementById('PickList_" . $objLink->relatedTable . "');\n";
						$string.="for(i=0;i<incell_" . $objLink->relatedTable . ".options.length;i++){\n";
						$string.="\tincell_" . $objLink->relatedTable . ".options[i].selected=true;\n";
						$string.="}\n";
					}
				}
				$string.=$this->JSComplementaryRevision;
				$string.="return(true);\n";
				$string.="}\n\n";
				if($this->selectDependiente){
					$string.="
						function GetHttpObject(handler){
							try
							{
								var oRequester = new ActiveXObject(\"Microsoft.XMLHTTP\");
								oRequester.onreadystatechange=handler;
								return oRequester;
							}
							catch (error){
								try{
									var oRequester = new XMLHttpRequest();
									oRequester.onload=handler;
									oRequester.onerror=handler;
									return oRequester;
								}
								catch (error){
									return false;
								}
							}
						}
					";

					for($i=0;$i<sizeof($this->attributes);$i++){
						$objAttribute=$this->attributes[$i];
						if($objAttribute->get("inputType")=="select_dependiente")
						{	

							$string.="
								var oXmlHttp_" . $objAttribute->get("field") . ";
								function updateRecursive_" . $objAttribute->get("field") . "(select){
									namediv='" . $objAttribute->get("namediv") . "';
									nameId='" . $objAttribute->get("field") . "';
									id=select.options[select.selectedIndex].value;
									width=document.getElementById(nameId).style.width;
									consulta='SELECT id, " . addslashes($objAttribute->get("foreignLabelFields")) . " FROM " . preg_replace("/[\n\r]/"," ",addslashes($objAttribute->get("foreignTable"))) . " WHERE " . $objAttribute->get("fieldIdParent") . "=\'' + id + '\'';
									document.getElementById(namediv).innerHTML='<select id=\"' + nameId + '\" style=\"width:' + document.getElementById(nameId).style.width + '\"><option>Actualizando...<\/select>';
									var consulta;
									query=escape(consulta);
//									var url=\"".$CFG->wwwroot."/lib/ajaxUpdateRecursive.php?module=" . $this->name . "&field=" . $objAttribute->get("field") . "&id=\" + id + \"&divid=\" + nameId + \"&width=\" + width;
									var url=\"".$CFG->wwwroot."/lib/ajaxUpdateRecursive.php?module=" . $this->name . "&field=" . $objAttribute->get("field") . "&id=\" + id + \"&divid=\" + namediv + \"&width=\" + width;
									oXmlHttp_" . $objAttribute->get("field") . "=GetHttpObject(cambiarRecursive_" . $objAttribute->get("field") . ");
									oXmlHttp_" . $objAttribute->get("field") . ".open(\"GET\", url , true);
									oXmlHttp_" . $objAttribute->get("field") . ".send(null);
								}
								function cambiarRecursive_" . $objAttribute->get("field") . "(){
									if (oXmlHttp_" . $objAttribute->get("field") . ".readyState==4 || oXmlHttp_" . $objAttribute->get("field") . ".readyState==\"complete\"){
										document.getElementById('" . $objAttribute->get("namediv") . "').innerHTML=oXmlHttp_" . $objAttribute->get("field") . ".responseText
									}
								}
							\n";
						}	
					}

				}
				
				$string.="-->\n</script>\n";
				if($this->needsWYSIWYG){
					$string.="<script type=\"text/javascript\" src=\"" . $this->CFG->wwwroot . "/ckeditor/ckeditor.js\"></script>\n";
				}

			}
			return($string);
		}

		function getLinkIframe(){
				$cont=0;
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if($objLink->type=="iframe" && $objLink->showInEdit){
						$cont++;		
					}
				}
				return($cont);
		}

		function getLinkPopup(){
				$cont=0;
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if($objLink->popup==TRUE){
						$cont++;		
					}
				}
				return($cont);
		}
			
		function printBusqueda(){
			$rowColor=$this->rowColor;
			$string="";
			$atributosXFila = $this->get("formColumns");
			$contadorAtributos = 0;
			$contadorFilas = 0;
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->searchable && $objAttribute->visible){
					if($objAttribute->get("sqlType")!="geometry") 
					{
						if($contadorAtributos == 0)
						{
							if($this->rowColor1!="" && $contadorFilas%2==1) $rowColor=$this->rowColor1;
							else $rowColor=$this->rowColor;
							$string .= "\n<tr bgcolor='" . $rowColor . "'  id='fila_$contadorFilas' ASD>";
							$contadorAtributos++;
							$contadorFilas++;
						}
						elseif($contadorAtributos < $atributosXFila)
						{
							$contadorAtributos++;
						}
						$string .= $objAttribute->getHtml();
						if($contadorAtributos == $atributosXFila)
						{
							$string .= "</tr>\n";
							$contadorAtributos = 0;
						}
					}
				}
			}
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($objLink->type=="incell" || $objLink->type=="checkbox"){
					if($objLink->type=="incell")
					{
						$string .= "<tr bgcolor='" . $this->rowColor . "' align='right'>\n<td>$objLink->name :</td><td align='left' bgcolor='".$this->bgColorIFrame."'>\n";
						$string .= $objLink->pintar_incell();
						$string.= "</td></tr>\n";
					}
					if($objLink->type=="checkbox")
					{
						$string .= "<tr bgcolor='" . $this->rowColor . "' align='right'>\n<td>$objLink->name :</td><td align='left' bgcolor='".$this->bgColorIFrame."'>\n";
						$string .= $objLink->pintar_checkbox();
						$string.= "</td></tr>\n";
					}
				}


			}
			return($string);
		}

		function set($attribute,$value){
			if(in_array($attribute,array_keys(get_object_vars($this)))){
				$this->$attribute=$value;
			}
			else return(FALSE);
//			else die("<br>El atributo [" . $attribute . "] no existe.<br>");
		}

		function get($attribute){
			if(in_array($attribute,array_keys(get_object_vars($this)))) return($this->$attribute);
			else die("<br>El atributo [" . $attribute . "] no existe.");
		}

		function findPath(){
			GLOBAL $CFG;
			$rep=0;
			if(isset($_SESSION[$CFG->sesion]['path'])){
				$_SESSION[$CFG->sesion]['contador']++;
				$contador=$_SESSION[$CFG->sesion]['contador'];
				for($i=1;$i<$contador;$i++){
					if($this->labelModule=="")
						$nombre=$this->name;
					else
						$nombre=$this->labelModule;
					if($_SESSION[$CFG->sesion]['path'][$i]['module']=="$nombre"){
						$rep=1;
						$delete=$i;
					}
					if($rep==1){
						if($delete<$i)
							unset($_SESSION[$CFG->sesion]['path'][$i]);
						$_SESSION[$CFG->sesion]['contador']=$delete;
					}
				}
			}
			else{
				$_SESSION[$CFG->sesion]['path']=array();
				$_SESSION[$CFG->sesion]['contador']=0;
				$contador=$_SESSION[$CFG->sesion]['contador'];
			}

			if($contador!=0 && $rep!=1){
				$_SESSION[$CFG->sesion]['path'][$contador]=array();
				if($this->labelModule=="")
					$_SESSION[$CFG->sesion]['path'][$contador]['module']="$this->name";
				else
					$_SESSION[$CFG->sesion]['path'][$contador]['module']="$this->labelModule";
				$_SESSION[$CFG->sesion]['path'][$contador]['url']="$_SERVER[REQUEST_URI]";
			}
			return($_SESSION[$CFG->sesion]);
		}

		function cleanValues()
		{
			for($i=0;$i<sizeof($this->attributes);$i++)
			{
				$objAttribute=$this->attributes[$i];
				$objAttribute->value="";
		
			}
		}
/*
		function averiguarDato($objAttribute)
		{
			//SELECT * FROM NombreLinkedServer.NombreBaseDeDatos.NombreOwner.N ombreTabla

			$consulta = "SELECT DISTINCT (" . $objAttribute->ACLabel . ") as valor FROM " . $objAttribute->ACFrom . " WHERE " . $objAttribute->ACIdField . " = " . $this->table . "." . $objAttribute->field; 
			echo $consulta;
			$qid = $objAttribute->ACbd->sql_query($consulta);

			$query = $objAttribute->ACbd->sql_fetchrow($qid);
			return($query["valor"]);
		
		}
*/
		
	}	
?>
