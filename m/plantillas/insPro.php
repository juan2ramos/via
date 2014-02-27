<?
$CFG->sesion_grnic="SESIONGRNIC";

if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
else $frm=$_GET;

switch(nvl($frm["mode"])){
	case "acceso":
		acceso($frm);
		break;
	case "login":
		print_login_form($frm,"acceso");
		break;
	case "paso_3":
		procesar_paso_2($frm);
		break;
	case "paso_2":
		procesar_paso_1($frm);
		break;
	case "paso_2muestra":
		muestra_paso_2($frm);
		break;			
	default:
		paso_1($frm);
		break;
}

function acceso($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="insPro";

	$user = verify_login($frm["login"], $frm["password"]);
	if ($user) {
		$_SESSION[$CFG->sesion_grnic]["user"] = $user;
		$_SESSION[$CFG->sesion_grnic]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_grnic]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_grnic]["path"] = NULL;
	    $frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id= '$user[id]'
		");
		$frm["id_usuario"]=$user["id"];
		$frm["login"]=$user["login"];
		$frm["id_programador"]=$user["id"];
		$frm["tipoEntrada"]=1;
		include("CCB/paso_2P.php");

		die;
	} else {
		$frm["error2"] = "Login inválido, por favor intente de nuevo.";
		$newMode="acceso";
		include("CCB/paso_1P.php");
	}
}


function verify_login($username, $password) {
	GLOBAL $db;
	$seccion="insPro";

	$pass = md5($password);
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM promotores WHERE login = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid))	return($user);
	return(FALSE);
}

function print_login_form($frm,$newMode="acceso_admin"){
	GLOBAL $CFG, $ME, $db;
	$seccion="insPro";

	include("CCB/login_formP.php");
}


function procesar_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="insPro";

	$usuario=$db->sql_row("SELECT * FROM promotores WHERE id='$frm[id_usuario]'");
    $frm["terminos"]=1;
	$frm["fecha_actualizacion"]=date("Y-m-d H:i:s");
	if($frm["id_usuario"]!=""){//Ya existe...
		$frm["id"]=$frm["id_usuario"];
		$frm["convenio"]="VIA2014";
		$db->sql_update("promotores", $frm);
	}
	
	/***********************************tareas o actividades************************************/
	$tarea1=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='1'");
    if (@$frm['pr_promotores_tareas1']){
		  if($tarea1[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','1')");
		  }
		}else{
		  if($tarea1[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='1'");
		   }
		}
		
	
	$tarea2=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='2'");
    if (@$frm['pr_promotores_tareas2']){
		  if($tarea2[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','2')");
		  }
		}else{
		  if($tarea2[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='2'");
		   }
		}	
		
	$tarea3=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='3'");
    if (@$frm['pr_promotores_tareas3']){
		  if($tarea3[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','3')");
		  }
		}else{
		  if($tarea3[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='3'");
		   }
		}		
		
	$tarea4=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='4'");
    if (@$frm['pr_promotores_tareas4']){
		  if($tarea4[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','4')");
		  }
		}else{
		  if($tarea4[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='4'");
		   }
		}		
		
	$tarea5=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='5'");
    if (@$frm['pr_promotores_tareas5']){
		  if($tarea5[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','5')");
		  }
		}else{
		  if($tarea5[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='5'");
		   }
		}	
	$tarea6=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='6'");
    if (@$frm['pr_promotores_tareas6']){
		  if($tarea6[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','6')");
		  }
		}else{
		  if($tarea6[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='6'");
		   }
		}		
				
	$tarea7=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='7'");
    if (@$frm['pr_promotores_tareas7']){
		  if($tarea7[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','7')");
		  }
		}else{
		  if($tarea7[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='7'");
		   }
		}		

    $tarea8=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='8'");
    if (@$frm['pr_promotores_tareas8']){
		  if($tarea8[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','8')");
		  }
		}else{
		  if($tarea8[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='8'");
		   }
		}	

    $tarea9=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='9'");
    if (@$frm['pr_promotores_tareas9']){
		  if($tarea9[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','9')");
		  }
		}else{
		  if($tarea9[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='9'");
		   }
		}	
		
	$tarea10=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='10'");
    if (@$frm['pr_promotores_tareas10']){
		  if($tarea10[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','10')");
		  }
		}else{
		  if($tarea10[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='10'");
		   }
		}
		
	$tarea11=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='11'");
    if (@$frm['pr_promotores_tareas11']){
		  if($tarea11[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','11')");
		  }
		}else{
		  if($tarea11[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='11'");
		   }
		}	
		
	$tarea12=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='12'");
    if (@$frm['pr_promotores_tareas12']){
		  if($tarea12[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','12')");
		  }
		}else{
		  if($tarea12[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='12'");
		   }
		}						

   $tarea13=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='13'");
    if (@$frm['pr_promotores_tareas13']){
		  if($tarea13[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','13')");
		  }
		}else{
		  if($tarea13[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='13'");
		   }
		}	
		
		
	$tarea14=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='14'");
    if (@$frm['pr_promotores_tareas14']){
		  if($tarea14[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','14')");
		  }
		}else{
		  if($tarea14[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='14'");
		   }
		}	
	
	$tarea15=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='15'");
    if (@$frm['pr_promotores_tareas15']){
		  if($tarea15[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','15')");
		  }
		}else{
		  if($tarea15[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='15'");
		   }
		}	
		
		
	$tarea16=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='16'");
    if (@$frm['pr_promotores_tareas16']){
		  if($tarea16[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','16')");
		  }
		}else{
		  if($tarea16[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='16'");
		   }
		}		
		
	$tarea17=$db->sql_row("SELECT id_tarea FROM pr_promotores_tareas WHERE id_promotor='$frm[id_usuario]' AND id_tarea='17'");
    if (@$frm['pr_promotores_tareas17']){
		  if($tarea17[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_tareas (id_promotor,id_tarea) VALUES('".$frm['id_usuario']."','17')");
		  }
		}else{
		  if($tarea17[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_tareas SET id_tarea='-1' WHERE id_promotor='$frm[id_usuario]' AND id_tarea='17'");
		   }
		}					
   /********************* fin codigo de las tareas ************/
   
   /**********************codigo Areas******************************/
      $frm['pr_promotores_areas1']=1;
	  $area1=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='1'");
		if (@$frm['pr_promotores_areas1']){
			  if($area1[0]==''){
				   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm['id_usuario']."','1')");
			  }
			}else{
			  if($area1[0]!=''){
				   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='1'");
			   }
			}	
			
		$frm['pr_promotores_areas2']="2";
		$area2=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='2'");
		if (@$frm['pr_promotores_areas2']){
			  if($area2[0]==''){
				   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm['id_usuario']."','2')");
			  }
			}else{
			  if($area2[0]!=''){
				   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='2'");
			   }
			}	
				
		$frm['pr_promotores_areas3']=3;
		$area3=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='3'");
		if (@$frm['pr_promotores_areas3']){
			  if($area3[0]==''){
				   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm['id_usuario']."','3')");
			  }
			}else{
			  if($area3[0]!=''){
				   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='3'");
			   }
			}		
			
		$frm['pr_promotores_areas4']=4;
		$area4=$db->sql_row("SELECT id_area FROM pr_promotores_areas WHERE id_promotor='$frm[id_usuario]' AND id_area='4'");
		if (@$frm['pr_promotores_areas4']){
			  if($area4[0]==''){
				   $db->sql_query("INSERT INTO pr_promotores_areas (id_promotor,id_area) VALUES('".$frm['id_usuario']."','4')");
			  }
			}else{
			  if($area4[0]!=''){
				   $db->sql_query("UPDATE pr_promotores_areas  SET id_area='-1' WHERE id_promotor='$frm[id_usuario]' AND id_area='4'");
			   }
			}				
   /************************************fin del codigo de areas ********************************/
   
   
   /************************************ idioma *************************************************/
   $idioma1=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='1'");
    if (@$frm['pr_promotores_idiomas1']){
		  if($idioma1[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm['id_usuario']."','1')");
		  }
		}else{
		  if($idioma1[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='1'");
		   }
		}	
		

   $idioma2=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='2'");
    if (@$frm['pr_promotores_idiomas2']){
		  if($idioma2[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm['id_usuario']."','2')");
		  }
		}else{
		  if($idioma2[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='2'");
		   }
		}		
		
		
    $idioma3=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='3'");
    if (@$frm['pr_promotores_idiomas3']){
		  if($idioma3[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm['id_usuario']."','3')");
		  }
		}else{
		  if($idioma3[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='3'");
		   }
		}					
   
    $idioma4=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='4'");
    if (@$frm['pr_promotores_idiomas4']){
		  if($idioma4[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm['id_usuario']."','4')");
		  }
		}else{
		  if($idioma4[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='4'");
		   }
		}		
   
    $idioma5=$db->sql_row("SELECT id_idioma FROM pr_promotores_idiomas WHERE id_promotor='$frm[id_usuario]' AND id_idioma='5'");
    if (@$frm['pr_promotores_idiomas5']){
		  if($idioma5[0]==''){
			   $db->sql_query("INSERT INTO pr_promotores_idiomas (id_promotor,id_idioma) VALUES('".$frm['id_usuario']."','5')");
		  }
		}else{
		  if($idioma5[0]!=''){
			   $db->sql_query("UPDATE pr_promotores_idiomas  SET id_idioma='-1' WHERE id_promotor='$frm[id_usuario]' AND id_idioma='5'");
		   }
		}	
   /***************************** organizacion **********************************************/
   
   $qEmpresas=$db->sql_query("
							SELECT emp.*
							FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
							WHERE ep.id_promotor='$frm[id_usuario]'
						");
						
	if($db->sql_numrows($qEmpresas)>0){ 
	//actualizacion
	  $id_empresa=$db->sql_query("select id_empresa from empresas_promotores  where id_promotor=".$frm['id_usuario']);
      $idemp=$db->sql_fetchrow($id_empresa);
	  $db->sql_query("UPDATE empresas SET empresa='".$frm['empresa']."', id_naturaleza='".$frm['id_naturaleza']."', nit='".$frm['nit']."', direccion='".$frm['direccion_emp']."', telefono='".$frm['telefono_emp']."', web='".$frm['web_emp']."', observaciones='".$frm['observaciones']."', email='".$frm['email_emp']."', pais='".$frm['pais_emp']."', ciudad='".$frm['ciudad_emp']."', telefono2='".$frm['telefono2_emp']."'    WHERE id='".$idemp[0]."'");
	
	/***********************************actividad empresa *****************************************/
	
	    $actividad1=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
    if (@$frm['empresas_razones1']){
		  if($actividad1[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','1')");
		  }
		}else{
		  if($actividad1[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
		   }
		}	
	
	
	 $actividad2=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
    if (@$frm['empresas_razones2']){
		  if($actividad2[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','2')");
		  }
		}else{
		  if($actividad2[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
		   }
		}	
		
		
		
	 $actividad3=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
    if (@$frm['empresas_razones3']){
		  if($actividad3[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','3')");
		  }
		}else{
		  if($actividad3[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
		   }
		}	
		
		
	 $actividad4=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
    if (@$frm['empresas_razones1']){
		  if($actividad4[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','4')");
		  }
		}else{
		  if($actividad4[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
		   }
		}	
		
	 $actividad5=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
    if (@$frm['empresas_razones5']){
		  if($actividad5[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','5')");
		  }
		}else{
		  if($actividad5[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
		   }
		}	
		
	 $actividad6=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
    if (@$frm['empresas_razones6']){
		  if($actividad6[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','6')");
		  }
		}else{
		  if($actividad6[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
		   }
		}	
		
	 $actividad7=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
    if (@$frm['empresas_razones7']){
		  if($actividad7[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','7')");
		  }
		}else{
		  if($actividad7[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
		   }
		}	
		
	 $actividad8=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
    if (@$frm['empresas_razones8']){
		  if($actividad8[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','8')");
		  }
		}else{
		  if($actividad8[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
		   }
		}	
		
		
	 $actividad9=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
    if (@$frm['empresas_razones9']){
		  if($actividad9[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','9')");
		  }
		}else{
		  if($actividad9[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
		   }
		}	
		
	 $actividad10=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
    if (@$frm['empresas_razones10']){
		  if($actividad10[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','10')");
		  }
		}else{
		  if($actividad10[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
		   }
		}	
		
	}else{
	//insertar nuevo
	  $db->sql_query("INSERT INTO empresas (empresa,id_naturaleza,nit,direccion,telefono,web,observaciones,email,pais,ciudad,telefono2) VALUES('".$frm['empresa']."','".$frm['id_naturaleza']."','".$frm['nit']."','".$frm['direccion_emp']."','".$frm['telefono_emp']."','".$frm['web_emp']."','".$frm['bservaciones']."','".$frm['email_emp']."','".$frm['pais_emp']."','".$frm['ciudad_emp']."','".$frm['telefono2_emp']."')");
	
	
	$id_empresa=$db->sql_query("select max(id) from empresas");
    $idemp=$db->sql_fetchrow($id_empresa);
    $db->sql_query("INSERT INTO empresas_promotores (id_empresa,id_promotor) VALUES('".$idemp[0]."','".$frm['id_usuario']."')");
	
	
	    $actividad1=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
    if (@$frm['empresas_razones1']){
		  if($actividad1[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','1')");
		  }
		}else{
		  if($actividad1[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='1'");
		   }
		}	
	
	
	 $actividad2=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
    if (@$frm['empresas_razones2']){
		  if($actividad2[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','2')");
		  }
		}else{
		  if($actividad2[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='2'");
		   }
		}	
		
		
		
	 $actividad3=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
    if (@$frm['empresas_razones3']){
		  if($actividad3[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','3')");
		  }
		}else{
		  if($actividad3[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='3'");
		   }
		}	
		
		
	 $actividad4=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
    if (@$frm['empresas_razones1']){
		  if($actividad4[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','4')");
		  }
		}else{
		  if($actividad4[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='4'");
		   }
		}	
		
	 $actividad5=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
    if (@$frm['empresas_razones5']){
		  if($actividad5[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','5')");
		  }
		}else{
		  if($actividad5[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='5'");
		   }
		}	
		
	 $actividad6=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
    if (@$frm['empresas_razones6']){
		  if($actividad6[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','6')");
		  }
		}else{
		  if($actividad6[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='6'");
		   }
		}	
		
	 $actividad7=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
    if (@$frm['empresas_razones7']){
		  if($actividad7[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','7')");
		  }
		}else{
		  if($actividad7[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='7'");
		   }
		}	
		
	 $actividad8=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
    if (@$frm['empresas_razones8']){

		  if($actividad8[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','8')");
		  }
		}else{
		  if($actividad8[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='8'");
		   }
		}	
		
		
	 $actividad9=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
    if (@$frm['empresas_razones9']){
		  if($actividad9[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','9')");
		  }
		}else{
		  if($actividad9[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='9'");
		   }
		}	
		
	 $actividad10=$db->sql_row("SELECT id_emp_razon_social FROM empresas_razones WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
    if (@$frm['empresas_razones10']){
		  if($actividad10[0]==''){
			   $db->sql_query("INSERT INTO empresas_razones (id_empresa,id_emp_razon_social) VALUES('".$idemp[0]."','10')");
		  }
		}else{
		  if($actividad10[0]!=''){
			   $db->sql_query("UPDATE empresas_razones SET id_emp_razon_social='-1' WHERE id_empresa='$idemp[0]' AND id_emp_razon_social='10'");
		   }
		}	
	
	}
	
	/**************************fin organizacion ************************/

   	$grupo=$db->sql_row("SELECT email1,preinscripto,nombre,apellido FROM promotores WHERE id='".$frm["id_usuario"]."'");
	        
	if($grupo["preinscripto"]==0){
		
			require 'include/PHPMailer/PHPMailerAutoload.php';
		
			$mail = new PHPMailer;
			$mail->IsSendmail();
			$mail->FromName ='[VIA2014]' ;
			$mail->From = 'via@festivaldeteatro.com.co';
			$mail->Subject = 'Preinscripción - pre registration';
			$mail->MsgHTML('Mensaje con HTML');
			$template = "-------------------------------------------------------------------------------------<br>";
			$template.= $grupo["nombre"]." ".$grupo["apellido"].',<br>Usted ha quedado preinscrito oficialmente en VIA2014. Muchas gracias por participar.<br>';
			$template.= "Posteriormente le estaremos enviando las especificaciones para el deposito, y así culminar con la inscripción al evento.<br>";	
			$template.= "-------------------------------------------------------------------------------------<br>";
			$template.= $grupo["nombre"]." ".$grupo["apellido"].',<br>You have been officially pre-registered in 2014 VIA. We thank you in advance for your participation..<br>';
			$template.= "We will send you the specifications for yor deposit shortly, with this you will finish the registration to our event.<br>";	
			$template.= "-------------------------------------------------------------------------------------<br>";
			$template.= "Atentamente - Best regards,<br>";
			$template.= "LUIS FERNANDO ZULUAGA REYNA<br>";
			$template.= "via@festivaldeteatro.com.co<br>";
			$template.= "http://via.festivaldeteatro.com.co/\n";
			$mail->Body = $template;
			$mail->AddAddress($grupo["email1"], '');
			$mail->AddCC('via@festivaldeteatro.com.co', '');
			$mail->Send(); 

    $db->sql_query("UPDATE promotores SET preinscripto='1' WHERE id='$frm[id_usuario]'");
	
	
	
	include("CCB/finalp.php");
	}else{

	
	require 'include/PHPMailer/PHPMailerAutoload.php';
		
			$mail = new PHPMailer;
			$mail->IsSendmail();
			$mail->FromName ='[VIA2014]' ;
			$mail->From = 'via@festivaldeteatro.com.co';
			$mail->Subject = 'Actualización de datos - Updated data';
			$mail->MsgHTML('Mensaje con HTML');
			$template = "-------------------------------------------------------------------------------------<br>";
			$template.= $grupo["nombre"]." ".$grupo["apellido"].',<br>Acaba de actualizar los datos exitosamente como profesional en VIA2014.<br>';
			$template.= "-------------------------------------------------------------------------------------<br>";
			$template.= $grupo["nombre"]." ".$grupo["apellido"].',<br>Dear VIA2014 Professional,<br>Your information was successfully updated.<br>';
			$template.= "-------------------------------------------------------------------------------------<br>";
			$template.= "Atentamente - Best regards,<br>";
			$template.= "LUIS FERNANDO ZULUAGA REYNA<br>";
			$template.= "via@festivaldeteatro.com.co<br>";
			$template.= "http://via.festivaldeteatro.com.co/\n";
			$mail->Body = $template;
			$mail->AddAddress($grupo["email1"], '');
			$mail->AddCC('via@festivaldeteatro.com.co', '');
			$mail->Send(); 

	
		include("CCB/finalp2.php");
	}
   
   
	//include("CCB/paso_3P.php");
}

function procesar_paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="insPro";
    $usuario=$db->sql_row("SELECT id FROM promotores WHERE login='".$frm['login']."'");
	if($usuario[0]!=''){
		$frm["error"]="El usuario ya existe.";
		paso_1($frm);
	}
	else{
		$frm["terminos"]=1;
		$pss=$frm["password"];
		$frm["convenio"]="VIA2014";
		$frm["password"]=md5($frm["password"]);
		$frm["password2"]=$frm["__CONFIRM_password"];
		$frm["fecha_actualizacion"]=date("Y-m-d H:i:s");
		$frm["id_usuario"]=$db->sql_insert("promotores",$frm);
		//empresas_promotores
		$frm["id_programador"]=$frm["id_usuario"];
		
		
		$qEmpresas=$db->sql_row("
							SELECT emp.*
							FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
							WHERE ep.id_promotor='".$frm["id_usuario"]."'
						");
						
		
		if($qEmpresas["id"]==""){
			// codigo para crear el espacio de empresa
			
			$strSql="INSERT INTO empresas (empresa,id_naturaleza,nit,direccion,telefono,web,observaciones,email,pais,ciudad,telefono2,imagen,mmdd_imagen_filename,mmdd_imagen_filetype,mmdd_imagen_filesize) VALUES ('','','','','','','','','','','','','','','')";
			$db->sql_query($strSql);
			echo($db->sql_nextid());
			
			$frm3["id_empresa"]=$db->sql_nextid();
			$frm3["id_promotor"]=$frm["id_programador"];
			$db->sql_insert("empresas_promotores",$frm3);
			}
				
	
    require 'include/PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;
	$mail->IsSendmail();
	$mail->FromName ='[VIA2014]' ;
	$mail->From = 'via@festivaldeteatro.com.co';
	$mail->Subject = 'Nueva Cuenta - new account';
	$mail->MsgHTML('Mensaje con HTML');
	$template = "--------------------------------<br>";
	$template.= 'Los datos de su cuenta son:<br>';
	$template.= "Usuario:    ".$frm["login"]."<br>";	
	$template.= "Clave:    ".$pss."<br>";
	$template.= "--------------------------------<br>";
	$template.= 'Your account details are:<br>';
	$template.= "User:    ".$frm["login"]."<br>";	
	$template.= "Password:    ".$pss."<br>";
	$template.= "--------------------------------<br>";
	$template.= "Atentamente - Best regards,<br>";
	$template.= "LUIS FERNANDO ZULUAGA REYNA<br>";
	$template.= "via@festivaldeteatro.com.co<br>";
	$template.= "http://via.festivaldeteatro.com.co/\n";
	$mail->Body = $template;
	$mail->AddAddress($_POST['email1'], '');
	$mail->AddCC('via@festivaldeteatro.com.co', '');
 	$mail->Send(); 	
	include("CCB/paso_2P.php");
	}
}
function muestra_paso_2($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="insPro";
	$frm["area"]="insPro";
	$id_programador=$_GET["id_programador"];
	
	if($id_programador!=""){
	$frm=$db->sql_row("
			SELECT *
			FROM promotores
			WHERE id=".$frm["id_programador"]."
		");
		
		$frm["id_programador"]=$id_programador;
		$frm["id_usuario"]=$id_programador;
		include("CCB/paso_2P.php");
	 }else{
		 paso_1($frm);
		 }
		 
}
function paso_1($frm){
	GLOBAL $CFG, $ME, $db;
	$seccion="insPro";
	include("CCB/paso_1P.php");
}

?>
