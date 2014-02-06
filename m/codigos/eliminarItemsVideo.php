<?php 
include("../application.php");
GLOBAL $CFG, $ME, $db;
$obra["id"]=$_GET["item"];
$db->sql_query("delete from archivos_obras_musica where id='". $obra["id"]."'");

?>
<script>
 window.location="cargaVideo.php?item=<?=$_GET["item2"]?>&a=<?php echo $_POST["a"]?>";
</script>