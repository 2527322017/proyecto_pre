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
		$tipo_usuario = (isset($request['tipo_user']) && $request['tipo_user'] > 0)? $request['tipo_user']:2; //default encargado
		$is_board = (isset($request['is_board']) && is_numeric($request['is_board']))? $request['is_board']:1; //preguntar si es la pizarra de trabajo
		
		$order_by = array('orden_tablero'=>'ASC');
		$where = null;
		if($tipo_usuario == 3 && $is_board == 0) {
			$where['usuario_cliente_id'] = $id; //filtrar los del cliente
		} else if($tipo_usuario == 1 && $is_board == 0) { //admin, ver los registros de los ultimos 10meses
			$nuevafecha = strtotime('-10 months', strtotime(date('Y-m-d')));
			$where['DATE(registro_caso.fecha_crea) >='] = date('Y-m-d' , $nuevafecha);
			$order_by = array('registro_caso.fecha_crea'=>'ASC');
		} else {
			$where['usuario_id'] = $id;
			//excluir los registros finalizados con más de 5 meses (en la pizarra)
			if($is_board == 1) {
				$where["DATE(registro_caso.fecha_crea) >= IF(registro_caso.estado = 4, ADDDATE(CURDATE(),INTERVAL -5 MONTH),DATE(registro_caso.fecha_crea))"] = null;
			}
		}
		
		$response = [];
		$response['status'] = "success";

		$response['result'] = $this->model_proceso->consultar($where, true, $order_by);
		die(json_encode($response));
	}

	public function consultar_admin()
	{	
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}

		$id = (isset($request['id_user_tecnico']) && $request['id_user_tecnico'] > 0)? $request['id_user_tecnico']:0;
		
		$where['usuario_id'] = $id;
		//excluir los registros finalizados con más de 5 meses (en la pizarra)
		$where["DATE(registro_caso.fecha_crea) >= IF(registro_caso.estado = 4, ADDDATE(CURDATE(),INTERVAL -5 MONTH),DATE(registro_caso.fecha_crea))"] = null;
		
		$order_by = array('orden_tablero'=>'ASC');
		$response = [];
		$response['status'] = "success";

		$response['result'] = $this->model_proceso->consultar($where, true, $order_by);
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
				$datos_insert['estado_seg'] 	= $q_existe[0]['estado']; //identificar en que estado se da el seguimiento
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
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		
		if(isset($request['tipo_user']) && $request['tipo_user'] == 1) { //admin
			$result_relations1 = $this->model_proceso->get_relations_data(['tipo_resolucion'=>'id_tipo_res=tipo_res_id'],['estado'=>1]);
			$result_relations2 = $this->model_proceso->get_relations_data(['usuarios'=>'id_usuario=usuario_id'],['tipo'=>2]);
			$result_relations = array_merge($result_relations1, $result_relations2);
		} else {
			$result_relations = $this->model_proceso->get_relations_data(['tipo_resolucion'=>'id_tipo_res=tipo_res_id'],['estado'=>1]);
		}
		
		$response = [];
		$response['status'] = "success";
		//solo encargados
		$response['result'] = $result_relations; 
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
						$n_estado = 3;
						$msj_estado = "Tu caso se encuentra en Análisis";
						break;
					case 'Verificación':
						$n_estado = 4;
						$msj_estado = "Tu caso se encuentra en Verificación";
						break;
					case 'Finalizado':
						$n_estado = 5;
						$msj_estado = "Tu caso se encuentra Finalizado";
						break;
					default:
						$n_estado = 2;
						$msj_estado = "Tu caso se encuentra Asignado"; //asignado
						break;
				}
				$datos_update = [];
				$datos_update['fecha_mod']	= date('Y-m-d H:i:s');
				$datos_update['usu_mod']	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:1;
				$datos_update['estado'] = $n_estado;
				$condicion['primary_key']	= $id;
				$this->model_proceso->actualizar($datos_update,$condicion);
				
				//agregar seguimiento para bitacora
				$estado_ant = get_estado_seguimiento($q_existe[0]['estado']);
				$datos_insert_seg['registro_caso_id'] 	= $id;
				$datos_insert_seg['comentario'] 	= "Cambio de estado de ". $estado_ant ." a " . $estado;
				$datos_insert_seg['fecha_registro'] = date('Y-m-d H:i:s');
				$datos_insert_seg['estado_seg'] 	= $q_existe[0]['estado']; //identificar en que estado se da el seguimiento
				$datos_insert_seg['estado_seg_cambio'] 	= $n_estado; //identificar el nuevo estado
				$datos_insert_seg['estado'] 	= 1;
				$datos_insert_seg['fecha_crea'] = date('Y-m-d H:i:s');
				$datos_insert_seg['fecha_mod'] 	= date('Y-m-d H:i:s');
				$datos_insert_seg['usu_crea'] 	= (isset($request['id_user']) && $request['id_user'] > 0)? $request['id_user']:0;
				$datos_insert_seg['usu_mod'] 	= (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:0;
				$datos_insert_seg['usuario_id'] = (isset($request['id_user'])  && $request['id_user'] > 0)? $request['id_user']:0;
				
				$id_insert_seg = $this->model_proceso->ingresar_seguimiento($datos_insert_seg);

				$response['status'] = "success";
				$response['result'] = ['id'=>$id, 'id_seg'=>$id_insert_seg];
	
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
		$tipo_usuario = (isset($request['tipo_user']) && $request['tipo_user'] > 0)? $request['tipo_user']:2; //default encargado
		
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
