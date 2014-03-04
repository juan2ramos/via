<?php 
include("../application.php");
GLOBAL $CFG, $ME, $db;
$obra["id"]=$_GET["item"];
$db->sql_query("delete from obras_musica where id='". $obra["id"]."'");

$_GET["modo"];

$_GET["id_usuario"];

$_GET["area"];

$_GET["id_grupo"];
?>
<script>
 
 window.location="../index.php?modo=<?=$_GET["modo"]?>&mode=paso_3muestra&id_usuario=<?=$_GET["id_usuario"]?>&area=<?=$_GET["area"]?>&id_grupo=<?=$_GET["id_grupo"]?>&a=<?php echo $_POST["a"]?>";
 
</script>