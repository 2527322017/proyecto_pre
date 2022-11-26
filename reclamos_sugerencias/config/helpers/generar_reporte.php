<?php 
 session_start();
include("router.php");
$v = phpversion(); 
$vn = intval(substr($v,0,1)) ;
if($vn == 8) {
  require_once __DIR__ . '/mpdf/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'Legal']);
} else {
  require_once __DIR__ . '/mpdf7/mpdf.php';
  $mpdf=new mPDF('c','Legal'); 
}

$router = new Router();
$host = $router->base_url();

$array_reportes = [
  "reporte_resoluciones", 
  "reporte_tipo_registro"
];

if($_GET && isset($_GET['file_reporte']) && in_array(trim($_GET['file_reporte']), $array_reportes)) {
  $file = trim($_GET['file_reporte']);
  $_POST['usuario'] = $_SESSION['usuario']['usuario'];
  include($file.".php");
} else {
  header("Location: $host");
}

