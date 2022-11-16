<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Reportes extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		
		if (ob_get_contents()) ob_end_clean(); 

		validar_acceso();
		$this->load->model('reclamo_model','model_proceso');		
    }


	public function index($id=null)
	{
		$response["error"] = true;	
		$response["message"] = "Método inválido";
		die(json_encode($response));
	}

	public function reclamos_resoluciones()
	{	
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$nuevafecha = strtotime('-10 months', strtotime(date('Y-m-d')));

		$desde = (isset($request['desde']) && $request['desde'] != '')? $request['desde']:date('Y-m-d' , $nuevafecha); 
		$hasta = (isset($request['hasta']) && $request['hasta'] != '')? $request['hasta']:date('Y-m-d'); 
		
		$order_by = array('registro_caso.fecha_crea'=>'ASC');
		$where = null;
		$where['DATE(registro_caso.fecha_crea) >='] = $desde;
		$where['DATE(registro_caso.fecha_crea) <='] = $hasta;
		
		$response = [];
		$response['status'] = "success";

		$response['result'] = $this->model_proceso->consultar($where, true, $order_by);
		die(json_encode($response));
	}

}
