<?php 
 include("../api.php");

 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  $data = json_decode(file_get_contents('php://input'), true);
  $request = (count($_POST) > 0)? $_POST:$data;
  $service = (isset($request['service']) && trim($request['service']) != '')? trim($request['service']):'';
  $service = ($service == '' && isset($_GET['service']) && trim($_GET['service']) != '')? trim($_GET['service']):'';
 

  if($service != '') {
    $API = new API($service);
   
    $respuesta = $API->call_api($request, $_SERVER['REQUEST_METHOD']);
    die($respuesta);
  }
}