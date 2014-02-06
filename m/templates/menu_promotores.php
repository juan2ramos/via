<?
require_once("../application.php");
$arrTitulos["perfil"]="Perfil";
$arrTitulos["en_perfil"]="Profile";
$arrTitulos["obras"]="Obras";
$arrTitulos["en_obras"]="Works";
$arrTitulos["fotografias"]="Fotografías";
$arrTitulos["en_fotografias"]="Pictures";
$arrTitulos["videos"]="Videos";
$arrTitulos["en_videos"]="Videos";
$arrTitulos["eventos"]="Eventos";
$arrTitulos["en_eventos"]="Events";

$hoy=date("Y-m-d");

	$cond="id_promotor='$id_promotor' AND id_mercado='" . $CFG->id_mercado_8 . "'";
	$qMercados=$db->sql_query("
		SELECT m.*
		FROM mercados m
		WHERE DATE_ADD(m.fecha_final,INTERVAL 5 DAY) >= '$hoy'
			AND m.id IN (SELECT id_mercado FROM mercado_promotores WHERE $cond)
	");
?>    
    
    <div id="menu">
		<?
		if(nvl($_GET["mode"])!="perfil" && $_GET["mode"]!="edit"){
			while($area=$db->sql_fetchrow($qAreas)){
				echo "<a href=\"promotores.php?id_area=" . $area["id"] . "\">" . $area["nombre"] . "</a>\n";
			}
		}
		if(isset($_SESSION[$CFG->sesion]["user"]["id_nivel"]) && $_SESSION[$CFG->sesion]["user"]["id_nivel"]==10){//Promotor
			echo "<a href=\"promotores.php?mode=perfil&id=$prom[id]\">". translate($arrTitulos,"perfil") ."</a>";
		}
		if(isset($_SESSION[$CFG->sesion]["user"]["id_nivel"]) && in_array($_SESSION[$CFG->sesion]["user"]["id_nivel"],array(4,5,6,7,8,9)) && nvl($_GET["mode"])=="perfil"){//Grupo
			echo "<a href=\"promotores.php?mode=perfil&id=$_GET[id]&id_mercado=$_GET[id_mercado]\">". translate($arrTitulos,"perfil") ."</a>";
		}
		
		if(isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])){
			while(isset($qMercados) && $mercado=$db->sql_fetchrow($qMercados)){
				if(isset($_GET["id_mercado"]) && $_GET["id_mercado"]==$mercado["id"]) echo "<a href=\"agenda.php?mode=agenda_promotor&id_promotor=$_GET[id]&id_mercado=" . $mercado["id"] . "\">" . $mercado["nombre"] . "</a>\n";
				else echo "<a href=\"agenda.php?id_mercado=" . $mercado["id"] . "&id_promotor=$prom[id] \">". $mercado["nombre"] ."</a>\n";
			}
		}
		?>
    <img src="<? $CFG->wwwroot ?>/imagenes/boton_inferior.jpg" width="190" height="15" />
    </div>


