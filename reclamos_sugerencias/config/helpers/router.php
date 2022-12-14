<?php 
class Router {
  
  private $load_page = 'inicio'; //default
  private $include_page = '';
  private $page_access = [];
  public function __construct($page = null, $page_user=null) {
    if($page) {
      $this->load_page = $page;
    }
   // $this->page_access = ($page_user)? $page_user:[$this->load_page]; //[]
  }

  public function load_page() {
    switch ($this->load_page) {
      case 'inicio':
        $this->include_page = 'welcome.php';
        break;
      case 'departamento':
        $this->include_page = 'pages/catalogos/departamentos.php';
        break;
      case 'municipio':
        $this->include_page = 'pages/catalogos/municipio.php';
        break;
      case 'genero':
        $this->include_page = 'pages/catalogos/generos.php';
        break;
      case 'areas':
        $this->include_page = 'pages/catalogos/area_salud.php';
        break;      
      case 'reclamo':
        $this->include_page = 'pages/reclamos/nuevo_reclamo.php';
        break;
      case 'asignar_caso':
        $this->include_page = 'pages/reclamos/asignar_caso.php';
        break;
      case 'seguimiento_caso':
        $this->include_page = 'pages/reclamos/seguimiento_caso.php';
        break;
      case 'board_seguimiento':
        $this->include_page = 'pages/reclamos/board_seguimiento.php';
        break;
      case 'cliente':
        $this->include_page = 'pages/catalogos/tipo_cliente.php';
        break;      
      case 'tipo_documento':
        $this->include_page = 'pages/catalogos/tipo_documento.php';
        break;
      case 'tipo_registro':
        $this->include_page = 'pages/catalogos/tipo_registro.php';
        break;      
      case 'tipo_resolucion':
        $this->include_page = 'pages/catalogos/tipo_resolucion.php';
        break; 
      case 'usuario':
        $this->include_page = 'pages/catalogos/usuario.php';
        break;
      case 'consulta_estado':
        $this->include_page = 'pages/reclamos/consultar_estado.php';
        break;
      case 'reporte1':
        $this->include_page = 'pages/reportes/reclamos_resoluciones.php';
        break;
      case 'reporte2':
        $this->include_page = 'pages/reportes/casos_tipo_registro.php';
        break;
      case 'reporte3':
        $this->include_page = 'pages/reportes/estadistica_resolucion.php';
        break;
      case 'reporte4':
        $this->include_page = 'pages/reportes/estadistica_casos.php';
        break;
      case 'perfil':
        $this->include_page = 'pages/system/perfil.php';
        break;
      case 'preguntas_frecuentes':
        $this->include_page = 'pages/info/preguntas_frecuentes.php';
        break;
      case 'contactanos':
        $this->include_page = 'pages/info/contactanos.php';
        break;
      default:
        $this->include_page = 'pages/system/no_found.php';
        break;
    }  

    if((!in_array($this->load_page, $this->page_access) 
      && !in_array('all', $this->page_access) 
      &&  $this->load_page != 'inicio'
      && $this->include_page != 'pages/system/no_found.php'
      ) 
      || in_array('no_access', $this->page_access)
      ) {
      $this->include_page = 'pages/system/no_access.php';
    }

    include($this->include_page);
   // return $this->include_page;  
  }
  
  public function get_path_page() {
    return $this->load_page();
  }

  public function get_page_content($file)
  {
    ob_start();
    if(trim($file) != '') {
      include($file);
    }
    return ob_get_clean();
   
  }


  public function base_url($url=null) {
    $protocolo = (substr_count(strtolower($_SERVER['SERVER_NAME']), 'azure') > 0)? 'https':'http';
    $n_position = (substr_count($_SERVER['SERVER_NAME'],'azure') > 0)? 0:1;

    $carpeta_proyecto = explode('/', $_SERVER['REDIRECT_URL'])[$n_position];
    $carpeta_proyecto = (trim($carpeta_proyecto) == '')? '': $carpeta_proyecto.'/';
    return $protocolo.'://'.$_SERVER['HTTP_HOST'] . '/' . $carpeta_proyecto . trim($url);
  }

  public function carpeta_proyecto() {
    $carpeta_proyecto = explode('/', $_SERVER['REDIRECT_URL'])[1];
    $carpeta_proyecto = (trim($carpeta_proyecto) == '')? '/': $carpeta_proyecto.'/';
    return (substr_count($_SERVER['SERVER_NAME'],'azure') > 0)? '':$carpeta_proyecto;
  }

  public function set_pages_user($tipo_usuario) {
    if($tipo_usuario == 1) { //admin
      $this->page_access = ['all']; //all  = todas
    }
    else if($tipo_usuario == 2) { //tecnico encargado
      $this->page_access = ['reclamo', 'consulta_estado','seguimiento_caso', 'board_seguimiento', 'perfil', 'contactanos'];
    }
    else if($tipo_usuario == 3) { //usuario final
      $this->page_access = ['reclamo', 'consulta_estado', 'seguimiento_caso', 'perfil', 'contactanos'];
    } 
    else if($tipo_usuario == 4) { //usuario sin session
      $this->page_access = ['reclamo', 'consulta_estado', 'contactanos'];
    }  else {
      $this->page_access = ['no_acess'];
    }
  }

 }
