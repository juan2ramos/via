<?php 

include("../application.php");
GLOBAL $CFG, $ME, $db;
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
body{
	background-color:#E7D8B1;
	color:#3D1211;}
table{
	font-size:13px;}
		#carga{
		display:none;}
</style>
<script type="text/javascript" src="http://2013.circulart.org/m/js/lib/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#enviar').click(function(){
			$('#carga').show();
			})
	})		
</script>
<body>
<?php

 $id_grupo=$_GET["id_grupo"];
 $audio=$_FILES['audio'];

if($_POST["id_grupo"]!=""&&$_POST["etiqueta"]!=""&&$audio["name"]!=""){
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM archivos_grupos_musica where id_grupos_musica='".$_POST["id_grupo"]."'");
 $ordenMax["MAX(orden)"];



if($audio["name"]!=""){
	
	if(preg_match("/php$/i",$audio["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
	    $archivo=array();
		$archivo["id_grupos_musica"]=$_POST["id_grupo"];
		$archivo["tipo"]=2;
	    $archivo["etiqueta"]=$_POST["etiqueta"];
	    $archivo["orden"]=($ordenMax["MAX(orden)"]+1);
		$archivo["archivo"]="";
		$archivo["mmdd_archivo_filetype"]=$audio["type"];
		$archivo["mmdd_archivo_filesize"]=$audio["size"];

		$nombreImg = basename($audio["name"]);
		$NoAllow = array("á","é","í","ó","ú","ä","ë","ï","ö","ü","à","è","ì","ò","ù","ñ"," ",",",";",":","¡","!","¿","?",'"',"Á","À","É","È","Í","Ì","Ó","Ó","Ú","Ù","ç","Ç","ñ","Ñ","â","ã","ª","Â","Ã","Î","î","ê","ô","õ","º","Ô","Õ","û","Û","`","´","!","¡","?","¿","=",")","(","/","\\","|","&","%","$","·","@","~","€","¬");
		$Allow = array("a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","n","_","","","","","","","",'',"A","A","E","E","I","I","O","O","U","U","c","C","n","N","a","a","a","A","A","I","i","e","o","o","o","O","O","u","U","","","","","","","","","","","","","","","S","","a","","E","");
		$nombreImg = str_replace($NoAllow,$Allow,$nombreImg);
     
	
		$archivo["mmdd_archivo_filename"]=$nombreImg;
		$audio["name"]=$nombreImg;
		
	
        if($archivo["mmdd_archivo_filesize"]<20000000){
		
		if($archivo["mmdd_archivo_filetype"]=="audio/mp3"){
		
			  $archivo["id"]=$db->sql_insert("archivos_grupos_musica", $archivo);
              $grupo_id=$db->sql_row("SELECT * FROM archivos_grupos_musica where id_grupos_musica='".$_POST["id_grupo"]."'");
			  
			 
			  
			  $path= "../../../musica/audio/".$grupo_id["id_grupos_musica"]."/grupo/".$archivo["id"]."/".$audio["name"];	
	   
			$ftp_server="circulart.org";
			
			$conn_id = ftp_connect($ftp_server);
   
            // iniciar sesión con nombre de usuario y contraseña
			$login_result = ftp_login($conn_id, 'circulart', '(MU0ag{2013@)48cir');
			

            $carpeta = "/circulart.org/musica/audio/".$_POST["id_grupo"];
			$dir=$carpeta;
			// intentar crear el directorio $dir
			if (ftp_mkdir($conn_id, $dir)) {
			// echo "creado con éxito $dir\n";
			 ftp_chmod($conn_id, 0777, $dir);
			} else {
			 //echo "Ha habido un problema durante la creación de $dir\n";
			}
			
			$carpeta = "/circulart.org/musica/audio/".$$_POST["id_grupo"]."/grupo";
			$dir=$carpeta;
			// intentar crear el directorio $dir
			if (ftp_mkdir($conn_id, $dir)) {
			ftp_chmod($conn_id, 0777, $dir);	
			// echo "creado con éxito $dir\n";
			} else {
			// echo "Ha habido un problema durante la creación de $dir\n";
			}
			
			$carpeta = "/circulart.org/musica/audio/".$_POST["id_grupo"]."/grupo/".$archivo["id"];
			$dir=$carpeta;
			// intentar crear el directorio $dir
			if (ftp_mkdir($conn_id, $dir)) {
			ftp_chmod($conn_id, 0777, $dir);	
			// echo "creado con éxito $dir\n";
			} else {
			// echo "Ha habido un problema durante la creación de $dir\n";
			}
			   	
				 if(copy($audio['tmp_name'], $path))
				  { 
				   
					?>
<script>
					 window.parent.refrescar();
					 window.frameElement.ownerDocument.parentWindow.refrescar();
				     window.parent.location="http://2013.circulart.org/m/index.php?modo=inscripciones&mode=paso_4muestra&id_usuario=<?php echo $_POST["id_usuario"]; ?>&area=<?php echo $_POST["area"]?>&id_grupo=<?php echo $_POST["id_grupo"]?>&a=<?php echo $_POST["a"];?>";
					</script>
					 <div align="center"></div>
	
					<?php
				  }else{
						?>
						<div align="center">
                        <strong>EL archivo debe ser menor de 5 Megas y no tener caracteres especiales como: &aacute;&eacute;&iacute;&oacute;&uacute;&ntilde;~</strong>
                        </div>
						<?php
				  }
		}} 
	}
}}
?>
<form action="subirArchivoAudio.php?item=<?php echo $_GET["id_grupo"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["id_grupo"];?>" name="id_grupo" id="id_grupo"/>
<input type="hidden" value="<?php echo $_GET["id_usuario"];?>" name="id_usuario" id="id_usuario"/>
<input type="hidden" value="<?php echo $_GET["area"];?>" name="area" id="area"/>
<input type="hidden" name="a" value="<?=$_GET["a"]?>">
<table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr>
    <td width="32%" class="colorTexto"><strong>(*) Etiqueta:</strong></td>
    <td width="68%"><input name="etiqueta" type="text" id="etiqueta" size="75" /></td>
  </tr>
  <tr>
    <td valign="top"  class="colorTexto"><strong>(*) Audio:</strong></td>
    <td>
      <div align="center" id="carga"><img src="loading31.gif" width="128" height="15"></div>
      <input name="audio" type="file" id="audio" size="100" />
      <br>
      <em><strong>EL archivo debe ser menor de 5 Megas y no tener caracteres especiales como: &aacute;&eacute;&iacute;&oacute;&uacute;&ntilde;~</strong></em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
  </tr>
</table>

</form>

</body>
</html>