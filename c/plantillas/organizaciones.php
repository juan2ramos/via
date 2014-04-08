<?
if(isset($_GET["id"])){
	$qOrganizacion=$db->sql_query("SELECT * FROM empresas WHERE id=".$_GET['id']."");
}else{
	$qOrganizacion=$db->sql_query("SELECT * FROM empresas ORDER BY empresa");
}

$qAreas=$db->sql_query("SELECT * FROM pr_areas");
?>

<div id="disciplina">
	<img src="../images/disciplina/organizaciones.jpg" width="175" height="230"/>
</div>
<div class="artista">
	<table width="440" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td>
            <? while($empresa=$db->sql_fetchrow($qOrganizacion)){?>
        	<h1><?=$empresa["empresa"]?></h1>
        	<em><?=$empresa["pais"]?></em>
        	<p><?=nl2br($empresa["observaciones"])?></p>
            <a href="http://<?=nl2br($empresa["web"])?>" target="_blank"><?=nl2br($empresa["web"])?></a><br /><br />
			<? //<a href='index.php?modo=promotores&id=$promotor["id"]'>&gt;&gt;más información</a>?>
            <? } ?>
           	</td>
		</tr>
	</table>
</div>

