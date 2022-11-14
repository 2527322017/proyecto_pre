<?php 
 session_start();
 require("../api.php");
 require("preparar_data.php");
 $prepare_data = new Preparar_data($_SESSION);

 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

 $request = $prepare_data->get_datos_form();

 $request['archivos'] = $prepare_data->archivos_caso();
 
 $service = $prepare_data->get_endpoint($request);

 if($service != '') {
    
    $service = str_replace('__','/',$service);
    $API = new API($service);
    //Para usar en editar o eliminar
    $id_registro = $prepare_data->get_id_registro($request);

    if($id_registro != '') {
      $API->set_parametro($id_registro);
    }

    //agregar variables de sesion a la peticion
    $request = $prepare_data->get_request_session($request);

    $respuesta = $API->call_api($request, $_SERVER['REQUEST_METHOD']);

    if($service == 'login') { //crear sesión de usuario
      $prepare_data->set_session($respuesta);
    }

    die($respuesta);
  }
}