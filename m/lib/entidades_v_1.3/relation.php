<?

/*  ********************************************  */
/*  Clase para llevar las relaciones muchos a     */
/*  muchos.  Las uno a muchos van en la clase     */
/*  [attribute]                                   */
/*  ********************************************  */
  class relationship{
    var $name;
    var $label;
    var $intermediateTable;
    var $foreignName;
    var $masterField="id";
    var $masterFieldValue;
    var $intermediateTableMasterField;
    var $intermediateTableForeignField;
    var $foreignTable;
    var $foreignField="id";
    var $browseable=FALSE;        //Si aparece en los listados
    var $searchable=TRUE;         //Si aparece en las búsquedas

    function set($attribute,$value){
      if(in_array($attribute,get_object_vars($this))){
        $this->$attribute=$value;
      }
      else die("<br>El atributo [" . $attribute . "] no existe.<br>");
    }

    function get($attribute){
      if(in_array($attribute,get_object_vars($this))) return($this->$attribute);
      else die("<br>El atributo [" . $attribute . "] no existe.");
    }
  }

?>
