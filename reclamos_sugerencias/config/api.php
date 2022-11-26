<?php 

class API {
   private $URL_API = "https://sistemareclamoapi.azurewebsites.net/"; 
   private $URL_API_AZURE = "https://sistemareclamoapi.azurewebsites.net/"; 
   private $KEY_API = "a53e668b01cd159065efa4070c5c9844485edb6f8f01bb775ed9307e5716e97a"; 
   private $endPoint = '' ; 
   private $params = '' ; 

   public function __construct($endpoint = null) {
      $this->endPoint = $endpoint;
   }


   public function set_parametro($param) {
      $this->params = '/'.$param;
   }

   public function call_api($data = NULL, $method = NULL)
   {
      $data_send = (is_array($data))? json_encode($data):$data;
      $method = ($method)? $method:$_SERVER['REQUEST_METHOD'];
      //die($this->URL_API  . $this->endPoint . $this->params);
      $API_SERVER =  (substr_count(strtolower($_SERVER['SERVER_NAME']), 'azure') > 0)? $this->URL_API_AZURE:$this->URL_API;
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => $API_SERVER  . $this->endPoint . $this->params,
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

      if (curl_errno($curl)) {
         return curl_error($curl);
     }

      curl_close($curl);

      return  $response;
   }
}

?>