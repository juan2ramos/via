
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
            <h1>PROFESIONALES</h1>
        </div>
        <div class="via">
	        <section class="form">
	           <?PHP
			   include("conexion.php");
			   $db = new MySQL();
			   $qPromotor=$db->consulta("SELECT * FROM promotores WHERE id='$_GET[n]'");
			   while($promotor=mysql_fetch_array($qPromotor)){
			   ?>
               <div class="perfil">
				  <div id="nombre"><?=utf8_encode($promotor["nombre"]). " " . utf8_encode($promotor["apellido"])?><hr></div>
                  <?php 
					$qEmpresa=$db->consulta("SELECT * FROM empresas_promotores WHERE id_promotor='".$promotor["id"]."'");
						 while($e=mysql_fetch_array($qEmpresa)){
							   $idEmpresa=$e["id_empresa"];
							   $nomEmpresa=$db->consulta("SELECT * FROM empresas WHERE id='".$e["id_empresa"]."'");
							    while($nom=mysql_fetch_array($nomEmpresa)){
									$imagenEmpresa=$nom["mmdd_imagen_filename"];
									$nombreEmpresa=$nom["empresa"];
									$webEmpresa=$nom["web"];
									$resenaEmpresa=$nom["observaciones"];
									}
							 }
					if($promotor["mmdd_imagen_filename"]!=''){ ?>
                          <div id="imagen"><img src="http://circulart.org/phpThumb/phpThumb.php?src=/home/redlat/public_html/circulart/files/promotores/imagen/<?=$promotor["id"]?>" border="0"></div>
                    <?php }else{ ?> 
					      <div id="imagen"><img src="http://via.festivaldeteatro.com.co/m/images/noimagen.png" border="0"></div>
					<?php }?>
                   <div id="pais" class="text"><strong>País: </strong><?=utf8_encode($promotor["pais"])?><hr></div> 
                   <div id="ciudad" class="text"><strong>Ciudad: </strong> <?=utf8_encode($promotor["ciudad"])?><hr></div>
                   <div id="ciudad" class="text"><strong>Organización: </strong> <?=utf8_encode($nombreEmpresa)?><hr></div>
                   <div id="cargo" class="text"><strong>Cargo: </strong> <?=utf8_encode($promotor["cargo"])?><hr></div>
                   <div id="resena" class="text"><strong>Reseña: </strong><hr> <?=utf8_encode($resenaEmpresa)?></div>
               </div>       
               <?php
				   }
               ?>
	        </section>
        
	        <sidebar>
                <div id="organizacion" class="ocultar">
                    <div><strong>Organización:</strong><hr></div>
                    <? if($imagenEmpresa!=""){ ?>
                    <div id="imagen"><img src="http://circulart.org/phpThumb/phpThumb.php?src=/home/redlat/public_html/circulart/files/empresas/imagen/<?=$idEmpresa?>" border="0" ></div>
                    <? } ?>
                    <div><? 
					$enlace="";
					 if($webEmpresa!=""){
						 if($webEmpresa!="en proceso..."){
						   $buscarWeb = "http";
						   $cadenaWeb = $webEmpresa;
						   $resultadoWeb = strpos($cadenaWeb, $buscarWeb);
						   if($resultadoWeb!== FALSE){
								$enlace="<a href='".$webEmpresa."' target='_blank'>".$webEmpresa."</a>";
							}else{
								$enlace="<a href='http://".$webEmpresa."' target='_blank'>".$webEmpresa."</a>";
							}
						}else{
							$enlace="CORPORACION ESPACIO ABIERTO";
							}
					}
					
					echo $enlace?></div>
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
</html>