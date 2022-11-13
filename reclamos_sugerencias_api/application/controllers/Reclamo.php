<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Reclamo extends CI_Controller {

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
				$response["message"] = "Método inválido";
				break;
		}
		
	}

	public function consultar($id = null)
	{	
		$where = null;
		if($id > 0) {
			$where['primary_key'] = $id;
		}
		
		$response = [];
		$response['status'] = "success";
		$response['result'] = $this->model_proceso->consultar($where);
		die(json_encode($response));
	}

	public function crear()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$response = [];
		if(is_array($request) && count($request) > 0  && isset($request['nombre']) && trim($request['nombre']) != '' ) {
			$q_existe = false; //$this->model_proceso->consultar(['nombre'=>trim($request['nombre'])], false);
			if($q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Nombre ya existe'];
			} else {
				
				$datos_insert['codigo'] 	= 'C'.date('YmdHis');
				$datos_insert['numero_documento'] 	= trim($request['numero_documento']);
				$datos_insert['nombre'] 	= trim($request['nombre']);
				$datos_insert['apellido'] 	= trim($request['apellido']);
				$datos_insert['telefono'] 	= trim($request['telefono']);
				$datos_insert['correo'] 	= trim($request['correo']);
				$datos_insert['descripcion'] 	= trim($request['descripcion']);
				$datos_insert['direccion_residencia'] 	= trim($request['direccion_residencia']);

				$datos_insert['estado'] 	= (isset($request['estado']) && $request['estado'] >= 0)? $request['estado']:1;
				$datos_insert['fecha_crea'] = date('Y-m-d H:i:s');
				$datos_insert['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_insert['usu_crea'] 	= (isset($request['id_user']) && $request['id_user'] > 0)? $request['id_user']:1;
				$datos_insert['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				
				$relaciones = $this->model_proceso->get_config_relations();
				foreach ($relaciones as $key => $value) {
					$idTabla = explode('=',$value);
					if($idTabla[1] != 'departamento_id') {
						$datos_insert[$idTabla[1]] = (isset($request[$idTabla[1]])  && $request[$idTabla[1]] > 0)? $request[$idTabla[1]]:null;
					}
				}
				$new = $this->model_proceso->crear($datos_insert);

				if(isset($request['archivos']) && count($request['archivos']) > 0 && $new > 0) {
					$datos_insert_file = [];
					$datos_insert_file['registro_caso_id'] = $new;
					$datos_insert_file['estado'] 	= (isset($request['estado']) && $request['estado'] >= 0)? $request['estado']:1;
					$datos_insert_file['fecha_crea']= date('Y-m-d H:i:s');
					$datos_insert_file['fecha_mod'] = date('Y-m-d H:i:s');
					$datos_insert_file['usu_crea'] 	= (isset($request['id_user']) && $request['id_user'] > 0)? $request['id_user']:1;
					$datos_insert_file['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
					foreach ($request['archivos'] as $f) {
						$datos_insert_file['nombre'] = trim($f['nombre']);
						$datos_insert_file['ruta'] = trim($f['ruta']);
						$datos_insert_file['peso'] = ($f['peso'] > 0)? $f['peso']:0;
						$datos_insert_file['extension'] = trim($f['extension']);
						if(trim($f['ruta']) != '') {
							$adjunto = $this->model_proceso->insertar_archivo($datos_insert_file);
						}
						
					}
				}

				$msj_estado = "Tu caso se encuentra en proceso";

				//enviar sms
				$response['sms'] = 'Problemas en notificar via SMS';
				if(trim($datos_insert['telefono']) != '') {
					$msg_sms = 'Sistema de reclamos: Caso: '.$datos_insert['codigo']. ', ' . $msj_estado;
					$response['sms'] = sendSMS($datos_insert['telefono'], $msg_sms);
				}

				//enviar mail
				$response['mail'] = 'Problemas en notificar via Correo';
				if(trim($datos_insert['correo']) != '') {
					$nombrePersona = ucwords(strtolower($datos_insert['nombre'] . ' ' . $datos_insert['apellido']));
					$datos = [];
					$datos['nombre_persona'] = $nombrePersona;
					$datos['mensaje_estado'] = $msj_estado;
					$datos['codigo'] = $datos_insert['codigo'];
					
					if(false) {
						//$this->load->model('usuario_model');
						//$html_usuario = '<b>Usuario:</b> ' . $datos_insert['correo'];
						//$html_usuario .= '<br /><b>Clave:</b> ' . $datos_insert['correo'];
						//$datos['msg_seguimiento'] = $html_usuario;	
					}
					

					$html_template = $this->load->view('template_mail', $datos, true);
					$response['mail'] = sendMail($reg_caso['correo'], $nombrePersona, $html_template);
				}


				
				$response['status'] = "success";
				$response['result'] = ['id'=>$new,'codigo'=>$datos_insert['codigo']];
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
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = ($id > 0)? $id: (isset($request['id'])? $request['id']:0);

		$response = [];
		if(is_array($request) && count($request) > 0  && isset($request['nombre']) && trim($request['nombre']) != '' && $id > 0 ) { 
			$q_existe = $this->model_proceso->consultar(['nombre'=>trim($request['nombre']), 'primary_key !='=>$id], false);
			if($q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Nombre ya existe'];
			} else { 
				$datos_update['nombre'] 	= $request['nombre'];
				$datos_update['estado'] 	= (isset($request['estado']) && $request['estado'] >= 0)? $request['estado']:1;
				$datos_update['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_update['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$condicion['primary_key'] 			= $id;
				
				$relaciones = $this->model_proceso->get_config_relations();
				foreach ($relaciones as $key => $value) {
					$idTabla = explode('=',$value);
					$datos_update[$idTabla[1]] = (isset($request[$idTabla[1]])  && $request[$idTabla[1]] > 0)? $request[$idTabla[1]]:null;
				}

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

	public function eliminar($id=null)
	{	
		$response = [];
		
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = ($id > 0)? $id: $request['id'];

		$condi['primary_key']	= $id;
		$registro_ocupado = $this->model_proceso->permite_eliminar(['relation_key'=>$id]);
		if($registro_ocupado) {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Registro en uso, imposible eliminar'];
		} else {
			$this->model_proceso->eliminar($condi);
			$response['status'] = "success";
			$response['result'] = ['id'=>$id];
		}
		
		die(json_encode($response));
	}

	public function relations()
	{	
		$response = [];
		$response['status'] = "success";
		$response['result'] = $this->model_proceso->get_relations_data();
		die(json_encode($response));
	}

}
