<?php 

class Router {
  
  private $load_page = 'inicio'; //default
  private $include_page = '';
  private $page_access = [];
  public function __construct($page = null, $page_user=null) {
    if($page) {
      $this->load_page = $page;
    }
    $this->page_access = ($page_user)? $page_user:[$this->load_page]; //[]
  }

  public function load_page() {
    switch ($this->load_page) {
      case 'inicio':
        $this->include_page = 'welcome.php';
        break;
      case 'departamento':
        $this->include_page = 'pages/catalogos/departamentos.php';
        break;
        break;
      case 'areas':
        $this->include_page = 'pages/catalogos/area_salud.php';
        break;
      case 'forms':
        $this->include_page = 'pages/system/ej_form.php';
        break;
      case 'tables':
        $this->include_page = 'pages/system/ej_table.php';
        break;
      
      default:
        $this->include_page = 'pages/system/no_found.php';
      break;
    }  

    if(!in_array($this->load_page, $this->page_access)) {
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
    $carpeta_proyecto = explode('/', $_SERVER['REDIRECT_URL'])[1];
    $carpeta_proyecto = (trim($carpeta_proyecto) == '')? '': $carpeta_proyecto.'/';
    return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'] . '/' . $carpeta_proyecto . trim($url);
  }

 }
