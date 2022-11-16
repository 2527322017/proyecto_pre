<?php
session_start();
//preguntar si no hay sesion activa.
if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0) {
  header('Location: page/');
  exit;
}
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
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="js/sweetalert/sweetalert2.min.css">
    <script src="js/sweetalert/sweetalert2.min.js"></script>


    <style type="text/css">
      .login_form, .registration_form { background: #f7f7f7ed; padding: 25px; border-radius: 10px; box-shadow: 0px 0px 7px 9px #004360;}
      label.error { color: red; float: left;}
      #titleRecover:before, #titleRecover:after {
        background: none !important;
      }

      .login {
        background-image: url('images/background_login.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
      }

   </style>
       <!-- jQuery -->
   <script src="js/jquery/jquery.min.js"></script>
   <script src="js/validate/jquery.validate.min.js"></script>
   <script async>(function(w, d) { var h = d.head || d.getElementsByTagName("head")[0]; var s = d.createElement("script"); s.setAttribute("type", "text/javascript"); s.setAttribute("src", "https://app.bluecaribu.com/conversion/integration/dc9c7f280cf3e917fa4be626eb97ea93"); h.appendChild(s); })(window, document);</script>
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" id="frmLogin">
              <h1>Iniciar Sesión</h1>
              <div>
                <input type="text" class="form-control" placeholder="Usuario/Correo" name="usuario" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contraseña" name="clave" required />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" style="border: 1px solid gray; width: 100%;">Ingresar</button>
                <a class="btn btn-default"  style="border: 1px solid gray; width: 100%;"  href="page/reclamo">Ingresar Reclamo / Sugerencia (sin sesión)</a>
              </div>

              <div class="clearfix"></div>
              <div class="separator">
                <p class="change_link">
                  <a href="#signup" class="to_register"> ¿Olvidé mi contraseña?</a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><i class="fa fa-book"></i> Reclamos / Sugerencias</h1>
                  <p>
                    Hospital Especializado Rosales
                    <br />©<?=date('Y')?> Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form id="frmRecuperar">
              <h2 id="titleRecover">Recuperar contraseña</h2>
              <div class="clearfix"></div>
                <br />
              <div>
                <input type="email" class="form-control" name="correo" placeholder="Correo electrónico" required="" />
              </div>
              <div class="clearfix"></div>
                <br />
                
              <div>
              <button type="submit" class="btn btn-default submit" style="border: 1px solid gray; width: 100%;">Recuperar contraseña</button>
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <p class="change_link">¿Ya tienes usuario?
                  <a href="#signin" class="to_register"> Iniciar sesión </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-book"></i> Reclamos / Sugerencias</h1>
                  <p>
                    Hospital Especializado Rosales
                    <br />©<?=date('Y')?> Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
    <script src="js/pages/login.js"></script>
  </body>
</html>
