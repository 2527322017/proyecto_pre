<?php

class Reclamo_model extends CI_Model
{
    private $table_model              = 'registro_caso';
    private $table_primary_key        = 'id_registro_caso';
    private $table_relation           = ['seguimiento'=>'registro_caso_id', 'archivos'=>'registro_caso_id'];
    private $table_relation_join      = [
                                        'municipio'=>'id_municipio=municipio_id',
                                        'departamento'=>'id_departamento=departamento_id',
                                        'tipo_registro'=>'id_tipo_reg=tipo_reg_id',
                                        'area_salud'=>'id_area_sal=area_sal_id',
                                        'tipo_cliente'=>'id_tipo_cli=tipo_cli_id',
                                        'tipo_documento'=>'id_tipo_doc=tipo_doc_id',
                                        'genero'=>'id_genero=genero_id',
                                      ];
    
    private $table_relation_join_left = [
                                        'tipo_resolucion'=>'id_tipo_res=tipo_res_id',
                                        'usuarios'=>'id_usuario=usuario_id',
                                      ];

  	public function __construct(){
   		$this->load->database();
 	}

 
 	public function consultar($where=null, $includeRelation = true) {
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
        $this->db->select("$key.nombre $key");
        $this->db->join($key, $value, 'left');
      }
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
          $q = $this->db->select("*, $idTable[0] id_key, nombre value")
                ->from($key)
                ->where('estado', 1)
                ->get()->result_array();
          $datos[$idTable[1]] = $q;
        }
      }
      if(count($this->table_relation_join_left) > 0) {
        foreach ($this->table_relation_join_left as $key => $value) {
          $idTable = explode('=', $value);
          $q = $this->db->select("*, $idTable[0] id_key, nombre value")
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

  

}
?>
