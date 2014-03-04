<?php 
include("../application2.php");
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

 $obra_id=$_GET["item"];
 $audio=$_FILES['audio'];

if($_POST["obra"]!=""&&$_POST["etiqueta"]!=""&&$audio["name"]!=""){
 $ordenMax=$db->sql_row("SELECT MAX(orden) FROM tracklist where id_obras_musica='".$_POST["obra"]."'");
 $ordenMax["MAX(orden)"];



if($audio["name"]!=""){
	
	if(preg_match("/php$/i",$audio["name"])) die("Error:" . __FILE__ . ":" . __LINE__);{ //Anti jáquers
	
	    $archivo=array();
		$archivo["etiqueta"]=$_POST["etiqueta"];
		$archivo["id_obras_musica"]=$_POST["obra"];
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
		echo $audio["name"]=$nombreImg;
		
	
        if($archivo["mmdd_archivo_filesize"]<20000000){
		
		if($archivo["mmdd_archivo_filetype"]=="audio/mp3"){
		
			  $archivo["id"]=$db->sql_insert("tracklist", $archivo);
              $grupo_id=$db->sql_row("SELECT * FROM obras_musica where id='".$_POST["obra"]."'");
			  
			 
			  
			  $path= "../../../musica/audio/".$grupo_id["id_grupos_musica"]."/obras/".$archivo["id"]."/".$audio["name"];	
	   
			$ftp_server="circulart.org";
			
			$conn_id = ftp_connect($ftp_server);
   
            // iniciar sesión con nombre de usuario y contraseña
			$login_result = ftp_login($conn_id, 'circulart', '(MU0ag{2013@)48cir');
			

            $carpeta = "/circulart.org/musica/audio/".$grupo_id["id_grupos_musica"];
			$dir=$carpeta;
			// intentar crear el directorio $dir
			if (ftp_mkdir($conn_id, $dir)) {
			// echo "creado con éxito $dir\n";
			 ftp_chmod($conn_id, 0777, $dir);
			} else {
			 //echo "Ha habido un problema durante la creación de $dir\n";
			}
			
			$carpeta = "/circulart.org/musica/audio/".$grupo_id["id_grupos_musica"]."/obras";
			$dir=$carpeta;
			// intentar crear el directorio $dir
			if (ftp_mkdir($conn_id, $dir)) {
			ftp_chmod($conn_id, 0777, $dir);	
			// echo "creado con éxito $dir\n";
			} else {
			// echo "Ha habido un problema durante la creación de $dir\n";
			}
			
			$carpeta = "/circulart.org/musica/audio/".$grupo_id["id_grupos_musica"]."/obras/".$archivo["id"];
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
					  //window.parent.refrescar()
					</script>
					 <div align="center">. </div>
	
					<?php
				  }else{
						?>
						<div align="center">
                      .
                        </div>
						<?php
				  }
		}} 
	}
}}
?>
<form action="cargaAudio.php?item=<?php echo $_GET["item"];?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input type="hidden" value="<?php echo $_GET["item"];?>" name="obra" id="obra"/>
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
      <em><strong>EL archivo debe ser menor de 5M y no tener caracteres especiales como: &aacute;&eacute;&iacute;&oacute;&uacute;&ntilde;~</strong></em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
  </tr>
</table>

</form>

<?php 
$obras = $db->sql_query("SELECT * FROM tracklist where id_obras_musica ='".$_GET["item"]."'");
	while($datos_obras=$db->sql_fetchrow($obras)){
?>
<hr />
<table width="100%" border="0" cellspacing="5" cellpadding="5" >
  <tr>
    <td width="84%"  class="colorTexto"><b><?php echo $datos_obras["etiqueta"]; ?></b></td>
    <td width="16%" rowspan="2" align="center" valign="middle"><a href="eliminarItemsAudio.php?item=<?php echo $datos_obras["id"]?>&item2=<?php echo $_GET["item"]?>" class="link">Eliminar</a></td>
  </tr>
  <tr>
    <td>
    <?php 
	$grupo_id2=$db->sql_row("SELECT * FROM obras_musica where id='".$_GET["item"]."'");
	?>
 <script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>
 <object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer<?php echo $datos_obras["id"]?>" height="24" width="290">
			<param name="movie" value="http://circulart.org/audio_base/player.swf">
			<param name="FlashVars" value="playerID=<?php echo $datos_obras["id"]?>&amp;soundFile=http://circulart.org/musica/audio/<?php echo $grupo_id2["id_grupos_musica"];?>/obras/<?php echo $datos_obras["id"]?>/<?php echo $datos_obras["mmdd_archivo_filename"]?>">
			<param name="quality" value="high">
			<param name="menu" value="false">
			<param name="wmode" value="transparent">
			</object>
</td>
  </tr>
</table>
<br>
<br>

<?php
}
?>
</body>
</html>