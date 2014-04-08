<?

/*  ********************************************  */
/*  Clase para los links, es decir, para las op-  */
/*  ciones en los listados.                       */
/*  ********************************************  */
class link{
	var $parent;                //El objeto que lo contiene
	var $name="";               //El nombre del link
	var $url="";                //La página a la que se va
	var $target="";             //Permite especificar el target del ancla (<a>)
	var $letra="";              //La letra (ícono)
	var $iconoLetra="";             //La letra (ícono)
	var $icon="";               //El ícono
	var $bgColor="";            //El color de fondo del link
	var $textColor="#FFFFFF";   //El color del texto del link
	var $description="";        //El texto del url
	var $type="";    						//Tipo de link, permitirá abrir iframe en los popups.
															//También puede ser: incell o checkbox
	var $frameHeight=200;    		//Permite especificar la altura del frame en el formulario
	var $popup=FALSE;    				//Permite definir si el link abrirá un popup.
	var $showInEdit=TRUE; 			//Permite definir si el link se mostrará en la ventana de edición.
	var $field="";              //El campo relacionado en la otra tabla
	var $fieldTitleTable="";    //El campo para el titulo de la tabla a la que va.
	var $actionMap="";    			//URL adicional para los link que apuntan a un mapa.
	var $javaScriptWindow=FALSE;    //Si el link se abre en una ventana nueva
	var $jsWindowWidth=450;         //Ancho de la ventana de javascript
	var $jsWindowHeight=350;        //Alto de la ventana de javascript
	var $jsWindowScrollBars="yes";  //Si la ventana de javascript lleva scrollbars
	var $relatedTable="";				//Si está vinculada con otra tabla
	var $visible=TRUE;					//Si es visible en los listados y formularios

	var $relatedICTable = "";	//si es tipo incell o checkbox,  es la tabla con el que se relaciona
	var $relatedICTableAlias = "";	//si es tipo incell o checkbox,  el alias
	var $relatedICTableFilter = "";	//si es tipo incell o checkbox,  el filtro que se le debe aplicar a la consulta
	var $relatedICField = "";		//el campo
	var $relatedICIdFieldUno = "";
	var $relatedICIdFieldDos = "";
	var $relatedICComplement = "";
	var $relatedIC = "";
	var $browseable = FALSE;  //En caso de incell y checkbox, si se deben listar
	var $reportable = FALSE; 	//En caso de incell y checkbox, si se deben incluír en el reporte
	var $numCols = 1; 	//En caso de checkbox, el número de columnas en que debe salir la información.

	var $deleteCascade = FALSE;	//OJO: Si al borrar el elemento debe borrar en cascada los elementos relacionados.  USAR CON CUIDADO

	/*  CONSTRUCTOR */
	function link(&$parent){
		$this->parent = &$parent;
	}

	function getHtml($marco=0){
		GLOBAL $CFG;
	
		if(!$this->visible) return("");
		if($this->bgColor=="") $this->bgColor=$this->parent->get("rowColor");
		$string="<td valign='middle' align='center' bgcolor='" . $this->get("bgColor") . "' NOWRAP>";
		$this->set("url",str_replace(urlencode("@@@@@@@@@@"),str_pad($this->parent->get("id"),10),$this->get("url")));
		if(($marco==1 || $this->popup==TRUE) && $this->target=="") $this->javaScriptWindow=TRUE;
		if($this->get("javaScriptWindow")){
			if($this->type=="map"){
				$string.="<a href=\"javascript:window.parent.parent.opener.location.href='";
				$string.=$CFG->servidor.$CFG->wwwmodulesdir."/map.phtml?cliente=".$this->parent->get("id")."';";
				$string.="window.parent.parent.results.src=window.parent.parent.results.src;";
				//					$string.="window.parent.parent.close();";
				$string.="\"";
			}
			else
			{
				$string.="<a href=\"javascript:abrirVentanaJavaScript('" . $this->get("name") . "',";
				$string.=$this->get("jsWindowWidth") . "," . $this->get("jsWindowHeight") . ",";
				if($this->popup==FALSE){
					if($marco==0)
						$string.="'" . $this->get("url") . "&amp;" . $this->get("field") . "=" . $this->parent->get("id") . "',";
					else
						$string.="'" . $this->get("url") . "&amp;" . $this->get("field") . "=" . $this->parent->get("id") . "&amp;popup',";
				}
				else
					$string.="'" . $this->get("url") . "&amp;" . $this->get("field") . "=" . $this->parent->get("id") . "&amp;popup',";
				$string.="'" . $this->get("jsWindowScrollBars") . "')\" ";
			}
		}
		else{
			if($this->name=="programa_especiales"){
				$att=$this->parent->getAttributeByName("fecha");
			}
			else{
				$att=$this->parent->getAttributeByName("id");
			}
			$string.="&nbsp;<a href='" . $this->get("url") . "&amp;" . $this->get("field") . "=" . $att->value . "&amp;table_parent=" . $this->parent->get("table") . "&amp;id_parent=" . $this->parent->get("id") . "&amp;ftt=" . $this->get("fieldTitleTable"). "' ";
			if($this->target != "") $string.="target='" . $this->target . "' ";
		}
		$string.="title='" . $this->get("description") . "'";
		$string.=" class='icono'>";

		if($this->get("icon")==""){
			if($this->get("iconoLetra")!="") $string.=$this->get("iconoLetra");
			elseif($this->parent->get("iconsPath")!=""){
				$str=$this->get("letra");
				for($i=0;$i<strlen($str);$i++){
					$string.="<img alt=\"" . $this->get("description") . "\" border='0' src='" . $this->parent->get("iconsPath") . "/" . strtolower($str[$i]) . ".gif'>";
				}
			}
			else $string.=$this->get("");
		}
		else{
			$string.="<img alt=\"" . $this->get("description") . "\" border='0' src='" . $this->parent->get("iconsPath") . "/" . $this->get("icon") . "'>";
		}
		$string.="</a>&nbsp;";
		$string.="</td>";
		return $string;
	}

	function set($attribute,$value){
		if(in_array($attribute,array_keys(get_object_vars($this)))){
			$this->$attribute=$value;
		}
		else die("<br>El atributo [" . $attribute . "] no existe.<br>");
	}

	function get($attribute){
		if(in_array($attribute,array_keys(get_object_vars($this)))) return($this->$attribute);
		else die("<br>El atributo [" . $attribute . "] no existe.");
	}

	function pintar_incell()
	{
		$string = "<table widht=\"100%\">\n<tr><td align=\"center\">Opciones</td><td>&nbsp;</td><td align=\"center\">Actuales</td></tr>\n<tr>";

		$centro="
			<td align='center' width=\"100\">
				<table width=\"100%\" height=\"100%\">
					<tr>
						<td valign=\"top\" height=\"30\" align=\"left\">
							<input type=\"button\" style=\"font-size:8pt\" value=\"Agregar --&gt;\" onClick=\"addIt_".$this->get("relatedTable")."()\">
						</td>
					</tr>
					<tr>
						<td valign='bottom' height=\"40\" align=\"right\">
							<input style=\"font-size:8pt\" type=\"button\" value=\"&lt;-- Quitar\" onClick=\"delIt_".$this->get("relatedTable")."()\">
						</td>
					</tr>
				</table>
			</td>\n";
		
		//las parciales
		if(SQL_LAYER == "postgresql")
			$strSQL="
			SELECT ".$this->get("relatedTable").".id,".$this->get("relatedICTable").".".$this->get("relatedICField")." as nombre,".$this->get("relatedICTable").".id as anot_id
			FROM ".$this->get("relatedTable")." 
			LEFT JOIN ".$this->get("relatedICTable")." ON ".$this->get("relatedICTable").".id = ".$this->get("relatedTable").".".$this->get("relatedICIdFieldDos")." 
			".$this->get("relatedICComplement")." WHERE ".$this->get("relatedTable").".".$this->get("relatedICIdFieldUno")."='".$this->parent->get("id") . "'
		";
		else
			$strSQL="
			SELECT ".$this->get("relatedTable").".id,concat(".$this->get("relatedICTable").".".$this->get("relatedICField").",'') as nombre,".$this->get("relatedICTable").".id as anot_id
			FROM ".$this->get("relatedTable")." 
			LEFT JOIN ".$this->get("relatedICTable")." ON ".$this->get("relatedICTable").".id = ".$this->get("relatedTable").".".$this->get("relatedICIdFieldDos")." 
			".$this->get("relatedICComplement")." WHERE ".$this->get("relatedTable").".".$this->get("relatedICIdFieldUno")."='".$this->parent->get("id") . "'
		";

		$qid = $this->parent->db->sql_query($strSQL);
//		$parciales= "<td>=\"PickList_".$this->get("relatedTable")."[]\" ID=\"PickList_".$this->get("relatedTable")."\" SIZE=\"5\" >";
		$parciales= "<td>=\"".$this->get("relatedTable")."[]\" ID=\"PickList_".$this->get("relatedTable")."\" SIZE=\"5\" MULTIPLE >";
		$ids_existentes = array(0);
		while($query = $this->parent->db->sql_fetchrow($qid)){
			$parciales.= "<option value=\"".$query["anot_id"]."\">".$query["nombre"]."</option>";	
			$ids_existentes[] = $query["anot_id"];
		}
		$parciales.= "</select></td>\n";

		//las totales
		if(SQL_LAYER == "postgresql")
			$cons = "SELECT ".$this->get("relatedICTable").".id,".$this->get("relatedICField")." as nombre FROM ".$this->get("relatedICTable")." ".$this->get("relatedICComplement")." WHERE ".$this->get("relatedICTable").".id NOT IN (".implode($ids_existentes,",").") ORDER BY nombre";
		else
			$cons = "SELECT ".$this->get("relatedICTable").".id,concat(".$this->get("relatedICField").",'') as nombre FROM ".$this->get("relatedICTable")." ".$this->get("relatedICComplement")." WHERE ".$this->get("relatedICTable").".id NOT IN (".implode($ids_existentes,",").") ORDER BY nombre";

//		echo $cons;
		$qidD = $this->parent->db->sql_query($cons);

		$totales= "<td>=\"SelectList_".$this->get("relatedTable")."\" ID=\"SelectList_".$this->get("relatedTable")."\" SIZE=\"5\" MULTIPLE >";
		while($queryD = $this->parent->db->sql_fetchrow($qidD)){
			$totales.= "<option value=\"".$queryD["id"]."\">".$queryD["nombre"]."</option>";
		}
		$totales.= "</td>";


		$string.=$totales . $centro . $parciales;
		
		$string.="</tr></table>";


		$string .= "<SCRIPT LANGUAGE=\"JavaScript\">
			<!--
			// Control flags for list selection and sort sequence
			// Sequence is on option value (first 2 chars - can be stripped off in form processing)
			// It is assumed that the select list is in sort sequence initially
			
		var singleSelect_".$this->get("relatedTable")." = true; // Allows an item to be selected once only
		var sortSelect_".$this->get("relatedTable")." = true; // Only effective if above flag set to true
		var sortPick_".$this->get("relatedTable")." = true; // Will order the picklist in sort sequence
		
		// Initialise - invoked on load
		function initIt_".$this->get("relatedTable")."() {
			var selectList = document.getElementById(\"SelectList_".$this->get("relatedTable")."\");
			var pickList = document.getElementById(\"PickList_".$this->get("relatedTable")."\");
			var pickOptions = pickList.options;
			
			pickOptions[0] = null; // Remove initial entry from picklist (was only used to set default width)
			selectList.focus(); // Set focus on the selectlist
		}
		
		// Adds a selected item into the picklist
		function addIt_".$this->get("relatedTable")."() {
			
			var selectList = document.getElementById(\"SelectList_".$this->get("relatedTable")."\");
			var selectIndex = selectList.selectedIndex;
			var selectOptions = selectList.options;
			var pickList = document.getElementById(\"PickList_".$this->get("relatedTable")."\");
			var pickOptions = pickList.options;
			var pickOLength = pickOptions.length;
			
			// An item must be selected
			if (selectIndex > -1) {
				pickOptions[pickOLength] = new Option(selectList[selectIndex].text);
				pickOptions[pickOLength].value = selectList[selectIndex].value;

				// If single selection, remove the item from the select list
				if (singleSelect_".$this->get("relatedTable").") {
					selectOptions[selectIndex] = null;
				}
				
				if (sortPick_".$this->get("relatedTable").") {
					var tempText;
					var tempValue;
					
					// Sort the pick list
					while (pickOLength > 0 && pickOptions[pickOLength].value < pickOptions[pickOLength-1].value) {
						tempText = pickOptions[pickOLength-1].text;
						tempValue = pickOptions[pickOLength-1].value;
						pickOptions[pickOLength-1].text = pickOptions[pickOLength].text;
						pickOptions[pickOLength-1].value = pickOptions[pickOLength].value;
						pickOptions[pickOLength].text = tempText;
						pickOptions[pickOLength].value = tempValue;
						pickOLength = pickOLength - 1;
					}
				}
			}
		}
		
		
		
		// Deletes an item from the picklist
		
		function delIt_".$this->get("relatedTable")."() {
			var selectList = document.getElementById(\"SelectList_".$this->get("relatedTable")."\");
			var selectOptions = selectList.options;
			var selectOLength = selectOptions.length;
			var pickList = document.getElementById(\"PickList_".$this->get("relatedTable")."\");
			var pickIndex = pickList.selectedIndex;
			var pickOptions = pickList.options;
			
			if (pickIndex > -1) {
				// If single selection, replace the item in the select list
				if (singleSelect_".$this->get("relatedTable").") {
					selectOptions[selectOLength] = new Option(pickList[pickIndex].text);
					selectOptions[selectOLength].value = pickList[pickIndex].value;
				}

				pickOptions[pickIndex] = null;
				
				if (singleSelect_".$this->get("relatedTable")." && sortSelect_".$this->get("relatedTable").") {
					var tempText;
					var tempValue;
					
					// Re-sort the select list
					while (selectOLength > 0 && selectOptions[selectOLength].value < selectOptions[selectOLength-1].value) {
						tempText = selectOptions[selectOLength-1].text;
						tempValue = selectOptions[selectOLength-1].value;
						selectOptions[selectOLength-1].text = selectOptions[selectOLength].text;
						selectOptions[selectOLength-1].value = selectOptions[selectOLength].value;
						selectOptions[selectOLength].text = tempText;
						selectOptions[selectOLength].value = tempValue;
						selectOLength = selectOLength - 1;
					}
				}
			}
		}
		-->
		</SCRIPT>";

		return $string;
	}

	function pintar_checkbox()
	{

		$string = "<table widht=\"100%\">\n<tr><td align=\"left\" valign=\"top\">";

		//la una
		$ids_insert = array();
		if($this->parent->get("id")=="") $this->parent->set("id",0);
		$strSQL="
			SELECT b.id
			FROM ".$this->get("relatedTable")." a 
			LEFT JOIN ".$this->get("relatedICTable")." b ON b.id = a.".$this->get("relatedICIdFieldDos")." 
			".$this->relatedICComplement."
			WHERE a.".$this->get("relatedICIdFieldUno")."='".$this->parent->get("id") . "'
		";
//		preguntar($strSQL);
		$qid = $this->parent->db->sql_query($strSQL);
		while($query = $this->parent->db->sql_fetchrow($qid))
		{
			$ids_insert[] = $query["id"];
		}
	
		if($this->relatedICTableFilter!="") $condicion=" WHERE " . $this->relatedICTableFilter;
		else $condicion="";
		if($this->relatedICTableAlias=="") 
			$consulta = "SELECT ".$this->get("relatedICTable").".id,".$this->get("relatedICField")." as nombre 
					FROM ".$this->get("relatedICTable").$this->relatedICComplement." $condicion 
					ORDER BY nombre";
		else
			$consulta = "SELECT " . $this->relatedICTableAlias . ".id,".$this->get("relatedICField")." as nombre
			FROM ".$this->get("relatedICTable")." " . $this->relatedICTableAlias .$this->relatedICComplement. " $condicion 
			ORDER BY nombre";
//		echo $consulta;

		$qidD = $this->parent->db->sql_query($consulta);
		$totalElementos=$this->parent->db->sql_numrows($qidD);
		$i=0;
		while($queryD = $this->parent->db->sql_fetchrow($qidD))
		{
			if(($i%(ceil($totalElementos/$this->numCols)))==0) $string.="</td><td valign=\"top\">";
			$ckecked = "";
			if(in_array($queryD["id"],$ids_insert))	$ckecked = " checked";
			$string .= "<input type=\"checkbox\" name=\"".$this->get("relatedTable")."[]\" value=\"".$queryD["id"]."\" id=\"".$queryD["nombre"]."\"".$ckecked.">".$queryD["nombre"]."<br>\n";
			$i++;
		}
	
		$string .= "</td></tr></table>";

        
		if($this->get("relatedTable")=="pub_publico_areas"){
			$string .="<div id='".$this->get("relatedTable")."_css'><div>Otras:";
			}else{
			$string .="<div id='".$this->get("relatedTable")."_css'><div>Otros:";
		}
		

        $string .="</div><input name=\"".$this->get("relatedTable")."datos\" id=\"".$this->get("relatedTable")."\" type=\"text\" /></div>";

		return $string;
	}

}

?>
