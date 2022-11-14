<?php 

class Preparar_data {
  private $datos_sesion = [];

  public function __construct($datos_sesion = null) {
    $this->datos_sesion = $datos_sesion;
  }

  public function get_datos_form()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    if(!is_array($data)) {
      parse_str(file_get_contents('php://input'),$data);
    }
    return (count($_POST) > 0)? $_POST:$data;
  }

  public function get_endpoint($request)
  {
    $srv = (isset($request['service']) && trim($request['service']) != '')? trim($request['service']):'';
    $srv = ($srv == '' && isset($_GET['service']) && trim($_GET['service']) != '')? trim($_GET['service']):'';
    return $srv;
  }

  public function get_id_registro($request)
  {
    $id_reg = (isset($request['id']) && trim($request['id']) != '')? trim($request['id']):'';
    $id_reg = ($id_reg == '' && isset($_GET['id']) && trim($_GET['id']) != '')? trim($_GET['id']):'';
    return $id_reg;
  }

  public function get_request_session($request)
  {
    $request_new = $request;
    if(isset($this->datos_sesion['id_user']) && $this->datos_sesion['id_user'] > 0) {
      $request_new['id_user']=$this->datos_sesion['id_user']; //enviar el id de usuario
      $request_new['tipo_user']=$this->datos_sesion['tipo_user']; //enviar el tipo de usuario
      $is_board = 0;
      if(substr_count($_SERVER['HTTP_REFERER'], 'board') > 0) {
        $is_board = 1;
      }
      $request_new['is_board']=$is_board; //identificar la peticion del tablero


      if($this->datos_sesion['tipo_user'] == 3) { //cliente
        $request_new['usuario_cliente_id']=$this->datos_sesion['id_user']; //enviar el id de usuario cliente
      }
   }
   
    return $request_new;
  }

  public function set_session($response)
  {
    $data = json_decode($response, true);
    if($data['status'] == 'success') {
      $_SESSION["id_user"]=$data['result']['id_usuario'];
      $_SESSION["tipo_user"]=$data['result']['tipo'];
      $_SESSION["usuario"]=$data['result'];
    }
  }



  public function archivos_caso() {
    $n_archivos = [];
    if(isset($_FILES) && count($_FILES) > 0) { 
        // contar el numero de archivos seleccionados
        $total_count = count($_FILES['adjuntar_archivos']['name']);
        // recorrer cada archivo
        for( $i=0 ; $i < $total_count ; $i++ ) {
          //obtener la ubicacion temporal del archivo.
          $tmpFilePath = $_FILES['adjuntar_archivos']['tmp_name'][$i];
          //verificar que aun este almacenado dicho archivo (memoria temporal)
          if ($tmpFilePath != "") {
          //Configurar la nueva ruta del archivo.
          $unique = time();
          $nameFile = $unique.'_'.str_replace(' ', '_', preg_replace('([^A-Za-z0-9 .])', '', $_FILES['adjuntar_archivos']['name'][$i]));
          $newFilePath = "../../uploads/" . $nameFile;
          $fileSize = filesize($tmpFilePath);
          $array_extension = explode('.', $nameFile);
            //Mover de la memoria temporal al directorio oficial
            if(@move_uploaded_file($tmpFilePath, $newFilePath)) {
            //crear el array para guardar en la db (lo usara el backend)
            $n_archivos[] = array(
              'nombre' => $nameFile,
              'ruta' => "uploads/" . $nameFile,
              'peso' => ($fileSize > 0)? $fileSize:0,
              'extension' => end($array_extension),
            );
            }

          }

        }
    }
   return $n_archivos;
   
  }

 }
