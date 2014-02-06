<?
	class generic_object{
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

	}
?>
