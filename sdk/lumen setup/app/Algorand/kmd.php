<?php
//References:
//    https://developer.algorand.org/docs/reference/rest-apis/kmd/

namespace App\Algorand;

use app\Algorand\b32;
use app\Algorand\msgpack;

class kmd
{
    // Configurations
    private $token;
    private $protocol;
    private $host;
    private $port;
    private $certificate;

    // Data
    public $debug=0;
    public $status;
    public $error;
    public $raw;
    public $response;

    public function __construct($token, $host = 'localhost', $port = 64988){

        $this->token      = $token;
        $this->host          = $host;
        $this->port          = $port;
        $this->protocol         = 'http';
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

        // cURL
        $options = array(
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_HTTPHEADER     => array(
                                        'X-KMD-API-Token: '.$this->token,
                                        ),
        );

        $tp=count($params);
        $params_url="";

        for($xp=0;$xp<$tp;++$xp){

            if(is_array($params[$xp])==false AND $xp>0){

               $params_url.="/".$params[$xp];

            }else{
              // Request
              if(!empty($params[$xp]['params'])){ $request = $params[$xp]['params']; }
              if(!empty($params[$xp]['body'])){ $request_body = $params[$xp]['body']; }
            }
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


        $url=$this->protocol."://".$this->host.":".$this->port."/".$method.$params_url;

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

    public function txn_encode($transaction,$opt_msgpack=false){

        $msgpack=new msgpack;

        $out=$transaction;
        ksort($out['txn']);



        if(!empty($out['txn']['fee'])) { $out['txn']['fee']=intval($out['txn']['fee']); }
        if(!empty($out['txn']['fv'])) { $out['txn']['fv']=intval($out['txn']['fv']); }
        if(!empty($out['txn']['gen'])) { $out['txn']['gen']=strval($out['txn']['gen']); }
        if(!empty($out['txn']['gh'])) { $out['txn']['gh']=strval($out['txn']['gh']); }
        if(!empty($out['txn']['grp'])) { $out['txn']['grp']=strval($out['txn']['grp']); }
        if(!empty($out['txn']['lv'])) { $out['txn']['lv']=intval($out['txn']['lv']); }
        if(!empty($out['txn']['note'])) { $out['txn']['note']=strval($out['txn']['note']); }
        if(!empty($out['txn']['gp'])) { $out['txn']['gp']=strval($out['txn']['gp']); }
        if(!empty($out['txn']['rekey'])) { $out['txn']['rekey']=strval($out['txn']['rekey']); }
        if(!empty($out['txn']['type'])) { $out['txn']['type']=strval($out['txn']['type']); }
        if(!empty($out['txn']['rcv'])) { $out['txn']['rcv']=strval($out['txn']['rcv']); }
        if(!empty($out['txn']['amt'])) { $out['txn']['amt']=intval($out['txn']['amt']); }
        if(!empty($out['txn']['aamt'])) { $out['txn']['aamt']=intval($out['txn']['aamt']); }
        if(!empty($out['txn']['close'])) { $out['txn']['close']=strval($out['txn']['close']); }
        if(!empty($out['txn']['xaid'])) { $out['txn']['xaid']=intval($out['txn']['xaid']); }
        if(!empty($out['txn']['apid'])) { $out['txn']['apid']=intval($out['txn']['apid']); }
        if(!empty($out['txn']['faid'])) { $out['txn']['faid']=intval($out['txn']['faid']); }
        if(!empty($out['txn']['caid'])) { $out['txn']['caid']=intval($out['txn']['caid']); }

        if(!empty($out['txn']['gh'])) { $out['txn']['gh']=base64_decode($out['txn']['gh']); }
        if(!empty($out['txn']['grp'])) { $out['txn']['grp']=b32::decode($out['txn']['grp']); }
        if(!empty($out['txn']['snd'])) { $out['txn']['snd']=b32::decode($out['txn']['snd']); }
        if(!empty($out['txn']['rcv'])) { $out['txn']['rcv']=b32::decode($out['txn']['rcv']); }
        if(!empty($out['txn']['close'])) { $out['txn']['close']=b32::decode($out['txn']['close']); }
        if(!empty($out['txn']['selkey'])) { $out['txn']['selkey']=b32::decode($out['txn']['selkey']); }
        if(!empty($out['txn']['votekey'])) { $out['txn']['votekey']=b32::decode($out['txn']['votekey']); }
        if(!empty($out['txn']['arcv'])) { $out['txn']['arcv']=b32::decode($out['txn']['arcv']); }
        if(!empty($out['txn']['asnd'])) { $out['txn']['asnd']=b32::decode($out['txn']['asnd']); }
        if(!empty($out['txn']['fadd'])) { $out['txn']['fadd']=b32::decode($out['txn']['fadd']); }
        if(!empty($out['txn']['apat'])) { $out['txn']['apat']=b32::decode($out['txn']['apat']); }
        if(!empty($out['txn']['apap'])) { $out['txn']['apap']=b32::decode($out['txn']['apap']); }
        if(!empty($out['txn']['apsu'])) { $out['txn']['apsu']=b32::decode($out['txn']['apsu']); }
        if(!empty($out['txn']['apfa'])) { $out['txn']['apfa']=b32::decode($out['txn']['apfa']); }
        if(!empty($out['txn']['apas'])) { $out['txn']['apas']=b32::decode($out['txn']['apas']); }

        if(!empty($out['txn']['apar']['am'])) { $out['txn']['apar']['am']=b32::decode($out['txn']['apar']['am']); }
        if(!empty($out['txn']['apar']['c'])) { $out['txn']['apar']['c']=b32::decode($out['txn']['apar']['c']); }
        if(!empty($out['txn']['apar']['f'])) { $out['txn']['apar']['f']=b32::decode($out['txn']['apar']['f']); }
        if(!empty($out['txn']['apar']['m'])) { $out['txn']['apar']['m']=b32::decode($out['txn']['apar']['m']); }
        if(!empty($out['txn']['apar']['r'])) { $out['txn']['apar']['r']=b32::decode($out['txn']['apar']['r']); }
        if(!empty($out['txn']['apar']['dc'])) { $out['txn']['apar']['dc']=intval($out['txn']['apar']['dc']); }
        if(!empty($out['txn']['apar']['t'])) { $out['txn']['apar']['t']=intval($out['txn']['apar']['t']); }


        $out=$msgpack->p($out['txn']);
        if($opt_msgpack==false){
            $out=base64_encode($out);
        }
        return $out;
    }

    public function pk_encode($array){
        $out=$array;
        $out=b32::decode($out);
        $out=base64_encode($out);
        return $out;
    }

    public function groupid($transactions){

       $msgpack=new msgpack;
       $txn="";
       $total=count($transactions);
       $txids=array();
       for($x=0; $x<$total; $x++){
          $raw_txn=$this->txn_encode($transactions[$x],true);
          $raw_txn=hash('sha512/256',"TX".$raw_txn,true);
          $txids[$x]=$raw_txn;
       }

        $group_list=array(
            'txlist' => $txids,
        );

        $encoded=$msgpack->p($group_list);
        $gid = hash('sha512/256',"TG".$encoded,true);

        $gid = b32::encode($gid);


        return $gid;
    }

     public function buffer($data){

          $data=unpack('H*', $data)[1];

         return $data;
     }
     public function spaces($data){

        $t=strlen($data);

        $out="";

        for($x=0;$x<$t;$x++){

          $out=$out.substr($data,$x,2);

          if($x<$t-2){
            $out=$out." ";

          }
          $x=$x+1;

        }
         return $out;

     }

}
?>
