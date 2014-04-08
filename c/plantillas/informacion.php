<div id="disciplina">
   <? if ($CFG->mercado==21){
	   if($frm["modo"]!='insPro'){?>
		<img src="../images/disciplina/informacion_21.jpg" width="175" height="230"/>
            <a href="http://via.circulart.org/reglamento_VIA.pdf" target="_blank">T&eacute;rminos y condiciones de la convocatoria</a>
        
    <? }} 
	else if ($CFG->mercado==22){?>
     <img src="../images/disciplina/informacion_22.jpg" width="175" height="175"/>
	<? } else if ($CFG->mercado==20){?>
		<img src="../images/disciplina/informacion_20.jpg" width="175" height="230"/>
    <? }else{?>
    	<img src="../images/disciplina/informacion.jpg" width="175" height="230"/>
    <? }?>  
    
    
    
    
    <? if ($CFG->mercado==0){?>
    <a href="index.php?modo=informacion" <? if($frm["modo"]=="informacion") echo "class='informacion'"; ?>>Quienes somos</a>
    <a href="index.php?modo=preguntas" <? if($frm["modo"]=="preguntas") echo "class='informacion'"; ?>>Preguntas frecuentes</a>
    <a href="index.php?modo=enlaces" <? if($frm["modo"]=="enlaces") echo "class='informacion'"; ?>>Enlaces</a>
	<? } else if ($CFG->mercado==19){?>
    <a href="http://www.circulart2011.com" target="_blank">CirculArt 2011</a>
    <a href="index.php?modo=informacion" <? if($frm["modo"]=="informacion") echo "class='informacion'"; ?>>Reglamento convocatoria</a>
	<? if(isset($_SESSION[$CFG->sesion]["user"]["id_nivel"])){?>
    <a href="index.php?modo=agenda" <? if($frm["modo"]=="agenda") echo "class='informacion'"; ?>>Mi Agenda</a>
    <a href="index.php?modo=login" <? if($frm["modo"]=="login") echo "class='informacion'"; ?>>Salir del mercado</a>
    <? }else{?>
    <a href="index.php?modo=login" <? if($frm["modo"]=="login") echo "class='informacion'"; ?>>Entrar al mercado</a>
    <? }?>
    
    
  
    
    
    
    <? /*<a href="index.php?modo=curadores&mode=login" <? if($frm["mode"]=="login") echo "class='informacion'"; ?>>Curaduria</a>
    <? if($frm["modo"]=="curadores" && $frm["mode"] != "login"){ 
		echo "<a href='index.php?modo=curadores&mode=listar_grupos'";
		if($frm["modo"]=="curadores") echo "class='informacion'";
		echo ">Listado de Grupos</a>"; 
	}
	?>*/?>
    <a href="index.php?modo=contacto" <? if($frm["modo"]=="contacto") echo "class='informacion'"; ?>>Contacto</a>
    <? } ?>
</div>
<div class ="artista">

  <? if($frm["modo"]=="informacion" && $CFG->mercado==0){ ?>
  <img src="images/fotos/quienes.jpg" width="660" height="258" />
  <h1>Quienes somos</h1>
<p>CIRCULART es una herramienta web desarrollada como parte del proyecto Plataformas Exportadoras de Artes Esc&eacute;nicas y Musicales 2008 liderada por Redlat.</p>
<p>Las plataformas exportadoras de cultura son una iniciativa de desarrollo productivo de las expresiones culturales colombianas en las artes esc&eacute;nicas y musicales, que tiene el objetivo de servir de punto de apoyo y lanzamiento de la diversidad cultural colombiana hacia el mundo, con la firme convicci&oacute;n de que ello redunda en el crecimiento de la calidad y creatividad de nuestras mismas propuestas art&iacute;sticas.</p>
<p>El objetivo principal es difundir y divulgar la oferta art&iacute;stica colombiana de manera racional, estrat&eacute;gica e inteligente, de manera que se garantice la eficacia comunicativa en los contactos y la circulaci&oacute;n y promoci&oacute;n de los productos culturales de mayor calidad art&iacute;stica; con criterios de inclusi&oacute;n, diversidad, trayectoria, confiabilidad, viabilidad comercial, capacidad de diferenciaci&oacute;n en el mercado, novedad y representatividad de la cultura colombiana. Se busca divulgar productos art&iacute;sticos que respondan realmente a criterios de internacionalizaci&oacute;n y que, por ello mismo, encuentren en CIRCULART una oportunidad real de circulaci&oacute;n en las redes y circuitos culturales. Con el fin de garantizar que los criterios de selecci&oacute;n sean respetados, Redlat Colombia cuenta con un reconocido equipo de curadores en cada una de las &aacute;reas art&iacute;sticas que se encargan de definir y actualizar permanentemente el portafolio de artistas que constituir&aacute;n la oferta colombiana para ofrecer en diversos espacios de negocios nacionales e internacionales tales como ferias, ruedas de negocios, festivales, etc.
<? } else if($frm["modo"]=="preguntas"){ ?>
<img src="images/fotos/preguntas.jpg" width="660" height="258" />
<h1>Preguntas frecuentes</h1>
<p><strong>&iquest;Qu&eacute; debo hacer para pertenecer a CIRCULART?</strong></p>
<p>Los artistas del cat&aacute;logo CIRCULART son contactados directamente por los curadores del equipo de Redlat de acuerdo con sus propios criterios curatoriales. CIRCULART no hace convocatorias p&uacute;blicas ni concursos para realizar su cat&aacute;logo.</p>
<p><strong>&iquest;C&oacute;mo eligen a los artistas que hacen parte de CIRCULART?</strong></p>
<p>Redlat cuenta con un equipo de curadores de reconocida idoneidad que bajo criterios de inclusi&oacute;n, diversidad, trayectoria, confiabilidad, viabilidad comercial, capacidad de diferenciaci&oacute;n en el mercado, novedad y representatividad de la cultura colombiana eligen los artistas que hacen parte de la plataforma de exportaci&oacute;n.</p>
<p><strong>&iquest;CIRCULART representa artistas?</strong></p>
<p>No. Ni CIRCULART ni Redlat realizan labores de management o booking. Estas responsabilidades le corresponden estrictamente a las personas, organizaciones o instituciones que sean delegadas para ello por parte de los artistas.</p>
<p><strong>&iquest;CIRCULART cobra comisiones por los contactos comerciales realizados a trav&eacute;s de su gesti&oacute;n?</strong></p>
<p> No. Las relaciones comerciales que llegaren a tener lugar entre artistas y promotores, programadores, productores, etc., son responsabilidad de cada una de las partes. CIRCULART no presta apoyo en contrataciones ni se lucra a trav&eacute;s de comisiones o contraprestaciones de ning&uacute;n tipo.</p>
<p><strong>&iquest;CIRCULART me asegura que comprar&aacute;n mi producto art&iacute;stico?</strong></p>
<p>No. Las decisiones de compra o las declaraciones de inter&eacute;s son de estricta competencia de los promotores, gestores, programadores y productores que consultan el cat&aacute;logo y dependen de sus propios criterios comerciales y estrat&eacute;gicos.</p>
<p><strong>&iquest;Debo pagar alguna suma mensual para pertenecer a CIRCULART?</strong></p>
<p>No. CIRCULART nunca pedir&aacute; dinero a los artistas por ingresar o permanecer en su cat&aacute;logo. El servicio es totalmente gratuito pues Redlat es una instituci&oacute;n sin &aacute;nimo de lucro.</p>
<p><strong>&iquest;La informaci&oacute;n que hace parte de CIRCULART es de uso libre?</strong></p>
<p>No. Los derechos morales y patrimoniales de toda la informaci&oacute;n de texto, audio, fotograf&iacute;a y video, le pertenece a cada agrupaci&oacute;n art&iacute;stica, por lo que Redlat no podr&aacute; en ning&uacute;n momento comercializarla de modo total o parcial. Toda la informaci&oacute;n no perteneciente a las agrupaciones art&iacute;sticas es patrimonio de Redlat.</p>
<p><strong>&iquest;C&oacute;mo puedo apoyar la plataforma CIRCULART?</strong></p>
<p>Si desea apoyar nuestro proyecto comun&iacute;quese con nosotros a trav&eacute;s de la secci&oacute;n de Contacto de este sitio o directamente a <a href="mailto:info@circulart.org">info@circulart.org</a> para discutir las posibles opciones de desarrollo, articulaci&oacute;n y ampliaci&oacute;n.</p>
<? } else if($frm["modo"]=="enlaces"){ ?>
<img src="images/fotos/enlaces.jpg" width="660" height="258" />
<h1>Enlaces</h1>
<p><strong>Instituciones</strong></p>
<p>Redlat Colombia: <a href="http://www.redlat.org" target="_blank">www.redlat.org</a></p>
<p>Ministerio de Cultura - Colombia: <a href="http://www.mincultura.gov.co" target="_blank">www.mincultura.gov.co</a></p>
<p>Secretar&iacute;a de Cultura, Recreaci&oacute;n y Deporte &ndash; Bogot&aacute;: <a href="http://www.culturarecreacionydeporte.gov.co" target="_blank">www.culturarecreacionydeporte.gov.co</a></p>
<p>British Council: <a href="http://www.britishcouncil.org/colombia-arts-and-culture-arts-music-and-performing-arts.htm" target="_blank">www.britishcouncil.org/</a></p>
<p>C&aacute;mara de Comercio de Bogot&aacute;: <a href="http://camara.ccb.org.co" target="_blank">http://camara.ccb.org.co</a></p>
<p>National Performance Network: <a href="http://www.npnweb.org" target="_blank">www.npnweb.org</a></p>
<p>Culturelink Network: <a href="http://www.culturelink.hr" target="_blank">www.culturelink.hr</a></p>
<p><strong>Artes esc&eacute;nicas</strong></p>
<p>Fundaci&oacute;n Espacio Cero: <a href="http://www.espaciocero.net/" target="_blank">www.espaciocero.net</a></p>
<p>International Society for the Performing Arts Foundation: <a href="http://www.ispa.org" target="_blank">www.ispa.org</a></p>
<p>International Theatre Institute: <a href="http://www.iti-worldwide.org" target="_blank">www.iti-worldwide.org</a></p>
<p><strong>M&uacute;sica</strong></p>
<p>La Distritof&oacute;nica: <a href="http://www.ladistritofonica.com" target="_blank">www.ladistritofonica.com</a></p>
<p>Cecom M&uacute;sica &ndash; Music Agency: <a href="http://www.cecommusica.com" target="_blank">www.cecommusica.com</a></p>
<p>Palenque Records: <a href="http://www.myspace.com/palenquerecords" target="_blank">www.myspace.com</a></p>
<p>Entrecasa: <a href="http://www.entrecasacolombia.com" target="_blank">www.entrecasacolombia.com</a></p>
<p>Chonta Records: <a href="http://www.chontarecords.com" target="_blank">www.chontarecords.com</a></p>
<p>Series Media: <a href="http://seriesmedia.org" target="_blank">http://seriesmedia.org</a></p>
<p>Radio C&aacute;psula: <a href="http://www.radiocapsula.org" target="_blank">www.radiocapsula.org</a></p>
<p>Sonido Local: <a href="http://www.sonidolocal.com" target="_blank">www.sonidolocal.com</a></p>
<p>Smithsonian Folkways:<a href="http://www.folkways.si.edu" target="_blank">www.folkways.si.edu</a></p>
<? } else if($frm["modo"]=="informacion" && $CFG->mercado==19){ ?>
<h1>Bases convocatoria 111<br />
</h1>
<p>Rueda de Negocios para la M&uacute;sica <br />
  CIRCULART 2011: Segundo Mercado Cultural de Medell&iacute;n<br />
</p>
<p>Del 22 al 25 septiembre de 2011 se prepara la segunda edici&oacute;n de CIRCULART, la plataforma  cultural  para las artes esc&eacute;nicas y la m&uacute;sica, que reunir&aacute; a profesionales de Latinoam&eacute;rica y el Mundo en la ciudad de Medell&iacute;n (Colombia).<br />
Redlat Colombia con el apoyo de EPM, la Alcald&iacute;a de Medell&iacute;n y el Ministerio de Cultura de Colombia, con el objetivo de apoyar y fortalecer la industria musical realizar&aacute; a nivel latinoamericano, en el marco de &quot;CIRCULART 2011: Segundo Mercado Cultural de Medell&iacute;n&quot;,  su Rueda de Negocios para la M&uacute;sica, plataforma  de promoci&oacute;n y difusi&oacute;n, espacio comercial y punto de encuentro para realizar acuerdos y negocios entre los creadores latinoamericanos y los programadores de eventos nacionales e internacionales.</p>
<p>Durante 3 d&iacute;as, empresarios culturales de todo el mundo estar&aacute;n atentos a la oferta art&iacute;stica regional, con el fin de identificar aquellos productos que se acomoden a sus necesidades estrat&eacute;gicas y negociar las condiciones de su circulaci&oacute;n en mercados nacionales e internacionales. <br />
</p>
<h2>1. Informaci&oacute;n General sobre la convocatoria</h2>
<p><strong>Objetivo:</strong> Seleccionar la oferta musical colombiana y latinoamericana que participar&aacute; y ofrecer&aacute; sus productos art&iacute;sticos en la Rueda de Negocios de Circulart 2011: Segundo Mercado Cultural de Medell&iacute;n.<br />
  <strong>Inscripci&oacute;n:</strong> La inscripci&oacute;n es gratuita y se realizar&aacute; online a trav&eacute;s de www.circulart2011.com <br />
<strong>Apertura:</strong> El aplicativo online de la convocatoria se activar&aacute; el mi&eacute;rcoles 18 de mayo de 2011 en la direcci&oacute;n www.circulart2011.com</p>
<p>Se podr&aacute;n realizar consultas a trav&eacute;s de las siguientes direcciones de correo electr&oacute;nico:<br />
  <a href="mailto:info@circulart.org ">info@circulart.org </a><br />
  <a href="mailto:ruedadenegocios@redlat.org">ruedadenegocios@redlat.org</a></p>
<h2>2. Participantes </h2>
<p><strong>&iquest;Qui&eacute;nes pueden participar en  la convocatoria?</strong><br />
  Artistas o agrupaciones residentes en Colombia o en alg&uacute;n pa&iacute;s de Latino Am&eacute;rica, que se desempe&ntilde;en en el campo de la m&uacute;sica, y cuyo trabajo est&eacute; ligado a:<br />
  M&uacute;sica Popular Urbana (Rock, Hip Hop, Electr&oacute;nica, Jazz, Salsa y Nuevas tendencias) <br />
  M&uacute;sica tradicional <br />
  M&uacute;sicas del Mundo <br />
  M&uacute;sica Cl&aacute;sica <br />
</p>
<h2>3. Informaciones requeridas (Requisitos de car&aacute;cter obligatorio)</h2>
<p>Todo el proceso de convocatoria y el env&iacute;o de materiales ser&aacute; a trav&eacute;s de formulario online  en el link inscripciones.<br />
</p>
<ul>
  <li>Breve rese&ntilde;a art&iacute;stica que incluya: origen, g&eacute;nero y trayectoria. </li>
  <li>Material gr&aacute;fico (montado en www.flickr.com) de programas de mano, recortes de prensa, programaciones impresas y dem&aacute;s documentos que soporten la experiencia art&iacute;stica.</li>
  <li>Una publicaci&oacute;n discogr&aacute;fica: Debe especificarse el t&iacute;tulo, el a&ntilde;o de producci&oacute;n y el sello disquero (car&aacute;tula en pdf ). Tambi&eacute;n se deber&aacute;n anexar mp3 de la misma.</li>
  <li>Ficha t&eacute;cnica (&Aacute;rea, g&eacute;nero, formato, raider t&eacute;cnico de luces y sonido, cr&eacute;ditos de autor&iacute;a de las canciones, integrantes de la agrupaci&oacute;n, productores t&eacute;cnicos, agenciamiento etc.)</li>
  <li>Material audiovisual montado en Youtube y/o Vimeo *(Opcional para los interesados en aplicar a las muestras art&iacute;sticas)<br />
  </li>
</ul>
<h2>4. Acerca de las muestras art&iacute;sticas</h2>
<p>La Rueda de Negocios programar&aacute; presentaciones promocionales de 30 minutos de duraci&oacute;n para los promotores asistentes, los conferencistas invitados y el p&uacute;blico en general. </p>
<p>Los interesados en aplicar a estas presentaciones, deben tener en cuenta que la organizaci&oacute;n no asumir&aacute; honorarios, gastos de viaje u otros costos. La organizaci&oacute;n proporcionar&aacute; a los artistas seleccionados el escenario adecuado y los equipos necesarios para la presentaci&oacute;n. </p>
<p>Estas  presentaciones en vivo de tipo promocional, no ser&aacute;n remuneradas por la organizaci&oacute;n del evento.</p>
<p><strong>Importante:</strong> La puesta en escena ser&aacute; un criterio fundamental para la elecci&oacute;n de las muestras, que ser&aacute; evaluado por medio del material audiovisual entregado por la agrupaci&oacute;n. En caso de no existir dicho material en video, el grupo no ser&aacute; considerado para las muestras art&iacute;sticas.</p>
<h2>5.  Evaluaci&oacute;n y selecci&oacute;n de las propuestas art&iacute;sticas participantes </h2>
<p>La organizaci&oacute;n de Circulart 2011: Segundo Mercado Cultural de Medell&iacute;n, ha nombrado un jurado especializado y de reconocida trayectoria en el sector de la m&uacute;sica, que evaluar&aacute; los propuestas y seleccionar&aacute; a los artistas que podr&aacute;n acceder a la &quot;Rueda de Negocios&quot;. </p>
<p>Criterios de evaluaci&oacute;n:<br />
</p>
<ul>
  <li>Calidad y proyecci&oacute;n en el mercado internacional: Este punto ser&aacute; evaluado por los jurados seg&uacute;n su criterio y conocimiento de la escena local e internacional.</li>
  <li>Trayectoria: Se considerar&aacute;n los soportes presentados: rese&ntilde;as y cr&iacute;ticas de prensa, programaciones de mano, premios y reconocimiento, etc.</li>
  <li>Puesta en escena: Se tendr&aacute; en cuenta para seleccionar a las agrupaciones que se programar&aacute;n dentro de las muestras art&iacute;sticas.</li>
</ul>
<p>Sobre la selecci&oacute;n y los jurados<br />
</p>
<ul>
  <li>Cada jurado realizar&aacute; de forma individual la evaluaci&oacute;n de las propuestas presentadas.</li>
  <li>Los jurados elegir&aacute;n las  mejores propuestas art&iacute;sticas de la convocatoria, a partir de la suma  de los puntajes derivados de sus evaluaciones individuales.</li>
  <li>Los jurados tendr&aacute;n autonom&iacute;a absoluta para proceder con la evaluaci&oacute;n de las propuestas.</li>
  <li>Las propuestas que incumplan con uno o m&aacute;s de los requisitos obligatorios no ser&aacute;n aceptadas.</li>
  <li>Los jurados dejar&aacute;n constancia de los resultados de la convocatoria, en un acta firmada por ellos mismos, en la que se indicar&aacute;n los nombres de las propuestas  seleccionadas.</li>
  <li>El listado de los seleccionados ser&aacute; publicado en la p&aacute;gina web  www.circulart2011.com el 18 de julio de 2011. </li>
  <li>Los resultados de la convocatoria no podr&aacute;n ser apelados y no proceder&aacute; recurso alguno contra &eacute;stos.<br />
  </li>
</ul>
<h2>6 . Cronograma de la convocatoria</h2>
<p>Apertura convocatoria: 18 mayo de 2011<br />
  Lanzamiento oficial: 24 de mayo de 2011<br />
  Cierre convocatoria: 28 de junio de 2011<br />
  Publicaci&oacute;n de resultados: 18 de julio de 2011<br />
  Apertura agendamiento: 19 de Agosto de 2011<br />
  Cierre agendamiento: 19 de Septiembre de 2011<br />
  Rueda de negocios de m&uacute;sica: 23, 24 y 25 de septiembre de 2011 <br />
</p>
<h2>7. Anotaciones Aclaratorias Finales</h2>
<p>Todos los interesados en participar de la rueda de negocios, deber&aacute;n realizar la aplicaci&oacute;n en el formulario online a trav&eacute;s de www.circulart2011.com</p>
<p>Los resultados de la convocatoria se informar&aacute;n a trav&eacute;s de la p&aacute;gina web www.circulart2011.com</p>
<p>Las inscripciones online estar&aacute;n abiertas hasta las 5:00 pm del d&iacute;a 28 de junio de 2011. No se aceptar&aacute;n inscripciones posteriores a esta fecha y hora.</p>
<p>S&oacute;lo tendr&aacute;n acceso al espacio donde se realizar&aacute;n las sesiones de la rueda de negocios dos representantes por agrupaci&oacute;n, previamente registrados en el formulario online de la convocatoria.</p>
<p>Los artistas que resulten seleccionados para la rueda de negocios, deber&aacute;n tener claro que los costos de traslado, manutenci&oacute;n y alojamiento relacionados con su participaci&oacute;n en el evento, correr&aacute;n por parte de ellos mismos. </p>
<p>Los participantes deber&aacute;n dar cumplimiento a la normatividad vigente sobre derechos de autor, con respecto a las propuestas art&iacute;sticas presentadas.</p>
<p>Se autorizar&aacute; a la organizaci&oacute;n del evento a la libre divulgaci&oacute;n y promoci&oacute;n de las propuestas seleccionadas para la rueda de negocios, en los diferentes medios de comunicaci&oacute;n relacionados con Circulart 2011: Segundo Mercado Cultural de Medell&iacute;n. </p>
<p>Los participantes no podr&aacute;n solicitar remuneraci&oacute;n por &eacute;sto.</p>
<p>Al participar de la convocatoria se dar&aacute;n por aceptados los t&eacute;rminos de la misma, as&iacute; como cualquier aclaraci&oacute;n o modificaci&oacute;n de los mismos. </p>
    <? } else if($frm["modo"]=="contacto"){ ?>
  <h1>Contacto</h1>
  <p>Para m&aacute;s informaci&oacute;n puede comunicarse a <a href="mailto:info@circulart.org">info@circulart.org</a></p>
  <p><strong>Website:</strong> <a href="http://www.circulart2011.com" target="_blank">www.circulart2011.com</a><br />
    <strong>Fan page:</strong> <a href="http://www.facebook.com/Circulart2011" target="_blank">www.facebook.com/Circulart2011</a><br />
  <strong>Twitter:</strong> <a href="http://twitter.com/#!/Circulart2011" target="_blank">@Circulart2011</a></p>
<? } else if($frm["modo"]=="inscripciones"){ 
	include("inscripciones.php");
	}else if($frm["modo"]=="curadores"){ 
	include("curadores.php");
	}else if($frm["modo"]=="agenda"){ 
	include("agenda.php");
	}
?>

</div>
