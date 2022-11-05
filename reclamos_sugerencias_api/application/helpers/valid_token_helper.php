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
