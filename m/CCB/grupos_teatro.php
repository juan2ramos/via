<?
//	require($CFG->common_libdir . "/entidades_v_1.3/object.php");
	require($CFG->objectPath . "/object.php");

	class grupos_teatro extends entity
	{
		function find()
		{
			global $CFG;

			$condicionAnterior="";
			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
			{
				$grupos = array(0);
				$qid = $this->db->sql_query("SELECT id_grupo_teatro
						FROM usuarios_grupos_teatro
						WHERE id_usuario = ".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
				while($query = $this->db->sql_fetchrow($qid))
				{
					$grupos[] = $query["id_grupo_teatro"];
				}
				$condicionAnterior .= " grupos_teatro.id IN (".implode(",",$grupos).")";
			}
			parent::find($condicionAnterior);
		}

		function insert()
		{
			global $CFG;

			$this->id = parent::insert();
			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
			{
				$this->db->sql_query("INSERT INTO usuarios_grupos_teatro (id_usuario,id_grupo_teatro) VALUES('".$_SESSION[$CFG->sesion_admin]["user"]["id"]."','$this->id')");
			}

			return($this->id);
		}

		function update()
		{
			global $CFG;
			parent::update();

			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 1)
			{
				$curado = $this->getAttributeByName("curado");
				$curado = $curado->get("value");
				if($curado)
					$this->db->sql_query("UPDATE usuarios SET id_nivel = 9 WHERE id IN (SELECT id_usuario FROM usuarios_grupos_teatro WHERE id_grupo_teatro=".$this->id.")");
				else
					$this->db->sql_query("UPDATE usuarios SET id_nivel = 6 WHERE id IN (SELECT id_usuario FROM usuarios_grupos_teatro WHERE id_grupo_teatro=".$this->id.")");
			}

		}


		function delete()
		{
				parent::delete();
				$this->db->sql_query("DELETE FROM usuarios_grupos_teatro WHERE id_grupo_teatro=".$this->id);
		}
	}

	
	$entidad =& new grupos_teatro();
	$entidad->set("db",$db);

	$entidad->set("name","grupos_teatro");
	$entidad->set("labelModule","Grupos Teatro");
	$entidad->set("table","grupos_teatro");
	$entidad->set("orderBy","nombre");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] != 6)
	{
		$link=new link($entidad);
		$link->set("name","generos_grupo_teatro");
		$link->set("url",$ME . "?module=generos_grupo_teatro");
		$link->set("icon","gear.png");
		$link->set("description","Géneros Grupo");
		$link->set("field","id_grupos_teatro");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","generos_grupo_teatro");
		$entidad->addLink($link);

	
		$link=new link($entidad);
		$link->set("name","obras_teatro");
		$link->set("url",$ME . "?module=obras_teatro");
		$link->set("icon","icon-activate.gif");
		$link->set("description","Obras");
		$link->set("field","id_grupos_teatro");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","obras_teatro");
		$entidad->addLink($link);


		$link=new link($entidad);
		$link->set("name","archivos_grupos_teatro");
		$link->set("url",$ME . "?module=archivos_grupos_teatro");
		$link->set("icon","picture.gif");
		$link->set("description","Archivos");
		$link->set("field","id_grupos_teatro");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","archivos_grupos_teatro");
		$entidad->addLink($link);
	
		$link=new link($entidad);
		$link->set("name","vinculados");
		$link->set("url",$ME . "?module=vinculados");
		$link->set("icon","stock_person.png");
		$link->set("description","Personas vinculadas");
		$link->set("field","id_grupo_teatro");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","vinculados");
		$entidad->addLink($link);

		$link=new link($entidad);
		$link->set("name","confirmados_grnic");
		$link->set("url",$ME . "?module=confirmados_grnic");
		$link->set("letra","GRNIC");
		$link->set("iconoLetra","GRNIC");
		$link->set("description","Finalizados GRNIC");
		$link->set("field","id_grupo_teatro");
		$link->set("type","iframe");
		$link->set("popup","TRUE");
		$link->set("relatedTable","confirmados_grnic");
		$entidad->addLink($link);

}


// ---------- ATRIBUTOS          ----------------
	
	$atributo=new attribute($entidad);
	$atributo->set("field","el_id");
	$atributo->set("label","id");
	$atributo->set("inputType","subQuery");
	$atributo->set("sqlType","subQuery");
	$atributo->set("subQuery","SELECT __id__");
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ingresado_por");
	$atributo->set("label","¿Inscrito?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("defaultValueSQL","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","terminos");
	$atributo->set("label","terminos");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("defaultValueSQL","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","convenio");
	$atributo->set("label","Mercado");
	$atributo->set("sqlType","character varying(255)");
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
	  $atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","email2");
	$atributo->set("label","Correo Dos");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
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
	$atributo->set("field","myspace");
	$atributo->set("label","MySpace");
	$atributo->set("sqlType","character varying(255)");
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
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
	{
		$atributo->set("editable",FALSE);
		$atributo->set("browseable",FALSE);
		$atributo->set("visible",FALSE);
	}
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
	$atributo->set("field","nombre_artistico");
	$atributo->set("label","Nombre artistico");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	
	
	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_actualizacion");
	$atributo->set("label","Fecha Actualización");
	$atributo->set("sqlType","timestamp");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

  $atributo=new attribute($entidad);
	$atributo->set("field","ustedes");
	$atributo->set("label","ustedes");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","otros");
	$atributo->set("label","otros");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure(FALSE);
?>
