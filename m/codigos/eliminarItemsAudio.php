<?php 
include("../application2.php");
GLOBAL $CFG, $ME, $db;
$obra["id"]=$_GET["item"];
$db->sql_query("delete from tracklist where id='". $obra["id"]."'");

?>
<script>
 window.location="cargaAudio.php?item=<?=$_GET["item2"]?>&a=<?php echo $_POST["a"]?>";
</script>