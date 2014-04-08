<?
if(isset($_GET["id_area"])) {
	$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id IN (SELECT id_promotor FROM pr_promotores_areas WHERE id_area='$_GET[id_area]') AND id IN (SELECT id_promotor FROM mercado_promotores WHERE id_mercado='" . $CFG->mercado . "') ORDER BY nombre");
} else if(isset($_GET["id"])){
	$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id=".$_GET['id']."");
}else{
	$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id IN (SELECT id_promotor FROM mercado_promotores WHERE id_mercado='" . $CFG->mercado . "') ORDER BY nombre");
}

$qAreas=$db->sql_query("SELECT * FROM pr_areas");
?>
<? if($CFG->mercado==21){ ?>
<style>
#contenedor #contenido #interna .artista table tr td h1, 
#contenedor #contenido #interna #disciplina a{
	color:#ffffff;
	background:#005BAA;}
</style>
<div id="disciplina">
	<img src="../images/disciplina/promotores21.jpg" width="175" height="45"/>
    
    <? 
		while($area=$db->sql_fetchrow($qAreas)){
			if($area['nombre']!='Música/Music'){
			echo "<a href='index.php?mercado=21&modo=promotores&id_area=".$area['id']."'>".$area['nombre']."</a>";
			}
		}
  	?>
</div> 
<? } ?>

<? if($CFG->mercado==22){ ?>
<style>
#contenedor #contenido #interna .artista table tr td h1, 
#contenedor #contenido #interna #disciplina a{
	color:#ffffff;
	background:#3e6081;}
strong, b {
color: #3e6081;
}	
#contenedor #contenido .artista {
	width:660px;
	float:left;
}
</style>
<? } ?>
<div class="artista">
<? if($CFG->mercado==22){ ?>
	<table width="495" border="0" cellspacing="0" cellpadding="5">
    <? } else{?>
    <table width="400" border="0" cellspacing="0" cellpadding="5">
    <? } ?>
		<tr>
			<td>
            <? while($promotor=$db->sql_fetchrow($qPromotor)){
				if($promotor["nombre"]!='Redlat'){?>
                    <h1><?=$promotor["nombre"] . " " . $promotor["apellido"]?></h1><br />
                    <strong>País: </strong> <?=$promotor["pais"]?><br />
                    <strong>Ciudad: </strong> <?=$promotor["ciudad"]?><br />
                    <strong>Cargo: </strong> <?=$promotor["cargo"]?><br />
                    <strong>Correo: </strong> <?=$promotor["email1"]?><br />
                    <strong>Web: <a  style="color:#3e6081" href="http://<?=$promotor["web"]?>" target="_blank"> <?=$promotor["web"]?></a></strong><br />
                    <p><?=nl2br($promotor["resena"])?></p>
                    <!--<a href="index.php?modo=promotores&id=<?=$promotor["id"]?>">&gt;&gt;más información</a>-->
            <? } }?>
           	</td>
		</tr>
	</table>
</div>

