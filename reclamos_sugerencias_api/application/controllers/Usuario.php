<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With*');
header("Content-Type: application/json; charset=UTF-8");
define('API_KEY','1234');

class Usuario extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		$this->load->model('usuario_model');  
        if (ob_get_contents()) ob_end_clean(); 

		if(!isset($_SERVER['HTTP_API_KEY'])) {
			$response["error"] = true;	
			$response["message"] = "Acceso denegado. Token inválido";
			header("HTTP/1.1 401");
			die(json_encode($response));
		} else if($_SERVER['HTTP_API_KEY'] != API_KEY) {
			$response["error"] = true;
			$response["message"] = "Acceso denegado. Token inválido";
			header("HTTP/1.1 401");
			die(json_encode($response));
		}

    }


	public function index()
	{
		$response = [];
		$response['status'] = "hola";
		die(json_encode($response));
	}


	public function consultar($user_id = null)
	{	
		$id = (count($_GET) > 0 && isset($_GET['user_id']))? $_GET['user_id']:$user_id; 
		$whereUsuario = null;
		if($id > 0) {
			$whereUsuario['id'] = $id;
		}
		
		$response = [];
		$response['status'] = "success";
		$response['result'] = $this->usuario_model->get_usuario($whereUsuario);
		die(json_encode($response));
	}

	public function crear()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $_POST = (count($_POST) > 0)? $_POST:$data;

		//print_r($_POST); die();
		$datosUsuario['nombre'] = $_POST['nombre'];
		$datosUsuario['usuario'] = $_POST['usuario'];
		$datosUsuario['clave'] = md5($_POST['clave']);
		$datosUsuario['tipo'] = $_POST['tipo'];

		$this->usuario_model->crear($datosUsuario);
		$response = [];
		$response['status'] = "success crear";
		die(json_encode($response));
	}

	public function actualizar()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $_POST = (count($_POST) > 0)? $_POST:$data;

		$datosUsuario['nombre'] = $_POST['nombre'];
		$datosUsuario['usuario'] = $_POST['usuario'];
		$datosUsuario['clave'] = md5($_POST['clave']);
		$datosUsuario['tipo'] = $_POST['tipo'];
		$condi['id'] 		= $_POST['id'];
		if(trim($datosUsuario['nombre']) == '') {
			$response['error'] = "nombre requerido";
			die(json_encode($response));
		}
		$this->usuario_model->actualizar($datosUsuario,$condi);
		$response = [];
		$response['status'] = "success update";
		die(json_encode($response));
	}

	public function eliminar()
	{
		$data = json_decode(file_get_contents('php://input'), true);
        $_POST = (count($_POST) > 0)? $_POST:$data;
		$condi['id'] 		= $_POST['id'];
		$this->usuario_model->eliminar($condi);
		$response = [];
		$response['status'] = "success eliminar";
		die(json_encode($response));
	}
}
