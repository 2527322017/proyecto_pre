<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Asignar_reclamo extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		
		if (ob_get_contents()) ob_end_clean(); 

		validar_acceso();
		$this->load->model('reclamo_model','model_proceso');		
    }


	public function index($id=null)
	{
		$peticion = $_SERVER['REQUEST_METHOD'];
		switch ($peticion) {
			case 'GET':
				if($id == 'relations') 
					$this->relations();
				else 
					$this->consultar($id);
				break;
			case 'PUT':
				$this->actualizar($id);
				break;
			default:
				$response["error"] = true;	
				$response["message"] = "Método inválido";
				break;
		}
		
	}

	public function consultar($id = null)
	{	
		$where = null;
		$where['usuario_id IS NULL'] = null;
		if($id > 0) {
			$where['primary_key'] = $id;
		}
		
		$response = [];
		$response['status'] = "success";
		$response['result'] = $this->model_proceso->consultar($where);
		die(json_encode($response));
	}

	public function actualizar($id=null)
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = ($id > 0)? $id: (isset($request['id'])? $request['id']:0);

		$response = [];
		if(is_array($request) && count($request) > 0  && isset($request['usuario_id']) && $request['usuario_id'] > 0 && $id > 0 ) { 
			$q_existe = $this->model_proceso->consultar(['primary_key'=>trim($id)], false);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Registro no existe'];
			} else { 
				$datos_update['usuario_id']	= $request['usuario_id'];
				$datos_update['fecha_mod']	= date('Y-m-d H:i:s');
				$datos_update['usu_mod']	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$condicion['primary_key']	= $id;
				
				$this->model_proceso->actualizar($datos_update,$condicion);
				$response = [];
				$response['status'] = "success";
				$response['result'] = ['id'=>$id];
			}
		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));
	}


	public function relations()
	{	
		$response = [];
		$response['status'] = "success";
		//solo encargados
		$response['result'] = $this->model_proceso->get_relations_data(['usuarios'=>'id_usuario=usuario_id'],['tipo'=>2]);
		die(json_encode($response));
	}

}
