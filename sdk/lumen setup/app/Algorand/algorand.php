<?php
//References:
//    https://developer.algorand.org/docs/reference/rest-apis/algod/v2/
//    https://developer.algorand.org/docs/reference/rest-apis/kmd/
//    https://developer.algorand.org/docs/reference/rest-apis/indexer/

namespace App\Algorand;

use App\Algorand\transactions;
use App\Algorand\b32;
use App\Algorand\msgpack;
use App\Algorand\algokey;


class Algorand {
    

    // Configurations
    private $token;
    private $protocol;
    private $host;
    private $port;
    private $certificate;
    private $external;
    private $service;

    // Data
    public $debug=0;
    public $status;
    public $error;
    public $raw;
    public $response;

    public function __construct($service,$token, $host = 'localhost', $port = 53898, $external = false){
        
        if($service!="algod" AND $service!="kmd" AND $service!="indexer"){
            echo 'Service not specified, use "algod", "kmd" or "indexer".';
            exit();
        }
        
        $this->token      = $token;
        $this->host       = $host;
        $this->port       = $port;
        $this->external   = $external;
        $this->service   = $service;

        if($this->external==true){
            $this->protocol = 'https';
        }else{
            $this->protocol = 'http';
        }
        $this->certificate = null;

    }

    public function debug($opt){

         $this->debug=$opt;

    }

    public function SSL($certificate = null) {

        $this->protocol         = 'https';
        $this->certificate = $certificate;

    }

    public function __call($type, $params){

        $this->status       = null;
        $this->error        = null;
        $this->raw = null;
        $this->response     = null;

        // Parameters
        $params = array_values($params);

        // Request Type
        $type=strtoupper($type);


        // Method
        $method=$params[0];

        $request="";
        $request_body="";
        $file="";
        $transaction="";

        // cURL
        $options = array(
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
        );
        
        if($this->external==true){
            $options[CURLOPT_HTTPHEADER][]='x-api-key: '.$this->token;
        }else{
            switch($this->service){
                case "algod":
                    $options[CURLOPT_HTTPHEADER][]='X-Algo-API-Token: '.$this->token;
                    break;
                case "kmd":
                        $options[CURLOPT_HTTPHEADER][]='X-KMD-API-Token: '.$this->token;
                    break;
                case "indexer":
                        $options[CURLOPT_HTTPHEADER][]='X-Indexer-API-Token: '.$this->token;
                    break;
            }
            
        }

        $tp=count($params);
        $params_url="";

        for($xp=0;$xp<$tp;++$xp){

            if(is_array($params[$xp])==false AND $xp>0){

               $params_url.="/".$params[$xp];

            }else{

              // Request
              if(!empty($params[$xp]['params'])){ $request = $params[$xp]['params']; }
              if(!empty($params[$xp]['body'])){ $request_body = $params[$xp]['body']; }

              // File
              if(!empty($params[$xp]['file'])){ $file=$params[$xp]['file']; }

              // Transaction
              if(!empty($params[$xp]['transaction'])){ $transaction=$params[$xp]['transaction']; }

            }
           
        }

        if($file!=""){
            if(file_exists($file)){
                $options[CURLOPT_HTTPHEADER][]='Content-type: application/x-binary';
                $request_body = file_get_contents($file);
            }
        }

        if($transaction!=""){
            if($this->external==true){
                $options[CURLOPT_HTTPHEADER][]='Content-type: application/x-binary';
            }
            $request_body = $transaction;
        }


        if($type=="POST"){

            $options[CURLOPT_POST]=true;
            if(!empty($request_body)){
                $options[CURLOPT_POSTFIELDS]=$request_body;
            }else{
                $options[CURLOPT_POSTFIELDS]=json_encode($request);
            }

        }

        if($type=="DELETE"){

            $options[CURLOPT_CUSTOMREQUEST]="DELETE";
            if(!empty($request_body)){
                $options[CURLOPT_POSTFIELDS]=$request_body;
            }else{
                if(is_array($request)){
                    $options[CURLOPT_POSTFIELDS]=json_encode($request);
                }
            }

        }
        
        if($this->external==true){
            $url=$this->protocol."://".$this->host."/".$method.$params_url;
        }else{
            $url=$this->protocol."://".$this->host.":".$this->port."/".$method.$params_url;
        }
        $curl    = curl_init($url);


        if(ini_get('open_basedir')) {
            unset($options[CURLOPT_FOLLOWLOCATION]);
        }

        if($this->protocol == 'https') {

            if ($this->certificate!="") {
                $options[CURLOPT_CAINFO] = $this->certificate;
                $options[CURLOPT_CAPATH] = DIRNAME($this->certificate);
            } else {
                $options[CURLOPT_SSL_VERIFYPEER] = false;
            }

        }


        curl_setopt_array($curl, $options);

        // Execute
        $this->raw = curl_exec($curl);

         // Get Status
        $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        //Json decode
        $this->response = $this->raw;

        // Filter Error
        $curl_error = curl_error($curl);

        curl_close($curl);

        if($curl_error!="") {
            $this->error = $curl_error;
        }

        $return="";

        if ($this->status != 200) {

            switch ($this->status) {
                case 400:
                    $this->error = 'BAD REQUEST';
                    break;
                case 401:
                    $this->error = 'UNAUTHORIZED';
                    break;
                case 403:
                    $this->error = 'FORBIDDEN';
                    break;
                case 404:
                    $this->error = 'NOT FOUND';
                    break;
                case 404:
                    $this->error = 'NOT ALLOWED';
                    break;
            }

      			$return = array(
      				"code" => $this->status,
      				"message" => $this->response,
      				);

      }else{

            $return = array(
				      "code" => $this->status,
				       "response" => $this->response,
            );

        }

        if($this->debug==1){

           $return['DEBUG']="ON";
           $return['url']=$url;
           $return['options']=$options;

        }
        return $return;

    }
}
?>
