<?
if(!isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])){
	$goto = "index.php?modo=login&mercado=26";
	header("Location: $goto");
	die();
}
?>
<style>
p{
	font-size:14px;}
.tituloGenero{
	width:930px;
	background-color:#F17127;
	padding:5px;
	cursor:pointer;
	color:#fff;}
	
#contenido_lista,#contenido_miAgenda,#contenido_listapro{
	width:1130px;
	margin-top: -2px;
	border-style: dotted;
	border-width: 1px;
	border-color: #FFF;	
	overflow:hidden;
	margin-bottom:8px;
	padding:10px;
	font-size:16px;
}

#contenido_lista div, #contenido_listapro div, #contenido_miAgenda div{
	background-color:red;
	padding:5px;
}

#contenido_listapro, #contenido_miAgenda,#contenido_lista{
	display:none;}

#lista_portafolios, #lista_portafolios_dos, #miAgenda{
	color:#FFF;
	padding:10px;
	text-decoration: underline;
	border-right-color: #fff;
	border-right-style: dotted;
	border-right-width: 1px;
	}

<? if($_GET["act"]==0){ ?>
#lista_portafolios{
	background-color:#252525;
	color:#F00;
}
#contenido_lista{display:block;}
<? }?>

<? if($_GET["act"]==1){ ?>
#lista_portafolios_dos{background-color:#252525;
	color:#F00;}
#contenido_listapro{display:block;}
<? }?>

<? if($_GET["act"]==2){ ?>
#miAgenda{background-color:#252525;
	color:#F00;}
#contenido_miAgenda{display:block;}
<? }?>

.nombre_profesional{
    padding:5px; 
	width:1130px; 
	margin-top:10px;
	margin-bottom:10px;
	font-size:24px;
	}
.nombre_profesional a div{
	color:#F00;
	font-size:18px;
	float:right;
	margin-top:8px;
	font-weight:bold;	
	}
	
		
#miAgenda{
	border:none;}	
.items{
	margin: 5px; 
	float: left; 
	width: 280px; 
	height:40px; 
	padding:0px;
	}	
.listados{
	width:1130px;
	}	
table{
	font-size:16px;}	
th a{
	font-size:16px;
	font-weight:normal;
	color:#FFF;}
.grupos, .profesionales{
	width:850px; 
	text-align:justify; 
	height:250px; 
	margin-top:30px; 
	margin-left:270px;
	overflow:hidden;}	
.vermas{
	padding:0px; 
	color:red; 
	text-decoration:underline; 
	font-size:14px;
	background-color:#252525;
	padding:10px;
	margin-left:270px;
	margin-bottom:10px;	}	
.izquierda{
	position:absolute; 
	top:0; 
	margin-top:590px;}	
	
.izquierda .titulo{
	padding:5px; 
	background-color:#666666; 
	color:#fff; 
	font-size:16px; 
	width:550px; 
	float:left; 
	margin-top:10px;
	text-align:center;
	}	
.izquierda table{
	width:550px;}	
.izquierda table th{
	font-size:14px;}
	
.derecha{
	position: absolute;
	top: 0;
	margin-top: 600px;
	margin-left: 600px;
	padding-bottom:30px;
	}	
.derecha p{
	margin-left:10px;}	
.derecha .titulo{
	padding:5px; 
	background-color:#666666; 
	color:#fff;
	text-align:center; 
	font-size:16px;
	width:550px; }
.derecha table{
	width:550px;}	
.derecha table th{
	font-size:14px;
}			
</style>
<script language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="http://circulart.org/b/m/js/sessvars.js"></script>
<link rel="stylesheet" type="text/css" href="http://circulart.org/circulart2013/m/js/source/jquery.fancybox.css?v=2.1.4" media="screen" />
<script language="JavaScript" type="text/javascript">

   function refrescar(){
   	location.reload();
   }

	function popup(url){
		width=1250;
		height=600;
		izq=(screen.width-width)/2;
		arriba=(screen.height-height)/2;
		return window.open(url,'popup','scrollbars=yes,width=' + width +',height=' + height +',resizable=yes,left='+izq+',top='+arriba);
	}
	
	function artistas(url){
		//alert(url)
		//popup(url)
		window.location=url;
		/*$.fancybox.open({
							href : url,
							padding : 5,
							width  : 1010,
							height :600,
							autoSize: false,
							type : 'iframe',
							'beforeClose': function() { refrescar() },
                            'closeClick': true
						});*/
	}
</script>

<?
$id_nivel=$_SESSION[$CFG->sesion]["user"]["id_nivel"];
if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
else $frm=$_GET;


/****************************** Cabecera del mail *********************************************/
/*require("../class.phpmailer.php");
			
			$mailer = new PHPMailer();
			$mailer->IsSMTP();
			$mailer->Host = 'ssl://smtp.gmail.com:465';
			$mailer->SMTPAuth = TRUE;
			$mailer->Username = 'notificacionescirculart@gmail.com';  // Change this to your gmail adress
			$mailer->Password = 'C1cul4rt!"2';  // Change this to your gmail password
			$mailer->FromName = 'Notificaciones Circulart2013'; // This is the from name in the email, you can put anything you like here	
			$mailer->From = 'notificacionescirculart@gmail.com'; 	 //remplazar por el de info@bogotamusicmarlet.com*/
/*********************************************************************************************/



if($id_nivel=="10"){//Promotor

	$id_promotor=$_SESSION[$CFG->sesion]["user"]["id"];
	
	if(nvl($frm["mode"])=="rechazar_cita_promotor_promotor"){//El promotor, en su agenda, le da eliminar a una cita con otro promotor
		$strQuery="
			SELECT c.*,
				CASE WHEN c.id_promotor='$id_promotor' THEN p2.email1 ELSE p.email1 END AS mail_destinatario,
				CASE WHEN c.id_promotor='$id_promotor' THEN CONCAT(p2.nombre,' ',p2.apellido) ELSE CONCAT(p.nombre,' ',p.apellido) END AS destinatario,
				CASE WHEN c.id_promotor='$id_promotor' THEN CONCAT(p.nombre,' ',p.apellido) ELSE CONCAT(p2.nombre,' ',p2.apellido) END AS remitente
			FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
			WHERE c.id='$frm[id_cita]'
		";
		$qid=$db->sql_query($strQuery);
		$result=$db->sql_fetchrow($qid);
		
		   /* $dest2 = $result["mail_destinatario"];
			$body2.="Estimado(a) " . $result["destinatario"]. ":\n";	
			$body2.="El promotor " . $result["remitente"] . " ha eliminado la cita que tenía programada con usted.\n";
			$body2.="La cita estaba programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			$body2.="\n";

			$mailer->Body = $body2;
			$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
			$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
			}else{
				
				}	

		
		*/
		/*if($result["mail_destinatario"]!=""){
			$txtMail="Estimado(a) " . $result["destinatario"] . ":\n";
			$txtMail.="El promotor " . $result["remitente"] . " ha eliminado la cita que tenía programada con usted.\n";
			$txtMail.="La cita estaba programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			//mail($result["mail_destinatario"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
			//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
		}*/
		$qDelete=$db->sql_query("DELETE FROM citas WHERE id='$frm[id_cita]'");
	}
	elseif(nvl($frm["mode"])=="confirmar_cita_promotor_promotor"){//El promotor, en su agenda, le da 'confirmar' a una cita con otro promotor
		$strQuery="
			SELECT c.*,
				CASE WHEN c.id_promotor='$id_promotor' THEN p2.email1 ELSE p.email1 END AS mail_destinatario,
				CASE WHEN c.id_promotor='$id_promotor' THEN CONCAT(p2.nombre,' ',p2.apellido) ELSE CONCAT(p.nombre,' ',p.apellido) END AS destinatario,
				CASE WHEN c.id_promotor='$id_promotor' THEN CONCAT(p.nombre,' ',p.apellido) ELSE CONCAT(p2.nombre,' ',p2.apellido) END AS remitente
			FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
			WHERE c.id='$frm[id_cita]'
		";
		$qid=$db->sql_query($strQuery);
		$result=$db->sql_fetchrow($qid);
		
		  /*$dest2 = $result["mail_destinatario"];
			$body2.="Estimado(a) " . $result["destinatario"]. ":\n";	
			$body2.="El promotor " . $result["remitente"] . " ha eliminado la cita que tenía programada con usted.\n";
			$body2.="La cita quedó entonces programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			$body2.="\n";

			$mailer->Body = $body2;
			$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
			$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
			}else{
				
				}	
		
		*/
		/*if($result["mail_destinatario"]!=""){
			$txtMail="Estimado(a) " . $result["destinatario"] . ":\n";
			$txtMail.="El promotor " . $result["remitente"] . " ha confirmado la cita que tenía programada con usted.\n";
			$txtMail.="La cita quedó entonces programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			//mail($result["mail_destinatario"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
			//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
		}*/
		$qUpdate=$db->sql_query("UPDATE citas SET aceptada_promotor='1' WHERE id='$frm[id_cita]'");
	}
	elseif(nvl($frm["mode"])=="rechazar_cita_promotor"){//El promotor, en su agenda, le da eliminar a una cita
		$strQuery="
			SELECT c.*,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.email
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.email
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.email
				END AS email,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
				END AS grupo,
				CONCAT(p.nombre,' ',p.apellido) as promotor
			FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
				LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
				LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
				LEFT JOIN promotores p ON c.id_promotor=p.id
			WHERE c.id='$frm[id_cita]'
		";
		$qid=$db->sql_query($strQuery);
		$result=$db->sql_fetchrow($qid);

     		/*$dest2 = $result["email"];
			$body2.="Estimado(s) " . $result["grupo"] . ":\n";	
			$body2.="El promotor " . $result["promotor"] . " ha eliminado la cita que tenía programada con usted(es).\n";
			$body2.="La cita estaba programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			$body2.="\n";

			$mailer->Body = $body2;
			$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
			$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
			}else{
				
				}	
		*/
		/*if($result["email"]!=""){
			$txtMail="Estimado(s) " . $result["grupo"] . ":\n";
			$txtMail.="El promotor " . $result["promotor"] . " ha eliminado la cita que tenía programada con usted(es).\n";
			$txtMail.="La cita estaba programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			//mail($result["email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
			//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
		}*/

		$qDelete=$db->sql_query("DELETE FROM citas WHERE id='$frm[id_cita]'");
	}
	elseif($frm["mode"]=="confirmar_cita_promotor"){//El promotor, en su agenda, confirma una cita
		$strQuery="
			SELECT c.*,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.email
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.email
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.email
				END AS email,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
				END AS grupo,
				CONCAT(p.nombre,' ',p.apellido) as promotor
			FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
				LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
				LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
				LEFT JOIN promotores p ON c.id_promotor=p.id
			WHERE c.id='$frm[id_cita]'
		";
		$qid=$db->sql_query($strQuery);
		$result=$db->sql_fetchrow($qid);
		
		
		/*$dest2 = $result["email"];
			$body2.="Estimado(s) " . $result["grupo"] . ":\n";	
			$body2.="El promotor " . $result["promotor"] . " ha confirmado la cita que tenía programada con usted(es).\n";
			$body2.="La cita quedó entonces programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			$body2.="\n";

			$mailer->Body = $body2;
			$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
			$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
			if(!$mailer->Send())
			{
			  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
			}else{
				
				}	
		
		*/
		/*if($result["email"]!=""){
			$txtMail="Estimado(s) " . $result["grupo"] . ":\n";
			$txtMail.="El promotor " . $result["promotor"] . " ha confirmado la cita que tenía programada con usted(es).\n";
			$txtMail.="La cita quedó entonces programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			//mail($result["email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
			//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
		}*/
		$qUpdate=$db->sql_query("UPDATE citas SET aceptada_promotor='1',fecha_inicial=fecha_inicial WHERE id='$frm[id_cita]'");
	}
	elseif($frm["mode"]=="bloquear_agenda_promotor"){//El promotor, en su agenda, bloquea un horario
		$desde=date("Y-m-d H:i:s",$frm["fecha"]);

		$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_promotor='$id_promotor' AND desde='$desde'");
		if($db->sql_numrows($qBloqueo)==0){
			$qid=$db->sql_query("
				INSERT INTO excepciones_agenda (desde,id_promotor)
				VALUES ('$desde','$id_promotor')
			");
		}
	}
	elseif($frm["mode"]=="desbloquear_agenda_promotor"){//El promotor, en su agenda, desbloquea un horario
		$desde=date("Y-m-d H:i:s",$frm["fecha"]);
		$qBloqueo=$db->sql_query("DELETE FROM excepciones_agenda WHERE id_promotor='$id_promotor' AND desde='$desde'");
	}
	
	$hoy=date("Y-m-d");

	$cond="id_promotor='$id_promotor' AND id_mercado='" . $CFG->mercado . "'";
	$qMercados=$db->sql_query("
		SELECT m.*
		FROM mercados m
		WHERE DATE_ADD(m.fecha_final,INTERVAL 5 DAY) >= '$hoy'
			AND m.id IN (SELECT id_mercado FROM mercado_promotores WHERE $cond)
	");
	
	
	$mostrar_mercados=1;
	if($frm["mode"]=="agenda_artista" || $frm["mode"]=="solicitar_cita_promotor"){
		$id=$frm["id_artista"];
		$tipo=$frm["tipo"];
		$qImagenes=$db->sql_query("SELECT id,mmdd_archivo_filename FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='".$id."' AND tipo=1 AND mmdd_archivo_filename IS NOT NULL ORDER BY orden");
		if($imagen = $db->sql_fetchrow($qImagenes)){
			$img="<img src=\"../m/phpThumb/phpThumb.php?src=" . urlencode($CFG->dirwww . "/admin/imagen.php?table=archivos_grupos_$tipo&field=archivo&id=" . $imagen["id"]) . "&amp;w=110\" class=\"artista\" />";
		}
		else $img="";

		$qObras=$db->sql_query("SELECT id, anio FROM obras_$tipo WHERE id_grupos_$tipo = '$id'");
		$qVideos=$db->sql_query("SELECT id,url,etiqueta FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='".$id."' AND tipo=3 AND url IS NOT NULL ORDER BY orden");
	}
	$respuesta=detalle_mercado($frm);
	$id_mercado=$respuesta["id"];

	$frm["id_mercado"]=$id_mercado;
	if(!isset($frm["id_promotor"])) $frm["id_promotor"]=$_SESSION[$CFG->sesion]["user"]["id"];
	if($frm["mode"]=="agenda_artista" || $frm["mode"]=="solicitar_cita_promotor"){
		if($frm["mode"]=="solicitar_cita_promotor"){//Cuando el promotor le solicita una cita al artista
			$strSQL="
				SELECT c.*
				FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
				WHERE s.id_rueda = (SELECT id_rueda FROM sesiones WHERE id='$frm[id_sesion]') AND
					(
						(c.id_promotor='$id_promotor' AND c.id_grupo_$frm[tipo]='$frm[id_artista]')	OR
						((c.id_promotor='$id_promotor' OR c.id_grupo_$frm[tipo]='$frm[id_artista]') AND c.fecha_inicial='$frm[fecha]')
					)
			";
			$qVerificacion=$db->sql_query($strSQL);
			if($db->sql_numrows($qVerificacion)==0){
				$qInsert=$db->sql_query("
					INSERT INTO citas (id_sesion,fecha_inicial,id_promotor,id_grupo_$frm[tipo],aceptada_promotor,aceptada_grupo)
					VALUES('$frm[id_sesion]','$frm[fecha]','$id_promotor','$frm[id_artista]','1','0')
				");
				$id_cita=$db->sql_nextid();

				$strQuery="
					SELECT c.*,
						CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.email
						WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.email
						WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.email
						END AS email,
						CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
						WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
						WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
						END AS grupo,
						CONCAT(p.nombre,' ',p.apellido) as promotor
					FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
						LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
						LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
						LEFT JOIN promotores p ON c.id_promotor=p.id
					WHERE c.id=".$id_cita;

				$qid=$db->sql_query($strQuery);
				$result=$db->sql_fetchrow($qid);
				
				
				/*$dest2 = $result["email"];
				$body2.="Estimado(s) " . $result["grupo"] . ":\n";	
				$body2.="El promotor " . $result["promotor"] . " ha solicitado una cita con usted(es).\n";
				$body2.="La cita solicitada está programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
				$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
				$body2.="\n";
	
				$mailer->Body = $body2;
				$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
				$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
				if(!$mailer->Send())
				{
				  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
				}else{
					
					}	
		*/
				/*if($result["email"]!=""){
					$txtMail="Estimado(s) " . $result["grupo"] . ":\n";
					$txtMail.="El promotor " . $result["promotor"] . " ha solicitado una cita con usted(es).\n";
					$txtMail.="Por favor confirmar esta cita en la página web.\n";
					$txtMail.="La cita solicitada está programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
					$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
					//mail($result["email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
					//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
				}*/
			}
			else{
				echo "<script>";
				echo "alert ('Hay un cruce de horario le rogamos buscar otra franja horaria.')";
				echo "</script>";
			}
		}
		detalle_mercado($frm);
		mostrar_agenda_promotor_artista($frm);
	}
	elseif($frm["mode"]=="agenda_promotor_promotor" || $frm["mode"]=="solicitar_cita_promotor_promotor"){
		if($frm["mode"]=="solicitar_cita_promotor_promotor"){//Cuando el promotor le solicita una cita a otro promotor
			$qVerificacion=$db->sql_query("SELECT c.* FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id WHERE s.id_rueda=(SELECT id_rueda FROM sesiones WHERE id='$frm[id_sesion]') AND ((c.id_promotor='$frm[id_promotor]' AND c.id_promotor2='$frm[id_promotor2]') OR (c.id_promotor='$frm[id_promotor2]' AND c.id_promotor2='$frm[id_promotor]') OR c.fecha_inicial='$frm[fecha]') ");
			if($db->sql_numrows($qVerificacion)==0){
				$qInsert=$db->sql_query("
					INSERT INTO citas (id_sesion,fecha_inicial,id_promotor,id_promotor2,aceptada_promotor,aceptada_promotor2)
					VALUES('$frm[id_sesion]','$frm[fecha]','$frm[id_promotor]','" . $_SESSION[$CFG->sesion]["user"]["id"] . "','0','1')
				");
				$id_cita=$db->sql_nextid();
				
				$strQuery="
					SELECT c.*,
						CONCAT(p.nombre,' ',p.apellido) as promotor, p.email1 as prom_email
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
					WHERE c.id=".$id_cita;
				
				$qid=$db->sql_query($strQuery);
				$result=$db->sql_fetchrow($qid);
				
				/*$dest2 = $result["prom_email"];
				$body2.="Estimado(a) " . $result["promotor"] . ":\n";
				$body2.="El promotor " . $_SESSION[$CFG->sesion]["user"]["nombre"] .  " " . $_SESSION[$CFG->sesion]["user"]["apellido"] . " ha solicitado una cita con usted.\n";
				$body2.="Por favor confirmar esta cita en la página web.\n";
				$body2.="La cita solicitada está programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
				$body2.="\n";
	
				$mailer->Body = $body2;
				$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
				$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
				if(!$mailer->Send())
				{
				  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
				}else{
					
					}	
				*/
				
				/*if($result["prom_email"]!=""){
					$txtMail="Estimado(a) " . $result["promotor"] . ":\n";
					$txtMail.="El promotor " . $_SESSION[$CFG->sesion]["user"]["nombre"] .  " " . $_SESSION[$CFG->sesion]["user"]["apellido"] . " ha solicitado una cita con usted.\n";
					$txtMail.="Por favor confirmar esta cita en la página web.\n";
					$txtMail.="La cita solicitada está programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
					$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
					//mail($result["prom_email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
					//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
				}*/
			}
			else{
				echo "<script>";
				echo "alert ('Hay un cruce de horario le rogamos buscar otra franja horaria.')";
				echo "</script>";
			}
		}
		detalle_mercado($frm);
		mostrar_agenda_promotor_promotor($frm);
	}
	else{
		detalle_mercado($frm);
		listar_grupos($frm);
		listar_promotores($frm);
		mostrar_agenda_promotor($frm);
		mostrar_encuesta_promotor($frm);
	}
}
elseif(in_array($id_nivel,array(4,5,6,7,8,9))){//Grupo
	$qGruposDanza=$db->sql_query("SELECT g.* FROM usuarios_grupos_danza ug LEFT JOIN grupos_danza g ON ug.id_grupo_danza = g.id WHERE ug.id_usuario='" . $_SESSION[$CFG->sesion]["user"]["id"] . "'");
	if($grupo=$db->sql_fetchrow($qGruposDanza)){
		$tipo="danza";
	}
	else{
		$qGruposMusica=$db->sql_query("SELECT g.* FROM usuarios_grupos_musica ug LEFT JOIN grupos_musica g ON ug.id_grupo_musica = g.id WHERE ug.id_usuario='" . $_SESSION[$CFG->sesion]["user"]["id"] . "'");
		if($grupo=$db->sql_fetchrow($qGruposMusica)){
			$tipo="musica";
		}
		else{
			$qGruposTeatro=$db->sql_query("SELECT g.* FROM usuarios_grupos_teatro ug LEFT JOIN grupos_teatro g ON ug.id_grupo_teatro = g.id WHERE ug.id_usuario='" . $_SESSION[$CFG->sesion]["user"]["id"] . "'");
			if($grupo=$db->sql_fetchrow($qGruposTeatro)){
				$tipo="teatro";
			}
			else{
				die("Este usuario no tiene ningún grupo relacionado.");
			}
		}
	}
	$id_grupo=$grupo["id"];
	$id=$id_grupo;

	if(nvl($frm["mode"])=="rechazar_cita_grupo"){
		$strQuery="
			SELECT c.*,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.email
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.email
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.email
				END AS email,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
				END AS grupo,
				CONCAT(p.nombre,' ',p.apellido) as promotor, p.email1 as prom_email
			FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
				LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
				LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
				LEFT JOIN promotores p ON c.id_promotor=p.id
			WHERE c.id='$frm[id_cita]'
		";
		$qid=$db->sql_query($strQuery);
		$result=$db->sql_fetchrow($qid);
		
		
		/*$dest2 = $result["prom_email"];
		$body2.="Estimado(a) " . $result["promotor"] . ":\n";
		$body2.="El grupo " . $result["grupo"] . " ha eliminado la cita que tenía programada con usted.\n";
		$body2.="La cita estaba programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
		$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
		$body2.="\n";

		$mailer->Body = $body2;
		$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
		$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
		if(!$mailer->Send())
		{
		  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
		}else{
			
			}	*/
		
		
		
		/*if($result["prom_email"]!=""){
			$txtMail="Estimado(a) " . $result["promotor"] . ":\n";
			$txtMail.="El grupo " . $result["grupo"] . " ha eliminado la cita que tenía programada con usted.\n";
			$txtMail.="La cita estaba programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			//mail($result["prom_email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
			//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
		}*/


		$qDelete=$db->sql_query("DELETE FROM citas WHERE id='$frm[id_cita]'");
	}
	elseif($frm["mode"]=="confirmar_cita_grupo"){//Cuando el grupo desde su agenda, confirma una cita que le ha solicitado el promotor
		$strQuery="
			SELECT c.*,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.email
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.email
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.email
				END AS email,
				CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
				WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
				WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
				END AS grupo,
				CONCAT(p.nombre,' ',p.apellido) as promotor, p.email1 as prom_email
			FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
				LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
				LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
				LEFT JOIN promotores p ON c.id_promotor=p.id
			WHERE c.id='$frm[id_cita]'
		";
		$qid=$db->sql_query($strQuery);
		$result=$db->sql_fetchrow($qid);
		
		/*$dest2 = $result["prom_email"];
		$body2.="Estimado(a) " . $result["promotor"] . ":\n";
		$body2.="El grupo " . $result["grupo"] . " ha confirmado la cita que tenía programada con usted.\n";
		$body2.="La cita quedó entonces programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
		$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
		$body2.="\n";

		$mailer->Body = $body2;
		$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
		$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
		if(!$mailer->Send())
		{
		  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
		}else{
			
			}*/	
		
		
		/*if($result["prom_email"]!=""){
			$txtMail="Estimado(a) " . $result["promotor"] . ":\n";
			$txtMail.="El grupo " . $result["grupo"] . " ha confirmado la cita que tenía programada con usted.\n";
			$txtMail.="La cita quedó entonces programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
			$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
			//mail($result["prom_email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
			//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
		}*/
		
		$qUpdate=$db->sql_query("UPDATE citas SET aceptada_grupo='1',fecha_inicial=fecha_inicial WHERE id='$frm[id_cita]'");
	}
	elseif($frm["mode"]=="bloquear_agenda_grupo"){//El grupo, en su agenda, bloquea un horario
		$desde=date("Y-m-d H:i:s",$frm["fecha"]);

		$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_grupo_$tipo='$id_grupo' AND desde='$desde'");
		if($db->sql_numrows($qBloqueo)==0){
			$qid=$db->sql_query("
				INSERT INTO excepciones_agenda (desde,id_grupo_$tipo)
				VALUES ('$desde','$id_grupo')
			");
		}
	}
	elseif($frm["mode"]=="desbloquear_agenda_grupo"){//El grupo, en su agenda, desbloquea un horario
		$desde=date("Y-m-d H:i:s",$frm["fecha"]);
		$qBloqueo=$db->sql_query("DELETE FROM excepciones_agenda WHERE id_grupo_$tipo='$id_grupo' AND desde='$desde'");
	}

	$hoy=date("Y-m-d");
	$qMercados=$db->sql_query("
		SELECT m.*
		FROM mercado_artistas ma LEFT JOIN mercados m ON ma.id_mercado=m.id
		WHERE ma.id_grupo_$tipo = '$id' AND DATE_ADD(m.fecha_final,INTERVAL 5 DAY) >= '$hoy' AND ma.id_mercado='" . $CFG->mercado . "'
	");

	$mostrar_mercados=1;

	$respuesta=detalle_mercado($frm);
	$id_mercado=$respuesta["id"];
	
	$qObras=$db->sql_query("SELECT id FROM obras_$tipo WHERE id_grupos_$tipo = '$id_grupo'");
	$qImagenes=$db->sql_query("SELECT id,mmdd_archivo_filename FROM archivos_grupos_$tipo WHERE id_grupos_$tipo='".$id_grupo."' AND tipo=1 AND mmdd_archivo_filename IS NOT NULL");
	$qVideos=$db->sql_query("SELECT id, etiqueta FROM archivos_grupos_$tipo WHERE id_grupos_$tipo = '$id_grupo' AND tipo='3'");

	echo $respuesta["string"];
	$frm["id_mercado"]=$id_mercado;
	$frm["id_grupo"]=$id_grupo;
	$frm["tipo"]=$tipo;
	if($frm["mode"]=="agenda_promotor" || $frm["mode"]=="solicitar_cita_grupo"){
		if($frm["mode"]=="solicitar_cita_grupo"){//Cuando el artista le solicita una cita al promotor
		
			$qVerificacion=$db->sql_query("
				SELECT c.*
				FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
				WHERE s.id_rueda=(SELECT id_rueda FROM sesiones WHERE id='$frm[id_sesion]') AND
					(
						(c.id_promotor='$frm[id_promotor]' AND c.id_grupo_$tipo='$id_grupo')	OR
						((c.id_promotor='$frm[id_promotor]' OR c.id_grupo_$tipo='$id_grupo') AND c.fecha_inicial='$frm[fecha]')
					)
			");
			if($db->sql_numrows($qVerificacion)==0){
				$qInsert=$db->sql_query("
					INSERT INTO citas (id_sesion,fecha_inicial,id_promotor,id_grupo_$frm[tipo],aceptada_promotor,aceptada_grupo)
					VALUES('$frm[id_sesion]','$frm[fecha]','$frm[id_promotor]','$frm[id_grupo]','0','1')
				");
				$id_cita=$db->sql_nextid();
							
				
				$strQuery="
					SELECT c.*,
						CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.email
						WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.email
						WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.email
						END AS email,
						CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
						WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
						WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
						END AS grupo,
						CONCAT(p.nombre,' ',p.apellido) as promotor, p.email1 as prom_email
					FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
						LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
						LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
						LEFT JOIN promotores p ON c.id_promotor=p.id
					WHERE c.id=".$id_cita;
					
            	$qid=$db->sql_query($strQuery);
				$result=$db->sql_fetchrow($qid);
				
				
				/*$dest2 = $result["prom_email"];
				$body2.="Estimado(a) " . $result["promotor"] . ":\n";
				$body2.="El grupo " . $result["grupo"] . " ha solicitado una cita con usted.\n";
				$body2.="Por favor confirmar esta cita en la página web.\n";
				$body2.="La cita solicitada está programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
				$body2.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";;
				
				$mailer->Body = $body2;
				$mailer->Subject = 'Cita Rueda de Negocios Circulart2013';
				$mailer->AddAddress($dest2);  // This is where you put the email adress of the person you want to mail
				if(!$mailer->Send())
				{
				  //echo "Message was not sent<br/ >"; echo "Mailer Error: " . $mailer->ErrorInfo;
				}else{
					
					}	*/
				/*if($result["prom_email"]!=""){
					$txtMail="Estimado(a) " . $result["promotor"] . ":\n";
					$txtMail.="El grupo " . $result["grupo"] . " ha solicitado una cita con usted.\n";
					$txtMail.="Por favor confirmar esta cita en la página web.\n";
					$txtMail.="La cita solicitada está programada para la siguiente fecha y hora:\n====\n" . $result["fecha_inicial"] . "\n====\n";
					$txtMail.="\n<a href=\"http://http://2013.circulart.org/m/index.php?modo=login\">http://2013.circulart.org/</a>\n";
					//mail($result["prom_email"],"Cita Rueda de Negocios Circulart2013",$txtMail,"From:info@circulart.org");
					//mail('notificacionescirculart@gmail.com',"Cita Rueda de Negocios Circulart2013",$txtMail,"From: info@circulart.org"); 
				}*/	
				
				
						
			}else{
				echo "<script>";
				echo "alert ('Hay un cruce de horario le rogamos buscar otra franja horaria.')";
				echo "</script>";
				
			}
			
		}
		detalle_mercado($frm);
		mostrar_agenda_grupo_promotor($frm);
	}
	else{
		detalle_mercado($frm);
		listar_promotores($frm);
		mostrar_agenda_grupo($frm);
		mostrar_encuesta_grupo($frm);
	}
}

/*	FUNCIONES	*/
function mostrar_agenda_promotor_promotor($frm){
	GLOBAL $CFG,$db,$ME;
	if(!isset($frm["id_promotor"]) || $frm["id_promotor"]==$_SESSION[$CFG->sesion]["user"]["id"]) die("<b>Error:</b>" . __FILE__ . ":" . __LINE__);
	$promotor=$db->sql_row("SELECT * FROM promotores WHERE id='$frm[id_promotor]'");
	echo "<div style='height:2200px'>";
	echo "<br><br><a style='border:none' id='lista_portafolios_dos' href='index.php?act=1&modo=agenda&id_mercado=$_GET[id_mercado]&id_promotor=$_GET[id_promotor2]&mercado=$_GET[id_mercado]'><< Regreso a los listados</a>";
	echo "<h2>Agenda de " . $promotor["nombre"] . " " . $promotor["apellido"] . "</h2>";
	echo "<div style='overflow:hidden;'>";
	if($promotor["mmdd_imagen_filename"]!=""){
	echo "<img style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px;' src=\"http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/files/promotores/imagen/$promotor[id]\" width=\"250\"/>";
	}else{
		echo "<div style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px; width:250px; height:250px; background-color:#F2EBD9'></div>";
		}
	echo "<p class='profesionales'>".$promotor["resena"]."</div>";
	echo "<a class='vermas' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&banner=0&num=' target=\"_blank\" \">Ver m&aacute;s</a>";
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	
	echo "<div class='izquierda' style='margin-top:600px'>";
	echo "<div class='titulo' align=\"center\"><strong>Agenda del profesional</strong></div><br><br>";
	$cambio=0;
	$cambio2=0;
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%A %d de %B",strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table  border=\"0\" cellpadding=\"5\" cellspacing=\"5\">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"210\">Profesional / Artista / Grupo</th><th width=\"90\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);
		
		while($desde<$hasta){
			
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde) . "</th>\n";

			$qCita=$db->sql_query("
				SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor='$frm[id_promotor]' LIMIT 1) as mesa
				FROM citas c
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor='$frm[id_promotor]' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "' AND c.id_promotor2 IS NULL
			");
			if($cita=$db->sql_fetchrow($qCita)){
				if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
				elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
				elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

				$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);

				echo "<td><a style=\"border:none; padding:0px; color:#fff; text-decoration:underline\" href=\"http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&amp;banner=0&amp;num=$grupo[id]\" target=\"_blank\">$grupo[nombre] (Grupo)</a></td>";
				if($cita["aceptada_promotor"]==1 && ($cita["aceptada_grupo"]==1 || $cita["aceptada_promotor2"]==1)) $estado="Aceptada";
				if($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==0 && $cita["aceptada_promotor2"]==0) $estado="Eliminada";
				else $estado="Por confirmar";
				echo "<td>$estado</td>";
			}
			else{
				$qCita=$db->sql_query("
					SELECT c.*,
						CASE WHEN c.id_promotor2='$frm[id_promotor]' THEN CONCAT(p.nombre, ' ', p.apellido) ELSE CONCAT(p2.nombre, ' ', p2.apellido) END as promotor,
						(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
						LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
						LEFT JOIN sesiones ses ON c.id_sesion=ses.id
						LEFT JOIN ruedas r ON ses.id_rueda=r.id
					WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2 IS NOT NULL AND (c.id_promotor='$frm[id_promotor]' OR c.id_promotor2='$frm[id_promotor]') AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($cita=$db->sql_fetchrow($qCita)){
					echo "</th>\n";
					echo "<td>$cita[promotor] (Promotor)</td>";
					if($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==1) $estado="Aceptada";
					elseif($cita["aceptada_promotor"]==0 || $cita["aceptada_promotor2"]==0) $estado="Por confirmar";
					echo "<td>$estado</td>";
				}
				else{
					$qBloqueo=$db->sql_query("
						SELECT * FROM excepciones_agenda 
						WHERE (id_promotor='" . $_SESSION[$CFG->sesion]["user"]["id"] . "' OR id_promotor='$frm[id_promotor]') AND desde='" . date("Y-m-d H:i:00",$desde) . "'
					");
					if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
						echo "<th style='border:none; background:#666666; font-size:14px'><strong>Bloqueado</strong></th>";
						echo "<th style='border:none; background:#666666; font-size:14px'><strong>Bloqueado</strong></th>\n";
					}
					else{
						$qCita=$db->sql_query("
							SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor='$frm[id_promotor]' LIMIT 1) as mesa
							FROM citas c
								LEFT JOIN sesiones ses ON c.id_sesion=ses.id
								LEFT JOIN ruedas r ON ses.id_rueda=r.id
							WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor='" . $frm["id_promotor"] . "' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "' AND c.id_promotor2 IS NULL
						");
						if($cita=$db->sql_fetchrow($qCita)){
							if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
							elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
							elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

							$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
							$grupo=$db->sql_fetchrow($qGrupo);

							echo "<td><a style=\"border:none; padding:0px; color:#fff; text-decoration:underline\" href=\"http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&amp;banner=0&amp;num=$grupo[id]\" target=\"_blank\">$grupo[nombre] (Grupo)</a></td>";
							if($cita["aceptada_promotor"]==1 && ($cita["aceptada_grupo"]==1 || $cita["aceptada_promotor2"]==1)) $estado="Aceptada";
							if($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==0 && $cita["aceptada_promotor2"]==0) $estado="Eliminada";
							else $estado="Por confirmar";
							echo "<td>$estado</td>";
						}
						else{
							echo "<td></td><td><a style=\"padding:0px; color:#fff; text-decoration:underline; text-align:left; border:none; background:none; cursor:pointer;\" href=\"" . simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=solicitar_cita_promotor_promotor&fecha=" . urlencode(date("Y-m-d H:i:s",$desde)) . "&id_sesion=$sesion[id_sesion]&id_promotor=$frm[id_promotor]&id_promotor2=$frm[id_promotor2]&id_mercado=".$CFG->mercado."&act=1\">Solicitar cita</a>";
						}
					}
				}
			}

			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	
	}	
	echo "</div>";
	
//// agenda profesional
$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
$promotores=$db->sql_row("SELECT * FROM promotores WHERE id='$_GET[id_promotor2]'");
	echo "<div class='derecha' style='margin-top:610px'>";
	echo "<div class='titulo'><strong>Visualización de espacios libres de ".$promotores["nombre"]." ".$promotores["apellido"]."</strong></div>";
	
	$cambio=0;
	$cambio2=0;
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%A %d de %B",strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table  border=\"0\" cellpadding=\"6\" cellspacing=\"5\">\n";
		echo "<tr><th width=\"100\" style='text-align:left'>Hora</th><th width=\"210\">Profesional / Artista / Grupo</th><th width=\"90\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);

		while($desde<$hasta){
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde) . "</th>\n";

			$qCita=$db->sql_query("
				SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor2='$frm[id_promotor2]' LIMIT 1) as mesa
				FROM citas c
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor='$frm[id_promotor2]' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "' AND c.id_promotor2 IS NULL
			");
			if($cita=$db->sql_fetchrow($qCita)){
				if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
				elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
				elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

				$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);

				echo "<td><a style=\"border:none; padding:0px; color:#fff; text-decoration:underline\" href=\"http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&amp;banner=0&amp;num=$grupo[id]\" target=\"_blank\">$grupo[nombre] (Grupo)</a></td>";
				if($cita["aceptada_promotor"]==1 && ($cita["aceptada_grupo"]==1 || $cita["aceptada_promotor2"]==1)) $estado="Aceptada";
				if($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==0 && $cita["aceptada_promotor2"]==0) $estado="Eliminada";
				else $estado="Por confirmar";
				echo "<td>$estado</td>";
			}
			else{
				$qCita=$db->sql_query("
					SELECT c.*,
						CASE WHEN c.id_promotor2='$frm[id_promotor2]' THEN CONCAT(p.nombre, ' ', p.apellido) ELSE CONCAT(p2.nombre, ' ', p2.apellido) END as promotor,
						(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
						LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
						LEFT JOIN sesiones ses ON c.id_sesion=ses.id
						LEFT JOIN ruedas r ON ses.id_rueda=r.id
					WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor IS NOT NULL AND (c.id_promotor2='$frm[id_promotor2]' OR c.id_promotor='$frm[id_promotor2]') AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($cita=$db->sql_fetchrow($qCita)){
					echo "</th>\n";
					echo "<td >$cita[promotor] (Promotor)</td>";
					if($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==1) $estado="Aceptada";
					elseif($cita["aceptada_promotor"]==0 || $cita["aceptada_promotor2"]==0) $estado="Por confirmar";
					echo "<td>$estado</td>";
				}
				else{
					$qBloqueo=$db->sql_query("
						SELECT * FROM excepciones_agenda 
						WHERE (id_promotor='" . $_SESSION[$CFG->sesion]["user"]["id"] . "' OR id_promotor='$frm[id_promotor2]') AND desde='" . date("Y-m-d H:i:00",$desde) . "'
					");
					if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
						echo "<th style='border:none; background:#666666; font-size:14px'><strong>Bloqueado</strong></th>";
						echo "<th style='border:none; background:#666666; font-size:14px'><strong>Bloqueado</strong></th>\n";
					}
					else{
						$qCita=$db->sql_query("
							SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor='$frm[id_promotor2]' LIMIT 1) as mesa
							FROM citas c
								LEFT JOIN sesiones ses ON c.id_sesion=ses.id
								LEFT JOIN ruedas r ON ses.id_rueda=r.id
							WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2='" . $frm["id_promotor"] . "' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "' AND c.id_promotor IS NULL
						");
						if($cita=$db->sql_fetchrow($qCita)){
							if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
							elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
							elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

							$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
							$grupo=$db->sql_fetchrow($qGrupo);

							echo "<td><a style=\"border:none; padding:0px; color:#fff; text-decoration:underline\" href=\"http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&amp;banner=0&amp;num=$grupo[id]\" target=\"_blank\">$grupo[nombre] (Grupo)</a></td>";
							if($cita["aceptada_promotor"]==1 && ($cita["aceptada_grupo"]==1 || $cita["aceptada_promotor2"]==1)) $estado="Aceptada";
							if($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==0 && $cita["aceptada_promotor2"]==0) $estado="Eliminada";
							else $estado="Por confirmar";
							echo "<td>$estado</td>";
						}
						else{
							echo "";
						}
					}
				}
			}

			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";

	}
	echo "</div>";
	echo "</div>";
}

function mostrar_agenda_promotor_artista($frm){
	GLOBAL $CFG,$db,$ME;

	$qGrupo=$db->sql_query("SELECT * FROM grupos_$frm[tipo] WHERE id='$frm[id_artista]'");
	$grupo=$db->sql_fetchrow($qGrupo);
	
	$caratula=$db->sql_row("SELECT * FROM archivos_grupos_musica WHERE id_grupos_musica='$frm[id_artista]' AND etiqueta='Imagen'");
	
	
	echo "<div id='perfil' style='height:2200px'>";
	echo "<br><br><a style='border:none' id='lista_portafolios' href='index.php?act=0&modo=agenda&id_mercado=$_GET[id_mercado]&id_promotor=$_GET[id_promotor]&mercado=$_GET[id_mercado]'><< Regreso a los listados</a>";
	echo "<h2>Agenda de el ".$grupo["nombre"]."</h2>";

	if($caratula["id"]!=""){
	echo "<img style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px;' src=\"http://2013.circulart.org/m/admin/imagen.php?table=archivos_grupos_musica&amp;field=archivo&amp;id=$caratula[id]\" width=\"250\"/>";
	}
	
	if($grupo["en_resena_corta"]!=""){$en="<br><br>/".$grupo["en_resena_corta"];}else{$en="";}
	
	echo "<p class='grupos'>".$grupo["resena_corta"].$en."<br><br></p>";
	echo "<a class='vermas' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&banner=0&num=".$grupo["id"]."' target=\"_blank\" \">Ver m&aacute;s</a>";
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	
	echo "<div class='izquierda'>";
	echo "<div class='titulo'><strong>Agenda del artista</strong></div><br><br>";
	
	$cambio=0;
	$cambio2=0;
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " .strftime("%A %d de %B", strtotime($sesion["fecha_inicial"])). "</p>\n";
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"210\">Profesional</th><th width=\"140\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);
		
		
		while($desde<$hasta){
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde) . "</th>\n";
			
			$qCita=$db->sql_query("
				SELECT c.*, CONCAT(p.nombre, ' ', p.apellido) as promotor, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
				FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_grupo_$frm[tipo]='$frm[id_artista]' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			");
			if($cita=$db->sql_fetchrow($qCita)){
				echo "<td>$cita[promotor]</td>";
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="Por confirmar";
				echo "<td>$estado</td>";
			}
			else{
				$qBloqueo=$db->sql_query("
					SELECT * FROM excepciones_agenda 
					WHERE (id_grupo_$frm[tipo]='$frm[id_artista]' OR id_promotor='$frm[id_promotor]') AND desde='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
					echo "<td style='border:none; background:#666666; font-size:14px'>&nbsp;&nbsp;<strong>Bloqueado</strong></th>";
					echo "<td style='border:none; background:#666666; font-size:14px'>&nbsp;&nbsp;<strong>Bloqueado</strong></th>\n";
				}
				else{
					echo "<td></td><td><a style=\"color:#fff; text-decoration:underline; text-align:left; border:none; background:none; cursor:pointer;\"  href=\"" . simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=solicitar_cita_promotor&fecha=" . urlencode(date("Y-m-d H:i:s",$desde)) . "&id_sesion=$sesion[id_sesion]&tipo=$frm[tipo]&id_artista=$frm[id_artista]&act=0&id_mercado=$_GET[mercado]&id_promotor=$_GET[id_promotor]&id_artista=$_GET[id_artista]\">Solicitar cita</a>";
				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	echo "</div>";
	
	//agdenda del profesional
	
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	
	$promotores=$db->sql_row("SELECT * FROM promotores WHERE id='$_GET[id_promotor]'");
	echo "<div class='derecha'>";
	echo "<div class='titulo'><strong>Visualización de la agenda de ".$promotores["nombre"]." ".$promotores["apellido"]."</strong></div>";
	
	$cambio=0;
	$cambio2=0;
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " .strftime("%A %d de %B", strtotime($sesion["fecha_inicial"])). "</p>\n";
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"3\" \">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"210\">Artista</th><th width=\"90\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);
		
		while($desde<$hasta){
			
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde);

			$qCita=$db->sql_query("
				SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor='$frm[id_promotor]' LIMIT 1) as mesa
				FROM citas c
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor='$frm[id_promotor]' AND c.id_promotor2 IS NULL AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			");
			if($cita=$db->sql_fetchrow($qCita)){
				echo "</th>\n";
				if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
				elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
				elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

				$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);

				echo "<td><a style='border:none;  padding:5px; color:#fff; font-size:16px; text-decoration:underline' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&banner=0&num=".$grupo["id"]."' target=\"_blank\">$grupo[nombre]</a></td>";
				
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="Por confirmar";
				else $estado="Eliminada";
				echo "<td style='color:#383838; padding:5px; font-size:16px'>$estado</td>";

			}
			else{
				$qCita=$db->sql_query("
					SELECT c.*,
						CASE WHEN c.id_promotor2='$frm[id_promotor]' THEN CONCAT(p.nombre, ' ', p.apellido) ELSE CONCAT(p2.nombre, ' ', p2.apellido) END as promotor,
						(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
						LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
						LEFT JOIN sesiones ses ON c.id_sesion=ses.id
						LEFT JOIN ruedas r ON ses.id_rueda=r.id
					WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2 IS NOT NULL AND (c.id_promotor='$frm[id_promotor]' OR c.id_promotor2='$frm[id_promotor]') AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($cita=$db->sql_fetchrow($qCita)){
					echo "</th>\n";
					echo "<td style='color:#383838; padding:5px; font-size:16px'><strong>$cita[promotor] (Promotor)</strong></td>";
					if($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==1) $estado="Aceptada";
					elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==0) $estado="Por confirmar";
					elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_promotor2"]==1) $estado="Por confirmar";
					else $estado="Eliminada";
					echo "<td style='color:#383838; padding:5px; font-size:16px'>$estado</td>";
				}
				else{
					$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_promotor='$frm[id_promotor]' AND desde='" . date("Y-m-d H:i:00",$desde) . "'");
					if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
						echo "<td style='border:none; background:#666666; font-size:14px'>&nbsp;&nbsp;<strong style='border:none;'>Bloqueado</strong>";
						echo "<td style='border:none; background:#666666; font-size:14px'>&nbsp;&nbsp;<strong style='border:none;'>Bloqueado</strong>";
						echo "</th>\n";
					}
					else{
						
					}
				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	echo "</div>";	
	
	echo "</div>";
	
}

function mostrar_encuesta_promotor($frm){
	GLOBAL $CFG,$db,$ME;

	$qEncuesta=$db->sql_query("
		SELECT mp.*
		FROM mercado_promotores mp LEFT JOIN mercados m ON mp.id_mercado=m.id
		WHERE mp.id_mercado='$frm[id_mercado]' AND mp.id_promotor='$frm[id_promotor]' AND m.fecha_final<'" . date("Y-m-d") . "'
	");
	if($encuesta=$db->sql_fetchrow($qEncuesta)){
		include("../templates/encuesta_promotor.php");
	}

}

function mostrar_agenda_promotor_promotor_recordatorio($frm){
	GLOBAL $CFG,$db,$ME;
    echo "<div id='perfil' style='position:absolute; top:0;  right:45px; margin-top:545px; width:400px; border:none; background-color:#ccc'>";
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	echo "<div style='padding:5px; background-color:#666666; color:#E6D7B0; font-size:14px' align='center'><strong>Visualización de horarios libres en mí agenda</strong></div>";
	$cambio=0;
	$cambio2=0;
	while($sesion=$db->sql_fetchrow($qSesiones)){
		
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%B %d de %Y",strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\" width=\"400\" style=\"background-color:#ccc\">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"210\">Artista</th><th width=\"90\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);

        while($desde<$hasta){
			
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde);
			$qCita=$db->sql_query("
				SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor='$frm[id_promotor]' LIMIT 1) as mesa
				FROM citas c
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor='$frm[id_promotor]' AND c.id_promotor2 IS NULL AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			");
			if($cita=$db->sql_fetchrow($qCita)){
				echo "</th>\n";
				if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
				elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
				elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

				$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);

				echo "<td><a style='border:none;  padding:0px; color:#fff; text-decoration:underline; font-size:14px;' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&banner=0&num=".$grupo["id"]."' target=\"_blank\">$grupo[nombre]</a></td>";
				
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="Debo confirmar";
				else $estado="Eliminada";
				echo "<td>$estado</td>";

			}
			else{
				$qCita=$db->sql_query("
					SELECT c.*,
						CASE WHEN c.id_promotor2='$frm[id_promotor]' THEN CONCAT(p.nombre, ' ', p.apellido) ELSE CONCAT(p2.nombre, ' ', p2.apellido) END as promotor,
						(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
						LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
						LEFT JOIN sesiones ses ON c.id_sesion=ses.id
						LEFT JOIN ruedas r ON ses.id_rueda=r.id
					WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2 IS NOT NULL AND (c.id_promotor='$frm[id_promotor]' OR c.id_promotor2='$frm[id_promotor]') AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($cita=$db->sql_fetchrow($qCita)){
					echo "</th>\n";
					echo "<td>$cita[promotor] (Promotor)</td>";
					echo "<td>$cita[mesa]</td>";
					if($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==1) $estado="Aceptada";
					elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==0) $estado="Por confirmar";
					elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_promotor2"]==1) $estado="<a href=\"" . simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=confirmar_cita_promotor_promotor&id_cita=$cita[id]\" style='color:#fff; text-decoration:underline'>Confirmar</a>";
					else $estado="Eliminada";
					echo "<td>$estado</td>";
				}
				else{
					$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_promotor='$frm[id_promotor]' AND desde='" . date("Y-m-d H:i:00",$desde) . "'");
					if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
						echo "<td style='border:none; background:#8D8D8D'>&nbsp;&nbsp;<strong style='border:none; background:#8D8D8D'>Bloqueado</strong>";
						echo "<td style='border:none; background:#8D8D8D'>&nbsp;&nbsp;<strong style='border:none; background:#8D8D8D'>Bloqueado</strong>";
						echo "</th>\n";
					}
					else{
						
					}
				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	
	echo "</div>";
}
/**************************************************/
/*funcion que construlle la agenda del profesional*/
/**************************************************/
function mostrar_agenda_promotor($frm){
	GLOBAL $CFG,$db,$ME;
    echo "<div id='contenido_miAgenda'>";
	echo "<div>Para imprimir <b>la agenda</b>, haga click en este icono <img src=\"../m/iconos/transparente/printer.png\" style=\"cursor:pointer\" onClick=\"popup('impresion.php?mode=agenda_promotor&id_promotor=$frm[id_promotor]&id_mercado=$frm[id_mercado]')\" title=\"Imprimir Agenda\"></div>";
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	
	$cambio=0;
	$cambio2=0;
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%A %d de %B", strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table border=\"0\" cellpadding=\"5\" cellspacing=\"5\" width=\"100%\">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"208\">Artista</th><th width=\"50\">Mesa</th><th width=\"90\">Estado</th><th width=\"50\">Cancelar cita</th></tr>\n";
			
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);

		while($desde<$hasta){
			echo "<tr><th scope=\"row\" style='text-align: left; fonti-size:14px'>" . strftime("%H:%M ",$desde) . date("a",$desde);
			
			$qCita=$db->sql_query("
				SELECT c.*, (SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor='$frm[id_promotor]' LIMIT 1) as mesa
				FROM citas c
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor='$frm[id_promotor]' AND c.id_promotor2 IS NULL AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			");
			if($cita=$db->sql_fetchrow($qCita)){
				echo "</th>\n";
				if($cita["id_grupo_musica"]!="" && $cita["id_grupo_musica"]!="0"){$tipo="musica";$id=$cita["id_grupo_musica"];}
				elseif($cita["id_grupo_danza"]!="" && $cita["id_grupo_danza"]!="0"){$tipo="danza";$id=$cita["id_grupo_danza"];}
				elseif($cita["id_grupo_teatro"]!="" && $cita["id_grupo_teatro"]!="0"){$tipo="teatro";$id=$cita["id_grupo_teatro"];}

				$qGrupo=$db->sql_query("SELECT id,nombre FROM grupos_$tipo WHERE id='$id'");
				$grupo=$db->sql_fetchrow($qGrupo);

				echo "<td><a style='border:none; padding:0px; color:#fff; text-decoration:underline;' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&banner=0&num=".$grupo["id"]."' target=\"_blank\">$grupo[nombre]</a></td>";
				echo "<td>$cita[mesa]</td>";
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="<a href=\"" . simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=confirmar_cita_promotor&id_cita=$cita[id]\" style='color:#fff; text-decoration:underline'>Confirmar</a>";
				else $estado="Eliminada";
				echo "<td>$estado</td>";
				echo "<td align=\"center\"><a style=\"border:none; background:none; cursor:pointer;\" href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=rechazar_cita_promotor&id_cita=$cita[id]&id_promotor=$_GET[id_promotor]\"><img border=\"0\" src=\"../m/iconos/transparente/trash-x.png\"></a></td>";

			}
			else{
				$qCita=$db->sql_query("
					SELECT c.*,
						CASE WHEN c.id_promotor2='$frm[id_promotor]' THEN CONCAT(p.nombre, ' ', p.apellido) ELSE CONCAT(p2.nombre, ' ', p2.apellido) END as promotor,
						(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
						LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
						LEFT JOIN sesiones ses ON c.id_sesion=ses.id
						LEFT JOIN ruedas r ON ses.id_rueda=r.id
					WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2 IS NOT NULL AND (c.id_promotor='$frm[id_promotor]' OR c.id_promotor2='$frm[id_promotor]') AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($cita=$db->sql_fetchrow($qCita)){
					echo "</th>\n";
					echo "<td>$cita[promotor] (Promotor)</td>";
					echo "<td>$cita[mesa]</td>";
					if($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==1){ $estado="Aceptada";}
					elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==0){ $estado="Por confirmar";}
					elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_promotor2"]==1){ 
					if($cita["id_promotor2"]==$frm["id_promotor"]){
					    $estado="Por confirmar";
					 }else{
						 $estado="<a href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=confirmar_cita_promotor_promotor&id_cita=$cita[id]\" style='color:#fff; text-decoration:underline'>Confirmar</a>";
						 }
					}else{ $estado="Eliminada";};
					echo "<td>$estado</td>";
					echo "<td align=\"center\"><a style=\"border:none; background:none; cursor:pointer;\" href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=rechazar_cita_promotor_promotor&id_cita=$cita[id]&id_promotor=$_GET[id_promotor]\"><img border=\"0\" src=\"../m/iconos/transparente/trash-x.png\"></a></td>";
					

				}
				else{
					$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_promotor='$frm[id_promotor]' AND desde='" . date("Y-m-d H:i:00",$desde) . "'");
					if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
						echo "&nbsp;&nbsp;<a style='border:none; background:none; text-decoration:underline;' href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=desbloquear_agenda_promotor&fecha=" . urlencode($desde) . "&id_promotor=$_GET[id_promotor]\" title=\"Desbloquear\">Desbloquear horario</a>";
						echo "</th>";
						echo "<th style='border:none; background:#8D8D8D'></th>";
						echo "<th style='border:none; background:#8D8D8D'></th>";
						echo "<th style='border:none; background:#8D8D8D'></th>";
						echo "<th style='border:none; background:#8D8D8D'></th>\n";
						
					}
					else{
						echo "&nbsp;&nbsp;<a style='border:none; background:none; text-decoration:underline;' href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=bloquear_agenda_promotor&fecha=" . urlencode($desde) . "&id_promotor=$_GET[id_promotor]\" title=\"Bloquear\">Bloquear horario</a>";
						echo "</th>\n";
					}
				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	
	echo "</div>";
}

function detalle_mercado($frm){
	GLOBAL $CFG,$db;
	
	$string="";

	$hoy=date("Y-m-d");
	if(isset($frm["id_sesion"])) $condicion="m.id=(SELECT r.id_mercado FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE s.id='$frm[id_sesion]')";
	elseif(isset($frm["id_mercado"])) $condicion="m.id='$frm[id_mercado]'";
	else $condicion="DATE_ADD(m.fecha_final,INTERVAL 5 DAY) >= '$hoy' AND m.id='" . $CFG->mercado . "'";

	$qMercado=$db->sql_query("SELECT m.* FROM mercados m WHERE $condicion LIMIT 1");
	if($mercado=$db->sql_fetchrow($qMercado)){
		$string.= "<p>";
		
		if(isset($frm["id_artista"]) && isset($frm["tipo"])){
			$qGrupo=$db->sql_query("SELECT * FROM grupos_$frm[tipo] WHERE id='$frm[id_artista]'");
			$grupo=$db->sql_fetchrow($qGrupo);
			$string.= '<div class="nombre_profesional">Bienvenido artista / grupo: '.$grupo["nombre"].'<a href="index.php?modo=login"><div>Salir [X]</div></a></div><br>';
			$string.= "<br><a id='lista_portafolios_dos' href='index.php?act=1&tipo=musica&modo=agenda&id_mercado=".$CFG->mercado."&id_artista=".$grupo["id"]."&mercado=".$CFG->mercado."'>Profesionales</a><a id='miAgenda' href='index.php?act=2&tipo=musica&modo=agenda&id_mercado=".$CFG->mercado."&id_artista=".$grupo["id"]."&mercado=".$CFG->mercado."'>Administraci&oacute;n de m&iacute; agenda</a><p></p>";
		}
		elseif($frm["mode"]=="agenda_promotor"){
			$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id='$frm[id_promotor]'");
			$promotor=$db->sql_fetchrow($qPromotor);
			$string.= "<br><br><a id='lista_portafolios_dos' style='border:none;' href='index.php?act=1&modo=agenda&tipo=teatro&id_artista=".$frm['id_artista']."&id_mercado=".$CFG->mercado."&mercado=".$CFG->mercado."'><< Regreso al listado de profesionales</a>";
			$string.= "<div style='height:2200px'>";
			$string.= "<h2>Agenda de " . $promotor["nombre"] . " " . $promotor["apellido"] . "</h2>";
			$string.= "<div style='overflow:hidden;'>";
			if($promotor["mmdd_imagen_filename"]!=""){
			$string.="<img style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px;' src=\"http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/files/promotores/imagen/$promotor[id]\" width=\"250\"/>";
			}else{
			$string.="<div style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px; width:250px; height:250px; background-color:#F2EBD9'></div>";
				}
			$string.= "<div class='profesionales'><p>" . $promotor["resena"] . "</p>\n";
			$string.= "<br><br><br><a class='vermas' style='margin-left:0;' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&amp;banner=0&amp;num=' target='_blank'>Ver más</a>";

		}elseif($frm["mode"]=="solicitar_cita_grupo"){
			$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id='$frm[id_promotor]'");
			$promotor=$db->sql_fetchrow($qPromotor);
			$string.= "<br><br><a id='lista_portafolios_dos' style='border:none;' href='index.php?act=1&modo=agenda&tipo=teatro&id_artista=".$frm['id_artista']."&id_mercado=".$CFG->mercado."&mercado=".$CFG->mercado."'><< Regreso al listado de profesionales</a>";
			$string.= "<div id='perfil' style='height:2200px'>";
			$string.= "<h2>Agenda de " . $promotor["nombre"] . " " . $promotor["apellido"] . "</h2>";
			$string.= "<div style='overflow:hidden;'>";
			if($promotor["mmdd_imagen_filename"]!=""){
			$string.="<img style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px;' src=\"http://2013.circulart.org/m/phpThumb/phpThumb.php?src=/var/www/vhosts/redlat.org/circulart.org/files/promotores/imagen/$promotor[id]\" width=\"250\"/>";
			}else{
			$string.="<div style='margin-top:10px; margin-left:5px; float:left; margin-bottom:30px; width:250px; height:250px; background-color:#F2EBD9'></div>";
				}
			$string.= "<div class='profesionales'><p>" . $promotor["resena"] . "</p>\n";
			$string.= "<br><br><br><a class='vermas' style='margin-left:0;' href='http://2013.circulart.org/portafolios/portafolios-rueda-de-negocios/portafolios-perfiles-rueda-de-negocios.html?idioma=es&amp;banner=0&amp;num=' target='_blank'>Ver más</a>";
		}
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		$array["id"]=$mercado["id"];
		$array["string"]=$string;
		return($array);
	}
	else die("No hay mercados activos");

}



/**************************************************************************************************************/
/*funcion que arma el listado de los artitas o grupos cuando entran como profesional al modulo de agendamiento*/
/**************************************************************************************************************/
function listar_grupos($frm){
	GLOBAL $CFG,$db,$ME;

	$qMercado=$db->sql_query("SELECT m.* FROM mercados m WHERE m.id='" . $CFG->mercado . "' LIMIT 1");
	$mercado=$db->sql_fetchrow($qMercado);

	$qPromotor=$db->sql_query("SELECT * FROM promotores WHERE id='$frm[id_promotor]'");
	$promotor=$db->sql_fetchrow($qPromotor);
	
	//linea de codigo donde se meuestra el nombre del profesional y el boton de salida
	echo "<div class='nombre_profesional'>Bienvenido profesional: <b>" .$promotor["nombre"]." ".$promotor["apellido"]. "</b><a href='index.php?modo=login'><div >Salir [X]</div></a></div>\n";
	$condicion="ma.id_mercado='$frm[id_mercado]'";
	$id_nivel=$_SESSION[$CFG->sesion]["user"]["id_nivel"];
	if($id_nivel=="10"){//Nivel 10 es igual a profesional
		$id_promotor=$_SESSION[$CFG->sesion]["user"]["id"];
		$qAreas=$db->sql_query("SELECT ar.codigo FROM pr_promotores_areas pa LEFT JOIN pr_areas ar ON pa.id_area=ar.id WHERE pa.id_promotor='$id_promotor'");
		$arrayCondiciones=array();
		while($area=$db->sql_fetchrow($qAreas)){
			if($area["codigo"]=="teatro"||$area["codigo"]=="musica"||$area["codigo"]=="danza"){//filtra por las tablas de teatro, musica, danza
			 array_push($arrayCondiciones,"(ma.id_grupo_" . $area["codigo"] . " IS NOT NULL AND ma.id_grupo_" . $area["codigo"] . "!='0')");
			}
		}
		if(sizeof($arrayCondiciones)>0)	$condicion.=" AND (" . implode(" OR ",$arrayCondiciones) . ")";
	}
	$qGrupos=$db->sql_query("
		SELECT ma.*
		FROM mercado_artistas ma
			LEFT JOIN grupos_musica gm on gm.id=ma.id_grupo_musica
			LEFT JOIN grupos_danza gd on gd.id=ma.id_grupo_danza
			LEFT JOIN grupos_teatro gt on gt.id=ma.id_grupo_teatro
		WHERE $condicion
		ORDER BY gm.nombre, gd.nombre, gt.nombre
	");

	$tipo_anterior="";
	
	//línea de codigo que muestra los enlaces de listado de artistas, litado de profesionales y la administración de las agendas para profesionales.
	echo "<a id='lista_portafolios' href='index.php?act=0&modo=agenda&id_mercado=".$CFG->mercado."&id_promotor=".$promotor["id"]."&mercado=".$CFG->mercado."'>Listado artistas</a>";
	echo "<a id='lista_portafolios_dos' href='index.php?act=1&modo=agenda&id_mercado=".$CFG->mercado."&id_promotor=".$promotor["id"]."&mercado=".$CFG->mercado."'>listado de profesionales</a>";
	echo "<a id='miAgenda' href='index.php?act=2&modo=agenda&id_mercado=".$CFG->mercado."&id_promotor=".$promotor["id"]."&mercado=".$CFG->mercado."'>Administraci&oacute;n de m&iacute; agenda</a>";
	
	//codigo que muestra a los grupos o artistas en la parte del Profesional
	echo "<br><br><div id='contenido_lista' ><div>Artistas:</div>";
	$j=1;
	echo "\n<table>";
	echo "<tr><td>";
	while($gm=$db->sql_fetchrow($qGrupos)){
		if($gm["id_grupo_musica"]!=""){$tipo="musica";$tipoTxt="Música";$id=$gm["id_grupo_musica"];}
		elseif($gm["id_grupo_danza"]!=""){$tipo="danza";$tipoTxt="Danza";$id=$gm["id_grupo_danza"];}
		elseif($gm["id_grupo_teatro"]!=""){$tipo="teatro";$tipoTxt="Teatro";$id=$gm["id_grupo_teatro"];}
		$tipo_anterior=$tipo;
		$qImagen=$db->sql_query("
			SELECT g.id,g.nombre
			FROM grupos_$tipo g
			WHERE id='$id'
		");
		if($grupo=$db->sql_fetchrow($qImagen)){
		//codigo nuevo 
		  if($grupo["id"]!=1555){
			$link=simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=agenda_artista&tipo=$tipo&id_artista=$grupo[id]&id_mercado=$frm[id_mercado]&act=0&id_promotor=$_GET[id_promotor]";
			echo "<table class='items' border='0' cellspacing='0' cellpadding='0' ><tr><td>";
			echo "<a style=\"text-align:left; border:none; background:none; cursor:pointer;\" onclick=\"artistas('".$link."')\" title=\"Ver agenda y perfil del artista\">";
			echo $j.".&nbsp;&nbsp;".$grupo["nombre"];
			echo "</a>&nbsp;";
			echo "</td></tr></table>";
			$j++;
		   }
		}
	}
	echo "</tr></td></table></div>"; 
}
/***********************************************************************************************************/
/*funcion que arma el listado de los profesionales para profesionales profesional al modulo de agendamiento*/
/***********************************************************************************************************/
function listar_promotores($frm){
	GLOBAL $CFG,$db,$ME;

	$condicion="mp.id_mercado='$frm[id_mercado]'";
   
	if(isset($_SESSION[$CFG->sesion]["user"]["grupo_tipo"])){//si es un grupo
		$tipo=$_SESSION[$CFG->sesion]["user"]["grupo_tipo"];
		//$condicion.=" AND mp.id_promotor IN (SELECT pa.id_promotor FROM pr_promotores_areas pa LEFT JOIN pr_areas ar ON pa.id_area=ar.id WHERE ar.codigo='$tipo')";
	}
	else{//si es un profesional
	    $id_promotor=$_SESSION[$CFG->sesion]["user"]["id"];
		$condicion.=" AND mp.id_promotor!='" . $id_promotor . "' AND mp.id_promotor IN (
			SELECT pa.id_promotor
			FROM pr_promotores_areas pa
			WHERE pa.id_area IN (SELECT id_area FROM pr_promotores_areas WHERE id_promotor='" . $id_promotor . "') 
		)";
	}
    echo "<div id='contenido_listapro'><div>Profesionales:</div>";
	$qPromotores=$db->sql_query("SELECT p.* FROM mercado_promotores mp LEFT JOIN promotores p ON mp.id_promotor=p.id WHERE $condicion ORDER BY nombre");
	$j=1;
	while($promotor=$db->sql_fetchrow($qPromotores)){ 
        //aqui va el codigo de bloqueo de los que son de circo
		if($promotor["id"]!=3788){ //oculta el profesional de prueba
			if(isset($id_promotor)) $link=simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=agenda_promotor_promotor&id_promotor2=$_GET[id_promotor]&id_promotor=$promotor[id]&id_mercado=$frm[id_mercado]&act=1";
			else $link=simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=agenda_promotor&id_promotor=$promotor[id]&id_mercado=$frm[id_mercado]&id_artista=$_GET[id_artista]&act=1";
			echo "<table class='items'><tr><td>";
			echo "<a style=\"border:none; background:none; cursor:pointer;\" onclick=\"artistas('".$link."')\" title=\"Ver agenda del promotor\">";
			echo $j.".&nbsp;&nbsp;".$promotor["nombre"] . " " . $promotor["apellido"];
			echo "</a>";
			echo "</td></tr></table>";
			$j++;
		}
		//aqui va el fin del bloqueo de circo
	}
	echo "</div>";
}

function mostrar_agenda_grupo($frm){
	GLOBAL $CFG,$db,$ME;
    
	echo "<div id='contenido_miAgenda'>";
	echo "<div style='padding:5px; margin:2px;'>Para imprimir <b>la agenda</b>, haga click en este icono <img src=\"../m/iconos/transparente/printer.png\" style=\"cursor:pointer\" onClick=\"popup('impresion.php?mercado=".$CFG->mercado."&modo=agenda&mode=agenda_artista&id_grupo=$frm[id_grupo]&tipo=$frm[tipo]&id_mercado=$frm[id_mercado]')\" title=\"Imprimir Agenda\"></div>";
	
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	
	$cambio=0;
	$cambio2=0;
	
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%B %d de %Y",strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"5\">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"208\">Promotor</th><th width=\"50\">Mesa</th><th width=\"90\">Estado</th><th width=\"50\">Eliminar</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);

			
		while($desde<$hasta){

			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde);

			
			$qCita=$db->sql_query("
				SELECT c.*, CONCAT(p.nombre, ' ', p.apellido) as promotor,(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
				FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_grupo_$frm[tipo]='$frm[id_grupo]' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			");
			if($cita=$db->sql_fetchrow($qCita)){
				echo "</th>\n";
				echo "<td>$cita[promotor]</td>";
				echo "<td>$cita[mesa]</td>";
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="<a href=\"" . simple_me($ME) . "?act=2&id_mercado=$_GET[id_mercado]&id_artista=$_GET[id_artista]&tipo=musica&mercado=".$CFG->mercado."&modo=agenda&mode=confirmar_cita_grupo&id_cita=$cita[id]\" style='color:#fff; text-decoration:underline'>Confirmar</a>";
				echo "<td>$estado</td>";
				echo "<td align=\"center\"><a style=\"border:none; background:none; cursor:pointer;\" href=\"" . simple_me($ME) . "?act=2&id_mercado=$_GET[id_mercado]&id_artista=$_GET[id_artista]&tipo=musica&mercado=$_GET[id_mercado]&modo=agenda&mode=rechazar_cita_grupo&id_cita=$cita[id]\"><img border=\"0\" src=\"../m/iconos/transparente/trash-x.png\"></a></td>";
				
			}
			else{
				$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_grupo_$frm[tipo]='$frm[id_grupo]' AND desde='" . date("Y-m-d H:i:00",$desde) . "'");
				if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
					echo "&nbsp;&nbsp;<a style='color:#fff; border:none; background:none; text-decoration:underline;' href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=desbloquear_agenda_grupo&tipo=$frm[tipo]&id_artista=$frm[id_grupo]&id_mercado=$frm[id_mercado]&fecha=" . urlencode($desde) . "\" title=\"Desbloquear\">Desbloquear Horario</a>";
					echo "</th>";
					echo "<th style='border:none; background:#8D8D8D'></th>";
					echo "<th style='border:none; background:#8D8D8D'></th>";
					echo "<th style='border:none; background:#8D8D8D'></th>";
					echo "<th style='border:none; background:#8D8D8D'></th>\n";
					
				}
				else{
					echo "&nbsp;&nbsp;<a style='color:#fff; border:none; background:none; text-decoration:underline;' href=\"" . simple_me($ME) . "?act=2&mercado=".$CFG->mercado."&modo=agenda&mode=bloquear_agenda_grupo&tipo=$frm[tipo]&id_artista=$frm[id_grupo]&id_mercado=$frm[id_mercado]&fecha=" . urlencode($desde) . "\" title=\"Bloquear\">Bloquear horario</a>";
					echo "</th>\n";
				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	echo "</div>";
}

function mostrar_encuesta_grupo($frm){
	GLOBAL $CFG,$db,$ME;

	$qEncuesta=$db->sql_query("
		SELECT ma.*
		FROM mercado_artistas ma LEFT JOIN mercados m ON ma.id_mercado=m.id
		WHERE ma.id_mercado='$frm[id_mercado]' AND ma.id_grupo_$frm[tipo]='$frm[id_grupo]' AND m.fecha_final<'" . date("Y-m-d") . "'
	");
	if($encuesta=$db->sql_fetchrow($qEncuesta))	include("../templates/encuesta_grupo.php");

}

function mostrar_agenda_grupo_promotor($frm){
	GLOBAL $CFG,$db,$ME;

	echo '<div class="izquierda" style="margin-left:-265px;">';
	echo '<div class="titulo" align="center"><strong>Agenda del profesional</strong></div><br><br>';
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]' ORDER BY s.fecha_inicial
	");
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%B %d de %Y",strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table  border=\"0\" cellpadding=\"5\" cellspacing=\"5\">\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"208\">Grupo</th><th width=\"90\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);

        while($desde<$hasta){
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde) . "</th>\n";
			$strQuery="
				SELECT c.*,
					CASE WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!=0) THEN gd.nombre
					WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!=0) THEN gm.nombre
					WHEN (c.id_grupo_teatro IS NOT NULL AND c.id_grupo_teatro!=0) THEN gt.nombre
					END AS grupo,
					(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=c.id_promotor LIMIT 1) as mesa
				FROM citas c LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
					LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
					LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2 IS NULL AND c.id_promotor='$frm[id_promotor]' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			";
			$qCita=$db->sql_query($strQuery);
			if($cita=$db->sql_fetchrow($qCita)){
				echo "<td>$cita[grupo]</td>";
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="Por confirmar";
				echo "<td>$estado</td>";
			}
			else{
				$qCita=$db->sql_query("
					SELECT c.*,
						CASE WHEN c.id_promotor2='$frm[id_promotor]' THEN CONCAT(p.nombre, ' ', p.apellido) ELSE CONCAT(p2.nombre, ' ', p2.apellido) END as promotor,
						(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
					FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
						LEFT JOIN promotores p2 ON c.id_promotor2=p2.id
						LEFT JOIN sesiones ses ON c.id_sesion=ses.id
						LEFT JOIN ruedas r ON ses.id_rueda=r.id
					WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_promotor2 IS NOT NULL AND (c.id_promotor='$frm[id_promotor]' OR c.id_promotor2='$frm[id_promotor]') AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
				");
				if($cita=$db->sql_fetchrow($qCita)){
					echo "</th>\n";
					echo "<td>$cita[promotor] (Promotor)</td>";
					if($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==1) $estado="Aceptada";
					elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_promotor2"]==0) $estado="Por confirmar";
					elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_promotor2"]==1) $estado="Por confirmar";
					else $estado="Eliminada";
					echo "<td>$estado</td>";
				}
				else{
					$qBloqueo=$db->sql_query("
						SELECT * FROM excepciones_agenda 
						WHERE (id_grupo_$frm[tipo]='$frm[id_grupo]' OR id_promotor='$frm[id_promotor]') AND desde='" . date("Y-m-d H:i:00",$desde) . "'
					");
					if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
					echo "<th style='border:none; background:#8D8D8D'>Bloqueado</th>";
					echo "<th style='border:none; background:#8D8D8D'>Bloqueado</th>\n";
					}
					else{
						echo "<td></td><td><a style='padding:0px; color:#fff; text-decoration:underline; text-align:left; border:none; background:none; cursor:pointer;' href=\"" . simple_me($ME) . "?mercado=".$CFG->mercado."&modo=agenda&mode=solicitar_cita_grupo&fecha=" . urlencode(date("Y-m-d H:i:s",$desde)) . "&id_sesion=$sesion[id_sesion]&id_promotor=$frm[id_promotor]&id_artista=$_GET[id_artista]&act=1\">Solicitar cita</a>";
					}
				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	echo "</div>";
	//agenda del artista
	echo '<div class="derecha" style="margin-left:320px;">';
	echo '<div class="titulo" align="center" ><strong>Visualización de horarios libres en mí agenda</strong></div>';
	$qSesiones=$db->sql_query("
		SELECT s.id as id_sesion, s.id_rueda, s.lugar, r.nombre, r.duracion_cita, s.fecha_inicial, fecha_final
		FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='$frm[id_mercado]'
		ORDER BY s.fecha_inicial
	");
	while($sesion=$db->sql_fetchrow($qSesiones)){
		echo "<p><strong>Rueda:</strong> $sesion[nombre] <br />\n";
		echo "<strong>Lugar:</strong> $sesion[lugar].<br />\n";
		setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
		echo "<strong>Fecha:</strong> " . strftime("%B %d de %Y",strtotime($sesion["fecha_inicial"])) . "</p>\n";
		echo "<table  border=\"0\" cellpadding=\"6\" cellspacing=\"5\" >\n";
		echo "<tr><th width=\"100\">Hora</th><th width=\"208\">Promotor</th><th width=\"90\">Estado</th></tr>\n";
		$desde=strtotime($sesion["fecha_inicial"]);
		$hasta=strtotime($sesion["fecha_final"]);

        while($desde<$hasta){
			echo "<tr><th scope=\"row\" style='text-align:left'>" . strftime("%H:%M ",$desde) . date("a",$desde);
			$qCita=$db->sql_query("
				SELECT c.*, CONCAT(p.nombre, ' ', p.apellido) as promotor,(SELECT mesa FROM mercado_promotores WHERE id_mercado=r.id_mercado AND id_promotor=p.id LIMIT 1) as mesa
				FROM citas c LEFT JOIN promotores p ON c.id_promotor=p.id
					LEFT JOIN sesiones ses ON c.id_sesion=ses.id
					LEFT JOIN ruedas r ON ses.id_rueda=r.id
				WHERE c.id_sesion='$sesion[id_sesion]' AND c.id_grupo_$frm[tipo]='$frm[id_grupo]' AND c.fecha_inicial='" . date("Y-m-d H:i:00",$desde) . "'
			");
			if($cita=$db->sql_fetchrow($qCita)){
				echo "</th>\n";
				echo "<td>$cita[promotor]</td>";
				if($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==1) $estado="Aceptada";
				elseif($cita["aceptada_promotor"]==0 && $cita["aceptada_grupo"]==1) $estado="Por confirmar";
				elseif($cita["aceptada_promotor"]==1 && $cita["aceptada_grupo"]==0) $estado="Por confirmar";
				else $estado="Eliminada";
				echo "<td>$estado</td>";
			}
			else{
				$qBloqueo=$db->sql_query("SELECT * FROM excepciones_agenda WHERE id_grupo_$frm[tipo]='$frm[id_grupo]' AND desde='" . date("Y-m-d H:i:00",$desde) . "'");
				if($db->sql_numrows($qBloqueo)!=0){//Horario bloqueado
					echo "<th style='border:none; background:#8D8D8D'>Bloqueado</th>";
					echo "<th style='border:none; background:#8D8D8D'>Bloqueado</th>\n";
				}
				else{

				}
			}
			echo "</tr>\n";
			$desde+=60*15;
		}
		echo "</table>\n";
	}
	echo "</div>";
	
	
}


?>