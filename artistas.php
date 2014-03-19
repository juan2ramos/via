
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1" />-->
        <script src="js/prefixfree.min.js"></script>
        <!-- Estilos -->
        <link rel="stylesheet" href="css/normalize.css" />
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/portfolio.css" />
        


    </head>
    <body >
        <!-- Header -->
        <?php include 'header.php' ?>
        <!-- content -->

        <div class="title">           
            <h1>ARTISTAS</h1>
        </div>
        <div id="contenedor_area">
        <div id="areas">
        <ul>
        <li class="activa"><a href="#">Teatro</a></li>
        <li><a href="#">Danza</a></li>
        </ul>
        </div>
        </div>
        <div id="basic" class="container">
        <?php
		
        include("conexion.php");
		$db = new MySQL();
		$j=1;
		$qGrupos=$db->consulta("SELECT ma.*, gm.* FROM mercado_artistas ma LEFT JOIN grupos_teatro gm on gm.id=ma.id_grupo_teatro WHERE ma.id_mercado='26' ORDER BY gm.nombre");
		if($db->num_rows($qGrupos)>0){
			while($gm=mysql_fetch_array($qGrupos)){
					$caratula=$db->consulta("SELECT * FROM archivos_grupos_teatro WHERE id_grupos_teatro='".$gm["id"]."' AND orden='0'");
					$cara=mysql_fetch_array($caratula);
					if($cara["id"]!="" && $cara["id"]!="655"){
				  ?>
                  <a href="perfil.php?n=<?=$gm["id"]?>">
                 	<div class="item">
                    <div id="imagen"><img src="http://circulart.org/admin/imagen.php?table=archivos_grupos_teatro&amp;field=archivo&amp;id=<?php echo $cara["id"];?>" border="0"></div>
                    <div id="marca">PORTAFOLIOS</div>
                    <div id="pais_genero"><?php
					    //busqueda del pais
						$arrayPais=$db->consulta("SELECT * FROM paises WHERE id='".$gm["id_pais"]."'");
						$datosPais=mysql_fetch_array($arrayPais);
						//busqueda del genero
						$arrayGenero=$db->consulta("SELECT * FROM generos_grupo_teatro WHERE id_grupos_teatro='".$gm["id"]."'");
						while($datosGenero=mysql_fetch_array($arrayGenero)){
							 $numGenero=$db->consulta("SELECT * FROM generos_teatro WHERE id='".$datosGenero["id_generos_teatro"]."'");
							 $genero=mysql_fetch_array($numGenero);
						}
					    echo utf8_encode($datosPais["pais"])." / ".utf8_encode($genero["genero"]);
						?></div>
                    <div id="nombre"><?=utf8_encode($gm["nombre"]);?></div>
                    </div>
                    </a>
                <?php
                }
			}
		}
		?> 
        </div>
        <div class="bar-red">
            <a href="https://twitter.com/VIA_2014"><span class="icon-twitter"></span>
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
    <script src="js/bower_components/eventEmitter/EventEmitter.js"></script>
	<script src="js/bower_components/eventie/eventie.js"></script>
    <script src="js/bower_components/doc-ready/doc-ready.js"></script>
    <script src="js/bower_components/get-style-property/get-style-property.js"></script>
    <script src="js/bower_components/get-size/get-size.js"></script>
    <script src="js/bower_components/jquery-bridget/jquery.bridget.js"></script>
    <script src="js/bower_components/matches-selector/matches-selector.js"></script>
    <script src="js/bower_components/outlayer/item.js"></script>
    <script src="js/bower_components/outlayer/outlayer.js"></script>
    <script src="js/masonry.js"></script>
    <script src="js/script.js"></script>
	<script language="javascript">
    docReady( function() {
      var container = document.querySelector('#basic');
      var msnry = new Masonry( container, {
        columnWidth: 4
      });
    });
    </script>
</html>