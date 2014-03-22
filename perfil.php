
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="es">
    <head> 

        <title>Via</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="author" content="" />       
        <meta name="description" content="Inicio" />       
        <!-- Si hay diseño responsive
        <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1" />
        -->

        <script src="js/prefixfree.min.js"></script>
        <!-- Estilos -->
        <link rel="stylesheet" href="css/normalize.css" />
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/portfolio.css" />


    </head>
    <body class="contact">
        <!-- Header -->
        <?php include 'header.php' ?>
        <!-- content -->

        <div class="title">           
            <h1>ARTISTAS</h1>
        </div>
        <div class="via">
	        <section class="form">
	           <?PHP
			   include("conexion.php");
			   $db = new MySQL();
			   $qGrupos=$db->consulta("SELECT gt.* FROM grupos_teatro gt where id='".$_GET["n"]."'");
			  
			   if($db->num_rows($qGrupos)>0){
				while($gt=mysql_fetch_array($qGrupos)){
			     $caratula=$db->consulta("SELECT * FROM archivos_grupos_teatro WHERE id_grupos_teatro='".$gt["id"]."' AND orden='0'");
			     $cara=mysql_fetch_array($caratula);
				?>	
				<div class="perfil">
				  <div id="nombre"><?=utf8_encode($gt["nombre"])?><hr></div>
                  <?php if($cara["id"]!=""){ ?>
                  <div id="imagen"><img src="http://circulart.org/admin/imagen.php?table=archivos_grupos_teatro&amp;field=archivo&amp;id=<?php echo $cara["id"];?>" border="0"></div>
                  <?php }else{ ?> 
				  <div id="imagen"><img src="http://via.festivaldeteatro.com.co/m/images/noimagen.png" border="0"></div>
				  <?php }?>
                  <div id="pais" class="text"><strong>País:</strong> <?
				        $arrayPais=$db->consulta("SELECT * FROM paises WHERE id='".$gt["id_pais"]."'");
						$datosPais=mysql_fetch_array($arrayPais);
						echo utf8_encode($datosPais["pais"])
				  ?><hr></div>
                  <div id="ciudad" class="text"><strong>Ciudad: </strong> <?=utf8_encode($gt["ciudad"])?><hr></div>
                  <div id="telefono" class="text"><strong>Teléfono: </strong> <?=utf8_encode($gt["telefono"])?><hr></div>
                  <div id="correo" class="text"><strong>Correo: </strong> <?=utf8_encode($gt["email"])?><hr></div>
                  <div id="web" class="text"><strong>WEB:</strong>
                  <?
                   if($gt["website"]!=""){
					$buscarWeb = "http";
					$cadenaWeb = $gt["website"];
					$resultadoWeb = strpos($cadenaWeb, $buscarWeb);
					
						if($resultadoWeb!== FALSE){
							$enlace="<a href='". $gt["website"]."' target='_blank'>".$gt["website"]."</a>";
						}else{
							$enlace="<a href='http://".$gt["website"]."' target='_blank'>".$gt["website"]."</a>";
						}
					}
				    echo utf8_encode($enlace)?><hr></div>
                  <div id="trayectoria" class="text"><strong>trayectoria: </strong><a href="http://circulart.org/admin/fileFS.php?table=grupos_teatro&field=trayectoria&id=<?=$gt["id"]?>">ver</a><hr></div>
                  <div id="resena" class="text"><strong>Reseña: </strong><hr> <?=utf8_encode($gt["resena_corta"])?></div>
                  <div id="cont_redes">
                    <div id="redes">
                      <div class="r"><?
						if($gt["facebook"]!=""){
							$buscarFace = "http";
							$cadenaFace = $gt["facebook"];
							$resultadoFace = strpos($cadenaFace, $buscarFace);
								if($resultadoFace !== FALSE){
									echo "<a href='". $gt["facebook"]."' target='_blank'><span class='icon-facebook'></span></a>";
								}else{
									echo "<a href='http://".$gt["facebook"]."' target='_blank'><span class='icon-facebook'></span></a>";
								}
						}
						?></div>
                        <div class="r"><?
						if($gt["twitter"]!=""){
							$buscarFace = "twitter";
							$cadenaFace = $gt["twitter"];
							$resultadoFace = strpos($cadenaFace, $buscarFace);
								if($resultadoFace !== FALSE){
									echo "<a href='". $gt["twitter"]."' target='_blank'><span class='icon-twitter'></span></a>";
								}else{
									echo "<a href='http://twitter.com/".$gt["twitter"]."' target='_blank'><span class='icon-twitter'></span></a>";
								}
						}
						?></div>
                     </div>   
                   </div>
                 </div>
				 <?php 
					$cont=0;
					$obrasD = $db->consulta("SELECT * FROM obras_teatro WHERE id_grupos_teatro ='".$gt["id"]."'ORDER BY anio DESC");
					while($datos_obras=mysql_fetch_array($obrasD)){$cont++;}
					
					if($cont!=0){
						$obrasD = $db->consulta("SELECT * FROM obras_teatro WHERE id_grupos_teatro ='".$gt["id"]."'ORDER BY anio DESC");
						$c=0;
						$contObras="";
						while($datos_obras=mysql_fetch_array($obrasD)){
							if($c==0){
								if($datos_obras["obra"]!="")$contObras.="<div class='obras' id='obras_$c'><div class='espacio'>".utf8_encode($datos_obras["obra"])."<hr></div>";
							}else{
								if($datos_obras["obra"]!="")$contObras.="<div class='obras' id='obras_$c'><div class='espacio'>".utf8_encode($datos_obras["obra"])."<hr></div>";}
								if($datos_obras["resena"]!="")$contObras.="<div class='text'>".utf8_encode($datos_obras["resena"])."<br><br></div>";
								if($datos_obras["anio"]!="")$contObras.="<div class='text'><strong>Año:</strong> ".utf8_encode($datos_obras["anio"])."<hr></div>";
								if($datos_obras["autor"]!="")$contObras.="<div class='text'><strong>Autor:</strong> ".utf8_encode($datos_obras["autor"])."<hr></div>";
								if($datos_obras["duracion"]!="")$contObras.="<div class='text'><strong>Duración:</strong> ".utf8_encode($datos_obras["duracion"])."<hr></div>";
								if($datos_obras["num_viajantes"]!="")$contObras.="<div class='text'><strong>No. de personas que viajan:</strong> ".utf8_encode($datos_obras["num_viajantes"])."<hr></div>";
								if($datos_obras["horas_montaje"]!="")$contObras.="<div class='text'><strong>Horas de Montaje:</strong> ".utf8_encode($datos_obras["horas_montaje"])."<hr></div>";
								if($datos_obras["horas_desmontaje"]!="")$contObras.="<div class='text'><strong>Horas desmontaje:</strong> ".utf8_encode($datos_obras["horas_desmontaje"])."<hr></div>";
								if($datos_obras["ensayos"]!="")$contObras.="<div class='text'><strong>Ensayos:</strong> ".utf8_encode($datos_obras["ensayos"])."<hr></div>";
								if($datos_obras["responsable_carga"]!="")$contObras.="<div class='text'><strong>Responsable de carga:</strong> ".utf8_encode($datos_obras["responsable_carga"])."<hr></div>";
								if($datos_obras["direccion_recogida"]!="")$contObras.="<div class='text'><strong>Dirección recogida:</strong> ".utf8_encode($datos_obras["direccion_recogida"])."<hr></div>";
								if($datos_obras["direccion_regreso"]!="")$contObras.="<div class='text'><strong>Dirección regreso:</strong> ".utf8_encode($datos_obras["direccion_regreso"])."<hr></div>";
								if($datos_obras["espacio"]!="")$contObras.="<div class='text'><strong>Espacio:</strong> ".utf8_encode($datos_obras["espacio"])."<hr></div>";
								if($datos_obras["iluminacion"]!="")$contObras.="<div class='text'><strong>Iluminación:</strong> ".utf8_encode($datos_obras["iluminacion"])."<hr></div>";
								if($datos_obras["sonido"]!="")$contObras.="<div class='text'><strong>Sonido:</strong> ".utf8_encode($datos_obras["sonido"])."<hr></div>";
								$contObras.="</div>";
							$c++;
						}
					   echo $contObras;
					}
				  }
				}
			   ?>
	        </section>
        
	        <sidebar>
                <div class="ocultar">
                <div><a id="mp">Perfil</a><hr></div>
                <div>Obras:</div>
	        	<ul class="members">       		
		        	<?php 
					$qGrupos=$db->consulta("SELECT gt.* FROM grupos_teatro gt where id='".$_GET["n"]."'");
					$r=0;
					while($gt=mysql_fetch_array($qGrupos)){
						
						   $obrasD = $db->consulta("SELECT * FROM obras_teatro WHERE id_grupos_teatro ='".$gt["id"]."'ORDER BY anio DESC");
							$c=0;
							$contObras="";
							while($datos_obras=mysql_fetch_array($obrasD)){
								if($c==0){
									if($datos_obras["obra"]!="")$contObras.="<li onClick='cambioObra($c)'><a >".utf8_encode($datos_obras["obra"])."</a><hr></li>";
								}else{
									if($datos_obras["obra"]!="")$contObras.="<li onClick='cambioObra($c)'><a >".utf8_encode($datos_obras["obra"])."</a><hr></li>";}
							    $c++;
							}
							echo $contObras;
					}
					?>
				</ul>
                </div>
	        </sidebar>
        </div>
        <div class="bar-red">
            <a href="https://twitter.com/VIA_2014" ><span class="icon-twitter"></span>
            <p>#TODOSTENEMOSQUEVER</p></a>
        </div>
        <div class="more-info">
            <ul>
                <li><p>XIV FITBogotá 2014 <span>@FITBogota</span> 24 ene Industria cultural en Colombia http://t.co/WrQN8xDoQp @con dencialcol</p></li>
                <li><p>XIV FITBogotá 2014 <span>@FITBogota</span>  27 ene ¿Existe mayor dolor que el de perder la patria? http://t.co/k3g9yHwC1v</p></li>
                <li><p>V FITBogotá 2014 <span>@FITBogota</span> 27 ene @vivianasanti Estamos trabajando en eso. Te invitamos a visitar nuestras redes sociales para estar informada de las novedades @FITBogota</p></li>
            </ul>        
        </div>
        
        <!-- footer -->
        <?php include 'footer.php' ?>
    </body>
    <!-- JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
    <script src="js/script.js"></script>
    <script>
    $(document).ready(function() {
		var e=$('.members li').size();
		$('.members li').click(function() {
			var i = $(this).index();
			for(var j=0; j<e; j++){
				$('#obras_'+j).hide();
				$('.perfil').hide();
				}
			$('#obras_'+i).show();
        });
		$('#mp').click(function(){
			for(var j=0; j<e; j++){
				$('#obras_'+j).hide();
				}
				$('.perfil').show();
			});
		
     });
	 $(window).resize(function() {
		 var pageWidth = $(document).width(); 
		 var e=$('.members li').size();
		   if (pageWidth < 981) {
			  for(var j=0; j<e; j++){
				  $('#obras_'+j).show();
				  $('.perfil').show();
				  }
		   }
		    if (pageWidth > 981) {
			  for(var j=0; j<e; j++){
				  $('#obras_'+j).hide();
				  $('.perfil').show();
				  }
		   }
		 location.reload(); 
    });
    </script>
</html>