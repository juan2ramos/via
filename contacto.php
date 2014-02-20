
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


    </head>
    <body class="contact">
        <!-- Header -->
        <?php include 'header.php' ?>
        <!-- content -->

        <div class="title">           
            <h1>CONTÁCTENOS</h1>
        </div>
        <div class="via">
	        <section class="form">
	            <h2>FORMULARIO DE CONTACTO</h2>
	            <hr>
	            <form id="contact-form" method="post">
	            	<label>Nombre<sup>*</sup></label>
	            	<input name="nombre" placeholder="Nombre" type="text" value="" maxlength="20" required>
	            	<label>Apellido<sup>*</sup></label>
	            	<input name="apellido" placeholder="Apellido" type="text" value="" maxlength="20" required>
	            	<label>Email<sup>*</sup></label>
	            	<input name="email" placeholder="Email" type="email" value=""  required="">
	            	<label>Asunto<sup>*</sup></label>
	            	<select id="subject">
					    <option value="hide">-- SELECCIONE --</option>
					    <option value="DIRECCIÓN GENERAL">DIRECCIÓN GENERAL</option>
					    <option value="COORDINACIÓN RUEDA DE NEGOCIOS">COORDINACIÓN RUEDA DE NEGOCIOS</option>
					    <option value="PRODUCCIÓN">PRODUCCIÓN</option>
					    <option value="COORDINACIÓN ARTÍSTAS">COORDINACIÓN ARTÍSTAS</option>
					    <option value="COORDINACIÓN PROGRAMADORES">COORDINACIÓN PROGRAMADORES</option>
					    <option value="PRODUCCIÓN SHOWCASES">PRODUCCIÓN SHOWCASES</option>
					    <option value="COORDINACIÓN LOGÍSTICA">COORDINACIÓN LOGÍSTICA</option>
					</select> 
				    <label>Mensaje<sup>*</sup></label>
				    <textarea id="message"rows="10" cols="52"></textarea>
	            	<input  id="submit" type="submit" value="ENVIAR" >
	            </form>
	                
	        </section>
        
	        <sidebar>
	        	<ul class="members">       		
		        	
		        	<li>
		        		<hr>
		        		OCTAVIO ARBELÁEZ
						<span class="assignation">DIRECCIÓN GENERAL</span>

					<li>
						<hr>
						BEATRIZ QUINTERO
						<span class="assignation">COORDINACIÓN RUEDA DE NEGOCIOS</span>
					</li>

					<li>
						<hr>
						PAULA POSADA
						<span class="assignation">PRODUCCIÓN</span>
						<a href="mailto:produccionvia@festivaldeteatro.com.co">PRODUCCIONVIA@FESTIVALDETEATRO.COM.CO</a>
					</li>

					<li>
						<hr>
						MILENA GARCÍA, CAMILA ZULUAGA
						<span class="assignation">COORDINACIÓN ARTÍSTAS</span>
						<a href="mailto:via@circulart.org">VIA@CIRCULART.ORG</a>
					</li>

					<li>
						<hr>
						LUIS FERNANDO ZULUAGA, ANGÉLICA CASTILLO
						<span class="assignation">COORDINACIÓN PROGRAMADORES</span>
						<a href="mailto:via@festivaldeteatro.com.co">VIA@FESTIVALDETEATRO.COM.CO</a>
					</li>

					<li>
						<hr>
						JULIAN ARBELÁEZ, RAUL MENESES
						<span class="assignation">PRODUCCIÓN SHOWCASES</span>
					</li>

					<li>
						<hr>
						GABRIEL ZAPATA
						<span class="assignation">COORDINACIÓN LOGÍSTICA PROGRAMADORES</span>
					</li>

					<li>
						<hr>
						CÉSAR VALENCIA, JUAN RAMOS
						<span class="assignation">PLATAFORMA VIRTUAL</span>
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