<?php 

class API {
   private $URL_API = "http://localhost:8083/reclamos_sugerencias_api/"; 
   private $KEY_API = "a53e668b01cd159065efa4070c5c9844485edb6f8f01bb775ed9307e5716e97a"; 
   private $endPoint = '' ; 

   public function __construct($endpoint = null) {
      $this->endPoint = $endpoint;
   }

   public function call_api($data = NULL, $method = NULL)
   {
      $data_send = (is_array($data))? json_encode($data):$data;
      $method = ($method)? $method:$_SERVER['REQUEST_METHOD'];
     
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => $this->URL_API  . $this->endPoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS =>$data_send,
      CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $this->KEY_API,
      'Content-Type: application/json'
      ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return  $response;
   }
}

?>