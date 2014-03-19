<?php class MySQL{

  private $conexion; private $total_consultas;

  public function MySQL(){ 
    if(!isset($this->conexion)){
     // $this->conexion = (mysql_connect("redlat.org:3306","redlat_cir48lar","c*giVR=1Z-q_"))
	 $this->conexion = (mysql_connect("localhost","root",""))
        or die(mysql_error());
      mysql_select_db("redlat_cir48lar",$this->conexion) or die(mysql_error());
    }
  }

  public function consulta($consulta){ 
    $this->total_consultas++; 
    $resultado = mysql_query($consulta,$this->conexion);
    if(!$resultado){ 
      echo 'MySQL Error: ' . mysql_error();
      exit;
    }
    return $resultado;
  }

  public function fetch_array($consulta){
   return mysql_fetch_array($consulta);
  }

  public function num_rows($consulta){
   return mysql_num_rows($consulta);
  }
  
  public function fetch_row($consulta){
   return mysql_fetch_row($consulta);
  }

  public function getTotalConsultas(){
   return $this->total_consultas; 
  }

}?>