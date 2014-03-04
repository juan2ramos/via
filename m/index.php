<?php
include("application.php");
if (isset($_SERVER["REQUEST_METHOD"])) session_start();
if (!isset($_SESSION[$CFG->sesion])) $_SESSION[$CFG->sesion] = array();
if (isset($_SERVER["REQUEST_METHOD"])) $CFG->servidor = "http://" . $_SERVER["SERVER_NAME"];
setlocale(LC_TIME, "es_ES");

if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
else $frm=$_GET;

if(nvl($frm["tipo"]) == "danza") $tipo="danza";
elseif(nvl($frm["tipo"]) == "musica") $tipo="musica";
else $tipo="teatro";


?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="es">
    <head> 

        <title>Via</title>

        <!-- Meta -->
        <meta charset="iso-8859-1">
        <meta name="author" content="" />       
        <meta name="description" content="Inicio" />       
        <!-- Si hay diseño responsive
        <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1" />
        -->

        <!--<script src="js/prefixfree.min.js"></script>-->
        <!-- Estilos -->
       <!-- <link rel="stylesheet" href="css/normalize.css" />-->
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css" />


    </head>
    <body >
    <div class="contenedor">
         <div class="fondoMenu">
         </div>
        <header>
            <div  class="content-head">
                <div id="logo"><a href="http://festivaldeteatro.com.co/" target="_blank"><img src="images/logo-festival-teatro.jpg" alt="XIV Festival iberoamericano de teatro de bogotá" borde="0" /></a></div>
                <nav>                  
                    
                        <a href="../index.php">Programaci&oacute;n<span>Agenda</span></a>
                        <a href="http://via.festivaldeteatro.com.co/m/index.php?modo=inscripciones">Artistas<span>Artist</span></a>
                        <a href="http://via.festivaldeteatro.com.co/m/index.php?modo=insPro">Profesionales<span>Professionals</span></a>
                        <a href="http://www.bogota.gov.co/" target="_blank">Info Bogot&aacute;<span>Bogot&aacute;</span></a>
                        <a href="../contacto.php">Contacto<span>Contact</span></a>
                    
                </nav>
                <ul class="menus redes">
                    <li><a href="https://www.facebook.com/pages/VIA-Ventana-Internacional-de-las-Artes-2012/105076839614385?fref=ts" target="_blank"><img src="images/facebook.png" alt="Facebook" borde="0"/></a></li>
                    <li><a href="https://twitter.com/VIA_2014" target="_blank"><img src="images/twitter.png" alt="Twitter" borde="0"/></a></li>
                </ul>
                <div id="logoVia"><a href="http://via.festivaldeteatro.com.co/" target="_blank"><img src="images/logo-via.jpg" alt="Venta internacional de las artes" borde="0"/></a></div>
               
            </div>
        </header>
        
        <section >
             <div class="titulo_page">REGISTRO - REGISTRATION</div>
             <div class="interna">
 			 <?php
                if($frm["modo"]=="perfil"|| $frm["modo"]=="obras" || $frm["modo"]=="fotografias" || $frm["modo"]=="videos" || $frm["modo"]=="eventos"){ 
                     include("plantillas/artista.php"); 
                }else{
                     include("plantillas/".$frm["modo"].".php"); 
                }
                
                if($frm["modo"]==""){ 
				 echo"<script>";
				 echo"document.location.href='index.php?modo=insPro';";
				 echo"</script>";
			} 
            ?>
            </div>
        </section>
      
        <!-- footer -->
        <footer>
           <div id="logos_footer">
            <div class="footer-below">
                <a class="festival-teatro" href="http://festivaldeteatro.com.co/" >
                    <img src="images/festival-teatro.png">
                </a> 
             </div>
              <div class="redlat-circulart">
                  <a href="http://redlat.org/"><img src="images/logo_redlat.png" alt="Logo Redlat"></a>
                  <a href="http://circulart.org/"><img src="images/circulart.png" alt="Logo Circulart"></a>
              </div>    
           </div>
        </footer>  
        </div>
    </body>
    <!-- JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
	function ajuste(){$("footer").width($(document).width());}
	$(document).ready(function() {
		ajuste();
    
	});
	$( window ).resize(function() {
		//location.reload()
});
    </script>
</html>