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
		$where['IFNULL(registro_caso.tipo_res_id,0) >'] = 0;
		
		$response = [];
		$response['status'] = "success";

		$response['result'] = $this->model_proceso->consultar($where, true, $order_by);
		die(json_encode($response));
	}

	public function casos_tipo_registro()
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
		if(isset($request['tipo_reg_id']) && $request['tipo_reg_id'] > 0) {
			$where['tipo_reg_id'] = $request['tipo_reg_id'];
		}
		if(isset($request['area_sal_id']) && $request['area_sal_id'] > 0) {
			$where['area_sal_id'] = $request['area_sal_id'];
		}
		if(isset($request['tipo_cli_id']) && $request['tipo_cli_id'] > 0) {
			$where['tipo_cli_id'] = $request['tipo_cli_id'];
		}
		if(isset($request['genero_id']) && $request['genero_id'] > 0) {
			$where['genero_id'] = $request['genero_id'];
		}
		if(isset($request['municipio_id']) && $request['municipio_id'] > 0) {
			$where['municipio_id'] = $request['municipio_id'];
		}
		if(isset($request['departamento_id']) && $request['departamento_id'] > 0) {
			$where['municipio_id IN (SELECT sub.id_municipio FROM municipio sub WHERE sub.departamento_id = '.$request['departamento_id'].')'] = NULL;
		}
		
		$response = [];
		$response['status'] = "success";

		$response['result'] = $this->model_proceso->consultar($where, true, $order_by);
		die(json_encode($response));
	}

	public function filtros_relations()
	{	
		$response = [];
		$response['status'] = "success";
		$response['result'] = $this->model_proceso->get_relations_data();
		die(json_encode($response));
	}


	public function estadistica_resolucion()
	{	
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$year = (isset($request['year']) && $request['year'] != '')? $request['year']:date('Y'); 

		$where = null;
		$where['c.estado'] = 5; //finalizados		
		$where['YEAR(c.fecha_crea)'] = $year;

		$query1 = $this->model_proceso->consultar_estadistico($where, 1); //tipo resolucion
		$query2 = $this->model_proceso->consultar_estadistico($where, 2); //tipo registro
		$query3 = $this->model_proceso->consultar_estadistico($where); //mes

		$data1 = [];
		foreach ($query1 as $q1) {
			$data1[] = [$q1['valor'],intval($q1['n'])];
		}

		$data2 = [];
		foreach ($query2 as $q2) {
			$data2[] = [$q2['valor'],intval($q2['n'])];
		}

		$data3 = [];
		$data_mes = array_column($query3,'n', 'valor');
		for ($i=1; $i <=12 ; $i++) { //doce meses
			$data3[] = (isset($data_mes[$i]))? intval($data_mes[$i]):0;
		}
				
		$response = [];
		$response['status'] = "success";

		$response['result'] = ['chart1'=>$data1, 'chart2'=>$data2, 'chart3'=>$data3];
		die(json_encode($response));
	}

	public function estadistica_casos()
	{	
		$data = json_decode(file_get_contents('php://input'), true);
        $request = (count($_POST) > 0)? $_POST:$data;
		if(!is_array($request)) {
			parse_str(file_get_contents('php://input'),$request);
		}
		$year = (isset($request['year']) && $request['year'] != '')? $request['year']:date('Y'); 

		$where = null;
		$where['YEAR(c.fecha_crea)'] = $year;

		$query1 = $this->model_proceso->consultar_estadistico_registro($where, 1); //tipo area
		$query2 = $this->model_proceso->consultar_estadistico_registro($where, 2); //tipo registro
		$query3 = $this->model_proceso->consultar_estadistico_registro($where, 3); //genero
		$query4 = $this->model_proceso->consultar_estadistico_registro($where, 4); //tipo cliente
		$query5 = $this->model_proceso->consultar_estadistico_registro($where, 5); //estado
		$query6 = $this->model_proceso->consultar_estadistico_registro($where); //mes

		$data1 = [];
		foreach ($query1 as $q1) {
			$data1[] = [$q1['valor'],intval($q1['n'])];
		}

		$data2 = [];
		foreach ($query2 as $q2) {
			$data2[] = [$q2['valor'],intval($q2['n'])];
		}

		$data3 = [];
		foreach ($query3 as $q3) {
			$data3[] = [$q3['valor'],intval($q3['n'])];
		}

		$data4 = [];
		foreach ($query4 as $q4) {
			$data4[] = [$q4['valor'],intval($q4['n'])];
		}

		$data5 = [];
		$data_estado = array_column($query5,'n', 'valor');
		for ($i=1; $i <=5 ; $i++) { //doce meses
			$data5[] = (isset($data_estado[$i]))? intval($data_estado[$i]):0;
		}

		$data6 = [];
		$data_mes = array_column($query6,'n', 'valor');
		for ($i=1; $i <=12 ; $i++) { //doce meses
			$data6[] = (isset($data_mes[$i]))? intval($data_mes[$i]):0;
		}
				
		$response = [];
		$response['status'] = "success";

		$response['result'] = ['chart1'=>$data1, 'chart2'=>$data2, 'chart3'=>$data3, 'chart4'=>$data4, 'chart5'=>$data5, 'chart6'=>$data6];
		die(json_encode($response));
	}

}
