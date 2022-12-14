<?php

class Reclamo_model extends CI_Model
{
    private $table_model              = 'registro_caso';
    private $table_primary_key        = 'id_registro_caso';
    private $table_relation           = ['seguimiento'=>'registro_caso_id', 'archivos'=>'registro_caso_id'];
    private $table_relation_join      = [
                                        'tipo_registro'=>'id_tipo_reg=tipo_reg_id',
                                        'area_salud'=>'id_area_sal=area_sal_id',
                                        'tipo_cliente'=>'id_tipo_cli=tipo_cli_id',
                                        'genero'=>'id_genero=genero_id',
                                      ];
    
    private $table_relation_join_left = [
                                        'municipio'=>'id_municipio=municipio_id',
                                        'departamento'=>'id_departamento=departamento_id',
                                        'tipo_documento'=>'id_tipo_doc=tipo_doc_id',
                                        'tipo_resolucion'=>'id_tipo_res=tipo_res_id',
                                        'usuarios'=>'id_usuario=usuario_id',
                                      ];

  	public function __construct(){
   		$this->load->database();
 	}

 
 	public function consultar($where=null, $includeRelation = true, $orderBy = null, $limitQuery = null) {
 		$this->db->select("$this->table_model.*, $this->table_primary_key id_key")
    ->from($this->table_model);
    if($where) {
      if(isset($where['primary_key'])) {
        $where[$this->table_primary_key] = $where['primary_key'];
        unset($where['primary_key']);
      }
      else if(isset($where['primary_key !='])) {
        $where[$this->table_primary_key.' !='] = $where['primary_key !='];
        unset($where['primary_key !=']);
      }
      $this->db->where($where);
    }
    
    if(count($this->table_relation_join) > 0 && $includeRelation) {
      foreach ($this->table_relation_join as $key => $value) {
        $this->db->select("$key.nombre $key");
        $this->db->join($key, $value);
      }
    }
    if(count($this->table_relation_join_left) > 0 && $includeRelation) {
      foreach ($this->table_relation_join_left as $key => $value) {
        $campos_left = explode('=', $value);
        $campo_left = $campos_left[1];
        $this->db->select("IFNULL($key.nombre,'') $key, $campo_left");
        $this->db->join($key, $value, 'left');
      }
    }


    if($orderBy && is_array($orderBy)) {
      foreach ($orderBy as $campo => $tipo) {
        $this->db->order_by($campo,$tipo);
      }
    }

    if($limitQuery && $limitQuery > 0) {
        $this->db->limit($limitQuery);
    }



    $datos = $this->db->get()->result_array();
    return $datos;
 	}

  public function crear($datos) {
    $this->db->insert($this->table_model,$datos);
    return $this->db->insert_id();
  }
  
  public function actualizar($datos, $condicion) {
    if(isset($condicion['primary_key'])) {
      $condicion[$this->table_primary_key] = $condicion['primary_key'];
      unset($condicion['primary_key']);
    }
    $this->db->update($this->table_model,$datos, $condicion);
  }

  public function eliminar($condicion) {
    if(isset($condicion['primary_key'])) {
      $condicion[$this->table_primary_key] = $condicion['primary_key'];
      unset($condicion['primary_key']);
    }
    $this->db->delete($this->table_model, $condicion);
  }

  public function permite_eliminar($where) {
    $posee = false;
    foreach ($this->table_relation as $key => $value) {
      $this->db->select("*")
      ->from($key);
      if($where) {
        if(isset($where['relation_key'])) {
          $where[$value] = $where['relation_key'];
          unset($where['relation_key']);
        }
        $this->db->where($where);
      }
      $this->db->limit(1);
      $datos = $this->db->get()->result_array();
      if($datos) {
        $posee++;
      }
    }
  
    return ($posee > 0)? true:false;
  }

  public function get_relations_data($tabla_relacionada = null, $where=null) {
    $datos = [];

    if($tabla_relacionada) { //preguntar si se ha indicado una tabla especifica.
      foreach ($tabla_relacionada as $key => $value) {
        $idTable = explode('=', $value);
        $q = $this->db->select("*, $idTable[0] id_key, nombre value")
              ->from($key)
              ->where('estado', 1)
              ;
        if($where) {
          $q->where($where);
        }
        $datos[$idTable[1]] = $q->get()->result_array();
      }
    } else {
      if(count($this->table_relation_join) > 0) {
        foreach ($this->table_relation_join as $key => $value) {
          $idTable = explode('=', $value);
          $extra_data = ($key == 'tipo_registro')? ', identificacion_completa data_extra':", '' data_extra";
          $q = $this->db->select("*, $idTable[0] id_key, nombre value $extra_data")
                ->from($key)
                ->where('estado', 1)
                ->get()->result_array();
          $datos[$idTable[1]] = $q;
        }
      }
      if(count($this->table_relation_join_left) > 0) {
        foreach ($this->table_relation_join_left as $key => $value) {
          $idTable = explode('=', $value);
          $q = $this->db->select("*, $idTable[0] id_key, nombre value, '' data_extra")
                ->from($key)
                ->where('estado', 1)
                ->get()->result_array();
          $datos[$idTable[1]] = $q;
        }
      }
    }
    


    return $datos;
  }

  public function get_config_relations() {
    return array_merge($this->table_relation_join, $this->table_relation_join_left);
  }

  public function get_archivos($where) {
    $this->db->select("*")
      ->from('archivos');
      if($where) {
        $this->db->where($where);
      }
      $this->db->where('estado', 1);

    return  $this->db->get()->result_array();
  }

  public function get_seguimiento($where) {
    $this->db->select("seguimiento.*, IFNULL(tipo_resolucion.nombre,'') tipo_resolucion, IFNULL(usuarios.nombre,'') nombre_usuario")
      ->from('seguimiento')
      ->join('usuarios', 'id_usuario=usuario_id','left')
      ->join('tipo_resolucion', 'id_tipo_res=tipo_res_id','left')
      ;
      if($where) {
        $this->db->where($where);
      }
      $this->db->where('seguimiento.estado', 1);

    return  $this->db->get()->result_array();
  }

  public function insertar_archivo($datos) {
    $this->db->insert('archivos',$datos);
    return $this->db->insert_id();
  }

  public function ingresar_seguimiento($datos) {
    $this->db->insert('seguimiento',$datos);
    return $this->db->insert_id();
  }

  public function get_tabla($tabla, $where) {
    $this->db->select()
      ->from($tabla);
      if($where) {
        $this->db->where($where);
      }
    return  $this->db->get()->result_array();
  }

  public function consultar_estadistico($where=null, $groupBy = null) {
    //defecto por mes
    $q_groupBy = "MONTH(c.fecha_crea)";
    $q_select = "COUNT(c.id_registro_caso) n, MONTH(c.fecha_crea)  valor";
    
    if($groupBy == 1) { //por tipo resolucion
      $q_groupBy = "r.id_tipo_res";
      $q_select = "COUNT(c.id_registro_caso) n, r.nombre valor";
    }
    
    if($groupBy == 2) { //por tipo de registro
      $q_groupBy = "t.id_tipo_reg";
      $q_select = "COUNT(c.id_registro_caso) n, t.nombre valor";
    }

    $this->db->select($q_select)
   ->from("$this->table_model c")
   ->join('tipo_resolucion r', 'r.id_tipo_res=c.tipo_res_id')
   ->join('tipo_registro t', 't.id_tipo_reg=c.tipo_reg_id')
   ;
   if($where) {
     $this->db->where($where);
   }
   $this->db->order_by('c.fecha_crea','ASC');
   $this->db->group_by($q_groupBy);


   $datos = $this->db->get()->result_array();
   return $datos;
  }

  public function consultar_estadistico_registro($where=null, $groupBy = null) {
    //defecto por mes
    $q_groupBy = "MONTH(c.fecha_crea)";
    $q_select = "COUNT(c.id_registro_caso) n, MONTH(c.fecha_crea)  valor";
    
    if($groupBy == 1) { //por area
      $q_groupBy = "a.id_area_sal";
      $q_select = "COUNT(c.id_registro_caso) n, a.nombre valor";
    }
    
    if($groupBy == 2) { //por tipo de registro
      $q_groupBy = "tr.id_tipo_reg";
      $q_select = "COUNT(c.id_registro_caso) n, tr.nombre valor";
    }

    if($groupBy == 3) { //por tipo genero
      $q_groupBy = "g.id_genero";
      $q_select = "COUNT(c.id_registro_caso) n, g.nombre valor";
    }

    if($groupBy == 4) { //tipo cliente
      $q_groupBy = "tc.id_tipo_cli";
      $q_select = "COUNT(c.id_registro_caso) n, tc.nombre valor";
    }

    if($groupBy == 5) { //estado
      $q_groupBy = "c.estado";
      $q_select = "COUNT(c.id_registro_caso) n,  c.estado valor,
      (CASE c.estado 
      WHEN 1 THEN 'Registrado'
      WHEN 2 THEN 'Asignado'
      WHEN 3 THEN 'An??lisis'
      WHEN 4 THEN 'Verificaci??n'
      WHEN 5 THEN 'Finalizado'
      ELSE 'Registrado'
      END ) valor2";
    }

    $this->db->select($q_select)
   ->from("$this->table_model c")
   ->join('area_salud a', 'a.id_area_sal=c.area_sal_id')
   ->join('genero g', 'g.id_genero=c.genero_id')
   ->join('tipo_cliente tc', 'tc.id_tipo_cli=c.tipo_cli_id')
   ->join('tipo_registro tr', 'tr.id_tipo_reg=c.tipo_reg_id')
   ;
   if($where) {
     $this->db->where($where);
   }
   $this->db->order_by('c.fecha_crea','ASC');
   $this->db->group_by($q_groupBy);


   $datos = $this->db->get()->result_array();
   return $datos;
  }

}
?>
