<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");

class Seguimiento_reclamo extends CI_Controller {

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
					$this->consultar($id); // id del usuario
				break;
			case 'POST':
				$this->crear_seguimiento();
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
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$id = ($id > 0)? $id: (isset($request['id_user'])? $request['id_user']:0);

		$where = null;
		$where['usuario_id'] = $id;
		$response = [];
		$response['status'] = "success";

		$response['result'] = $this->model_proceso->consultar($where, true, array('orden_tablero'=>'ASC'));
		die(json_encode($response));
	}

	public function crear_seguimiento()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$id = (isset($request['id']) &&  $request['id'] > 0)? $request['id']:0;

		$response = [];
		if(is_array($request) && count($request) > 0  && isset($request['comentario']) && trim($request['comentario']) != '' && $id > 0 ) {
			$q_existe = $this->model_proceso->consultar(['primary_key'=>$id], false);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Registro no existe'];
			} else {
				
				$datos_insert['registro_caso_id'] 	= $id;
				$datos_insert['comentario'] 	= trim($request['comentario']);
				$datos_insert['fecha_registro'] = date('Y-m-d H:i:s');
				$datos_insert['estado'] 	= (isset($request['estado']) && $request['estado'] >= 0)? $request['estado']:1;
				$datos_insert['fecha_crea'] = date('Y-m-d H:i:s');
				$datos_insert['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_insert['usu_crea'] 	= (isset($request['id_user']) && $request['id_user'] > 0)? $request['id_user']:1;
				$datos_insert['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				
				$datos_insert['usuario_id'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$datos_insert['tipo_res_id'] 	= (isset($request['tipo_res_id'])  && $request['tipo_res_id'] > 0)? $request['tipo_res_id']:null;
				$datos_insert['envio_correo'] 	= (isset($request['notificar_correo'])  && $request['notificar_correo'] > 0)? 1:0;
				
				$id_insert = $this->model_proceso->ingresar_seguimiento($datos_insert);

				if($datos_insert['tipo_res_id'] > 0) {
					$datos_update = [];
					$datos_update['tipo_res_id']= $datos_insert['tipo_res_id'];
					$datos_update['fecha_mod']	= date('Y-m-d H:i:s');
					$datos_update['usu_mod']	= $datos_insert['usu_mod'];
					$condicion['primary_key']	= $id;
					$this->model_proceso->actualizar($datos_update,$condicion);
				}

				if($datos_insert['envio_correo'] == 1 && $datos_insert['tipo_res_id'] > 0) {
					$datos_res = $this->model_proceso->get_tabla('tipo_resolucion',['id_tipo_res'=>$datos_insert['tipo_res_id']]);
					
					//enviar mail
				$response['mail'] = 'Problemas en notificar via Correo';
				$reg_caso = $q_existe[0];
				if(trim($reg_caso['correo']) != '') {
					$nombrePersona = ucwords(strtolower($reg_caso['nombre'] . ' ' . $reg_caso['apellido']));
					$datos = [];
					$datos['nombre_persona'] = $nombrePersona;
					$datos['mensaje_estado'] = "Resolución, " . $datos_res[0]['nombre'];
					$datos['codigo'] = $reg_caso['codigo'];
					$datos['msg_seguimiento'] = $datos_insert['comentario'];

					$html_template = $this->load->view('template_mail', $datos, true);
					$response['mail'] = sendMail($reg_caso['correo'], $nombrePersona, $html_template);
				}

				}


				$response['status'] = "success";
				$response['result'] = ['id'=>$id_insert];
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
		$response['result'] = $this->model_proceso->get_relations_data(['tipo_resolucion'=>'id_tipo_res=tipo_res_id'],['estado'=>1]);
		die(json_encode($response));
	}

	public function orden_update()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$registros = (isset($request['registros']) && count($request['registros'])>0)? $request['registros']: [];
		
		$response = [];
		if(is_array($registros) && count($registros) > 0) { 
			
		
			$datos_update = [];
			$datos_update['fecha_mod']	= date('Y-m-d H:i:s');
			$datos_update['usu_mod']	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;


			foreach ($registros as $key => $value) {
				$datos_update['orden_tablero'] = $key;
				$condicion['primary_key']	= $value;
				$this->model_proceso->actualizar($datos_update,$condicion);
			}
			
				$response = [];
				$response['status'] = "success";
				$response['result'] = ['affected'=>count($registros)];
			
		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));

	}


	public function status_update()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$estado = (isset($request['estado']) &&  trim($request['estado']) !='')? $request['estado']:'';
		$id = (isset($request['id']) && $request['id']>0)? $request['id']: 0;
		
		$response = [];
		if($id > 0  && $estado != '' ) { 
			$q_existe = $this->model_proceso->consultar(['primary_key'=>trim($id)], false);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Registro no existe'];
			} else { 
				$reg_caso = $q_existe[0];
				switch ($estado) {
					case 'Análisis':
						$n_estado = 2;
						$msj_estado = "Tu caso se encuentra en Análisis";
						break;
					case 'Verificación':
						$n_estado = 3;
						$msj_estado = "Tu caso se encuentra en Verificación";
						break;
					case 'Finalizado':
						$n_estado = 4;
						$msj_estado = "Tu caso se encuentra Finalizado";
						break;
					default:
						$n_estado = 1;
						$msj_estado = "Tu caso se encuentra en proceso"; //asignado
						break;
				}
				$datos_update = [];
				$datos_update['fecha_mod']	= date('Y-m-d H:i:s');
				$datos_update['usu_mod']	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$datos_update['estado'] = $n_estado;
				$condicion['primary_key']	= $id;
				$this->model_proceso->actualizar($datos_update,$condicion);
				$response['status'] = "success";
				$response['result'] = ['id'=>$id];
	
				//enviar sms
				$response['sms'] = 'Problemas en notificar via SMS';
				if(trim($reg_caso['telefono']) != '') {
					$msg_sms = 'Sistema de reclamos: Caso: '.trim($reg_caso['codigo']). ', ' . $msj_estado;
					$response['sms'] = sendSMS($reg_caso['telefono'], $msg_sms);
				}

				//enviar mail
				$response['mail'] = 'Problemas en notificar via Correo';
				if(trim($reg_caso['correo']) != '') {
					$nombrePersona = ucwords(strtolower($reg_caso['nombre'] . ' ' . $reg_caso['apellido']));
					$datos = [];
					$datos['nombre_persona'] = $nombrePersona;
					$datos['mensaje_estado'] = $msj_estado;
					$datos['codigo'] = $reg_caso['codigo'];

					$html_template = $this->load->view('template_mail', $datos, true);
					$response['mail'] = sendMail($reg_caso['correo'], $nombrePersona, $html_template);
				}

			}
			
		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));

	}


	public function get_detalle()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$id = (isset($request['id']) && $request['id']>0)? $request['id']: 0;
		
		$response = [];
		if($id > 0 ) { 
			$q_existe = $this->model_proceso->consultar(['primary_key'=>trim($id)], true);
			if(!$q_existe) {
				$response['status'] = "error";
				$response['result'] = ['msg'=>'Registro no existe'];
			} else { 
				$q_archivos = $this->model_proceso->get_archivos(['registro_caso_id'=>trim($id)]);
				$q_seguimiento = $this->model_proceso->get_seguimiento(['registro_caso_id'=>trim($id)]);

				$registro_completo = [];
				$registro_completo['registro'] = $q_existe[0];
				$registro_completo['archivos'] = $q_archivos;
				$registro_completo['seguimiento'] = $q_seguimiento;
				
				$response['status'] = "success";
				$response['result'] = $registro_completo;

			}
			
		} else {
			$response['status'] = "error";
			$response['result'] = ['msg'=>'Campos requeridos'];
		}
		die(json_encode($response));

	}

}
