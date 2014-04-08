<?

/*  ********************************************  */
/*  Clase para los botones.                       */
/*  ********************************************  */
class button {
	var $parent;                //El objeto que lo contiene
	var $name="";               //El nombre del bot�n
	var $caption="";            //El texto del bot�n
	var $js="";                 //El c�digo de javascript asociado al bot�n
	var $onClick=NULL;          //La acci�n del onclick
	var $individual="0";        //Indica si la acci�n se ejecuta sobre el �tem seleccionado o no

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
