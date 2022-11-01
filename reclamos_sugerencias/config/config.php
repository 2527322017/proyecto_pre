<?php 
 include("helpers/router.php");

 $page = 'inicio';
 $is_page = ($_GET && isset($_GET['page']) && trim($_GET['page']) != "")? true:false;
 if($is_page) {
    $page = trim($_GET['page']);
 }
 $router = new Router($page);
 $host = $router->base_url();
 define("HOST", $host);

 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $is_page) {
    $path_page = $router->get_path_page();
    $router->get_page_content($path_page);
    die();
  }


?>