<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('API_KEY','a53e668b01cd159065efa4070c5c9844485edb6f8f01bb775ed9307e5716e97a');
function validar_acceso()
{
    $cabecera = getallheaders();
    if(!isset($cabecera['Authorization'])) {
        $response["error"] = true;	
        $response["message"] = "Acceso denegado. API KEY inválida";
        header("HTTP/1.1 401");
        die(json_encode($response));
    } else if($cabecera['Authorization'] != API_KEY) {
        $response["error"] = true;
        $response["message"] = "Acceso denegado. API KEY inválida";
        header("HTTP/1.1 401");
        die(json_encode($response));
    } 
}

function sendSMS($telefono="", $mensaje="")
{
    $telefono = (trim($telefono) != '')? preg_replace('/\D/', '', $telefono):'';
    $mensaje = (trim($mensaje) != '')? trim($mensaje):'';
    if($telefono == '' || $mensaje == '' ) {
        return ['error'=>'campos requeridos, SMS no enviado'];
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://apismsrene.herokuapp.com/api/notificaciones',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{   
        "telefono":"'.$telefono.'",
        "mensaje": "'.$mensaje.'"
    }',
    CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
}


function sendMail($correo='', $name = "", $html_mensaje = "")
{
    $data = [];
    $data['mensaje'] = $html_mensaje;
    $data['correo'] = $correo;
    $data['name'] = $name;
    $data['copias'] = [
        'reymundo0792@hotmail.com' =>'Rene',
    //	'zaivonner@gmail.com' =>'My hearth',
    ];
    $curl = curl_init('https://ferreteriavidri.com/public/back/sendMail/sendMail.php');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function sendMailBK($correo='', $name = "", $html_mensaje = "")
{
    // Load PHPMailer library
    //$this->load->library('phpmailer_lib');
    // PHPMailer object
    //$mail = $this->phpmailer_lib->load();

    require_once APPPATH.'third_party/PHPMailer-6.6.5/src/PHPMailer.php';
    require_once APPPATH.'third_party/PHPMailer-6.6.5/src/SMTP.php';
    
    //$mail = new PHPMailer;
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = false;
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.postmarkapp.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $mail->Password = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $mail->setFrom('sistema_reclamos@gmail.com', 'Sistema de reclamos');
    $mail->addAddress($correo, $name);
    $mail->Subject = "Seguimiento de caso";
    $mail->CharSet = 'UTF-8';
    
    $mail->msgHTML($html_mensaje);
    if($mail->Send()) {
        return "Correo enviado con exito";
    }	
    else {
        return "Error en enviar correo";
    }
}
