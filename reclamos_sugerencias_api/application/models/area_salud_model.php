<?php

class Area_salud_model extends CI_Model
{
  	public function __construct(){
   		$this->load->database();
 	}

 
 	public function consultar($where=null) {
 		$this->db->select("*")
    ->from('area_salud');
    if($where) {
      $this->db->where($where);
    }
    $datos = $this->db->get()->result_array();
    return $datos;
    //return (count($datos) == 1)? $datos[0]:$datos;
 	}

  public function crear($datos) {
    $this->db->insert('area_salud',$datos);
    return $this->db->insert_id();
  }
  
  public function actualizar($datos, $condicion) {
    $this->db->update('area_salud',$datos, $condicion);
  }

  public function eliminar($condicion) {
    $this->db->delete('area_salud', $condicion);
  }

}
?>
