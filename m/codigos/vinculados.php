<link href="../css/style.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:0;
	background:#fff;
	text-align:center;
		background-color:#383838
	}
	#carga{
		display:none;}
	a{
		color:#FFF;
		text-decoration:underline;}	
	input{
		width:180px}		
</style>
<?php
include("../application.php");
GLOBAL $CFG, $ME, $db;

$frm["id_grupo"]=$_GET["item"];
$frm["area"]=$_GET["area"];
$frm["paso"]=$_GET["paso"];
//codigo para listar los vinculados a un grupo o artista
if($frm["paso"]==1){
?>
<div style="text-align:left; text-transform: uppercase">
<a href="vinculados.php?item=<?=$frm["id_grupo"]?>&area=<?=$frm["area"]?>&paso=2" style="text-decoration:none"><div style="text-align:center; margin-top:10px; margin-bottom:20px; padding:10px; background-color:#F00; width:150px; font-size:14px; text-decoration:none">[+] agregar</div></a>
</div>
<?php	
$vinculados = $db->sql_query("SELECT * FROM vinculados WHERE id_grupo_".$frm["area"]."='".$frm["id_grupo"]."'");
while($datos_vinculados=$db->sql_fetchrow($vinculados)){
	?>
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" style="border-style:solid;border-bottom:1px dotted #fff;">
  <tr>
    <td width="244"><?=$datos_vinculado["nombre"]?></td>
    <td width="192"><?=$datos_vinculado["documento"]?></td>
    <td width="114">eliminar</td>
  </tr>
</table>
<?php
	}
}

//codigo que carga el formulario de ingreso de los datos
if($frm["paso"]==2){
	?>
<form action="vinculados.php?item=<?=$frm["id_grupo"]?>&area=<?=$frm["area"]?>&paso=3" method="POST" enctype="multipart/form-data"> 
<input name="id_grupo" type="hidden" value="<?=$frm["id_grupo"]?>" /> 
<input name="area" type="hidden" value="<?=$frm["area"]?>" />     
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" style="border-style:solid;border-bottom:1px dotted #fff;">
  <tr>
    <td width="225" valign="middle">Nombre:<br />      <input name="nombre" type="text" /></td>
    <td width="198" valign="middle">Documento:<br />      
      <input name="documento" type="text" /></td>
    <td width="159" align="center"><input  type="submit" name="Submit" id="Submit" value="Agregar"/></td>
  </tr>
</table>
</form>    
    <?
	}
	
if($frm["paso"]==3){
	    $frm["id_grupo_" . $frm["area"]]=$frm["id_grupo"];
	 	$frm["nombre"]=$_POST["nombre"];
		$frm["documento"]=$_POST["documento"];
	    $id_vinculado=$db->sql_insert("vinculados", $frm);
		//header('Location:vinculados.php?item='.$frm["id_grupo"].'&area='.$frm["area"].'&paso=1');
		?>
        <script>
		window.location="vinculados.php?item='.$frm["id_grupo"].'&area='.$frm["area"].'&paso=1";
		</script>
        <?
	}	
?>
