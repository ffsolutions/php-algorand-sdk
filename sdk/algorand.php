<?php
//References:
//    https://developer.algorand.org/docs/reference/rest-apis/algod/v2/
//    https://developer.algorand.org/docs/reference/rest-apis/kmd/
//    https://developer.algorand.org/docs/reference/rest-apis/indexer/

class Algorand_algod {

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

    public function __construct($token, $host = 'localhost', $port = 53898){

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
        $file="";
        $transaction="";

        // cURL
        $options = array(
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_HTTPHEADER     => array(
                                        'X-Algo-API-Token: '.$this->token,
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
}

class Algorand_kmd
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

class Algorand_indexer
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

    public function __construct($token, $host = 'localhost', $port = 8980){

        $this->token      = $token;
        $this->host          = $host;
        $this->port          = $port;
        $this->protocol         = 'http';
        $this->certificate = null;

    }

    public function debug($opt){

         $this->debug=$opt;

    }

    public function SSL($certificate = null){

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
                                        'X-Indexer-API-Token: '.$this->token,
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

                case 405:
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


class b32 {

    const  ALBT = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=';

    const  B2HEXP = '/[^A-Z2-7]/';

    const  MAPP = ['=' => 0b00000,'A' => 0b00000,'B' => 0b00001,'C' => 0b00010,'D' => 0b00011,'E' => 0b00100,'F' => 0b00101,'G' => 0b00110,'H' => 0b00111,'I' => 0b01000,'J' => 0b01001,'K' => 0b01010,'L' => 0b01011,'M' => 0b01100,'N' => 0b01101,'O' => 0b01110,'P' => 0b01111,'Q' => 0b10000,'R' => 0b10001,'S' => 0b10010,'T' => 0b10011,'U' => 0b10100,'V' => 0b10101,'W' => 0b10110,'X' => 0b10111,'Y' => 0b11000,'Z' => 0b11001,'2' => 0b11010,'3' => 0b11011,'4' => 0b11100,'5' => 0b11101,'6' => 0b11110,'7' => 0b11111,];

    public static function encode($string) {

        if ('' === $string) { return '';  }

        $encoded = '';

        $n = $bitLen = $val = 0;

        $len = strlen($string);

        $string .= str_repeat(chr(0), 4);

        $chars = (array) unpack('C*', $string, 0);

        while ($n < $len || 0 !== $bitLen) {

            if ($bitLen < 5) { $val = $val << 8;   $bitLen += 8; $n++; $val += $chars[$n]; }

            $shift = $bitLen - 5; $encoded .= ($n - (int)($bitLen > 8) > $len && 0 == $val) ? '=' : static::ALBT[$val >> $shift]; $val = $val & ((1 << $shift) - 1); $bitLen -= 5;

        }

        return $encoded;
    }

    public static function decode($base32String) {

        $base32String = strtoupper($base32String); $base32String = preg_replace(static::B2HEXP, '', $base32String);

        if ('' === $base32String || null === $base32String) { return ''; }

        $decoded = ''; $len = strlen($base32String); $n = 0; $bitLen = 5; $val = static::MAPP[$base32String[0]];

        while ($n < $len) {

            if ($bitLen < 8) { $val = $val << 5; $bitLen += 5; $n++; $pentet = $base32String[$n] ?? '=';

                if ('=' === $pentet) { $n = $len; }

                $val += static::MAPP[$pentet];

                continue;

            }

            $shift = $bitLen - 8; $decoded .= chr($val >> $shift); $val = $val & ((1 << $shift) - 1); $bitLen -= 8;

        }
        return $decoded;
    }
}



class msgpack
{
    private const UTF8_REGEX = '/\A(?: [\x00-\x7F]++  | [\xC2-\xDF][\x80-\xBF]  |  \xE0[\xA0-\xBF][\x80-\xBF]  | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  |  \xED[\x80-\x9F][\x80-\xBF]   |  \xF0[\x90-\xBF][\x80-\xBF]{2}  | [\xF1-\xF3][\x80-\xBF]{3}   |  \xF4[\x80-\x8F][\x80-\xBF]{2} )*+\z/x';

    private $fDStrBin=true;
    private $fFStr=true;
    private $fDArrMap=true;
    private $fFArr=true;
    private $fFF32=true;
    private $tmrs = [];

    public function p($value){

        if (is_int($value)) {
            return $this->pInt($value);
        }

        if (is_string($value)) {
            if ('' === $value) {
                return $this->fFStr || $this->fDStrBin ? "\xa0" : "\xc4\x00";
            }
            if ($this->fFStr) {
                return $this->pStr($value);
            }
            if ($this->fDStrBin && preg_match(self::UTF8_REGEX, $value)) {
                return $this->pStr($value);
            }

            return $this->pBin($value);
        }

        if (is_array($value)) {

            if ([] === $value) {
                return $this->fDArrMap || $this->fFArr ? "\x90" : "\x80";
            }

            if ($this->fDArrMap) {

                if (!isset($value[0]) && !array_key_exists(0, $value)) {
                    return $this->pMap($value);
                }

                return array_values($value) === $value
                    ? $this->pArray($value)
                    : $this->pMap($value);
            }

            return $this->fFArr ? $this->pArray($value) : $this->pMap($value);
        }

        if (is_null($value)) {
            return "\xc0";
        }

        if (is_bool($value)) {
            return $value ? "\xc3" : "\xc2";
        }

        if (is_float($value)) {
            return $this->pFloat($value);
        }

        if ($this->tmrs) {
            foreach ($this->tmrs as $transformer) {
                if (!is_null($packed = $transformer->p($this, $value))) {
                    return $packed;
                }
            }
        }

        if ($value instanceof Ext) {
            return $this->pExt($value->type, $value->data);
        }
    }

    public function pNil(){
        return "\xc0";
    }

    public function pBool($bool){
        return $bool ? "\xc3" : "\xc2";
    }

    public function pInt($int){

        if ($int >= 0) {

            if ($int <= 0x7f) {
                return chr($int);
            }

            if ($int <= 0xff) {
                return "\xcc".chr($int);
            }

            if ($int <= 0xffff) {
                return "\xcd".chr($int >> 8).chr($int);
            }

            if ($int <= 0xffffffff) {
                return pack('CN', 0xce, $int);
            }

            return pack('CJ', 0xcf, $int);
        }

        if ($int >= -0x20) {
            return chr(0xe0 | $int);
        }

        if ($int >= -0x80) {
            return "\xd0".chr($int);
        }

        if ($int >= -0x8000) {
            return "\xd1".chr($int >> 8).chr($int);
        }

        if ($int >= -0x80000000) {
            return pack('CN', 0xd2, $int);
        }

        return pack('CJ', 0xd3, $int);
    }

    public function pFloat($float){
        return $this->fFF32
            ? "\xca".pack('G', $float)
            : "\xcb".pack('E', $float);
    }

    public function pFloat32($float){
        return "\xca".pack('G', $float);
    }

    public function pFloat64($float){
        return "\xcb".pack('E', $float);
    }

    public function pStr($str){
        $length = strlen($str);

        if ($length < 32) {
            return chr(0xa0 | $length).$str;
        }

        if ($length <= 0xff) {
            return "\xd9".chr($length).$str;
        }

        if ($length <= 0xffff) {
            return "\xda".chr($length >> 8).chr($length).$str;
        }

        return pack('CN', 0xdb, $length).$str;

    }

    public function pBin($str){

        $length = strlen($str);

        if ($length <= 0xff) {
            return "\xc4".\chr($length).$str;
        }

        if ($length <= 0xffff) {
            return "\xc5".chr($length >> 8).chr($length).$str;
        }

        return pack('CN', 0xc6, $length).$str;

    }

    public function pArray($array){

        $data = $this->pArrayHeader(count($array));

        foreach ($array as $val) {
            $data .= $this->p($val);
        }

        return $data;

    }

    public function pArrayHeader($size){

        if ($size <= 0xf) {

            return chr(0x90 | $size);

        }

        if ($size <= 0xffff) {

            return "\xdc".chr($size >> 8).chr($size);

        }

        return pack('CN', 0xdd, $size);

    }

    public function pMap($map){
        $data = $this->pMapHeader(count($map));

        if ($this->fFStr) {

            foreach ($map as $key => $val) {

                $data .= is_string($key) ? $this->pStr($key) : $this->pInt($key);
                $data .= $this->p($val);

            }

            return $data;
        }

        if ($this->fDStrBin) {
            foreach ($map as $key => $val) {

                $data .= is_string($key)
                    ? (preg_match(self::UTF8_REGEX, $key) ? $this->pStr($key) : $this->pBin($key))
                    : $this->pInt($key);

                $data .= $this->p($val);
            }

            return $data;
        }

        foreach ($map as $key => $val) {

            $data .= is_string($key) ? $this->pBin($key) : $this->pInt($key);

            $data .= $this->p($val);
        }

        return $data;
    }

    public function pMapHeader($size){

        if ($size <= 0xf) {

            return chr(0x80 | $size);

        }

        if ($size <= 0xffff) {

            return "\xde".chr($size >> 8).chr($size);

        }

        return pack('CN', 0xdf, $size);

    }

    public function pExt($type, $data){

        $length = strlen($data);

        switch ($length) {

            case 1: return "\xd4".chr($type).$data;
            case 2: return "\xd5".chr($type).$data;
            case 4: return "\xd6".chr($type).$data;
            case 8: return "\xd7".chr($type).$data;
            case 16: return "\xd8".chr($type).$data;

        }

        if ($length <= 0xff) {

            return "\xc7".chr($length).chr($type).$data;

        }

        if ($length <= 0xffff) {

            return pack('CnC', 0xc8, $length, $type).$data;

        }

        return pack('CNC', 0xc9, $length, $type).$data;
    }
}

?>
