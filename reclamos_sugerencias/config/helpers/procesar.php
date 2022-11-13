<?php 
 session_start();
 include("../api.php");

 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  $data = json_decode(file_get_contents('php://input'), true);
  if(!is_array($data)) {
    parse_str(file_get_contents('php://input'),$data);
  }
  $request = (count($_POST) > 0)? $_POST:$data;

  if(isset($_FILES) && count($_FILES) > 0) {
      // Count the number of uploaded files in array
      $total_count = count($_FILES['adjuntar_archivos']['name']);
      // Loop through every file
      $n_archivos = [];
      for( $i=0 ; $i < $total_count ; $i++ ) {
        //The temp file path is obtained
        $tmpFilePath = $_FILES['adjuntar_archivos']['tmp_name'][$i];
        //A file path needs to be present
        if ($tmpFilePath != ""){
            //Setup our new file path
            $nameFile = str_replace(' ', '_', preg_replace('([^A-Za-z0-9 .])', '', $_FILES['adjuntar_archivos']['name'][$i]));
            $newFilePath = "../../uploads/" . $nameFile;
            $fileSize = filesize($tmpFilePath);
            //File is uploaded to temp dir
            if(@move_uploaded_file($tmpFilePath, $newFilePath)) {
              $n_archivos[] = array(
                'nombre' => $nameFile,
                'ruta' => "uploads/" . $nameFile,
                'peso' => ($fileSize > 0)? $fileSize:0,
                'extension' => end(explode('.', $nameFile)),
              );
            }

        }

      }
      if(count($n_archivos) > 0) {
        $request['archivos'] = $n_archivos;
      }
  }
  //print_r($request);    print_r($_FILES); die();
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