<table width="900" border="0" align="center" cellpadding="10" cellspacing="0" bgcolor="#E7D8B1" >
  <tr>
    <td><h1 >Listado de grupos</h1>
      <br />
      <table width="860" border="0" align="center" style="">
        <tr >
          <td width="300">&nbsp;</td>
          <td><strong style="font-size:16px">No. de evaluaciones</strong></td>
          <td><strong></strong></td>
        </tr>
        <?
				$i=0;
				//.$db->sql_field("SELECT SUM(cumple_requisitos) FROM curadores_grupos WHERE  id_grupo_" . $grupo["area"] . "='$grupo[id]' AND cumple_requisitos = 1")."
				while($grupo=$db->sql_fetchrow($qGruposMusica)){
					if($i!=0) echo "";
					echo "<tr height='50'><td >".($i+1).".    <a href=\"" . $ME . "?mercado=".$CFG->mercado."&modo=curadores&mode=evaluar&amp;area=" . $grupo["area"] . "&amp;a=1&amp;id_grupo=" . $grupo["id"] . "\">" . $grupo["nombre"] . "</a></td>";
					echo "<td> " . $db->sql_field("SELECT COUNT(*) FROM curadores_grupos WHERE id_grupo_" . $grupo["area"] . "='$grupo[id]' AND cumple_requisitos IN(1,2)") . "</td>  <td></td>  </tr>";
					$i++;
				}
				?>
        <p></p>
    </table></td>
  </tr>
</table>    
