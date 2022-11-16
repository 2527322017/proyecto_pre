<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Perfil extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		
		if (ob_get_contents()) ob_end_clean(); 

		validar_acceso();
		$this->load->model('usuario_model','model_catalogo');		
    }


	public function index()
	{
		$peticion = $_SERVER['REQUEST_METHOD'];
		switch ($peticion) {
			case 'GET':
				$this->consultar();
				break;
			default:
				$response["error"] = true;	
				$response["message"] = "Método inválido";
				break;
		}
		
	}

	public function consultar($id = null)
	{	
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = isset($request['id_user'])? $request['id_user']:0;
		$where['primary_key'] = $id;
		$q = $this->model_catalogo->consultar($where);
		if($q) {
			$response = [];
			$response['status'] = "success";
			$response['result'] = $q[0];
		} else {
			$response = [];
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Registro no encontrado'];
		}

		die(json_encode($response));
	}


	public function update_user()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = isset($request['id_user'])? $request['id_user']:0;

		$response = [];
		if(is_array($request) && count($request) > 0 
			&& isset($request['nombre']) && trim($request['nombre']) != '' 
			&& $id > 0 ) { 
			$q_existe = $this->model_catalogo->consultar(['primary_key'=>$id]);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Usuario no existe'];
			} else { 
				$datos_update['nombre'] 	= trim($request['nombre']);
				$datos_update['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_update['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$condicion['primary_key']   = $id;
		
				$this->model_catalogo->actualizar($datos_update,$condicion);
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

	public function update_password()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = isset($request['id_user'])? $request['id_user']:0;

		$response = [];
		if(is_array($request) && count($request) > 0 
			&& isset($request['clave_actual']) && trim($request['clave_actual']) != '' 
			&& isset($request['clave']) && trim($request['clave']) != '' 
			&& $id > 0 ) { 
			$q_existe = $this->model_catalogo->consultar(['primary_key'=>$id]);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Usuario no existe'];
			} else { 
				if(trim($request['clave_actual']) == trim($request['clave'])) {
					$response['status'] = "error";
					$response['result'] = ['msg'=>'La nueva clave debe ser diferente'];
				} else {
					$password = trim($request['clave_actual']);
					$hashed_password = $q_existe[0]['clave'];
					if(password_verify($password, $hashed_password)) { //contraseña correcta
						$datos_update['clave'] 		= password_hash(trim($request['clave']), PASSWORD_DEFAULT);
						$datos_update['fecha_mod'] 	= date('Y-m-d H:i:s');
						$datos_update['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:0;
						$condicion['primary_key']   = $id;
				
						$this->model_catalogo->actualizar($datos_update,$condicion);
						$response = [];
						$response['status'] = "success";
						$response['result'] = ['id'=>$id];
					} else {
						$response['status'] = "error";
						$response['result'] = ['msg'=>'Contraseña incorrecta'];
					}
				}
			}
		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));
	}
}
