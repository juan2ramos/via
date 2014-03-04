<?php 
include("../application2.php");
GLOBAL $CFG, $ME, $db;
$vinculado["id"]=$_GET["persona"];
$db->sql_query("delete from vinculados where id='". $vinculado["id"]."'");

$_GET["modo"];

$_GET["id_usuario"];

$_GET["area"];

$_GET["id_grupo"];
?>
<script>
 window.location="../index.php?modo=<?=$_GET["modo"]?>&mode=paso_2muestra&id_usuario=<?=$_GET["id_usuario"]?>&area=<?=$_GET["area"]?>&id_grupo=<?=$_GET["id_grupo"]?>"
</script>