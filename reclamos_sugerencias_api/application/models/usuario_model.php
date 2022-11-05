<?php

class Usuario_model extends CI_Model
{
    private $table_model = 'usuarios';
    private $table_primary_key = 'id_usuario';
    private $table_relation = ['registro_caso'=>'usuario_id', 'seguimiento'=>'usuario_id'];
  	public function __construct(){
   		$this->load->database();
 	}
 	
 	public function consultar($where=null) {
    $this->db->select("*, $this->table_primary_key id_key")
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

}
?>
