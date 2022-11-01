<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Areas_salud extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		
		if (ob_get_contents()) ob_end_clean(); 

		validar_acceso();
		$this->load->model('area_salud_model');		
    }


	public function index($id=null)
	{
		$peticion = $_SERVER['REQUEST_METHOD'];
		switch ($peticion) {
			case 'GET':
				$this->consultar($id);
				break;
			case 'POST':
				$this->crear();
				break;
			case 'PUT':
				$this->actualizar($id);
				break;
			case 'DELETE':
				$this->eliminar($id);
				break;
			default:
				$response["error"] = true;	
				$response["message"] = "Acceso denegado. Método inválido";
				break;
		}
		
	}

	public function consultar($id = null)
	{	

		$where = null;
		if($id > 0) {
			$where['id_area_sal'] = $id;
		}
		
		$response = [];
		$response['status'] = "success";
		$response['result'] = $this->area_salud_model->consultar($where);
		die(json_encode($response));
	}

	public function crear()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		$response = [];
		if(is_array($request) && count($request) > 0  && isset($request['nombre']) && trim($request['nombre']) != '' ) {
			$q_existe = $this->area_salud_model->consultar(['nombre'=>trim($request['nombre'])]);
			if($q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Nombre ya existe'];
			} else {
				$datos_insert['nombre'] 	= $request['nombre'];
				$datos_insert['estado'] 	= (isset($request['estado']) && $request['estado'] >= 0)? $request['estado']:1;
				$datos_insert['fecha_crea'] = date('Y-m-d H:i:s');
				$datos_insert['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_insert['usu_crea'] 	= (isset($request['id_user']) && $request['id_user'] > 0)? $request['id_user']:1;
				$datos_insert['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$new = $this->area_salud_model->crear($datos_insert);
				
				$response['status'] = "success";
				$response['result'] = ['id'=>$new];
			}

		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));
	}

	public function actualizar($id=null)
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		$id = ($id > 0)? $id: $request['id'];

		$datos_update['nombre'] 	= $request['nombre'];
		$datos_update['estado'] 	= $request['usuario'];
		$datos_update['fecha_mod'] 	= $request['fecha_mod'];
		$datos_update['usu_mod'] 	= $request['usu_mod'];
		$condicion['id'] 			= $id;
		if(trim($datos_update['nombre']) == '') {
			$response['error'] = "nombre requerido";
			die(json_encode($response));
		}
		$this->area_salud_model->actualizar($datos_update,$condicion);
		$response = [];
		$response['status'] = "success";
		$response['result'] = ['id'=>$id];
		die(json_encode($response));
	}

	public function eliminar($id=null)
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		$id = ($id > 0)? $id: $request['id'];

		$condi['id']	= $id;
		$this->area_salud_model->eliminar($condi);
		$response = [];
		$response['status'] = "success";
		$response['result'] = ['id'=>$id];
		die(json_encode($response));
	}
}
