<?php

class Login_model extends CI_Model
{
    private $table_model = 'usuarios';
    private $table_primary_key = 'id_usuario';
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

}
?>
