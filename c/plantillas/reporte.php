<?
include("../application.php");

if(nvl($_GET["artistas"]) == "danza")
{
	//artistas de danza
	$grupo="danza";
}
elseif(nvl($_GET["artistas"]) == "musica")
{
	//artistas de musica
	$grupo="musica";
}
else
{
	//artistas de teatro
	$grupo="teatro";
}

	$strSQL="
		SELECT DISTINCT
			gr.id,gr.nombre,gr.ciudad,gr.contacto,gr.contacto_cc,gr.email, gr.telefono, '$grupo' as tipo, cug.cumple_requisitos,
			(SELECT GROUP_CONCAT(g.genero SEPARATOR ',') FROM generos_grupo_".$grupo." gg LEFT JOIN generos_".$grupo." g ON gg.id_generos_".$grupo."=g.id WHERE gg.id_grupos_".$grupo."=gr.id GROUP BY gg.id_grupos_".$grupo.") as generos,
			(SELECT COUNT(*) FROM curadores_grupos WHERE id_grupo_".$grupo."=gr.id AND fecha > '2010-08-23 07:00:00' GROUP BY id_grupo_".$grupo.") as num_evaluaciones,
			(
			 SELECT GROUP_CONCAT(CASE WHEN trayectoria IS NOT NULL AND calidad IS NOT NULL AND solidez IS NOT NULL THEN (trayectoria+calidad+solidez)/3 ELSE 'NS/NR' END SEPARATOR '|')
			 FROM curadores_grupos WHERE id_grupo_".$grupo."=gr.id AND fecha > '2010-08-23 07:00:00' GROUP BY id_grupo_".$grupo."
			) as notas,
			(SELECT AVG((trayectoria+calidad+solidez)/3) FROM curadores_grupos WHERE id_grupo_".$grupo."=gr.id AND fecha > '2010-08-23 07:00:00' GROUP BY id_grupo_".$grupo.") as nota,
			(
			 SELECT GROUP_CONCAT(CASE WHEN permitiria_asistencia IS NULL THEN 'NS/NR' WHEN permitiria_asistencia='1' THEN 'Sí' ELSE 'No' END SEPARATOR '|')
			 FROM curadores_grupos WHERE id_grupo_".$grupo."=gr.id AND fecha > '2010-08-23 07:00:00' GROUP BY id_grupo_".$grupo."
			) as asistencia
		FROM curadores_grupos cug LEFT JOIN grupos_".$grupo." gr ON cug.id_grupo_".$grupo."=gr.id
		WHERE cug.fecha > '2010-08-23 07:00:00' AND gr.id IS NOT NULL
		ORDER BY gr.nombre
	";

$strSQLCount="SELECT COUNT(*) as total FROM (".$strSQL.") as foo";
$REGISTROSPAGINA=50;
if(!isset($_GET['pagina'] ) || $_GET['pagina'] < 0 ){
	$pagina = 1;
	$offset = 0;
}
else{
	$pagina = $_GET['pagina'];
	$offset = ( $pagina - 1 ) * $REGISTROSPAGINA;
}

	$arrTitulos["siguientes"]="Siguientes";
	$arrTitulos["anteriores"]="Anteriores";

	$qid=$db->sql_query($strSQLCount);
	$res=$db->sql_fetchrow($qid);
	$totalArticulos = $res["total"];
	$totalPaginas = ceil($res["total"]/$REGISTROSPAGINA);
	$consulta = $strSQL." LIMIT ".$offset." , ". $REGISTROSPAGINA;
	$qidGr = $db->sql_query($consulta);
	$txtNavegacion="<table border=\"0\">";
	$txtNavegacion.="<tr><td colspan=\"2\">Página $pagina - $totalPaginas &nbsp;&nbsp;</td><td width=\"80\" align=\"center\">";
	$txtNavegacion.="<tr><td>";
	if($pagina>1) $txtNavegacion.="<a href=\"" . hallar_querystring("pagina",$pagina-1)  . "\">".translate($arrTitulos,"anteriores")."</a>";
	$txtNavegacion.=" | ";
	if($pagina<$totalPaginas) $txtNavegacion.="<a href=\"" . hallar_querystring("pagina",$pagina+1)  . "\">".translate($arrTitulos,"siguientes")."</a>";
	$txtNavegacion.="</td></tr></table>";

?>
	
  	<table width="1200" border="1" cellspacing="0" cellpadding="5">
		  <tr>
		    <th>Nombre</th>
		    <th>Ciudad</th>
		    <th>Contacto</th>
		    <th>CC</th>
		    <th>Email</th>
		    <th>Teléfono</th>
		    <th>Géneros</th>
		    <th>Requisitos</th>
		    <th># de evaluaciones</th>
		    <th>Notas</th>
		    <th>Promedio</th>
		    <th>Asistencia</th>
      </tr>
		  <?
			while($gruposT = $db->sql_fetchrow($qidGr))
			{
				$tipo=$gruposT["tipo"];
			?>
		  <tr>
		    <td><?=$gruposT["nombre"]?></td>
		    <td><?=$gruposT["ciudad"]?></td>
		    <td><?=$gruposT["contacto"]?></td>
		    <td><?=$gruposT["contacto_cc"]?></td>
		    <td><?=$gruposT["email"]?></td>
		    <td><?=$gruposT["telefono"]?></td>
		    <td>&nbsp;<?=$gruposT["generos"]?></td>
		    <td align="center"><? if ($gruposT["cumple_requisitos"]==1) echo "Sí"; else echo "No"; ?></td>
		    <td align="center"><?=$gruposT["num_evaluaciones"]?></td>
		    <td align="center"><?=$gruposT["notas"]?></td>
		    <td align="center"><?=$gruposT["nota"]?></td>
		    <td align="center"><?=$gruposT["asistencia"]?></td>
	      </tr>
          <? } ?>
</table>
		<p>&nbsp;</p>
       
          <? echo $txtNavegacion;?>
