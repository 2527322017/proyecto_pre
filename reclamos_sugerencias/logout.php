<?php
session_start();
$_SESSION["id_user"]=0;
$_SESSION["tipo_user"]='';
$_SESSION["usuario"]=[];

unset($_SESSION["id_user"]);
unset($_SESSION["tipo_user"]);
unset($_SESSION["usuario"]);

if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
  );
}

// Finalmente, destruir la sesión.
session_destroy();

header('Location: login');
exit;