<?php 
 session_start();
 include("../api.php");

 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  $data = json_decode(file_get_contents('php://input'), true);
  if(!is_array($data)) {
    parse_str(file_get_contents('php://input'),$data);
  }
  $request = (count($_POST) > 0)? $_POST:$data;
  $service = (isset($request['service']) && trim($request['service']) != '')? trim($request['service']):'';
  $service = ($service == '' && isset($_GET['service']) && trim($_GET['service']) != '')? trim($_GET['service']):'';
 

  if($service != '') {
    
    $service = str_replace('__','/',$service);

    $API = new API($service);
    //Para usar en editar o eliminar
    $id_registro = (isset($request['id']) && trim($request['id']) != '')? trim($request['id']):'';
    $id_registro = ($id_registro == '' && isset($_GET['id']) && trim($_GET['id']) != '')? trim($_GET['id']):'';


    if($id_registro != '') {
      $API->set_parametro($id_registro);
    }

    if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0) {
      $request['id_user']=$_SESSION['id_user']; //enviar el id de usuario
   }

    $respuesta = $API->call_api($request, $_SERVER['REQUEST_METHOD']);
    if($service == 'login') {
      $data = json_decode($respuesta, true);
      if($data['status'] == 'success') {
        $_SESSION["id_user"]=$data['result']['id_usuario'];
        $_SESSION["tipo_user"]=$data['result']['tipo'];
        $_SESSION["usuario"]=$data['result'];
      }
    }
    die($respuesta);
  }
}