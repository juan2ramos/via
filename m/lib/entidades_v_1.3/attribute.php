<?
/*	********************************************	*/
/*	Clase para los atributos, es decir, los cam-	*/
/*	pos en las tablas.                          	*/
/*	********************************************	*/
	class attribute{
		var $parent;											//El objeto que lo contiene
		var $mandatory=FALSE;							//Si puede ser nulo o no
		var $field="";										//El nombre del campo en la base de datos
		var $value="";
		var $label="";										//Desplegable
		var $arrayValues=NULL;						//Arreglo de datos, si es un SELECT
		var $foreignTable=NULL;						//Tabla asociada
		var $foreignTableFilter=NULL;			//Filtro de la tabla asociada
		var $foreignTableAlias=NULL;			//Alias para la tabla asociada
		var $foreignField="id";						//Campo de relación en la tabla asociada
		var $foreignLabelFields=NULL;			//Los desplegables en la tabla asociada
		var $foreignModule=NULL;
		
		var $joinQuery=NULL;							//es la consulta cuando se hace con un join
//		var $fieldJoin=NULL;							//es el campo q referencia la consulta del join

		var $inputType="text";						// Tipo html para poner en los formulariosi.  Puede ser:
																			// password | select | option | checkbox | autocomplete | querySelect | arraySelectJoin | arraySelect |
	 																		// popupSelect | file | image | select_dependiente | recursiveSelect | geometry | georref | text |
																			// subQuery | onlyValue | querySelect | select | textarea | date | timestamp | hidden | color | 
																			// fileFS (archivo pero en el sistema de archivos)
		var $encrypted=FALSE;							//Para cuando es un inputType password
		var $sqlType="";									//El tipo de dato en la base de datos, si es subquery, será un pseudo campo que no existe realmente en la BD.
		var $subQuery="";									//Subconsulta para cuando el campo es de tipo subquery.  Si se escribe __id__ se reemplaza por el id de la entidad
		var $geometryType="";							//Si es una geometría, de qué tipo es
		var $geometrySRID=1;							//Si es una geometría, qué SRID tiene
		var $geometryDimension=2;					//Si es una geometría, qué dimensión tiene
		var $inputSize=20;								//Para el formulario HTML
		var $inputRows=3;									//El rows del textarea
		var $browseable=FALSE;						//Si aparece en los listados
		var $searchable=TRUE;							//Si aparece en las búsquedas
		var $editable=TRUE;								//Si aparece en las fichas de edición
		var $visible=TRUE;								//Si aparece en las fichas de detalle
		var $shortList=FALSE;							//Si aparece en los listados chicorios
		var $readonly=FALSE;							//Si es editable
		var $defaultValue="";
		var $defaultValueSQL="";
		var $primaryKey=FALSE;
		var $editList="";									// Si se puede editar el dato en el listado
		var $onClick="";
    var $onChange="";
		var $onKeyDown="";
		var $onFocus="";
		var $onBlur="";
		var $JSRegExp="";                 //La expresión regular para validación del formulario en javascript

		var $psSelect="";                 //Si el tipo de input es popupSelect, tiene que tener un select de la tabla
    var $psFrom="";                   //Igual
    var $psWhere="";                  //Igual, pero no obliga
    var $psOrder="";                  //Igual, pero no obliga
		var $psForeignKey="";
		var $psForeignLabel="";

//Si el tipo de input es querySelect
//sirve para armar el combo a partir de una consulta arbitraria.
	
		var $qsQuery="";									//La consulta como tal

//PARA EL AUTOCOMPLETE:
		var $ACIdField="";
		var $ACLabel="";
		var $ACFrom="";
		var $ACWhere="";
		var $ACFields="";
//PARA EL COMBO RECURSIVO CON EL id_superior(el inputType debe ser: recursiveSelect):
		var $parentIdName="id";
		var $parentIdLabel="nombre";
		var $parentTable="";
		var $parentRecursiveId="id_superior";

//PARA EL COMBO RECURSIVO DE UN SELECT A PARTIR DE OTRO SELECT
		var $namediv = "";
		var $fieldIdParent = "";
		var $foreignFieldId = "id";
		
		var $jsrevision="";

//para mostrar el objeto de un swf, o un video. Aunque es tipo imagen, pero no se va a mostrar ninguna imagen.
		var $mostrarImagen = TRUE;
		var $reemplazoImagen = "";
		var $reemplazoID = FALSE;

		// Si se permite que se suban archivos de extensión php (cuando es file o imagen)
		var $allowPHP = false;



		/*	CONSTRUCTOR	*/
		function attribute(&$parent){
			$this->parent = &$parent;
		}

		function getHtmlLabel(){
			GLOBAL $ME;
			
			$string="<td class='" . $this->parent->classTH . "' nowrap align='center'><b>";
			if($this->parent->upButton!="") $txtUp="<img alt=\"ASC\" border='0' src='" . $this->parent->iconsPath . "/" . $this->parent->upButton . "'>";
			else $txtUp="^";
			if($this->parent->upButton!="") $txtDown="<img alt=\"DESC\" border='0' src='" . $this->parent->iconsPath . "/" . $this->parent->downButton . "'>";
			else $txtDown="v";
			$arrQueryStringOrder=querystring2array(hallar_querystring("orderBy",$this->field));
			$querystringAsc=hallar_querystring("orderByMode","ASC",$arrQueryStringOrder);
			$querystringDesc=hallar_querystring("orderByMode","DESC",$arrQueryStringOrder);
			if($this->sqlType != "subquery") $string.="<a href='" . simple_me($ME) . $querystringAsc . "' title='Ordenar ascendentemente'>" . $txtUp . "</a>";
			$string.=$this->label;
			if($this->sqlType != "subquery") $string.="<a href='" . simple_me($ME) . $querystringDesc . "' title='Ordenar descendentemente'>" . $txtDown . "</a>";
			$string.="</b></td>";

			/*
			$string="<td class='title' >";
			$string.=$this->label;
			$string.="</td>";
			*/
			return($string);
		}

		function getHtmlList(){
			if($this->primaryKey && !$this->parent->editable) return "";
			elseif(!$this->primaryKey && !$this->browseable) return "";
			$string="<td class='" . $this->parent->classTD . "'";
			if(!$this->editList)
			{
				if(trim($this->value)=="") $value="&nbsp;";
				else $value=$this->value;
				if($this->primaryKey && $this->parent->editable) 
				{
					$string.=" width='1'><input type='radio' id='radio_" . $this->value . "' name='" . $this->field . "' value='" . $this->value . "'>";
					if($this->browseable)
					{
						$string.="<td class='" . $this->parent->classTD . "'>".$value;
					}
				}
				elseif($this->parent->editable) $string.="><label for='radio_" . $this->parent->id . "'>" . $value . "</label>";
				else $string.=">" . $value;
			}
			else
			{
				$string.=">";
				$edit = 1;
				$string.=$this->getHtml($edit);
			}
			$string.="</td>";
			return($string);
		}

		function getHtml($edit = 0){
//			echo "entro";
			($this->parent->fieldLabelStyle=="") ? $class="" : $class=" class=\"" . $this->parent->fieldLabelStyle . "\"";
			($this->onClick=="") ? $onClick="" : $onClick=" onClick=\"" . $this->onClick . "\"";
			$string="";
			if($this->parent->editable){
				if($this->inputType!="geometry" && $this->inputType!="hidden")	{
					if($this->mandatory) $asterisco="(*) ";
					else $asterisco="";
					if($edit == 0) $string.="<td" . $class . " align='right' bgcolor='#ffffff' nowrap>" . $asterisco . $this->label . " : </td>";
					if($this->get("defaultValue")!="" && $this->parent->mode=='agregar') $this->value=$this->get("defaultValue");
					if($this->parent->get("newMode")=="consultar") {
						$string.="<td" . $class . ">";
						if($this->inputType=="password") $this->value="*******";
						elseif($this->inputType=="select" && $this->value!=''){
							if($this->foreignTableAlias!=NULL)
							{
								$str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable ." as ".$this->foreignTableAlias." WHERE " . $this->foreignField . "=" .$this->value. " ORDER BY ". $this->get("foreignLabelFields");
							}
							else
							{
								$str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable ." WHERE " . $this->foreignField . "=" .$this->value. " ORDER BY ". $this->get("foreignLabelFields");
							}
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['nombre'];
						}
						elseif($this->inputType=="option" || $this->inputType=="checkbox")
						{
							if($this->value == '1') 
								$this->value = 'Sí';
							elseif($this->value == '0')
								$this->value = 'No';
						}
						elseif($this->inputType=="autocomplete")
						{
							$str_query= "SELECT DISTINCT (" . $this->ACLabel . ") as value FROM " . $this->ACFrom . " WHERE " . $this->ACIdField . " = " . $this->value;
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['value'];
						}
						elseif($this->inputType=="querySelect")
						{
							$valor = $this->value;
							//para que no salga error cuando el valor es vacío.
							if($valor == "")
								$valor = 0;
							$str_query= "SELECT foo.nombre FROM (" . $this->qsQuery . ") as foo WHERE foo.id = " . $valor;
							//echo $str_query."<br>";
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['nombre'];
						}
						elseif($this->inputType=="arraySelectJoin")
						{


						}
						elseif($this->inputType=="arraySelect"){
							foreach($this->arrayValues as $key => $val){
								if(nvl($this->value,$this->defaultValue)==$key) $this->value=$val;
							}
						}
						elseif($this->inputType=="popupSelect"){
							if($this->value!=""){
								$str_query = "SELECT " . $this->psSelect . " FROM " . $this->psFrom . " WHERE " . $this->psForeignKey . " = '" . $this->value . "'";
								$qid=$this->parent->db->sql_query($str_query);
								$data = $this->parent->db->sql_fetchrow($qid);
								$this->value = $data[0];
							}
						}
						elseif($this->inputType=="file" || $this->inputType=="fileFS"){
							if($this->inputType=="file") $script="file.php";
							elseif($this->inputType=="fileFS") $script="fileFS.php";
							if($this->value!=""){
								$arrFile=explode("|",$this->value);
								$fileName=$arrFile[0];
//								preguntar($this->value);
								$this->value="\n<a href=\"" . $script . "?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">" . $fileName . "</a><br>\n";
							}
						}
						elseif($this->inputType=="image"){
							if($this->value!="" && $this->mostrarImagen){
								$archivo = $this->moverImagenToArchivo($this->parent->get("table"),$this->field,$this->parent->get("id"));
								$datos=getimagesize($archivo);
								if($datos[0]>250)
									$width = "&w=250";
								else
									$width = "";
								$this->value="\n<img src=".$this->parent->CFG->wwwroot."/phpThumb/phpThumb.php?src=".$archivo.$width." border=0><br>\n";
							}
							if($this->reemplazoImagen != "")
							{
								if($this->reemplazoID)
									$this->value= str_replace("%reemplazoID%",$this->parent->get("id"),$this->reemplazoImagen);
								else
									$this->value= $this->reemplazoImagen;
							}
						}
						elseif($this->inputType=="select_dependiente" && $this->value!=''){
							$str_query = "SELECT ".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." WHERE ".$this->foreignField."= '".$this->value."'";
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['nombre'];
						}
						
						$string.=$this->value;
						$string.="</td>";
						return($string);
					}
					if($edit == 0)
					{
						$string.="<td" . $class . " bgcolor='".$this->parent->bgColorFieldValue."'>";
						$id = "";
					}
					if($edit == 1)
					{
						$string .= "";
						$id = "__".$this->parent->id;
					}
				}
			
			switch($this->inputType){
				case "recursiveSelect":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else $onChange="";
					if($this->parentTable=="") $this->parentTable=$this->parent->table;
					$this->parent->db->build_recursive_tree($this->parentTable,$options,nvl($this->value,$this->defaultValue),$this->parentIdName,$this->parentRecursiveId,$this->parentIdLabel);
//					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					$string.="<select name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . "><option value=''>Raíz" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'></a>";
					}
					break;

					//el sig atributo es para recargar un select a partir de un id dado de otro select.  Para que funcione Ãste atributo,  se debe colocar en lib el archivo ajaxUpdateRecursive.php (que se encuentra en /librerias_php).
					case "select_dependiente":
						if($this->value!=0)
						{
							$str_query = "SELECT ".$this->foreignFieldId.",".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." WHERE ".$this->fieldIdParent." = (SELECT ".$this->fieldIdParent." FROM ".$this->foreignTable." WHERE ".$this->foreignField."='".$this->value."')";
							$options=$this->parent->db->sql_listbox($str_query,"",nvl($this->value,$this->defaultValue));
							$string.="<div id=\"".$this->namediv."\"><select name=\"".$this->field."\" id=\"".$this->field."\" style=\"width:200px\">" . $options . "</select></div>";
						}
						else
							$string.="<div id=\"".$this->namediv."\"><select name=\"".$this->field."\" id=\"".$this->field."\" style=\"width:200px\"><option value=0>Seleccione...</option></select></div> ";
					break;
					
				case "geometry":
					$string="<input type='hidden' name='" . $this->field. "' value='" . $this->value . "'>";
					break;

				case "georref":
					if($this->onFocus!="") $onFocus=" onFocus=\"" . $this->onFocus  . "\"";
					else $onFocus="";
					if($this->onBlur!="") $onBlur=" onBlur=\"" . $this->onBlur  . "\"";
					else $onBlur="";
					$string.="<input type='text' size='" . $this->inputSize . "' name='" . $this->field.  "$id' value='" . $this->value . "' " . $onFocus  . " " . $onBlur  . " >";
					$string.="
						<div id='help' name='help' style='position:absolute;display:none;color:#003399;background-color:#eeeeee;border:1px solid black;width:250;'>
							<b>Para ingresar direcciones tenga en cuenta:</b><br>
							KR - Carrera <br> AK - Avenida Carrera <br> CL - Calle <br> AC - Avenida Calle <br> TV - Transversal 
							<br> DG - Diagonal <br> KR 100 B BIS B # 56 A - 10 SUR <br> AVENIDA CIUDAD DE QUITO # 76 - 50
						</div>
						";
					if($this->parent->name!="negocio_cliente" && $this->parent->name!="proyecto"){
						$string.="&nbsp;<a title=\"Ubicar en el mapa\" href=\"javascript:newWindow('modules/map.phtml?type=".$this->parent->mode."&amp;map_type=georref&amp;id=".$this->parent->id."&amp;direccion=' + escape(document.entryform." . $this->field. ".value),'georref',600,400)\">";
						$string.="<img alt=\"Geo\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-georref.gif' border='0'></a>";
					}
					else{
						$string.="&nbsp;<a title=\"Ubicar en el mapa\" href=\"javascript:evaluar_accion('".$this->parent->mode."','".$this->parent->id."','".$this->field."')\"><img alt=\"Geo\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-georref.gif' border='0'></a>";
					}
					break;
				
				case "text":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else $onChange="";
					if($this->foreignTable != "" && $this->parent->mode!="buscar" && $this->parent->mode!="agregar" )
					{
						if($this->value != null)
						{
							$str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable ." WHERE " . $this->foreignField . "=" .$this->value;
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
	//						$value=$value['nombre'];
							$string.= $value['nombre'];
							$string.="<input type='hidden' name='" . $this->field . "' value='" . $this->value . "'>";
						}
					}	
					else{
						if($this->readonly)
						  $readonly = " readonly ";
						else
						  $readonly = "";
						
						$string.="<input type='text' size='" . $this->inputSize . "' ". $this->get("editable")." name='" . $this->field ."$id' value='" . str_replace("'","&apos;",$this->value) . "' ". $onChange ." ".$readonly . ">";
					}
					break;

				case "subQuery":
				case "onlyValue":
						$string.= $this->value;
					break;
					
				case "password":
					if($this->encrypted) $string.="<input type='password' size='" . $this->inputSize . "' name='" . $this->field ."$id' value=''" . $this->get("editable") . ">";
					else $string.="<input type='password' size='" . $this->inputSize . "' name='" . $this->field ."$id' value='" . $this->value . "'" . $this->get("editable") . ">";
					$string.="<br><input type='password' size='" . $this->inputSize . "' name='__CONFIRM_" . $this->field ."$id' value=''" . $this->get("editable") . "> (Confirmar)";
				break;

				case "querySelect":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else $onChange="";
					if($this->qsQuery=="") die("Error: Si el tipo de input es \"querySelect\", la consulta debe ir en la variable <b>qsQuery</b>");
					$str_query=$this->qsQuery;
					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					$string.="<select name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . ">" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'></a>";
					}
					break;

				case "select":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else $onChange="";
					if($this->foreignTableAlias!=NULL){
						$str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable . " " . $this->foreignTableAlias;
					}
					else $str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable;
					if($this->foreignTableFilter!=NULL){
						$str_query.=" WHERE " . $this->foreignTableFilter;
						if(preg_match("/__%([^%]*)%__/",$str_query,$matches)){
							$campo=$matches[1];
							$temp = $this->parent;
							$temp2 = $temp->getAttributeByName($campo);
							$relatedObjectValue = $temp2->get("value");
//							$relatedObjectValue=$this->parent->getAttributeByName($campo)->get("value");
							if($relatedObjectValue=="" || $relatedObjectValue=="%") $relatedObjectValue="-1";
							$str_query = preg_replace("/__%([^%]*)%__/",$relatedObjectValue,$str_query);
						}
						$str_query=preg_replace("/(id_[^=]*)='([^']+,[^']+)'/","$1 IN ($2)",$str_query);
					}
					$str_query.=" ORDER BY ". $this->get("foreignLabelFields");
					
					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					$string.="<select name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . ">" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href='javascript:addForeignItem(\"" . $this->foreignModule . "\",\"" . $this->field . "$id\",\"" . $this->foreignTable . "\",\"" . $this->foreignField . "\",\"" . base64_encode($this->foreignLabelFields) . "\")'>";
						$string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'></a>";
					}
					break;

				case "arraySelect":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else $onChange="";
					$options="\n<option value=\"%\">Seleccione...\n";
					foreach($this->arrayValues as $key => $val){
						$options.="<option value=\"" . $key . "\"";
						if($this->parent->mode!="buscar")
							if(nvl($this->value,$this->defaultValue)==$key) $options.=" SELECTED";
						$options.=">" . $val . "\n";
					}
					
					$string.="<select name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange  . ">" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'></a>";
					}
					break;

				case "arraySelectJoin":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
					else $onChange="";
					$options="\n<option value=\"%\">Seleccione...\n";
					$str_query = $this->joinQuery;
					if(preg_match("/__%([^%]*)%__/",$str_query,$matches)){
						$campo=$matches[1];
					}
					$temp = $this->parent;
					$temp2 = $temp->getAttributeByName($campo);
					$relatedObjectValue = $temp2->get("value");
					//$relatedObjectValue=$this->parent->getAttributeByName($campo)->get("value");
					if($relatedObjectValue=="" || $relatedObjectValue=="%") $relatedObjectValue="-1";
					$str_query = preg_replace("/__%([^%]*)%__/",$relatedObjectValue,$str_query);
					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					$string.="<select name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . ">" . $options . "</select>";

					if($this->foreignModule!=NULL) 
					{
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'></a>";
					}	
					break;	
				case "textarea":
					$string.="<textarea rows='" . $this->inputRows . "' cols='" . $this->inputSize . "' name='" . $this->field . "$id' " . $this->get("editable") . ">" . $this->value . "</textarea>";
					break;

				case "option":	//	YES/NO
					if($this->sqlType=="boolean"){
						$trueVal="t";
						$falseVal="f";
					}
					else{
						$trueVal="1";
						$falseVal="0";
					}
					$checked="";
					if($this->value==$trueVal) $checked=" CHECKED";
					$string.="Sí&nbsp;<input type='radio' name='" . $this->field . "$id' value='" . $trueVal . "' " . $checked . " " . $this->get("editable") . ">";
					$checked="";
					if($this->value==$falseVal) $checked=" CHECKED";
					$string.="&nbsp;No&nbsp;<input type='radio' name='" . $this->field . "$id' value='" . $falseVal . "'" . $checked . ">";
					break;

				case "checkbox":
					$checked="";
					if($this->value==1 || $this->value=="Sí" || $this->value=='t') $checked=" CHECKED ";
					$string.="<input type='checkbox' name='".$this->field."$id'" . $checked . " value='1'>";
					break;
					
				case "date":
					if($this->onChange!="") $onChange=" onChange=\" " . $this->onChange . "\"";
          else $onChange="";
					if($this->parent->mode=='buscar')	$value="";
					elseif($this->parent->mode=='agregar' && $this->get("defaultValue")!="") $value = $this->get("defaultValue");
					elseif($this->parent->mode=='agregar' && $this->mandatory) $value = date("Y-m-d");
					else $value = $this->value;
					$string.="<input type='text' style='text-align:center;' readonly name='".$this->field."' value='".$value."'".$onChange.">";
					$string.="&nbsp;<a title=\"Calendario\" href=\"javascript:";
					$string.="abrir('".$this->field."');\">";
					$string.="<img alt=\"Fecha\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-date.gif' border='0'>";
					$string.="</a>";	
					break;
				
				case "timestamp":
					if($this->parent->mode=='buscar') $value="";
					elseif($this->parent->mode=='agregar' && $this->get("defaultValue")!="") $value = $this->get("defaultValue");
					elseif($this->parent->mode=='agregar' && $this->mandatory) $value = date("Y-m-d H:i:s");
					else $value = $this->value;

					$string.="<input type='text' size='25' style='text-align:center;' name='".$this->field."' value='".$value."'>";
					$string.="&nbsp;<a title=\"Calendario\" href=\"javascript:";
					$string.="abrirWHora('".$this->field."');\">";
					$string.="<img alt=\"Fecha\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-date.gif' border='0'>";
					$string.="</a>";
					break;

				case "popupSelect":
/*					if(isset($_GET['campo']) && $_GET['campo'] == $this->field){
						$var = $_GET['campo'];
					}
					else
						$var = "";
					if(isset($_GET[$var])){
						$this->value = $_GET[$var];
					}
					$string.="<input type='hidden' size='" . $this->inputSize . "' name='".$this->field . "$id' value='" . $this->value . "'>\n";
					if($this->value != "")
					{
						$str_query = "SELECT " . $this->psSelect . " FROM " . $this->psFrom . " WHERE " . $this->psForeignKey . " = '" . $this->value . "'";
						$qid=$this->parent->db->sql_query($str_query);
						$data = $this->parent->db->sql_fetchrow($qid);
						$value = $data[0];
					}
					else
					{
						$value = "";
					}
					$string.="<input type='text' size='" . $this->inputSize . "' name='" . $this->field ."__1". $id."' value='".$value."'". $this->get("editable") .">\n";
					$string.="<a title=\"buscar\" href=\"javascript:";
					if($this->field=='codigo_eco')
						$edit=$this->field;
					else
						$edit="";
					$string.="psBuscar('" . $this->psSelect . "','" . $this->psFrom . "','" . $this->psWhere . "','" . $this->psOrder. "','" . $this->psForeignLabel . "','" . $this->field . "','".$edit."');\">";
					$string.="<img src='iconos/transparente/search1.gif' border='0'>";
					if($this->foreignModule!=""){
						$string.="</a>&nbsp;&nbsp;<a title=\"Agregar\" href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img src='iconos/transparente/icon-add.gif' border='0'>";
						$string.="</a>";
					}*/
					if(isset($_GET['campo']) && $_GET['campo'] == $this->field){
            $value = $_GET['campo'];
          }
          else
            $value = "";
          if(isset($_GET[$value])){
            $this->value = $_GET[$value];
          }
          if(isset($_POST[$this->field]))
            $this->value=$_POST[$this->field];
          $string.="<input type='hidden' size='" . $this->inputSize . "' name='" . $this->field . "$id' value='" . $this->value . "'>\n";
          if($this->value != "")
          {
            $str_query = "SELECT " . $this->psSelect . " FROM " . $this->psFrom . " WHERE " . $this->psForeignKey . " = '" . $this->value . "'";
            $qid=$this->parent->db->sql_query($str_query);
            $data = $this->parent->db->sql_fetchrow($qid);
            $value = $data[0];
          }
          else
          {
            $value = "";
          }
          $string.="<input type='text' size='" . $this->inputSize . "' name='" . $this->field ."__1". $id."' value='".str_replace("'","&apos;",$value)."'". $this->get("editable") .">\n";
          $string.="<a title=\"buscar\" href=\"javascript:";
          $string.="psBuscar('" . $this->psSelect . "','" . $this->psFrom . "','" . $this->psWhere . "','" . $this->psOrder. "','" . $this->psForeignLabel . "','" . $this->field . "','".$id."');\">";
          $string.="<img alt=\"Search\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/search1.gif' border='0'>";
          if($this->foreignModule){
            $string.="</a>&nbsp;&nbsp;<a title=\"Agregar\" href=\"javascript:agregar('" . $this->foreignModule . "')\">";
            $string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'>";
            $string.="</a>";
          }
					break;

				case "hidden":
					if(isset($_GET['campo']) && $_GET['campo'] == $this->field){
				    $value = $_GET['campo'];
			    }
			    else
			      $value = "";
		      if(isset($_GET[$value])){
		 	       $this->value = $_GET[$value];
          }
					$string="<input type='hidden' name='" . $this->field . "' value='" . $this->value . "'>";
					break;
			
				case "autocomplete":
					$string.="\n<input type='hidden' id='" . $this->field . "' name='" . $this->field . "' value='" . $this->value . "'>\n";
					$label="";
					if($this->value!=""){
						$strQuery="SELECT " . $this->ACLabel . " FROM " . $this->ACFrom . " WHERE " . $this->ACIdField . " = '" . $this->value . "'";
						$qid=$this->parent->db->sql_query($strQuery);
						if($result=$this->parent->db->sql_fetchrow($qid)) $label=$result[0];
					}
					if($this->readonly) $readonly=" readonly";
					else $readonly="";
					$string.="<input autocomplete=\"off\" type=\"text\" id=\"AC_" . $this->field . "\" size=\"" . $this->inputSize . "\" value=\"" . $label . "\"" . $readonly . ">\n";
					$string.="<div id=\"popup_" . $this->field . "\" class=\"autocomplete\"><span>-----</span></div>\n";
					$string.="<script type=\"text/javascript\">\n";
					$string.="autocomplete('" . $this->field . "','AC_" . $this->field . "',";
					$string.="'popup_" . $this->field . "',";
					$string.="'" . $this->parent->CFG->wwwroot . "/autocomplete/autocomplete.php?id=popup_" . $this->field;
				 	$string.="&dirroot=" . urlencode($this->parent->CFG->dirroot);
				 	$string.="&ACIdField=" . urlencode($this->ACIdField);
				 	$string.="&ACLabel=" . urlencode($this->ACLabel);
				 	$string.="&ACFrom=" . urlencode($this->ACFrom);
				 	$string.="&ACWhere=" . urlencode($this->ACWhere);
				 	$string.="&ACFields=" . urlencode($this->ACFields);
					$string.="');\n";
					$string.="</script>\n";

					
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->CFG->wwwroot . "/iconos/transparente/icon-add.gif' border='0'></a>";
					}
					break;

				case "image":
					if($this->value!="" ){
						$string.="\nImagen actual:<br>\n";
						if($this->mostrarImagen){
							$archivo = $this->moverImagenToArchivo($this->parent->get("table"),$this->field,$this->parent->get("id"));
	//						$string.="\n<img src=\"imagen.php?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\"><br>\n";
							$datos=getimagesize($archivo);
							if($datos[0]>250)
									$width = "&w=250";
							else
									$width = "";
							$string.="\n<img src=".$this->parent->CFG->wwwroot."/phpThumb/phpThumb.php?src=".$archivo.$width." border=0>
							<a href='".$this->parent->CFG->wwwroot."/admin/index.php?module=".$this->parent->name."&mode=eliminarImagen&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Imagen)</a><br>\n";
						}
						if($this->reemplazoImagen != "")
						{
							if($this->reemplazoID)
								$string.= str_replace("%reemplazoID%",$this->parent->get("id"),$this->reemplazoImagen);
							else
								$string.= $this->reemplazoImagen;
					
							$string.= "<a href='".$this->parent->CFG->wwwroot."/admin/index.php?module=".$this->parent->name."&mode=eliminarImagen&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Imagen)</a><br>\n";	
						}


					}
					$string.="\n<input type='file' name='" . $this->field . "' size='" . $this->inputSize . "'>\n";
					break;

				case "file":
					if($this->value!=""){
						$string.="\nArchivo actual:<br>\n";
						$attrFN=$this->parent->getAttributeByName("mmdd_" . $this->field . "_filename");
						$fileName=$attrFN->value;
						$string.="\n<a href=\"file.php?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">" . $fileName . "</a>&nbsp;&nbsp;&nbsp;<a href='".$this->parent->CFG->wwwroot."/admin/index.php?module=".$this->parent->name."&mode=eliminarImagen&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Archivo)</a><br>\n";
					}
					$string.="\n<input type='file' name='" . $this->field . "' size='" . $this->inputSize . "' >\n";
					break;

				case "fileFS":
					if($this->value!=""){
						$string.="\nArchivo actual:<br>\n";
						$attrFN=$this->parent->getAttributeByName("mmdd_" . $this->field . "_filename");
						$fileName=$attrFN->value;
						$string.="\n<a href=\"fileFS.php?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">" . $fileName . "</a>&nbsp;&nbsp;&nbsp;<a href='".$this->parent->CFG->wwwroot."/admin/index.php?module=".$this->parent->name."&mode=eliminarImagen&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Archivo)</a><br>\n";
					}
					$string.="\n<input type='file' name='" . $this->field . "' size='" . $this->inputSize . "' >\n";
					break;

				case "color":
					$color=explode(" ",$this->value);
					if(sizeof($color)==3) $bgcolor="#" . str_pad(dechex($color[0]),2,'0') . str_pad(dechex($color[1]),2,'0') . str_pad(dechex($color[2]),2,'0');
					else{
						$color[0]="0";
						$color[1]="0";
						$color[2]="0";
						$bgcolor="";
					}
					$string.="<input type='hidden' name='" . $this->field . "$id' value='" . $this->value . "' id='" . $this->field . "'>";
					$string.="<table border='1' cellpadding='0' cellspacing='0'><tr>";
					$string.="<td width='20' height='20' bgcolor='$bgcolor' id='cell_" . $this->field . "' ";
					$string.="onClick=\"popup_color('" . $color[0] . "," . $color[1] . "," . $color[2] . "','" . $this->field . "')\">&nbsp;</td>";
					$string.="</tr></table>";
				break;
				case "color_hexa":
					$string.="<input type='hidden' name='" . $this->field . "$id' value='" . $this->value . "' id='" . $this->field . "'>";
					$string.="<table border='1' cellpadding='0' cellspacing='0'><tr>";
					$string.="<td width='20' height='20' bgcolor='$this->value' id='cell_" . $this->field . "' ";
					$string.="onClick=\"popup_color('" . $this->value . "','" . $this->field . "')\">&nbsp;</td>";
					$string.="</tr></table>";
				break;

			}
			
			if($this->inputType!="geometry" && $this->inputType!="hidden")  {
				if($edit == 0)
					$string.="</td>";
				if($edit == 1)
					$string .= "";
			}

			return($string);
		}
		}

		function moverImagenToArchivo($table,$field,$id)
		{
			$strQuery="SELECT ".$field." as image,mmdd_".$field."_filename as fn FROM ".$table." WHERE id = ".$id;
			$qid=$this->parent->db->sql_query($strQuery);
			if($result=$this->parent->db->sql_fetchrow($qid))
			{
				srand( (double) microtime()*1000000 );
				$nombre = str_replace(" ","_",$result["fn"]);
				$archivo = "/tmp/".md5( rand() )."_".$nombre;
				$imgImg=base64_decode($result["image"]);
				$gestor = fopen($archivo,"x+");
				fwrite($gestor,$imgImg);
				fclose($gestor);
				return $archivo;
				//    file_put_contents($archivo,$imgImg);
			}
			
		
		
		
		}

		
		function getJSRegExp(){
			if($this->JSRegExp!="") return($this->JSRegExp);
	 		preg_match("/^([a-zA-Z]+2?)(\(?([0-9]+)[,|\)]([0-9]+)?\)?)?$/",$this->sqlType,$fieldType);
//      $this->sqlType="NUMBER";
			if(!isset($fieldType[1]))
			{
				preg_match("/^(character) (varying)(\(?([0-9]+)[,|\)]([0-9]+)?\)?)?$/",$this->sqlType,$fieldType);
				if(!isset($fieldType[1]))
				{
					preg_match("/^(timestamp)/",$this->sqlType,$fieldType);
					if(isset($fieldType[1]))
						$sqlType="timestamp";
					else{
						preg_match("/^(time) (without)/",$this->sqlType,$fieldType);
						if(isset($fieldType[1]))
							if(SQL_LAYER == "mysql")
								$sqlType="time";
							else
								$sqlType="time without time zone";
					}
				}
				else{
					$sqlType=$fieldType[1];
					if(isset($fieldType[4])) $precision1=$fieldType[4];
				}
			}
			else{
				$sqlType=$fieldType[1];
				if(isset($fieldType[3])) $precision1=$fieldType[3];
				if(isset($fieldType[4])) $precision2=$fieldType[4];
			}
			if(!isset($sqlType) && $this->sqlType=="double precision") $sqlType="numeric";
			switch($sqlType){
				case("smallint"):
				case("integer"):
				case("tinyint"):
				case("numeric"):
					if(!isset($precision1)) $this->JSRegExp="/(^-?\d+$)|(^-?\d+\.\d+$)/";//Cualquier número...
			  	elseif(nvl($precision2,0)==0) $this->JSRegExp="/^-?\d{1," . $precision1 . "}$/";//Cualquier entero...
					else $this->JSRegExp="/(^-?\d{1," . $precision1 . "}$)|(^-?\d{1," . $precision1 . "}\.\d{" . $precision2 . "}$)/";
					break;

				case("character"):
						$this->JSRegExp="/^.{1," . $precision1 . "}$/m";//Controla el ancho...
					break;

				case("date"):
						$this->JSRegExp="/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/m";//Controla la fecha...
					break;

				case("timestamp"):
						$this->JSRegExp="/^[0-9]{4}-[0-9]{2}-[0-9]{2}/";//Controla la parte de la fecha...
					break;

				case("time without time zone"):
						$this->JSRegExp="/^[0-9]{2}:[0-9]{2}:[0-9]{2}/";//controla la hora
					break;
				case("time"):
						$this->JSRegExp="/^[0-9]{2}:[0-9]{2}:[0-9]{2}/";//controla la hora
					break;
					
				case("real"):
				case("float"):
						$this->JSRegExp="/(^-?\d+$)|(^-?\d+\.\d+$)/";//Cualquier número...
					break;
				default:
					$this->JSRegExp="/./";
					break;
			}
			return($this->JSRegExp);
		}
/*		
		function getJavaScript(){
			$string="";
			switch($this->inputType){
				case "text":
					$string.="if(document.entryform." . $this->field . ".value==''){\n";
					$string.="\twindow.alert('Por favor escriba: " . $this->get("label") . "');\n";
					$string.="\tdocument.entryform." . $this->field . ".focus();\n";
					$string.="\treturn(false);\n";
					$string.="}\n";
					break;

				case "select":
					$string.="if(document.entryform." . $this->field . ".options[document.entryform." . $this->field . ".selectedIndex].value=='%'){\n";
					$string.="\twindow.alert('Por favor seleccione: " . $this->get("label") . "');\n";
					$string.="\tdocument.entryform." . $this->field . ".focus();\n";
					$string.="\treturn(false);\n";
					$string.="}\n";

					break;
			}
			return($string);
		}
*/
		function getJavaScript(){
			$string="";
			switch($this->inputType){
				case "select":
				case "arraySelectJoin":
				case "arraySelect":
				case "querySelect":
					if($this->mandatory){
						$string.="if(document.entryform." . $this->field . ".options[document.entryform." . $this->field . ".selectedIndex].value=='%'){\n";
						$string.="\twindow.alert('Por favor seleccione: " . $this->get("label") . "');\n";
						$string.="\tdocument.entryform." . $this->field . ".focus();\n";
						$string.="\treturn(false);\n";
						$string.="}\n";
					}
				break;

				default:
					if($this->mandatory){
						//$string.="if(document.entryform." . $this->field . ".value==''){\n";
						$string.="if(document.entryform." . $this->field . ".value.replace(/ /g, '') ==''){\n";
						$string.="\twindow.alert('Por favor escriba: " . $this->get("label") . "');\n";
						$string.="\tdocument.entryform." . $this->field . ".focus();\n";
						$string.="\treturn(false);\n";
						$string.="}\n";
						$string.="else{\n";
					}
					else 
						$string.="if(document.entryform." . $this->field . ".value !=''){\n";
						if($this->inputType != "option"){
							$string.="\tvar regexpression=" . $this->getJSRegExp() . ";\n";
							$string.="\tif(!regexpression.test(document.entryform." . $this->field . ".value)){\n";
							$string.="\t\twindow.alert('[" . $this->get("label") . "] no contiene un dato válido.');\n";
							$string.="\t\tdocument.entryform." . $this->field . ".focus();\n";
							//$string.="\twindow.alert(document.entryform." . $this->field . ".value);";
							$string.="\t\treturn(false);\n";
							$string.="\t}\n";
						}
						$string.="}\n";
						
				break;

			}

			if($this->inputType=="password"){
				$string.="if(document.entryform." . $this->field . ".value != document.entryform.__CONFIRM_" . $this->field .".value){\n";
				$string.="\twindow.alert('La confirmación de " . $this->get("label") . " no corresponde.');\n";
				$string.="\tdocument.entryform." . $this->field . ".focus();\n";
				$string.="\treturn(false);\n";
				$string.="}\n";
			}
			return($string);
		}
	
		function getJSCampoObligatorio()
		{
			$valores = explode(",",$this->get("jsrevision"));
			$string="";
			$string.="if(document.entryform." . $this->field . ".value==".$valores[0]." && (document.entryform.".$valores[1].".value=='' || document.entryform.".$valores[1].".value=='%')){\n";
			$string.="\twindow.alert('Por favor escriba: " . $valores[1] . "');\n";
			$string.="\tdocument.entryform." . $valores[1]. ".focus();\n";
			$string.="\treturn(false);\n";
			$string.="}\n";
			return $string;	
		}











		
		function set($attribute,$value){
			if(in_array($attribute,array_keys(get_object_vars($this)))){
				if($attribute=="sqlType"){
					$value=strtolower($value);
					if($value=="int") $value="integer";
					if($value=="time")
						if(SQL_LAYER == "postgresql")
							$value="time without time zone";
					if($value=="timestamp")
					{
						if(SQL_LAYER == "mysql")
							$value="timestamp";
						else
							$value="timestamp without time zone";
					}
					if($value=="float") $value="double precision";
					if(SQL_LAYER == "postgresql") $value=str_replace("varchar", "character varying", $value);
					elseif(SQL_LAYER == "mysql"){
						$value=str_replace("boolean", "tinyint(4)", $value);
						$value=str_replace("character varying", "varchar", $value);
					}
				}
				elseif($attribute=="foreignTable"){
					if($this->get("foreignLabelFields")==NULL) $this->foreignLabelFields=$value . ".nombre";
					if($this->get("foreignField")==NULL) $this->foreignField="id";
				}
				elseif($attribute=="encrypted" && $value==TRUE){
 	        if($this->inputType!="password") die("Error:<br>\nEl atributo [" . $this->label . "] para ser encriptado debe ser de tipo password.");
        }
				elseif($attribute=="inputType" && $value=="popupSelect"){
 	        if($this->psSelect=="") die("Error:<br>\nEl atributo [" . $this->label . "] para ser popupSelect, debe contar con un [psSelect].");
          if($this->psFrom=="") die("Error:<br>\nEl atributo [" . $this->label . "] para ser popupSelect, debe contar con un [psFrom].");
          if($this->psForeignKey=="") die("Error:<br>\nEl atributo [" . $this->label . "] para ser popupSelect, debe contar con un [psForeignKey].");
          if($this->psForeignLabel=="") die("Error:<br>\nEl atributo [" . $this->label . "] para ser popupSelect, debe contar con un [psForeignLabel].");
          $this->parent->popupsSelect=1;
        }
				elseif($attribute=="inputType" && $value=="autocomplete"){
 	        if($this->ACIdField=="") die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser autocomplete, debe contar con un [ACIdField].<br>
						Este atributo contiene el campo llave primaria,<br>
						Por ejemplo:<br><b>id</b>
					");
 	        if($this->ACLabel=="") die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser autocomplete, debe contar con un [ACLabel].<br>
						Este atributo contiene lo que se desplegará en el autocomplete,<br>
						Por ejemplo:<br><b>apellido || ', ' || nombre || ' (' || cedula || ')'</b>
					");
 	        if($this->ACFrom=="") die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser autocomplete, debe contar con un [ACFrom].<br>
						Este atributo contiene la(s) tabla(s) con sus respectivos joins de ser necesario, a partir de los cuales se hará la consulta para el autocomplete,<br>
						Por ejemplo:<br><b>personas</b>
					");
 	        if($this->ACFields=="") die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser autocomplete, debe contar con un [ACFields].<br>
						Este atributo contiene los campos por los cuales se debe buscar en las tablas (separados por comas),<br>
						Por ejemplo:<br><b>apellido,nombre,cedula</b>
					");
 	        if(!file_exists($this->parent->CFG->dirroot . "/autocomplete/autocomplete.css")) die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser autocomplete, debe existir la carpeta <b>" . $this->parent->CFG->dirroot . "/autocomplete/</b> con los respectivos archivos.<br>
						Se recomienda (estando ubicado en la carpeta <b>" . $this->parent->CFG->dirroot . "</b>) ejecutar el siguiente comando:<br>
						<b>ln -s " . $this->parent->CFG->common_libdir . "/autocomplete .</b>
					");
          $this->parent->needsAutoComplete=TRUE;
        }
				elseif($attribute=="inputType" && $value=="select_dependiente"){
					$this->parent->selectDependiente = 1;
				}
				$this->$attribute=$value;
			}
			else die("<br>El objeto [" . get_class($this) . "] no tiene el atributo [" . $attribute . "].<br>");
		}

		function get($attribute){
			if(in_array($attribute,array_keys(get_object_vars($this)))){
//TOCA REVISAR ESTO.  ES QUE HABÍA UN ERROR EN EL HTML, PORQUE ESCRIBÍA 1
				if($attribute=="editable" && $this->$attribute==1 && $this->parent->get("mode")!="update") return("");
				return($this->$attribute);
			}
			else{
				die("<br>El objeto [" . get_class($this) . "] no tiene el atributo [" . $attribute . "].<br>");
			}
		}

	}

?>
