<?php
 include("config/config.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de reclamos</title>
    <!-- Bootstrap -->
    <link href="<?=HOST?>css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=HOST?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="<?=HOST?>js/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?=HOST?>css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" />

    <!-- jQuery -->
    <script src="<?=HOST?>js/jquery/jquery.min.js"></script>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?=HOST?>" class="site_title"><i class="fa fa-book"></i> <span>Gestión reclamos</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?=HOST?>images/sistema.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bienvenid@,</span>
                            <h2>Admin</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>MENÚ</h3>
                            <ul class="nav side-menu">
                                <li><a href="<?=HOST?>"><i class="fa fa-home"></i> Inicio </a></li>
                                <li><a><i class="fa fa-edit"></i> Reclamos / Sugerencias <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="#">Nuevo reclamo/sugerencia</a></li>
                                        <li><a href="#">Consultar estado</a></li>
                                        <li><a href="#">Seguimiento de caso</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bar-chart-o"></i> Reportes <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="#">Reclamos y resoluciones</a></li>
                                        <li><a href="#">Total de sugerencias</a></li>
                                        <li><a href="#">Estadisticas por resolución</a></li>
                                        <li><a href="#">Estadisticas de sugerencias</a></li>
                                        <li><a href="<?=HOST?>page/forms">Forms</a></li>
                                        <li><a href="<?=HOST?>page/tables">Tables</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bar-chart-o"></i> Configuración <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=HOST?>page/departamento">Departamento</a></li>
                                        <li><a href="<?=HOST?>page/municipio">Municipio</a></li>
                                        <li><a href="<?=HOST?>page/genero">G&eacute;nero</a></li>
                                        <li><a href="<?=HOST?>page/tipo_cliente">Tipo de clientes</a></li>
                                        <li><a href="<?=HOST?>page/areas">Areas de salud</a></li>
                                        <li><a href="<?=HOST?>page/tipo_documento">Tipo documentos</a></li>
                                        <li><a href="<?=HOST?>page/tipo_registro">Tipo registro</a></li>
                                        <li><a href="<?=HOST?>page/tipo_resolucion">Tipo resoluciones</a></li>                                       
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>OTROS</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-comments"></i> Contactanos<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="#">Preguntas frecuentes</a></li>
                                        <li><a href="#">Telefonos</a></li>
                                        <li><a href="#">Redes sociales</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?=HOST?>images/user.png" alt="">Administrador
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"> Perfil</a>
                                    <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main" id="main_page">
                <?php $router->load_page(); ?>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Sistema de reclamos y sugerencias - &copy; Todos los derechos reservados 
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

        <!-- Bootstrap -->
    <script src="<?=HOST?>js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?=HOST?>js/iCheck/icheck.min.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="<?=HOST?>js/bootstrap/bootstrap-wysiwyg.min.js"></script>
    <script src="<?=HOST?>js/prettify.js"></script>
    <!-- Switchery -->
    
    <script src="<?=HOST?>js/switchery/switchery.min.js"></script>
    
    <script src="<?=HOST?>js/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?=HOST?>js/sweetalert/sweetalert2.min.css">
    <script src="<?=HOST?>js/validate/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="<?=HOST?>js/dataTable/jquery.dataTables.min.css">
    <script src="<?=HOST?>js/dataTable/jquery.dataTables.min.js"></script>


    <!-- Custom Theme Scripts -->
    <script src="<?=HOST?>js/custom.min.js"></script>
    <script src="<?=HOST?>js/master_page.js"></script>
    
</body>

</html>