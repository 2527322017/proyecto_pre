<?php 
session_start();
 include("helpers/router.php");

 $page = 'inicio';
 $is_page = ($_GET && isset($_GET['page']) && trim($_GET['page']) != "")? true:false;
 if($is_page) {
    $page = trim($_GET['page']);
 }
 $router = new Router($page);
 $tipo_usuario = 4; //default
 $nombre_usuario = "Invitado"; //default
//preguntar por la sesion del usuario.
 if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0) {
   $tipo_usuario = ($_SESSION['tipo_user'] > 0)? $_SESSION['tipo_user']:0;
   $nombre_usuario = $_SESSION['usuario']['nombre'];
}

$router->set_pages_user($tipo_usuario);

 $host = $router->base_url();
 define("HOST", $host);
 define("TYPE_USER", $tipo_usuario);
 define("NOMBRE_USUARIO", $nombre_usuario);

 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $is_page) {
    $path_page = $router->get_path_page();
    $router->get_page_content($path_page);
    die();
  }


?>