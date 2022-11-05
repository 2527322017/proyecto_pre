<?php

class Municipio_model extends CI_Model
{
    private $table_model              = 'municipio';
    private $table_primary_key        = 'id_municipio';
    private $table_relation           = 'registro_caso';
    private $table_relation_key       = 'municipio_id';
    private $table_relation_join      = ['departamento'=>'id_departamento=departamento_id'];
    private $table_relation_join_left = [];
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
    $this->db->select("*")
    ->from($this->table_relation);
    if($where) {
      if(isset($where['relation_key'])) {
        $where[$this->table_relation_key] = $where['relation_key'];
        unset($where['relation_key']);
      }
      $this->db->where($where);
    }
    $this->db->limit(1);
    $datos = $this->db->get()->result_array();
    return $datos;
  }

  public function get_relations_data() {
    $datos = [];
    
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

    return $datos;
  }

  public function get_config_relations() {
    return array_merge($this->table_relation_join, $this->table_relation_join_left);
  }

  

}
?>
