<?php 
include("../application.php");
GLOBAL $CFG, $ME, $db;
$obra["id"]=$_GET["item"];
$db->sql_query("delete from archivos_obras_".$_GET["area"]." where id='". $obra["id"]."'");
?>
<script>
window.location="cargaImagen.php?item=<?=$_GET["item2"]?>&area=<?=$_GET["area"]?>";
</script>