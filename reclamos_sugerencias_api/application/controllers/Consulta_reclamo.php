<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Consulta_reclamo extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		
		if (ob_get_contents()) ob_end_clean(); 

		validar_acceso();
		$this->load->model('reclamo_model','model_proceso');		
    }


	public function index()
	{
		$peticion = $_SERVER['REQUEST_METHOD'];
		switch ($peticion) {
			case 'POST':
				$this->consultar(); 
				break;
			default:
				$response["error"] = true;	
				$response["message"] = "Método inválido";
				break;
		}
		
	}

	public function consultar()
	{	
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$cod = (isset($request['codigo']) && trim($request['codigo']) != '')? trim($request['codigo']):'';
		$cod_get = (isset($_GET['codigo']) && trim($_GET['codigo']) != '')? trim($_GET['codigo']):'';
		$cod = ($cod != '' )? $cod:$cod_get;

		$where['codigo'] = $cod;
		$response = [];
		$response['status'] = "success";

		$result = $this->model_proceso->consultar($where, true);
		$response['result'] = ($result)? $result[0]:[];

		die(json_encode($response));
	}

}
