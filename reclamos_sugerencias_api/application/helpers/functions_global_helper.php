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
    return '';
    $telefono = (trim($telefono) != '')? preg_replace('/\D/', '', $telefono):'';
    $mensaje = (trim($mensaje) != '')? trim($mensaje):'';
    if($telefono == '' || $mensaje == '' ) {
        return ['error'=>'campos requeridos, SMS no enviado'];
    }
    //https://apismsrene.herokuapp.com/api/notificaciones
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://apimensajes.herokuapp.com/api/mensajes',
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
    return "";
    $data = [];
    $data['mensaje'] = $html_mensaje;
    $data['correo'] = $correo;
    $data['name'] = $name;
    $data['copias'] = [
        'reymundo0792@hotmail.com' =>'Rene'
    ];
    $curl = curl_init('https://ferreteriavidri.com/public/back/sendMail/sendMail.php');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function generate_password($longitud = 5)
{ 
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input = $permitted_chars;
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $longitud; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}

function sendMailLocal($correo='', $name = "", $html_mensaje = "")
{
    // Load PHPMailer library
    //$this->load->library('phpmailer_lib');
    // PHPMailer object
    //$mail = $this->phpmailer_lib->load();
    require_once APPPATH.'third_party/PHPMailer-6.6.5/src/Exception.php';
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
    $mail->Username = '1e9232f5-9cbd-4809-b217-6b45d81f5f70';
    $mail->Password = '1e9232f5-9cbd-4809-b217-6b45d81f5f70';
    $mail->setFrom('2527322017@mail.utec.edu.sv', 'Sistema de reclamos');
    $mail->addAddress($correo, $name);
    $mail->Subject = "Seguimiento de caso";
    $mail->CharSet = 'UTF-8';
    $mail->addBCC('reymundo0792@hotmail.com');

    
    $mail->msgHTML($html_mensaje);
    if($mail->Send()) {
        return "Correo enviado con exito";
    }	
    else {
        return "Error en enviar correo. ". $mail->ErrorInfo;
    }
}

function get_estado_seguimiento($estado = null) {
    $status = 1;
    if($estado) {
        if(is_numeric($estado) && $estado > 0) { //si es numero retornar string
            $status = 'Registrado';
            switch (intval($estado)) {
                case 2:
                    $status = 'Asignado';
                    break;
                case 3:
                    $status = 'Análisis';
                    break;
                case 4:
                    $status = 'Verificación';
                    break;
                case 5:
                    $status = 'Finalizado';
                    break;
                default:
                    $status = 'Registrado';
                    break;
            }
         }
         else if(trim($estado) != '') {
            $status = 1;
            switch (trim($estado)) {
                case 'Asignado':
                    $status = 2;
                    break;
                case 'Análisis':
                    $status = 3;
                    break;
                case 'Verificación':
                    $status = 4;
                    break;
                case 'Finalizado':
                    $status = 5;
                    break;
                default:
                    $status = 1;
                    break;
            }
         }

    }
    return $status;
}
