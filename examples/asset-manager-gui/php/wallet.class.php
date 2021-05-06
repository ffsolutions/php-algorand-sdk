<?php
class Wallet{

    #Config
    protected $algod_token="";
    protected $algod_host="localhost";
    protected $algod_port=53898;
    protected $kmd_token="";
    protected $kmd_host="localhost";
    protected $kmd_port=7833;
    protected $genesis_hash="wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=";
    protected $genesis_id="mainnet-v1.0";
    public $algod;
    public $kmd;

    
    public function algod_init(){
       $this->algod=new Algorand_algod($this->algod_token,$this->algod_host,$this->algod_port);
    }

    public function kmd_init(){
       $this->kmd=new Algorand_kmd($this->kmd_token,$this->kmd_host,$this->kmd_port);
    }

    public function tests(){
       $algod=$this->algod->get("v2","status");
       $kmd=$this->kmd->get("versions");
       $output=array(
         "aldod" => $algod,
         "kmd" => $kmd
       );
       return $output;
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

    public function key_balance($address){
       return $this->algod->get("v1","account",$address);
    }

    public function key_transaction_info($address,$txid){
        return $this->algod->get("v1","account",$address,"transaction",$txid);
    }


    public function asset_list($address){
      //List Assets
      $assets=$this->algod->get("v1","account",$address);
      $assets_array=json_decode($assets['response']);
     
      //Format with Asset name
      $array_return=array();
      $array_return[-1]="ALGO = amount: ".$assets_array->amount;
      foreach ($assets_array->assets as $key => $value){
        $asset_id=intval($key);
        if($asset_id>0){
           $array=$this->algod->get("v2","assets",$asset_id);
           $array=json_decode($array['response']);
            if($array->params->name!=null){
                $array_return[$asset_id]=$array->params->name." - id: ".$array->index." = amount: ".$value->amount;
            }
        }
      } 
     
     $json=json_encode($array_return);
     return $json;
    }
    
    public function asset_info($asset_id){
         return $this->algod->get("v2","assets",$asset_id);
    }
    
    
    public function send($token,$wallet_password,$from,$transaction){

      #Get parameters for constructing a new transaction
      $param_return=$this->algod->get("v2","transactions","params");

      if($param_return['code']==200){
        $transaction_param=json_decode($param_return['response']);
      }else{
        return $param_return;
      }

      $fee=$transaction_param->{'min-fee'};
      $fv=$transaction_param->{'last-round'};
      $lv=$fv+1000;

      $txn_params=array(
              "txn" => array(
                      "fee" => $fee, //Fee
                      "fv" => $fv, //First Valid
                      "gen" => $this->genesis_id, // GenesisID
                      "gh" => $this->genesis_hash, //Genesis Hash
                      "lv" => $lv, //Last Valid
                      "snd" => $from, //Sender
                  ),
      );
    
      //Merge transaction with params
      $transaction['txn']=array_merge($txn_params["txn"],$transaction["txn"]);

      $params['params']=array(
         "transaction" => $this->kmd->txn_encode($transaction),
         "wallet_handle_token" => $token,
         "wallet_password" => $wallet_password
      );

      $return=$this->kmd->post("v1","transaction","sign",$params);


      if($return['code']==200){
        $r=json_decode($return['response']);
        $txn=base64_decode($r->signed_transaction);
      }else{
        return $return;
      }

      #Broadcasts a raw transaction to the network.
      $params['transaction']=$txn;
      return $this->algod->post("v2","transactions",$params);

    }

    public function json_print($json){
      $out=json_decode($json);
      $out=json_encode($out,JSON_PRETTY_PRINT);
      return $out;
    }


}
?>
