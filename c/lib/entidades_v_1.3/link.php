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
	var $popup=FALSE;    					//Permite definir si el link abrirá un popup.
	var $field="";              //El campo relacionado en la otra tabla
	var $fieldTitleTable="";    //El campo para el titulo de la tabla a la que va.
	var $actionMap="";    			//URL adicional para los link que apuntan a un mapa.
	var $javaScriptWindow=FALSE;    //Si el link se abre en una ventana nueva
	var $jsWindowWidth=450;         //Ancho de la ventana de javascript
	var $jsWindowHeight=350;        //Alto de la ventana de javascript
	var $jsWindowScrollBars="yes";  //Si la ventana de javascript lleva scrollbars
	var $relatedTable="";				//Si está vinculada con otra tabla
	var $visible=TRUE;					//Si es visible en los listados y formularios


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
}

?>
