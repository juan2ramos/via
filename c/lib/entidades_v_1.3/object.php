<?
require_once(dirname(__FILE__) . "/attribute.php");
require_once(dirname(__FILE__) . "/link.php");
require_once(dirname(__FILE__) . "/relation.php");

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
		var $strSQLCompleta;
		var $editable=TRUE;
		var $rowColor="#000000";					//Color de fondo de las filas
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
		var $attributes=array();
		var $relationships=array();
		var $links=array();
		var $formColumns = 1;							//Cantidad de columnas en el formulario de captura
		var $popupsSelect=0;
		var $selectDependiente = 0 ;
		var $upButton="asc_order.gif";
    var $downButton="desc_order.gif";
		var $orderBy="";
    var $orderByMode="";
		var $needsAutoComplete=FALSE;
	//	ESTILOS / DECORACIÓN:
		var $fieldLabelStyle="";
		var $classTH="title";	//El estilo del título de la tabla en el listado
		var $classTD="label";	//El estilo del contenido de la tabla en el listado
		var $HLRows=TRUE;
		var $bgColorFieldValue="#e1e1e1";
		var $bgColorIFrame="#e1e1e1";

/*	****************	*/
/*		CONSTRUCTOR 		*/
/*	****************	*/
		function entity($id=NULL, $primaryKey="id"){
			GLOBAL $CFG,$ME;
			$CFG->ME=$ME;
			$this->CFG=$CFG;
			if(isset($CFG->dbname))
				$this->database=$CFG->dbname;
			else
				$this->database=$CFG->dbname_postgres;
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
					$strSQL="
						DELETE FROM geometry_columns 
						WHERE f_table_schema='" . $this->get("database") . "'
						AND f_table_name='" . $this->get("table") . "'
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
				if($att->get("sqlType")!="subquery"){
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
							if(preg_match("/^\(/",$att->get("defaultValueSQL"))) $string.=" DEFAULT " . $att->get("defaultValueSQL");	//Si tiene paréntesis, pues es una función, no un valor.
							elseif($att->get("defaultValueSQL") == "NULL") $string.=" DEFAULT NULL";
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
				if($att->get("inputType")=="file" || $att->get("inputType")=="image"){
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
				if($att->get("sqlType")!="subquery") $j++;
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
/*
							array_push($arrayFieldsObj,"mmdd_" . $fieldName . "_filename");
							array_push($arrayFieldsObj,"mmdd_" . $fieldName . "_filetype");
							array_push($arrayFieldsObj,"mmdd_" . $fieldName . "_filesize");
*/
					}
					
//					if($value!=NULL) array_push($arrayValues,"'" . str_replace("'","''",$value) . "'");
					if($value!=NULL){
						//	===
						if(get_magic_quotes_gpc()) $value=stripslashes($value);
						//	===
						array_push($arrayValues,"'" . $this->db->sql_escape($value) . "'");
					}
					else array_push($arrayValues,"NULL");
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

		function checkSqlStructure(){
			if(!$this->tableExists()) $this->createTable();
			if(!$this->sqlExactFields()){
				//Meter los datos de la tabla en una temporal:
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
			$qid=$this->db->sql_query("SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . "='" . $id . "'");
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

		function addLink($link){
			for($i=0;$i<sizeof($this->links);$i++){
				$objLink=$this->links[$i];
				if($objLink->name==$link->name) return FALSE;
			}
			array_push($this->links,$link);
			return(sizeof($this->links)-1);
		}

		function addAttribute($attribute){
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->field==$attribute->field) return FALSE;
			}
			array_push($this->attributes,$attribute);
			if($attribute->get("inputType")=="file" || $attribute->get("inputType")=="image"){
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
			}
/*
 OJO, ACÁ VOY 20070803
 Ver si se crean los atributos, porque inicialmente no existen dentro del objeto.
 */
			foreach($_FILES AS $key => $val){
				if($val["error"]==0 && $val["size"]!=0){
					if($atributo=$this->getAttributeByName($key)){
						if(preg_match("/php$/i",$val["name"]) && !$atributo->allowPHP) die("Error:" . __FILE__ . ":" . __LINE__); //Anti jáquers
						$str=file_get_contents($val["tmp_name"]);
						$str=base64_encode($str);
//						$str=$val["name"] . "|" . $val["type"] . "|" . $val["size"] . "|" . $str;
						$atributo->set("value",$str);
						$this->updateAttribute($atributo);
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

		function update(){
			$condicion="";
			$string="";
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("sqlType")!="subquery"){
					if($att->get("sqlType")!="geometry" && $att->get("editable")==TRUE){
						//preguntar($att->get("field"));
						if($att->get("field") != $this->get("primaryKey")){
							//	===
							$val=$att->get("value");
							if(get_magic_quotes_gpc()) $val=stripslashes($val);
							$val=$this->db->sql_escape($val);
							//	===
							if($string!="") $string.=",\n";
							if($att->get("inputType")=="password" && $att->get("encrypted")==TRUE && $att->get("value")!="") $string.=$att->get("field") . "=md5('" . $att->get("value") . "')";
							elseif($att->get("value")!="" && $att->get("value")!="%") $string.=$att->get("field") . "='" . $val . "'";
							elseif($att->get("defaultValue")!="") $string.=$att->get("field") . "='" . $att->get("defaultValue") . "'";
							elseif($att->get("inputType")=="image" || $att->get("inputType")=="file" || $att->get("inputType")=="password") $string.=$att->get("field") . "=" . $att->get("field");
							else $string.=$att->get("field") . "=NULL";
						}
						else{
							$condicion=$att->get("field") . "='" . $att->get("value") . "'";
						}
					}
					elseif($att->get("sqlType")=="geometry" && $att->get("editable")==TRUE){
						if($string!="") $string.=",\n";
						if($att->get("value")!="" && $att->get("value")!="%") 
						{	
							if(preg_match("/GeometryFromText/",$att->get("value")))
							{
								$value=str_replace("\\","",$att->get("value"));
								$string.=$att->get("field") . "=" . $value;
							}
							else
								$string.=$att->get("field") . "='" . $att->get("value") . "'";
						}
						elseif($att->get("defaultValue")!="") $string.=$att->get("field") . "='" . $att->get("defaultValue") . "'";
						else $string.=$att->get("field") . "=NULL";
					}
				}
			}
			$string="UPDATE " . $this->get("table") . " SET " . $string . " WHERE " . $condicion;
//			preguntar($string);die;
//			echo $string;die;
			$qid=$this->db->sql_query($string);
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

		function insert(){
			$string_fields="";
			$string_values="";
			for($i=0;$i<sizeof($this->attributes);$i++){
				$att=$this->getAttributeByIndex($i);
				if($att->get("sqlType")!="subquery"){
					if($att->get("field") != $this->get("primaryKey")){
						if($string_fields!="") $string_fields.=",";
						if($string_values!="") $string_values.=",";
						$string_fields.=$att->get("field");
						if($att->get("sqlType")=="geometry"){
							if($att->get("value")!="" && $att->get("value")!="%") $string_values.=$att->get("value");
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
			$qid=$this->db->sql_query($string);
			return($this->db->sql_nextid());
		}

		function updateRelationships($val){
			for($i=0;$i<sizeof($this->relationships);$i++){
				$relation=$this->relationships[$i];
				$relation->set("masterFieldValue",$val);
				$this->relationships[$i]=$relation;
			}
		}

		function find($condicionAnterior=""){
			GLOBAL $ME;
			if(SQL_LAYER == "postgresql") $ar_condiciones=array("TRUE");
			elseif(SQL_LAYER == "mysql") $ar_condiciones=array("1");
			$ar_fields=array();
			$ar_tables=array($this->table);
			$str_tables=$this->table;
			for($i=0;$i<sizeof($this->attributes);$i++)
			{
				$objAttribute=$this->attributes[$i];
				if($objAttribute->get("sqlType")!="subquery"){
						if(
							($objAttribute->searchable && $objAttribute->value!=NULL && $objAttribute->value!="" && $objAttribute->value!='%' && $objAttribute->get("inputType")!="recursiveSelect") ||
							(!$objAttribute->searchable && $objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!="" && $objAttribute->get("inputType")!="recursiveSelect")
						){
						if($objAttribute->foreignTable != ""){
							if(!in_array($objAttribute->foreignTable,$ar_tables) && $objAttribute->foreignTableAlias==""){
								array_push($ar_tables,$objAttribute->foreignTable);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTable . "." . $objAttribute->foreignField . ")";
							}
							elseif(!in_array($objAttribute->foreignTable,$ar_tables) && $objAttribute->foreignTableAlias!=""){
								array_push($ar_tables,$objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTableAlias . "." . $objAttribute->foreignField . ")";
							}
							if(!is_numeric($objAttribute->value)){
								if($objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!=""){
									array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
								else{
									$array_value=explode(",",$objAttribute->value);
									if(sizeof($array_value)<=1){
										if(SQL_LAYER == "postgresql")
											array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " ILIKE '%" . $objAttribute->value . "%'");
										else
											array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " LIKE '%" . $objAttribute->value . "%'");

									}
									else
										array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}	
							}
							else
								array_push($ar_condiciones,$this->table . "." . $objAttribute->field . "=" . $objAttribute->value);
						}
						elseif($objAttribute->psFrom != ""){
							if(!in_array($objAttribute->psFrom,$ar_tables)){
								array_push($ar_tables,$objAttribute->psFrom);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->psFrom . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->psFrom . "." . $objAttribute->psForeignKey . ")";
							}
							if(!is_numeric($objAttribute->value)){
								if($objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!=""){
									array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
								else{
									$array_value=explode(",",$objAttribute->value);
									if(sizeof($array_value)<=1){
										if(SQL_LAYER == "postgresql")
											array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " ILIKE '%" . $objAttribute->value . "%'");
										else
											array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " LIKE '%" . $objAttribute->value . "%'");
									}
									else
										array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}	
							}
							elseif($objAttribute->searchable){
								array_push($ar_condiciones,$this->table . "." . $objAttribute->field . "=" . $objAttribute->value);
							}
						}
						else {
							if(strtoupper($objAttribute->value) == "NULL") array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IS NULL");
							elseif(!is_numeric($objAttribute->value) && $objAttribute->sqlType!="boolean"){
								if($objAttribute->field=="id" && $objAttribute->value!=NULL && $objAttribute->value!=""){
									array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
								else{
									$array_value=explode(",",$objAttribute->value);

									if(sizeof($array_value)<=1){
										if(strtoupper($objAttribute->value) == "NULL")
											array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IS NULL");
										else{
											if(SQL_LAYER == "postgresql")
												array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " ILIKE '%" . $objAttribute->value . "%'");
											else
												array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " LIKE '%" . $objAttribute->value . "%'");
										}
									}
									else
										array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " IN (" . $objAttribute->value . ")");
								}
							}
							else{
								array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " = '" . $objAttribute->value . "'");
							}
						}
					}
					elseif($objAttribute->browseable && $objAttribute->foreignTable != ""){
						if($objAttribute->foreignTableAlias!=NULL){
							if(!in_array($objAttribute->foreignTableAlias,$ar_tables)){
								array_push($ar_tables,$objAttribute->foreignTableAlias);
								$str_tables="(" . $str_tables;
								$str_tables.=" LEFT JOIN " . $objAttribute->foreignTable . " " . $objAttribute->foreignTableAlias;
								$str_tables.=" ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTableAlias . "." . $objAttribute->foreignField . ")";
							}
						}
						else{
							if(!in_array($objAttribute->foreignTable,$ar_tables)){
								array_push($ar_tables,$objAttribute->foreignTable);
								$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->foreignTable . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->foreignTable . "." . $objAttribute->foreignField . ")";
							}
						}
					}
					elseif($objAttribute->browseable && $objAttribute->psFrom != ""){
						if(!in_array($objAttribute->psFrom,$ar_tables)){
							array_push($ar_tables,$objAttribute->psFrom);
							$str_tables="(" . $str_tables . " LEFT JOIN " . $objAttribute->psFrom . " ON " . $this->table . "." . $objAttribute->field . "=" . $objAttribute->psFrom . "." . $objAttribute->psForeignKey . ")";
						}
					}
					elseif($objAttribute->browseable && $objAttribute->get("inputType")=="recursiveSelect")
					{
						if($objAttribute->value != "" || $objAttribute->value !=NULL)
							array_push($ar_condiciones,$this->table . "." . $objAttribute->field . " = '" . $objAttribute->value . "'");
						if($objAttribute->parentTable != "" && $this->table!=$objAttribute->parentTable)
						{
							$str_tables="(" . $str_tables . " LEFT JOIN ".$objAttribute->parentTable." ON ".$this->table.".".$objAttribute->field."=".$objAttribute->parentTable.".".$objAttribute->parentIdName.")";
						}
						else
							$str_tables="(" . $str_tables . " LEFT JOIN ".$this->table." ".$this->table."Copia ON ".$this->table."Copia.id = ".$this->table.".".$objAttribute->parentRecursiveId.")";
					}
					if($objAttribute->browseable || $objAttribute->primaryKey){
						if($objAttribute->foreignTable != "" || ($objAttribute->get("inputType")=="arraySelectJoin" && $objAttribute->foreignLabelFields!="")) $campo=$objAttribute->foreignLabelFields;
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
							$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . " IS NULL THEN '' WHEN " . $this->table . "." . $objAttribute->field . "='1' THEN 'Sí' ELSE 'No' END";
						}
						elseif($objAttribute->get("inputType")=="querySelect"){
							$campo="(SELECT foo.nombre FROM (" . $objAttribute->qsQuery . ") as foo WHERE foo.id = " . $this->table . "." . $objAttribute->field . ")";
						}
						elseif($objAttribute->get("inputType")=="autocomplete"){
							$campo="(SELECT DISTINCT " . $objAttribute->ACLabel . " FROM " . $objAttribute->ACFrom . " WHERE " . $objAttribute->ACIdField . " = " . $this->table . "." . $objAttribute->field . ")";
						}
						elseif($objAttribute->get("inputType")=="option"){
							if($objAttribute->sqlType=="boolean"){
								$trueVal="t";
								$falseVal="f";
							}
							else{
								$trueVal="1";
								$falseVal="0";
							}
							$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . "='$trueVal' THEN 'Sí' WHEN " . $this->table . "." . $objAttribute->field . "='$falseVal' THEN 'No' ELSE '' END";
						}
						elseif($objAttribute->get("inputType")=="file"){
							if(SQL_LAYER == "postgresql")
							{
								$campo="CASE WHEN " . $objAttribute->field . " IS NULL THEN '' ELSE '<a href=''file.php?table=" . $this->table . "&field=' || '" . $objAttribute->field . "' || '&id=' || " . $this->table . ".id || '''>' || mmdd_" . $objAttribute->field . "_filename || '</a>' END";
							}
							else
							{
								$campo="CASE WHEN " . $objAttribute->field . " IS NULL THEN '' ELSE concat('<a href=\"file.php?table=".$this->table."&field=".$objAttribute->field."&id=',".$this->table.".id,'\" class=\"link_azul\">',mmdd_".$objAttribute->field."_filename,'</a>') END";
							}
						}
						elseif($objAttribute->get("inputType")=="image"){
							$campo="CASE WHEN " . $this->table . "." . $objAttribute->field . " IS NOT NULL THEN '<img src=\"imagen.php?table=" . $this->table . "&amp;field=" . $objAttribute->field . "&amp;id=' || " . $this->table . ".id || '\">' ELSE '&nbsp;' END";
						}
						elseif($objAttribute->get("inputType")=="textarea"){
							if(SQL_LAYER == "postgresql")
								$campo="substring(".$this->table.".".$objAttribute->field . " from 1 for 255) || '...'";
							elseif(SQL_LAYER == "mysql")
								$campo="concat(substring(".$this->table.".".$objAttribute->field.",1,255),'...')";
						}
						elseif($objAttribute->get("inputType")=="recursiveSelect")
						{
							if($objAttribute->parentTable != "" && $this->table!=$objAttribute->parentTable)
								$campo = $objAttribute->parentTable.".".$objAttribute->parentIdLabel;
							else
								$campo = $this->table."Copia.".$objAttribute->parentIdLabel;
						}
						elseif($objAttribute->get("inputType")=="select_dependiente")
						{
							$campo = $this->table.$objAttribute->foreignLabelFields;
						}
						else $campo=$this->table . "." . $objAttribute->field;
						
						if($objAttribute->field!="") $campo.=" AS \"" . $objAttribute->field . "\"";
						array_push($ar_fields, $campo);
					}
				}
			}


			if($condicionAnterior!="") array_push($ar_condiciones,$condicionAnterior);
			$str_condicion=implode(" AND ",$ar_condiciones);
			$str_fields=implode(", ",$ar_fields);
			$strSQLCount="SELECT COUNT(1) as total FROM " . $str_tables . " WHERE " . $str_condicion;
			$qid=$this->db->sql_query($strSQLCount);
			$res=$this->db->sql_fetchrow($qid);
			$this->numRows=$res["total"];
			$limite_inf=$this->currentPage*$this->maxRows-$this->maxRows;
			$this->strSQL="SELECT " . $str_fields . " FROM " . $str_tables . " WHERE " . $str_condicion;
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
				if($link->relatedTable!=""){
					$table=$link->relatedTable;
					$field=$link->field;
					$qid=$this->db->sql_query("SELECT * FROM $table WHERE $field='" . $this->id . "'");
					if($this->db->sql_fetchrow($qid)!=0) return(TRUE);
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
			$qid=$this->db->sql_query("DELETE FROM " . $this->get("table") . " WHERE " . $this->get("primaryKey") . "=" . $this->get("id"));
		}

		function getRow($marco=0){
			if($row=$this->db->sql_fetchrow($this->sqlQid)){
				$this->loadValues($row);
				$string="<tr ";
				$string.="bgcolor=\"" . $this->rowColor . "\" ";
				if($this->HLRows){
					$string.="onmouseover=\"setPointer(this,'" .  $row[$this->primaryKey] . "', 'over', '#ffffff', '#c9ece8', '#D93333');\" onmouseout=\"setPointer(this,'" . $row[$this->primaryKey] . "', 'out', '#ffffff', '#c9ece8', '#D93333');\"";
				}
				$string.=">";
				$objAttribute=$this->getAttributeByName($this->primaryKey);
				$string.=$objAttribute->getHtmlList();
				for($i=0;$i<sizeof($this->attributes);$i++){
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

		function getRowCSV(){
			//echo $this->sqlQid;
			if($row=$this->db->sql_fetchrow($this->sqlQid)){
				$arrayValues=array();
				$this->loadValues($row);
				for($i=0;$i<sizeof($this->attributes);$i++){
					$objAttribute=$this->attributes[$i];
					array_push($arrayValues,"\"" . $objAttribute->value . "\"");
				}
				$string=implode(",",$arrayValues) . "\n";
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

		function getTitleRowCSV(){
			$arrayTitle=array();
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				array_push($arrayTitle,"\"" . $objAttribute->label . "\"");
			}
			$string=implode(",",$arrayTitle) . "\n";
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
			$valor = 0;
			for($i=0;$i<sizeof($this->attributes);$i++)
			{
				$objAttribute=$this->attributes[$i];
				if($objAttribute->primaryKey) $valor=$objAttribute->value;
				if(!$objAttribute->primaryKey && (
							($objAttribute->visible && $objAttribute->parent->mode!='editar' && $objAttribute->parent->mode!='agregar') ||
							($objAttribute->editable && ($objAttribute->parent->mode=='editar' || $objAttribute->parent->mode=='agregar' ))
							)
					)
				{
					if($contadorAtributos == 0)
					{
						if($objAttribute->inputType!="hidden")
							$string .= "\n<tr bgcolor='" . $this->rowColor . "'>";
						$contadorAtributos++;
					}
					elseif($contadorAtributos < $atributosXFila)
					{
						$contadorAtributos++;
					}
					$string .= $objAttribute->getHtml();
					if($contadorAtributos == $atributosXFila)
					{
						if($objAttribute->inputType!="hidden") $string .= "</tr>\n";
						$contadorAtributos = 0;
					}
				}
			}

			$contadorLinks=0;
			if($this->mode!='agregar'){
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if($objLink->type=="iframe" && $objLink->visible){
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
							$string .= "&amp;iframe' width='100%' height='".$this->iframeHeight."' frameborder='0'></iframe>";
						$string .= "</td>\n";
						if($contadorLinks == $atributosXFila){
							$string .= "</tr>\n";
							$contadorLinks = 0;
						}
					}
				}
			}
			return($string);
		}

		function getJavaScript()
		{
			global $CFG;
			$string="";
			if($this->get("editable")){
				if($this->needsAutoComplete){
					$string.="<link href=\"" . $this->CFG->wwwroot . "/autocomplete/autocomplete.css\" rel=\"stylesheet\" type=\"text/css\">\n";
					$string.="<script language=\"javascript\" src=\"" . $this->CFG->wwwroot . "/autocomplete/autocomplete.js\" type=\"text/javascript\"></script>\n";
				}
				$string.='<script type="text/javascript">' . "\n" . '<!--' . "\n";
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
				for($i=0;$i<sizeof($this->attributes);$i++){
					$objAttribute=$this->attributes[$i];
					if($objAttribute->get("visible"))
					{	
						$string.=$objAttribute->getJavaScript();
					}
					if($objAttribute->get("jsrevision")!= "")
					{
						$string.=$objAttribute->getJSCampoObligatorio();
					}	
				}
				$string.="}\n\n";
				if($this->selectDependiente){
				$string.="
					var oXmlHttp;
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
					
					function updateRecursive(select,nameId,query)
					{
						namediv  = '".$CFG->namediv."';
						id=select.options[select.selectedIndex].value;
						document.getElementById(namediv).innerHTML='<select id=\"' + nameId + '\" style=\"width:' + document.getElementById(nameId).style.width + '\"><option>Actualizando...<\/select>';
						var consulta;
					 	consulta = query.replace('__%idARemp%__',id);
						query=escape(consulta);
						//window.alert(consulta);
						var url=\"".$CFG->wwwroot."/ajaxUpdateRecursive.php?query=\" + query + '&id=' + nameId + '&width=' + document.getElementById(nameId).style.width;
						oXmlHttp=GetHttpObject(cambiarRecursive);
						oXmlHttp.open(\"GET\", url , true);
						oXmlHttp.send(null);
					}
					function cambiarRecursive()
					{
						if (oXmlHttp.readyState==4 || oXmlHttp.readyState==\"complete\"){
							document.getElementById('".$CFG->namediv."').innerHTML=oXmlHttp.responseText
						}
					}
				\n";
				}
				
				$string.="-->\n</script>\n";
			}
			return($string);
		}

		function getLinkIframe(){
				$cont=0;
				for($i=0;$i<sizeof($this->links);$i++){
					$objLink=$this->links[$i];
					if($objLink->type=="iframe"){
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
			$string="";
			$atributosXFila = $this->get("formColumns");
			$contadorAtributos = 0;
			for($i=0;$i<sizeof($this->attributes);$i++){
				$objAttribute=$this->attributes[$i];
				if($objAttribute->searchable && $objAttribute->visible){
					if($objAttribute->get("sqlType")!="geometry") 
					{
						if($contadorAtributos == 0)
						{
							$string .= "\n<tr bgcolor='" . $this->rowColor . "'>";
							$contadorAtributos++;
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


		
	}	
?>
