<?
	require($CFG->objectPath . "/object.php");

	class grupos_musica extends entity
	{
		function find()
		{
			global $CFG;

			$condicionAnterior="";
			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
			{
				$grupos = array(0);
				$qid = $this->db->sql_query("SELECT id_grupo_musica 
						FROM usuarios_grupos_musica 
						WHERE id_usuario = ".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
				while($query = $this->db->sql_fetchrow($qid))
				{
					$grupos[] = $query["id_grupo_musica"];
				}
				$condicionAnterior .= " " . $this->table . ".id IN (".implode(",",$grupos).")";
			}
			parent::find($condicionAnterior);	
		}

		function insert()
		{
			global $CFG;

			if($_FILES["ficha"]["size"] != "")
			{
				if(!in_array($_FILES["ficha"]["type"],$this->CFG->tiposAdmitidosDocumentos))
				{
					//$this->getAttributeByName("ficha")->set("value","");
					$ficha = $this->getAttributeByName("ficha");
					$ficha = $ficha->set("value","");
					//$this->getAttributeByName("mmdd_ficha_filename")->set("value",NULL);
					$ffn = $this->getAttributeByName("mmdd_ficha_filename");
					$ffn = $ffn->set("value",NULL);
					//$this->getAttributeByName("mmdd_ficha_filetype")->set("value",NULL);
					$ffy = $this->getAttributeByName("mmdd_ficha_filetype");
					$ffy = $ffy->set("value",NULL);
					//$this->getAttributeByName("mmdd_ficha_filesize")->set("value",NULL);
					$ffs = $this->getAttributeByName("mmdd_ficha_filesize");
					$ffs = $ffs->set("value",NULL);
					unset($_FILES["ficha"]);
					echo "<script>window.alert('La Ficha Técnica no está en un formato permitido. Se aceptan formatos .pdf y .doc. No se ha insertado la Ficha Técnica')</script>";
				}
			}

			$this->id = parent::insert();
			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
			{
				$this->db->sql_query("INSERT INTO usuarios_grupos_musica (id_usuario,id_grupo_musica) VALUES('".$_SESSION[$CFG->sesion_admin]["user"]["id"]."','$this->id')");
			}

			return($this->id);		
		}

		function update()
		{
			if($_FILES["ficha"]["size"] != "")
			{
				if(!in_array($_FILES["ficha"]["type"],$this->CFG->tiposAdmitidosDocumentos))
				{
					//$this->getAttributeByName("ficha")->set("value","");
					$ficha = $this->getAttributeByName("ficha");
					$ficha = $ficha->set("value","");
					//$this->getAttributeByName("mmdd_ficha_filename")->set("value",NULL);
					$ffn = $this->getAttributeByName("mmdd_ficha_filename");
					$ffn = $ffn->set("value",NULL);
					//$this->getAttributeByName("mmdd_ficha_filetype")->set("value",NULL);
					$ffy = $this->getAttributeByName("mmdd_ficha_filetype");
					$ffy = $ffy->set("value",NULL);
					//$this->getAttributeByName("mmdd_ficha_filesize")->set("value",NULL);
					$ffs = $this->getAttributeByName("mmdd_ficha_filesize");
					$ffs = $ffs->set("value",NULL);
					unset($_FILES["ficha"]);
					echo "<script>window.alert('La Ficha Técnica no está en un formato permitido. Se aceptan formatos .pdf y .doc. No se ha actualizado la Ficha Técnica')</script>";
				}
			}

			parent::update();

			if(isset($CFG->sesion_admin) && nvl($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"]) == 1){
				$curado = $this->getAttributeByName("curado");
				$curado = $curado->get("value");
				if($curado)
					$this->db->sql_query("UPDATE usuarios SET id_nivel = 8 WHERE id IN (SELECT id_usuario FROM usuarios_grupos_musica WHERE id_grupo_musica=".$this->id.")");
				else
					$this->db->sql_query("UPDATE usuarios SET id_nivel = 5 WHERE id IN (SELECT id_usuario FROM usuarios_grupos_musica WHERE id_grupo_musica=".$this->id.")");
			}

			//$datos_grupo=$this->db->sql_row("SELECT * FROM ".$this->table." WHERE id =".$this->id."");
/**/
				$strMail="ACTUALIZACIÓN DE DATOS CIRCULART 2012\n\n";
				$strMail.="Usted ha actualizado los datos para CIRCULART 2012.\n\n";
				$strMail.="Atentamente,\n\n";
				$strMail.="CIRCULART - REDLAT\n";
				$strMail.="info@circulart.org\n";
				$strMail.="http://circulart.org/circulart2012/\n";
				$strMail.="\n".date("Y-m-d H:i:s");
				$strMail.="\n";
			
			mail($datos_grupo['email'],"Actualización de datos Circulart 2012",$strMail,"From: info@circulart.org");
			
				$strMail2="ACTUALIZACIÓN DE DATOS CIRCULART 2012\n\n";
				$strMail2.="El grupo o el artista: ".$datos_grupo['nombre']." acaba de ACTUALIZAR sus datos en Circulart 2012.\n\n";
				$strMail2.="Atentamente,\n\n";
				$strMail2.="CIRCULART - REDLAT\n";
				$strMail2.="info@circulart.org\n";
				$strMail2.="http://circulart.org/circulart2012/\n";
				$strMail2.="\n".date("Y-m-d H:i:s");
				$strMail2.="\n";
				
			mail("notificacionescirculart@gmail.com","Actualización de datos Circulart 2012",$strMail2,"From: info@circulart.org");
			mail("ncirculart@gmail.com","Actualización de datos Circulart 2012",$strMail2,"From: info@redlat.com");
			
			
			$this->db->sql_query("UPDATE " . $this->table . " SET fecha_actualizacion = '".date("Y-m-d H:i:s")."' WHERE id = ".$this->id);

		}

		function delete()
		{
			parent::delete();
			$this->db->sql_query("DELETE FROM usuarios_grupos_musica WHERE id_grupo_musica=".$this->id);
		}
	}

	$entidad =& new grupos_musica();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Grupos Música");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","ingresado_por DESC");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] != 5)
	{
		$link=new link($entidad);
		$link->set("name","generos_grupo_musica");
		$link->set("url",$ME . "?module=generos_grupo_musica");
		$link->set("icon","gear.png");
		$link->set("description","Géneros Grupo");
		$link->set("field","id_grupos_musica");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","generos_grupo_musica");
		$entidad->addLink($link);

		$link=new link($entidad);
		$link->set("name","obras_musica");
		$link->set("url",$ME . "?module=obras_musica");
		$link->set("icon","icon-activate.gif");
		$link->set("description","Producciones");
		$link->set("field","id_grupos_musica");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","obras_musica");
		$entidad->addLink($link);


		$link=new link($entidad);
		$link->set("name","arhivos_grupos_musica");
		$link->set("url",$ME . "?module=archivos_grupos_musica");
		$link->set("icon","picture.gif");
		$link->set("description","Archivos");
		$link->set("field","id_grupos_musica");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","archivos_grupos_musica");
		$entidad->addLink($link);
	
		$link=new link($entidad);
		$link->set("name","vinculados");
		$link->set("url",$ME . "?module=vinculados");
		$link->set("icon","stock_person.png");
		$link->set("description","Personas vinculadas");
		$link->set("field","id_grupo_musica");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","vinculados");
		$entidad->addLink($link);

		/*$link=new link($entidad);
		$link->set("name","confirmados_grnic");
		$link->set("url",$ME . "?module=confirmados_grnic");
		$link->set("letra","GRNIC");
		$link->set("iconoLetra","GRNIC");
		$link->set("description","Finalizados GRNIC");
		$link->set("field","id_grupo_musica");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","confirmados_grnic");
		$entidad->addLink($link);*/

}

// ---------- ATRIBUTOS          ----------------
	
	$atributo=new attribute($entidad);
	$atributo->set("field","el_id");
	$atributo->set("label","id");
	$atributo->set("inputType","subQuery");
	$atributo->set("sqlType","subQuery");
	$atributo->set("subQuery","SELECT __id__");
//	$atributo->set("subQuery","id");
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ingresado_por");
	$atributo->set("label","Circulart2012");
	$atributo->set("sqlType","character varying(50)");
	$atributo->set("defaultValue","0");
	$atributo->set("defaultValueSQL","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","resena_corta");
	$atributo->set("label","Descripción Corta");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
  $atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_resena_corta");
	$atributo->set("label","Descripción Corta (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
  $atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","resena");
	$atributo->set("label","Descripción");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_resena");
	$atributo->set("label","Descripción (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_pais");
	$atributo->set("label","País");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","paises");
	$atributo->set("foreignLabelFields","pais");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","ciudad");
	$atributo->set("label","Ciudad");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
		$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","direccion");
	$atributo->set("label","Dirección");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","telefono");
	$atributo->set("label","Teléfono");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","telefono2");
	$atributo->set("label","Teléfono Dos");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	
	$atributo=new attribute($entidad);
	$atributo->set("field","email");
	$atributo->set("label","Correo");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
		$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","email2");
	$atributo->set("label","Correo Dos");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","contacto");
	$atributo->set("label","Nombre Contacto");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","contacto_cc");
	$atributo->set("label","Cédula del contacto");
	$atributo->set("sqlType","character varying(32)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","website");
	$atributo->set("label","Website");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","myspace");
	$atributo->set("label","MySpace");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","facebook");
	$atributo->set("label","Facebook");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","lastfm");
	$atributo->set("label","Last.fm");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","twitter");
	$atributo->set("label","Twitter");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","tipo_propuesta");
	$atributo->set("label","Tipo Propuesta");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("arrayValues",array("1"=>"Vocal","2"=>"Instrumental","3"=>"Vocal e Instrumental"));
	$atributo->set("mandatory",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","empresa");
	$atributo->set("label","Empresa");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","nit");
	$atributo->set("label","NIT");
	$atributo->set("sqlType","varchar(32)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","rut");
	$atributo->set("label","RUT");
	$atributo->set("sqlType","varchar(32)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","manager");
	$atributo->set("label","Manager");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","booking");
	$atributo->set("label","Agente de Booking");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","booking_uno");
	$atributo->set("label","Agente de Booking 1");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","booking_dos");
	$atributo->set("label","Agente de Booking 2");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","booking_tres");
	$atributo->set("label","Agente de Booking 3");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","editor");
	$atributo->set("label","Editor");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","num_personas_gira");
	$atributo->set("label","No. de personas en gira");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","num_personas_escenario");
	$atributo->set("label","No. personas en escenario");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","instrumentos");
	$atributo->set("label","Describa los instrumentos<br>que hay en escenario");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_instrumentos");
	$atributo->set("label","Describa los instrumentos<br>que hay en escenario (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","equipos_adicionales");
	$atributo->set("label","Equipos adicionales<br>y/o efectos especiales");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_equipos_adicionales");
	$atributo->set("label","Equipos adicionales<br>y/o efectos especiales (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios");
	$atributo->set("label","Comentarios adicionales");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_comentarios");
	$atributo->set("label","Comentarios adicionales (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ficha");
	$atributo->set("label","Ficha Técnica<br>(Subir PDF)");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","fileFS");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","demo");
	$atributo->set("label","Demo / Single<br>(Subir MP3)");
	$atributo->set("sqlType","varchar(10)");
	$atributo->set("inputType","fileFS");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","trayectoria");
	$atributo->set("label","Trayectoria<br> (Subir PDF)");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","fileFS");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","trayectoria_url");
	$atributo->set("label","URL Trayectoria");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","curado");
	$atributo->set("label","¿Curado?");
	$atributo->set("inputType","option");
	$atributo->set("sqlType","boolean");
	$atributo->set("defaultValue","f");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	{
		$atributo->set("editable",FALSE);
		$atributo->set("browseable",FALSE);
		$atributo->set("visible",FALSE);
	}
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_actualizacion");
	$atributo->set("label","Fecha Actualización");
	$atributo->set("sqlType","timestamp");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure(FALSE);

?>
