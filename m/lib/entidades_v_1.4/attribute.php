<?
/*	********************************************	*/
/*	Clase para los atributos, es decir, los cam-	*/
/*	pos en las tablas.                          	*/
/*	********************************************	*/
	class attribute{
		var $parent;											//El objeto que lo contiene
		var $mandatory=FALSE;							//Si puede ser nulo o no
		var $field="";										//El nombre del campo en la base de datos
		var $fieldAlias=""; 							//Alias del campo
		var $value="";
		var $label="";										//Desplegable
		var $arrayOptions=array();						//Arreglo de datos, si es un option o checkbox
		var $arrayValues=NULL;						//Arreglo de datos, si es un SELECT
		var $foreignTable=NULL;						//Tabla asociada
		var $foreignTableFilter=NULL;			//Filtro de la tabla asociada
		var $foreignTableAlias=NULL;			//Alias para la tabla asociada
		var $foreignTableOrderBy=NULL;		//Criterio para ordenar el combo
		var $foreignField="id";						//Campo de relación en la tabla asociada
		var $foreignLabelFields=NULL;			//Los desplegables en la tabla asociada
		var $foreignModule=NULL;
		
		var $joinQuery=NULL;							//es la consulta cuando se hace con un join
//		var $fieldJoin=NULL;							//es el campo q referencia la consulta del join

		var $inputType="text";						// Tipo html para poner en los formulariosi.  Puede ser:
																			// password | select | option | checkbox | autocomplete | arraySelectJoin | arraySelect |
	 																		// popupSelect | file | image | select_dependiente | recursiveSelect | geometry | georref | text |
																			// subQuery | onlyValue | querySelect | select | textarea | date | timestamp | hidden | color | 
																			// fileFS (archivo pero en el sistema de archivos) | gLocation (Google Maps Location) | fileFTP (archivo remoto por ftp) |
																			// externalAC (AutoComplete externo) | wysiwyg (editor HTML)
		var $encrypted=FALSE;							//Para cuando es un inputType password
		var $sqlType="";									//El tipo de dato en la base de datos, si es subquery, será un pseudo campo que no existe realmente en la BD.
		var $subQuery="";									//Subconsulta para cuando el campo es de tipo subquery.  Si se escribe __id__ se reemplaza por el id de la entidad
		var $geometryType="";							//Si es una geometría, de qué tipo es
		var $geometrySRID=1;							//Si es una geometría, qué SRID tiene
		var $geometryDimension=2;					//Si es una geometría, qué dimensión tiene

		var $gmapsApiKey = "";						//Si es de tipo gLocation, la key api
		var $gLocLat = 4;									//Si es de tipo gLocation, la coordenada y por defecto
		var $gLocLng = -74;								//Si es de tipo gLocation, la coordenada x por defecto
		var $gLocZoom = 5;								//Si es de tipo gLocation, el zoom por defecto

		var $inputSize=20;								//Para el formulario HTML
		var $inputSizeAutocomplete=25;			//sólo es utilizada en el autocomplete
		var $inputRows=3;									//El rows del textarea
		var $browseable=FALSE;						//Si aparece en los listados
		var $searchable=TRUE;							//Si aparece en las búsquedas
		var $reportable=FALSE;						//Si aparece en los reportes
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

		var $searchableRange=FALSE;				//Para que en los formularios de búsqueda se pueda buscar por rangos
		var $valMin="";										//Para almacenar el valor del mínimo y el máximo
		var $valMax="";

//Si el tipo de input es querySelect
//sirve para armar el combo a partir de una consulta arbitraria.
	
		var $qsQuery="";									//La consulta como tal

//PARA EL AUTOCOMPLETE:
		var $ACIdField="";
		var $ACLabel="";
		var $ACFrom="";
		var $ACWhere="";
		var $ACFields="";
		var $ACbd = "";
		var $ACLimit = "30";

//PARA EL COMBO RECURSIVO CON EL id_superior(el inputType debe ser: recursiveSelect):
		var $parentIdName="id";
		var $parentIdLabel="nombre";
		var $parentTable="";
		var $parentRecursiveId="id_superior";
		var $useGetPath=FALSE;

//si se muestra la imagen en el listado.php,  decir de qué tamaño va a ser
		var $tamanioImagen="";

		var $tooltip = "";
		var $inputStyle = "";

//Si el tipo es fileFS, pero es una imagen y se quiere el preview:
		var $previewInForm=FALSE;
		var $previewInList=FALSE;
		var $previewWidth=80;
/*
	 Una función que se ingresa en postgres, para que en el listado pinte toda la ruta.
	 Se debe crear una función denjtro de la base de datos (sólo Postgres) así:

CREATE OR REPLACE FUNCTION getPath(node_id integer,table_name text) RETURNS text AS '
DECLARE
registro RECORD;
path TEXT;
id_sup integer;
arrayNodes TEXT[];
i integer;
BEGIN
id_sup=node_id;
path := '''';
i := 0;
LOOP
IF id_sup=0 OR id_sup IS NULL THEN
 EXIT;
 END IF;
 EXECUTE ''SELECT id, id_superior, nombre FROM '' || table_name || '' WHERE id = '' || id_sup INTO registro;
 id_sup=registro.id_superior;
 arrayNodes[i]=registro.nombre;
path := registro.nombre || ''>'' || path ;
i := i+1;
END LOOP;
return path;
END;
' LANGUAGE 'plpgsql';

*/

//PARA EL COMBO RECURSIVO DE UN SELECT A PARTIR DE OTRO SELECT (select_dependiente)
		var $namediv = "";
		var $fieldIdParent = "";
		var $dependent_fields = array();
		var $foreignFieldId = "id";
		var $parentJoin= "";	//Se escribe aquí el campo del foregnTable por el cual se debe vincular (únicamente si necesita hacer doble join)
		var $sd_condition = ""; //Si no es directa la relación, por ejemplo depende de algo que a su vez depende de otra cosa.
		
		var $jsrevision="";
		var $javaScriptRevision="";  // Si hay algún valor aquí, se emplea éste en vez de revisar su obligatoriedad.

//para mostrar el objeto de un swf, o un video. Aunque es tipo imagen, pero no se va a mostrar ninguna imagen.
		var $mostrarImagen = TRUE;
		var $reemplazoImagen = "";
		var $reemplazoID = FALSE;
	
//Para cuando es de tipo fileFTP
		var $ftpServer = "";
		var $ftpLogin = "";
		var $ftpPassword = "";
		var $ftpPath = "/";


//si se desea que en un atributo tipo textarea, se muestre todo el campo, sin cortes (se pondría en el atributo false)
		var $cut = true;

// Si se permite que se suban archivos de extensión php (cuando es file o imagen)
		var $allowPHP = false;

//	Si se permite ordenar por una columna de tipo subquery
		var $allowOrderByQuery = false;

//	Si es de tipo externalAC, el URL del conector
		var $EACUrl = "";

//	Barra de herramientas para el wysiwyg:
		var $wysiwygToolbar="['Bold','Italic','Underline','Strike','Source','Font','FontSize','TextColor','BGColor','-', 'Link', 'Unlink']";
/* Todas las opciones:
	 ['Source','-','Save','NewPage','Preview','-','Templates'],
	 ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	 ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	 ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	 '/',
	 ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	 ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	 ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	 ['Link','Unlink','Anchor'],
	 ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
	 '/',
	 ['Styles','Format','Font','FontSize'],
	 ['TextColor','BGColor'],
	 ['Maximize', 'ShowBlocks','-','About']

*/

		var $preCode="";	//Por si en los listados de resultados se le quiere poner un enlace a algún modo (como editar o detalles).  Si se escribe __id__ se reemplaza por el id de la entidad
		var $postCode="";	//Por si en los listados de resultados se le quiere poner un enlace a algún modo (como editar o detalles).  Si se escribe __id__ se reemplaza por el id de la entidad
/*
	EJEMPLO:
	$atributo->set("preCode","<a href=\"" . $ME . "?module=" . $module . "&mode=detalles&id=__id__\">");
	$atributo->set("postCode","</a>");
*/

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
			if($this->sqlType != "subquery" || $this->allowOrderByQuery) $string.="<a href='" . simple_me($ME) . $querystringAsc . "' title='Ordenar ascendentemente'>" . $txtUp . "</a>";
			$string.=$this->label;
			if($this->sqlType != "subquery" || $this->allowOrderByQuery) $string.="<a href='" . simple_me($ME) . $querystringDesc . "' title='Ordenar descendentemente'>" . $txtDown . "</a>";
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
			if(!$this->editList){
				if(trim($this->value)=="") $value="&nbsp;";
				else $value=$this->value;
				$this->preCode=str_replace("__id__",$this->parent->id,$this->preCode);
				$this->postCode=str_replace("__id__",$this->parent->id,$this->postCode);
				$value=$this->preCode . $value . $this->postCode;
				if($this->primaryKey && $this->parent->editable){
					$string.=" width='1'><input type='radio' id='radio_" . $this->value . "' name='" . $this->field . "' value=\"" . $this->value . "\">";
					if($this->browseable){
						$string.="<td class='" . $this->parent->classTD . "'>";
						if($this->ACbd != ""){
							$string.="ASD";
						}
						else $string.=$value;
					}
				}
				elseif($this->parent->editable){
					if(is_object($this->ACbd)){
						$consulta = "SELECT " . $this->ACLabel . " FROM " . $this->ACFrom . " WHERE " . $this->ACIdField . " ='" . $value . "'";
						$qid = $this->ACbd->sql_query($consulta);
						$result = $this->ACbd->sql_fetchrow($qid);
						$value = $result[0];
					}
					elseif($this->inputType=="externalAC"){
						if(!preg_match("/^http:/",$this->EACUrl)) $url="http://" . $_SERVER["HTTP_HOST"] . "/" . $this->EACUrl;
						else $url=$this->EACUrl;
						$ch=curl_init($url);
						$data=array("mode"=>"return","id"=>$value);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						$value = curl_exec($ch);
					}
					$string.="><label for='radio_" . $this->parent->id . "'>" . $value . "</label>";
				}
				else{
					
					$string.=">" . $value;
				}
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
			if($this->inputStyle !="") $inputStyle=" style=\"" . $this->inputStyle . "\" ";
			else $inputStyle="";
			($this->parent->fieldLabelClass=="") ? $class="" : $class=" class=\"" . $this->parent->fieldLabelClass . "\"";
			($this->parent->cellInputClass=="") ? $cellInputClass="" : $cellInputClass=" class=\"" . $this->parent->cellInputClass . "\"";
			($this->parent->textInputClass=="") ? $textInputClass="" : $textInputClass=" class=\"" . $this->parent->textInputClass . "\"";
			($this->parent->selectInputClass=="") ? $selectInputClass="" : $selectInputClass=" class=\"" . $this->parent->selectInputClass . "\"";
			($this->parent->bgColorFieldValue=="") ? $bgColorFieldValue="" : $bgColorFieldValue=" bgcolor=\"" . $this->parent->bgColorFieldValue . "\"";
			($this->parent->bgColorLabelFieldValue=="") ? $bgColorLabelFieldValue="" : $bgColorLabelFieldValue=" bgcolor=\"" . $this->parent->bgColorLabelFieldValue . "\"";
			($this->onClick=="") ? $onClick="" : $onClick=" onClick=\"" . $this->onClick . "\"";
			$string="";
			if($this->parent->editable){
				if($this->inputType!="geometry" && $this->inputType!="hidden")	{
					if($this->mandatory && $this->parent->mode!="buscar" && $this->parent->mode!="consultar") $asterisco="(*) ";
					else $asterisco="";
					if($this->tooltip=="") $title="";
					else $title=" title=\"" . $this->tooltip . "\"";
					if($edit == 0) $string.="<td" . $title . $class . " align='right' " . $bgColorLabelFieldValue . " nowrap>" . $asterisco . $this->label . " : </td>";
					if($this->get("defaultValue")!="" && $this->parent->mode=='agregar') $this->value=$this->get("defaultValue");
					if($this->parent->get("newMode")=="consultar") {
						$string.="<td" . $cellInputClass . $title . ">";
						if($this->inputType=="password") $this->value="*******";
						elseif($this->inputType=="select" && $this->value!=''){
							if($this->foreignTableOrderBy==NULL) $orderBy=" ORDER BY ". $this->get("foreignLabelFields");
							else $orderBy=" ORDER BY ". $this->foreignTableOrderBy;

							if($this->foreignTableAlias!=NULL)
							{
								$str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable ." as ".$this->foreignTableAlias." WHERE " . $this->foreignField . "='" .$this->value. "' ". $orderBy;
							}
							else
							{
								$str_query="SELECT " . $this->foreignField . ", " . $this->get("foreignLabelFields") . " as nombre FROM " . $this->foreignTable ." WHERE " . $this->foreignField . "='" .$this->value. "' ". $orderBy;
							}
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['nombre'];
						}
						elseif($this->inputType=="option" || $this->inputType=="checkbox"){
							foreach($this->arrayOptions AS $key => $val){
								if($this->value == $key){
									$this->value = $val;
									break;
								}
							}
						}
						elseif($this->inputType=="externalAC"){
							if(!preg_match("/^http:/",$this->EACUrl)) $url="http://" . $_SERVER["HTTP_HOST"] . "/" . $this->EACUrl;
							else $url=$this->EACUrl;
							$ch=curl_init($url);
							$data=array("mode"=>"return","id"=>$this->value);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							$this->value = curl_exec($ch);
						}
						elseif($this->inputType=="autocomplete"){
							$str_query= "SELECT DISTINCT (" . $this->ACLabel . ") as value FROM " . $this->ACFrom . " WHERE " . $this->ACIdField . " = '" . $this->value . "'";
							if(is_object($this->ACbd)) $qid=$this->ACbd->sql_query($str_query);
							else $qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['value'];
						}
						elseif($this->inputType=="querySelect"){
							$valor = $this->value;
							//para que no salga error cuando el valor es vacío.
							if($valor == "")
								$valor = 0;
							$str_query= "SELECT foo.nombre FROM (" . $this->qsQuery . ") as foo WHERE foo.id = '" . $valor."'";
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
						elseif($this->inputType=="file" || $this->inputType=="fileFS" || $this->inputType=="fileFTP"){
							if($this->inputType=="file") $script="file.php";
							elseif($this->inputType=="fileFS") $script="fileFS.php";
							elseif($this->inputType=="fileFTP") $script="fileFTP.php";

							if($this->value!=""){
								$attrFN=$this->parent->getAttributeByName("mmdd_" . $this->field . "_filename");
								$fileName=$attrFN->value;
			//					$arrFile=explode("|",$this->value);
			//					$fileName=$arrFile[0];
//								preguntar($this->value);
								$this->value="\n<a href=\"" . $script . "?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">" . $fileName . "</a>\n";
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
							if($this->foreignTableAlias!=""){
								$alias=$this->foreignTableAlias;
								$str_query = "SELECT ".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." $alias WHERE $alias.".$this->foreignField."= ".$this->value;
							}
							else{
								$str_query = "SELECT ".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." WHERE ".$this->foreignField."= ".$this->value;
							}
							$qid=$this->parent->db->sql_query($str_query);
							$value=$this->parent->db->sql_fetchrow($qid);
							$this->value=$value['nombre'];
						}
						elseif($this->inputType=="recursiveSelect"){
							if(SQL_LAYER == "postgresql" && $this->useGetPath){
								if($this->value!=""){
									if($this->parentTable=="") $parentTable=$this->parent->table;
									else $parentTable=$this->parentTable;
									$str_query = "SELECT getPath(" . $this->value . ",'" . $parentTable . "') as path";
									$qid=$this->parent->db->sql_query($str_query);
									$result=$this->parent->db->sql_fetchrow($qid);
									$this->value=$result["path"];
								}
//								$this->value=$str_query;

//							$this->value="VGR";
							}
						}
						
						$string.=nl2br($this->value);
						$string.="</td>";
						return($string);
					}
					if($edit == 0)
					{
						$string.="<td" . $title . $cellInputClass . $bgColorFieldValue .">";
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
					if($this->useGetPath) $this->parent->db->build_recursive_tree_path($this->parentTable,$options,nvl($this->value,$this->defaultValue),$this->parentIdName,$this->parentRecursiveId,$this->parentIdLabel);
					else $this->parent->db->build_recursive_tree($this->parentTable,$options,nvl($this->value,$this->defaultValue),$this->parentIdName,$this->parentRecursiveId,$this->parentIdLabel);
//					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					$string.="<select " . $selectInputClass . " name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . "><option value=''>Ra&iacute;z" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'></a>";
					}
					break;

					//el sig atributo es para recargar un select a partir de un id dado de otro select.  Para que funcione Ãste atributo,  se debe colocar en lib el archivo ajaxUpdateRecursive.php (que se encuentra en /librerias_php).
					case "select_dependiente":
						$parentAttribute=$this->parent->getAttributeByName($this->fieldIdParent);
						$onChange = "";
						if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
						if($parentAttribute->value!=0)
						{
							$alias="foo";
							if($this->foreignTableAlias!="") $alias=$this->foreignTableAlias;

							if($this->sd_condition=="") $cond="$alias.".$this->fieldIdParent." = '" . $parentAttribute->value . "'";
							else $cond=str_replace("__%idARemp%__",$parentAttribute->value,$this->sd_condition);
							
							$str_query = "SELECT $alias.".$this->foreignFieldId.",".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." ".$alias." ".$this->parentJoin." WHERE $cond";
/*
							if($this->foreignTableAlias!=""){
								$alias=$this->foreignTableAlias;
								$str_query = "SELECT $alias.".$this->foreignFieldId.",".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." $alias WHERE $alias.".$this->fieldIdParent." = '" . $parentAttribute->value . "'";
							}
							else{
								$str_query = "SELECT ".$this->foreignFieldId.",".$this->foreignLabelFields." as nombre FROM ".$this->foreignTable." WHERE ".$this->fieldIdParent." = '" . $parentAttribute->value . "'";
							}
*/
//							echo $str_query;
							$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
							$string.="<div id=\"".$this->namediv."\"><select  " . $selectInputClass . " name=\"".$this->field."\" id=\"".$this->field."\" style=\"width:250px\" ".$onChange.">" . $options . "</select></div>";
						}
						else
							$string.="<div id=\"".$this->namediv."\"><select " . $selectInputClass . " name=\"".$this->field."\" id=\"".$this->field."\" style=\"width:250px\" ".$onChange."><option value=\"%\">Seleccione...</option></select></div> ";
					break;
					
				case "geometry":
					$string="<input type='hidden' name='" . $this->field. "' value=\"" . $this->value . "\">";
					break;

				case "gLocation":
					$string.="<input type='text' name='" . $this->field. "' value=\"" . $this->value . "\" READONLY> <input type=\"button\" value=\"Ubicar\" onClick=\"gLocate(this.form." . $this->field . ")\">";
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
						if($this->readonly && $this->parent->mode != "buscar")
						  $readonly = " readonly ";
						else
						  $readonly = "";
						if($this->parent->mode == "buscar" && $this->searchableRange){
							$string.="<input type='text' size='" . $this->inputSize . "' ". $this->get("editable")." name='" . $this->field .$id . "__desde' value='" . str_replace("'","&apos;",$this->value) . "' ". $onChange ." ".$readonly . ">";
							$string.=" - <input type='text' size='" . $this->inputSize . "' ". $this->get("editable")." name='" . $this->field .$id."__hasta' value='" . str_replace("'","&apos;",$this->value) . "' ". $onChange ." ".$readonly . ">";
						}
						else
							$string.="<input type='text'" . $textInputClass . " size='" . $this->inputSize . "' ". $this->get("editable")." name='" . $this->field ."$id' value='" . str_replace("'","&apos;",$this->value) . "' ". $onChange ." ".$readonly . ">";
					}
					break;

				case "subQuery":
				case "onlyValue":
						$string.= $this->value;
					break;
					
				case "password":
					if($this->encrypted) $string.="<input type='password' size='" . $this->inputSize . "' name='" . $this->field ."$id' value=''" . $this->get("editable") . ">";
					else $string.="<input type='password' size='" . $this->inputSize . "' name='" . $this->field ."$id' value='" . $this->value . "'" . $this->get("editable") . ">";
					if($this->encrypted) $string.="<br><input type='password' size='" . $this->inputSize . "' name='__CONFIRM_" . $this->field ."$id' value=''" . $this->get("editable") . "> (Confirmar)";
					else $string.="<br><input type='password' size='" . $this->inputSize . "' name='__CONFIRM_" . $this->field ."$id' value='" . $this->value . "'" . $this->get("editable") . "> (Confirmar)";
				break;

				case "querySelect":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else{
						$onChange="onChange='";
						foreach($this->dependent_fields AS $atrib){
							$onChange.="updateRecursive_" . $atrib . "(this);";
						}
						$onChange.="'";
					}

					if($this->qsQuery=="") die("Error: Si el tipo de input es \"querySelect\", la consulta debe ir en la variable <b>qsQuery</b>");
					$str_query=$this->qsQuery;

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

					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					if($this->readonly) $readonly=" readonly ";
					else $readonly="";
					$string.="<select " . $selectInputClass . " " . $readonly . "name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . ">" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'></a>";
					}
					break;

				case "select":
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else{
						$onChange="onChange='";
						foreach($this->dependent_fields AS $atrib){
							$onChange.="updateRecursive_" . $atrib . "(this);";
						}
						$onChange.="'";
					}

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
					if($this->foreignTableOrderBy==NULL) $str_query.=" ORDER BY ". $this->get("foreignLabelFields");
					else $str_query.=" ORDER BY ".$this->foreignTableOrderBy;
					
					$options=$this->parent->db->sql_listbox($str_query,"Seleccione...",nvl($this->value,$this->defaultValue));
					if($this->readonly) $readonly=" readonly ";
					else $readonly="";
					$string.="<select " . $selectInputClass . " " . $readonly . "name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . ">" . $options . "</select>";
					if($this->foreignModule!=NULL && $this->parent->mode!="buscar") {
						$string.="&nbsp;<a href='javascript:addForeignItem(\"" . $this->foreignModule . "\",\"" . $this->field . "$id\",\"" . $this->foreignTable . "\",\"" . $this->foreignField . "\",\"" . base64_encode($this->foreignLabelFields) . "\")'>";
						$string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'></a>";
					}
					break;

				case "arraySelect":
					$name=$this->field;
					if($this->readonly){
						$readonly=" readonly ";
					}
					else $readonly="";
					if($this->onChange!="") $onChange=" onChange=\"" . $this->onChange . "\"";
          else{
						if(sizeof($this->dependent_fields)>0){
							$onChange="onChange='";
							foreach($this->dependent_fields AS $atrib){
								$onChange.="updateRecursive_" . $atrib . "(this);";
							}
							$onChange.="'";
						}
						else $onChange="";
					}
					$options="\n<option value=\"%\">Seleccione...\n";
					foreach($this->arrayValues as $key => $val){
						$options.="<option value=\"" . $key . "\"";
						if($this->parent->mode!="buscar")
							if(nvl($this->value,$this->defaultValue)==$key) $options.=" SELECTED";
						$options.=">" . $val . "\n";
					}
					
					$string.="<select id='". $name ."'" . $selectInputClass . " name='" . $name . "$id' " . $this->get("editable") . " " . $onChange  . $readonly . ">" . $options . "</select>";
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'></a>";
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
					$string.="<select " . $selectInputClass . " name='" . $this->field . "$id' " . $this->get("editable") . " " . $onChange . ">" . $options . "</select>";

					if($this->foreignModule!=NULL) 
					{
						$string.="&nbsp;<a href=\"javascript:agregar('" . $this->foreignModule . "')\">";
						$string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'></a>";
					}	
					break;	
				case "textarea":
					$string.="<textarea " . $inputStyle . " rows='" . $this->inputRows . "' cols='" . $this->inputSize . "' name='" . $this->field . "$id' " . $this->get("editable") . ">" . $this->value . "</textarea>";
					break;

				case "option":	//	Radio button
					foreach($this->arrayOptions AS $key => $val){
						$checked="";
						if($this->value!="" && $this->value==$key) $checked=" CHECKED";
						$string.="<label for='" . $this->field . "_" . $key . "'>" . $val . "</label>&nbsp;";
						$string.="<input type='radio' id='" . $this->field . "_" . $key . "' name='" . $this->field . "' value='" . $key . "' " . $checked . " " . $this->get("editable") . ">&nbsp;";
					}
/*
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
					$string.="<label for='" . $this->field . "_si'>S&iacute;</label>&nbsp;";
					$string.="<input type='radio' id='" . $this->field . "_si' name='" . $this->field . "$id' value='" . $trueVal . "' " . $checked . " " . $this->get("editable") . ">";
					$checked="";
					if($this->value==$falseVal) $checked=" CHECKED";
					$string.="&nbsp;<label for='" . $this->field . "_no'>No</label>&nbsp;";
					$string.="<input type='radio' id='" . $this->field . "_no' name='" . $this->field . "$id' value='" . $falseVal . "'" . $checked . ">";
*/
					break;

				case "checkbox":
					$checked="";
					if($this->value==1 || $this->value=="S&iacute;" || $this->value=='t') $checked=" CHECKED ";
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

					if(!$this->readonly){
						$string.="&nbsp;<a title=\"Calendario\" href=\"javascript:";
						$string.="abrir('".$this->field."');\">";
						$string.="<img alt=\"Fecha\" src='" . $this->parent->iconsPath . "/icon-date.gif' border='0'>";
						$string.="</a>";	
					}
					break;
				
				case "timestamp":
					if($this->readonly) $readonly=" readonly";
					else $readonly="";

					if($this->parent->mode=='buscar') $value="";
					elseif($this->parent->mode=='agregar' && $this->get("defaultValue")!="") $value = $this->get("defaultValue");
					elseif($this->parent->mode=='agregar' && $this->mandatory) $value = date("Y-m-d H:i:s");
					else $value = $this->value;

					$string.="<input type='text' size='25' style='text-align:center;' $readonly name='".$this->field."' value='".$value."'>";
					if(!$this->readonly){
						$string.="&nbsp;<a title=\"Calendario\" href=\"javascript:";
						if($this->parent->mode=='buscar')
							$string.="abrir('".$this->field."');\">";
						else
							$string.="abrirWHora('".$this->field."');\">";
						$string.="<img alt=\"Fecha\" src='" . $this->parent->iconsPath . "/icon-date.gif' border='0'>";
						$string.="</a>";
					}
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
            $string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'>";
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
					if($this->parent->mode=="agregar") $this->value=$this->defaultValue;
					$string="<input type='hidden' name='" . $this->field . "' value='" . $this->value . "'>";
					break;
			
				case "autocomplete":
					$string.="\n<input type='hidden' id='" . $this->field . "' name='" . $this->field . "' value='" . $this->value . "'>\n";
					$label="";
					if($this->value!=""){
						$strQuery="SELECT " . $this->ACLabel . " FROM " . $this->ACFrom . " WHERE " . $this->ACIdField . " = '" . $this->value . "'";
//						echo $strQuery."<br>";
//						echo $this->ACbd;
						if(is_object($this->ACbd))
							$qid=$this->ACbd->sql_query($strQuery);
						else
							$qid=$this->parent->db->sql_query($strQuery);

						if($result=$this->parent->db->sql_fetchrow($qid)) $label=$result[0];
					}
					if($this->readonly) $readonly=" readonly";
					else $readonly="";
/*
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
*/
				 	$qString="?dirroot=" . urlencode($this->parent->CFG->dirroot);
				 	$qString.="&module=" . urlencode($this->parent->name);
				 	$qString.="&field=" . urlencode($this->field);

					$string.='<div class=" yui-skin-sam" style="width:25em;padding-bottom:2em;position:relative;"><input style="width:'.$this->inputSizeAutocomplete.'em;" id="AC_' . $this->field . '" type="text" value="' . $label . '"><div style="width:'.$this->inputSizeAutocomplete.'em;" id="popup_' . $this->field . '"></div></div>';
					$string.='
<script type="text/javascript">
YAHOO.example.BasicRemote = function() {
    // Use an XHRDataSource
    var oDS = new YAHOO.util.XHRDataSource("' . $this->parent->CFG->wwwroot . '/autocomplete2/autocomplete.php");
    // Set the responseType
    oDS.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
    // Define the schema of the delimited results
    oDS.responseSchema = {
        recordDelim: "\n",
        fieldDelim: "\t"
    };
    // Enable caching
    oDS.maxCacheEntries = 5;
    // Instantiate the AutoComplete
    var oAC = new YAHOO.widget.AutoComplete("AC_' . $this->field . '", "popup_' . $this->field . '", oDS);
		oAC.maxResultsDisplayed = 30;
    oAC.generateRequest = function(sQuery) {
      return "' . $qString . '&s=" + sQuery ;
    };

    // Define an event handler to populate a hidden form field
    // when an item gets selected
    var myHiddenField = YAHOO.util.Dom.get("' . $this->field .'");
    var myHandler = function(sType, aArgs) {
      var myAC = aArgs[0]; // reference back to the AC instance
      var elLI = aArgs[1]; // reference to the selected LI element
      myHiddenField.value = aArgs[2][1];
    };
    oAC.itemSelectEvent.subscribe(myHandler);

    return {
        oDS: oDS,
        oAC: oAC
    };
}();
</script>						
					';
					
					if($this->foreignModule!=NULL) {
						$string.="&nbsp;<a href='javascript:addACPopup(\"" . $this->foreignModule . "\",\"" . $this->field . "\")'>";
						$string.="<img alt=\"Add\" src='" . $this->parent->iconsPath . "/icon-add.gif' border='0'></a>";
					}
					break;

				case "externalAC":
					$string.="\n<input type='hidden' id='" . $this->field . "' name='" . $this->field . "' value='" . $this->value . "'>\n";
					$label="";
					if($this->value!=""){
						if(!preg_match("/^http:/",$this->EACUrl)) $url="http://" . $_SERVER["HTTP_HOST"] . "/" . $this->EACUrl;
						else $url=$this->EACUrl;
						$ch=curl_init($url);
						$data=array("mode"=>"return","id"=>$this->value);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						$label = curl_exec($ch);
					}
					if($this->readonly) $readonly=" readonly";
					else $readonly="";

				 	$qString="?dirroot=" . urlencode($this->parent->CFG->dirroot);
				 	$qString.="&module=" . urlencode($this->parent->name);
				 	$qString.="&field=" . urlencode($this->field);

					if($this->EACUrl=="") die("El atributo " . $this->field . " debe tener la propiedad EACUrl (el URL de donde se toman los valores.)");

					$string.='<div class=" yui-skin-sam" style="width:25em;padding-bottom:2em;position:relative;"><input style="width:'.$this->inputSizeAutocomplete.'em;" id="AC_' . $this->field . '" type="text" value="' . $label . '"><div style="width:'.$this->inputSizeAutocomplete.'em;" id="popup_' . $this->field . '"></div></div>';
					$string.='
<script type="text/javascript">
YAHOO.example.BasicRemote = function() {
    // Use an XHRDataSource
    var oDS = new YAHOO.util.XHRDataSource("' . $this->EACUrl . '");
    // Set the responseType
    oDS.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
    // Define the schema of the delimited results
    oDS.responseSchema = {
        recordDelim: "\n",
        fieldDelim: "\t"
    };
    // Enable caching
    oDS.maxCacheEntries = 5;
    // Instantiate the AutoComplete
    var oAC = new YAHOO.widget.AutoComplete("AC_' . $this->field . '", "popup_' . $this->field . '", oDS);
		oAC.maxResultsDisplayed = 30;
    oAC.generateRequest = function(sQuery) {
      return "' . $qString . '&s=" + sQuery ;
    };

    // Define an event handler to populate a hidden form field
    // when an item gets selected
    var myHiddenField = YAHOO.util.Dom.get("' . $this->field .'");
    var myHandler = function(sType, aArgs) {
      var myAC = aArgs[0]; // reference back to the AC instance
      var elLI = aArgs[1]; // reference to the selected LI element
      myHiddenField.value = aArgs[2][1];
    };
    oAC.itemSelectEvent.subscribe(myHandler);

    return {
        oDS: oDS,
        oAC: oAC
    };
}();
</script>						
					';
					
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
							$string.="\n<img src=".$this->parent->CFG->wwwroot."/phpThumb/phpThumb.php?src=".$archivo.$width." border=0><br>
							<a href='".$this->parent->CFG->admin_dir . "/index.php?module=".$this->parent->name."&mode=eliminarImagen&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Imagen)</a><br>\n";
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
						$string.="\nArchivo actual:\n";
						$attrFN=$this->parent->getAttributeByName("mmdd_" . $this->field . "_filename");
						$fileName=$attrFN->value;
						$string.="\n<a href=\"file.php?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">" . $fileName . "</a>&nbsp;&nbsp;&nbsp;";
						if(!$this->mandatory)
							$string.="<a href='index.php?module=".$this->parent->name."&mode=eliminarImagen&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Archivo)</a>";
						$string.="<br>\n";
					}
					$string.="\n<input type='file' name='" . $this->field . "' size='" . $this->inputSize . "' >\n";
					break;

				case "fileFS":
					if($this->value!=""){
						$string.="\nArchivo actual:<br>\n";
						$attrFN=$this->parent->getAttributeByName("mmdd_" . $this->field . "_filename");
						$fileName=$attrFN->value;
						$string.="\n<a href=\"fileFS.php?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">";
					 	if($this->previewInForm) $string.="\n<img src=\"".$this->parent->CFG->wwwroot."/phpThumb/phpThumb.php?src=".$this->parent->CFG->dirroot . "/" . $this->parent->CFG->filesdir . "/" . $this->parent->get("table") . "/" . $this->field . "/" . $this->parent->get("id")."&amp;w=" . $this->previewWidth . "\" border=\"0\">";
						else $string.=$fileName;
					 	$string.="</a>&nbsp;&nbsp;&nbsp;";
						if(!$this->mandatory) $string.="<a href='index.php?module=".$this->parent->name."&mode=eliminarFS&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Archivo)</a>";
						$string.="<br>\n";
					}
					$string.="\n<input type='file' name='" . $this->field . "' size='" . $this->inputSize . "' >\n";
					break;

				case "fileFTP":
					if($this->value!=""){
						$string.="\nArchivo actual:<br>\n";
						$attrFN=$this->parent->getAttributeByName("mmdd_" . $this->field . "_filename");
						$fileName=$attrFN->value;
						$string.="\n<a href=\"fileFTP.php?table=" . $this->parent->get("table") . "&amp;field=" . $this->field . "&amp;id=" . $this->parent->get("id") . "\" class=\"link_azul\">" . $fileName . "</a>&nbsp;&nbsp;&nbsp;<a href='index.php?module=".$this->parent->name."&mode=eliminarFTP&field=".$this->field."&id=".$this->parent->get("id")."' class=\"link_azul_borrar\">(Borrar Archivo)</a><br>\n";
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

				case "wysiwyg":
					$string.="<textarea " . $inputStyle . " rows='" . $this->inputRows . "' cols='" . $this->inputSize . "' name='" . $this->field . "' " . $this->get("editable") . ">" . $this->value . "</textarea>\n";
					$string.="<script type=\"text/javascript\">\n";
					$string.="//<![CDATA[\n";
					$string.="CKEDITOR.replace( '" . $this->field . "',\n";
					$string.="{\ntoolbar :\n[\n" . $this->wysiwygToolbar . "]\n}\n";
				 	$string.=");\n";
					$string.="//]]>\n";
					$string.="</script>\n";
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

		function moverImagenToArchivo($table,$field,$id){
			if(isset($this->parent->CFG->tmpdir) && is_dir($this->parent->CFG->tmpdir) && is_writable($this->parent->CFG->tmpdir)) $tmpdir=$this->parent->CFG->tmpdir;
			else $tmpdir="/tmp/";
			$strQuery="SELECT ".$field." as image,mmdd_".$field."_filename as fn FROM ".$table." WHERE id = '".$id."'";
			$qid=$this->parent->db->sql_query($strQuery);
			if($result=$this->parent->db->sql_fetchrow($qid)){
				srand( (double) microtime()*1000000 );
				$nombre = str_replace(" ","_",$result["fn"]);
				$archivo = $tmpdir . "/".md5( rand() )."_".$nombre;
				if($this->value!="") $imgImg=base64_decode($this->value);
				else $imgImg=base64_decode($result["image"]);
				$gestor = fopen($archivo,"x+");
				fwrite($gestor,$imgImg);
				fclose($gestor);
				return $archivo;
				//    file_put_contents($archivo,$imgImg);
			}
			else{
				if($this->value!=""){
					$attFileName=$this->parent->getAttributeByName("mmdd_".$field."_filename");
					srand( (double) microtime()*1000000 );
					$nombre = str_replace(" ","_",$attFileName->value);
					$archivo = $tmpdir . "/".md5( rand() )."_".$nombre;
					$imgImg=base64_decode($this->value);
					$gestor = fopen($archivo,"x+");
					fwrite($gestor,$imgImg);
					fclose($gestor);
					return $archivo;
				}
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
			elseif(!isset($sqlType)) return("");
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
			if($this->inputType=="subQuery" || $this->inputType=="dummy") return("");
			if($this->javaScriptRevision!="") return($this->javaScriptRevision);
			$string="";
			switch($this->inputType){
				case "option":
					if($this->mandatory){
						$string.="
							var seleccionadas=0;
							for(i=0;document.entryform." . $this->field . "[i]!=undefined;i++){
//								if(document.entryform." . $this->field . "[i].value=='1' || document.entryform." . $this->field . "[i].value=='t') seleccionadas++;
								if(document.entryform." . $this->field . "[i].checked) seleccionadas++;
							}
							if(seleccionadas==0){
								window.alert('Por favor seleccione una opción para: " . preg_replace("/<[^>]*>/","",$this->get("label")) . "');
								return(false);
							}
						";
					}
				break;
				case "select":
				case "arraySelectJoin":
				case "arraySelect":
				case "querySelect":
				case "select_dependiente":
					if($this->mandatory){
						$string.="if(document.entryform." . $this->field . ".options[document.entryform." . $this->field . ".selectedIndex].value=='%'){\n";
						$string.="\twindow.alert('Por favor seleccione: " . preg_replace("/<[^>]*>/","",$this->get("label")) . "');\n";
						$string.="\tdocument.entryform." . $this->field . ".focus();\n";
						$string.="\treturn(false);\n";
						$string.="}\n";
					}
				break;

				case "image":
				case "fileFS":
					if($this->mandatory){
						$string.="if(document.entryform." . $this->field . ".value.replace(/ /g, '') =='' && document.entryform.mmdd_" . $this->field . "_filename.value.replace(/ /g, '') ==''){\n";
						$string.="\twindow.alert('Por favor escriba: " . preg_replace("/<[^>]*>/","",$this->get("label")) . "');\n";
						$string.="\tdocument.entryform." . $this->field . ".focus();\n";
						$string.="\treturn(false);\n";
						$string.="}\n";
					}
				break;

				default:
					if($this->mandatory){
						//$string.="if(document.entryform." . $this->field . ".value==''){\n";
						$string.="if(document.entryform." . $this->field . ".value.replace(/ /g, '') ==''){\n";
						$string.="\twindow.alert('Por favor escriba: " . preg_replace("/<[^>]*>/","",$this->get("label")) . "');\n";
						$string.="\tdocument.entryform." . $this->field . ".focus();\n";
						$string.="\treturn(false);\n";
						$string.="}\n";
						$string.="else{\n";
					}
					else $string.="if(document.entryform." . $this->field . ".value !=''){\n";
					$string.="\tvar regexpression=" . $this->getJSRegExp() . ";\n";
					$string.="\tif(!regexpression.test(document.entryform." . $this->field . ".value)){\n";
					$string.="\t\twindow.alert('[" . preg_replace("/<[^>]*>/","",$this->get("label")) . "] no contiene un dato válido.');\n";
					$string.="\t\tdocument.entryform." . $this->field . ".focus();\n";
					$string.="\t\treturn(false);\n";
					$string.="\t}\n";
					$string.="}\n";
				break;

			}

			if($this->inputType=="password"){
				$string.="if(document.entryform." . $this->field . ".value != document.entryform.__CONFIRM_" . $this->field .".value){\n";
				$string.="\twindow.alert('La confirmación de " . preg_replace("/<[^>]*>/","",$this->get("label")) . " no corresponde.');\n";
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
					if($this->inputType=="option"){
						if(count($this->arrayOptions)==0){
							if($value=="boolean" && SQL_LAYER == "postgresql") $this->arrayOptions=array("t"=>"Sí","f"=>"No");
							else $this->arrayOptions=array("0"=>"No","1"=>"Sí");
						}
					}
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
 	        if(!file_exists($this->parent->CFG->dirroot . "/autocomplete/autocomplete.css") && !file_exists($this->parent->CFG->dirroot . "/autocomplete2/autocomplete.php")) die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser autocomplete, debe existir la carpeta <b>" . $this->parent->CFG->dirroot . "/autocomplete/</b> con los respectivos archivos o la carpeta <b>" . $this->parent->CFG->dirroot . "/autocomplete2/</b>.<br>
						Se recomienda (estando ubicado en la carpeta <b>" . $this->parent->CFG->dirroot . "</b>) ejecutar el siguiente comando:<br>
						<b>ln -s " . $this->parent->CFG->common_libdir . "/autocomplete .</b>
					");
          $this->parent->needsAutoComplete=TRUE;
					if($this->foreignModule!=null) $this->parent->needsACPopup=TRUE;
        }
				elseif($attribute=="foreignModule" && $value!="" && $this->inputType=="autocomplete") $this->parent->needsACPopup=TRUE;
				elseif($attribute=="inputType" && $value=="externalAC"){
 	        if($this->EACUrl=="") die("
						Error:<br>\nEl atributo [" . $this->label . "] para ser externalAC, debe contar con un valor para [EACUrl].<br>
						Este atributo contiene el URL de donde se toman los valores.<br>
					");
          $this->parent->needsAutoComplete=TRUE;
        }
				elseif($attribute=="inputType" && $value=="gLocation"){
					$this->parent->needsGLocation = 1;
				}
				elseif($attribute=="inputType" && $value=="select_dependiente"){
					$this->parent->selectDependiente = 1;
				}
				elseif($attribute=="inputType" && $value=="option" && $this->sqlType!=""){
					if(count($this->arrayOptions)==0){
						if($this->sqlType=="boolean" && SQL_LAYER == "postgresql") $this->arrayOptions=array("t"=>"Sí","f"=>"No");
						else $this->arrayOptions=array("0"=>"No","1"=>"Sí");
					}
				}
				elseif($attribute=="fieldIdParent"){
					if(!$parentAttribute=$this->parent->getAttributeByName($value)) die("No se encuentra el atributo del cual depende ($value)");
					$parentAttribute->dependent_fields[]=$this->get("field");
				}
				elseif($attribute=="inputType" && $value=="wysiwyg"){
					$this->parent->needsWYSIWYG = 1;
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
