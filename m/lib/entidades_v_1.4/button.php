<?

/*  ********************************************  */
/*  Clase para los botones.                       */
/*  ********************************************  */
class button {
	var $parent;                //El objeto que lo contiene
	var $name="";               //El nombre del botón
	var $caption="";            //El texto del botón
	var $js="";                 //El código de javascript asociado al botón
	var $onClick=NULL;          //La acción del onclick
	var $individual="0";        //Indica si la acción se ejecuta sobre el ítem seleccionado o no

	/*  CONSTRUCTOR */
	function button(&$parent){
		$this->parent = &$parent;
	}

	function set($attribute,$value){
		if(in_array($attribute,array_keys(get_object_vars($this)))){
			$this->$attribute=$value;
		}
		else return(FALSE);
	}

	function get($attribute){
		if(in_array($attribute,array_keys(get_object_vars($this)))) return($this->$attribute);
		else die("<br>El atributo [" . $attribute . "] no existe.");
	}
}

?>
