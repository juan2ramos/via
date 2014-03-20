
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
                  <div id="imagen"><img src="http://circulart.org/admin/imagen.php?table=archivos_grupos_teatro&amp;field=archivo&amp;id=<?php echo $cara["id"];?>" border="0"></div>
                  <div id="pais" class="text"><strong>País:</strong> <?
				        $arrayPais=$db->consulta("SELECT * FROM paises WHERE id='".$gt["id_pais"]."'");
						$datosPais=mysql_fetch_array($arrayPais);
						echo utf8_encode($datosPais["pais"])
				  ?><hr></div>
                  <div id="ciudad" class="text"><strong>Ciudad:</strong> <?=utf8_encode($gt["ciudad"])?><hr></div>
                  <div id="telefono" class="text"><strong>Teléfono:</strong> <?=utf8_encode($gt["telefono"])?><hr></div>
                  <div id="resena" class="text"><strong>Reseña:</strong><hr> <?=utf8_encode($gt["resena_corta"])?></div>
                 </div>
				 <?php 
				 }
				}
			   ?>
	        </section>
        
	        <sidebar>
	        	<ul class="members">       		
		        	<li>
						<a href="#">Perfil</a>
						<hr>
					<li>
                      
						<a href="#">Obra 1</a>
						<hr>
					</li>

					<li>
						<a href="#">Obra 1</a>
						<hr>
					</li>
				</ul>
	        </sidebar>
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
    <script src="js/script.js"></script>
</html>