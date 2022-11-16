<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Login extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		
		if (ob_get_contents()) ob_end_clean(); 

		validar_acceso();
		$this->load->model('login_model');		
    }


	public function index($id=null)
	{
		$peticion = $_SERVER['REQUEST_METHOD'];
		switch ($peticion) {
			case 'POST':
				$this->login();
				break;
			default:
				$response["error"] = true;	
				$response["message"] = "Método inválido";
				break;
		}
		
	}

	public function login()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$response = [];
		if(is_array($request) && count($request) > 0  
			&& isset($request['usuario']) && trim($request['usuario']) != '' 
			&& isset($request['clave']) && trim($request['clave']) != '' 
			) {
			$q_existe = $this->login_model->consultar(['usuario'=>trim($request['usuario']), 'estado'=>1]);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Usuario incorrecto (o inactivo)'];
			} else {
				$password = trim($request['clave']);
				$hashed_password = $q_existe[0]['clave'];
				if(password_verify($password, $hashed_password)) { //contraseña correcta
					$response['status'] = "success";
					$response['result'] = $q_existe[0];
				} else {
					$response['status'] = "error";
					$response['result'] = ['msg'=>'Contraseña incorrecta'];
				}			
				
			}

		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));
	}


	public function verificar_correo()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$response = [];
		if(is_array($request) && count($request) > 0  
			&& isset($request['correo']) && trim($request['correo']) != '' 
			) {
			$q_existe = $this->login_model->consultar(['usuario'=>trim($request['correo'])]);
			if(!$q_existe) {
				$q_existe = $this->login_model->consultar(['correo'=>trim($request['correo'])]);
			}
			
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Usuario no existe'];
			} else {
				$response['status'] = "success";
				$response['result'] = $q_existe[0];	
			}

		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));
	}

	public function recuperar_clave()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$response = [];
		if(is_array($request) && count($request) > 0  
			&& isset($request['correo']) && trim($request['correo']) != ''
			) {
			$q_existe = $this->login_model->consultar(['correo'=>trim($request['correo']), 'estado'=>1]);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Correo incorrecto (o inactivo)'];
			} else {
				$this->load->model('usuario_model');
				$newClave = generate_password();

				$datos_update['clave'] 		= password_hash($newClave, PASSWORD_DEFAULT);
				$datos_update['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_update['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:0;
				$condicion['correo']   		= trim($request['correo']);
		
				$this->usuario_model->actualizar($datos_update,$condicion);

				$html_usuario = '';
				$html_usuario = 'Tus nuevos datos de acceso son los siguiente:<br /><br />'; 
				$html_usuario .= '<b>Usuario:</b> ' . $q_existe[0]['usuario'];
				$html_usuario .= '<br /><b>Clave:</b> ' .$newClave;

				$datos = [];
				$datos['nombre_persona'] = $q_existe[0]['nombre'];
				$datos['mensaje_estado'] = 'Nueva contraseña generada';
				$datos['msg_seguimiento'] = $html_usuario;
				$html_template = $this->load->view('template_mail', $datos, true);
				$response['status'] = "success";
				$response['mail'] = sendMail($request['correo'], $q_existe[0]['nombre'], $html_template);
				$response['result'] = $request['correo'];
				
			}

		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));
	}
	
}
