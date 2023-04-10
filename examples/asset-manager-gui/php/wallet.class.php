<?php
class Wallet{
    public $kmd;

    public function kmd_init($kmd_token,$kmd_host,$kmd_port){
       $this->kmd=new Algorand("kmd",$kmd_token,$kmd_host,$kmd_port);
    }


    public function token($id,$password){
        $params['params']=array(
            "wallet_id" => $id,
            "wallet_password" => $password,
        );
        $return=$this->kmd->post("v1","wallet","init",$params);
        $return_array=json_decode($return['response']);
        $wallet_handle_token=$return_array->wallet_handle_token;
        return $wallet_handle_token;
    }


    public function list(){
       $output=$this->kmd->get("v1","wallets");
       return $output;
    }

    public function info($token){
        $params['params']=array(
            "wallet_handle_token" => $token,
        );
         return $this->kmd->post("v1","wallet","info",$params);
    }
    
    public function key_list($token){
      $params['params']=array(
          "wallet_handle_token" => $token
      );
      return $this->kmd->post("v1","key","list",$params);
    }
    
    public function sign($token,$wallet_password,$transaction){
     
      $params['params']=array(
         "transaction" => $transaction,
         "wallet_handle_token" => $token,
         "wallet_password" => $wallet_password
      );


      $return=$this->kmd->post("v1","transaction","sign",$params);


      if($return['code']==200){
        $r=json_decode($return['response']);
        return $txn=base64_decode($r->signed_transaction);
      }else{
        return $return;
      }

    }

    public function json_print($json){
      $out=json_decode($json);
      $out=json_encode($out,JSON_PRETTY_PRINT);
      return $out;
    }


}
?>
