<?php

class Usuario_model extends CI_Model
{
	
  	public function __construct(){
   		$this->load->database();
 	}

 
 	public function get_usuario($where=null) {
 		$this->db->select("*")
    ->from('system_usuario');
    if($where) {
      $this->db->where($where);
    }
    $datos = $this->db->get()->result_array();
    return $datos;
 	}

  public function crear($datos) {
    $this->db->insert('system_usuario',$datos);
    return $this->db->insert_id();
  }
  
  public function actualizar($datos, $condicion) {
    $this->db->update('system_usuario',$datos, $condicion);
  }
  public function eliminar($condicion) {
    $this->db->delete('system_usuario', $condicion);
  }

}
?>
