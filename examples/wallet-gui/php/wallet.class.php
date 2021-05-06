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

    public function create($name,$password){
      $params['params']=array(
          "wallet_name" => $name,
          "wallet_password" => $password,
          "wallet_driver_name" => "sqlite",
      );
       return $this->kmd->post("v1","wallet",$params);

       /*
       Array
          (
             [code] => 200
             [response] => {
           "wallet": {
             "driver_name": "sqlite",
             "driver_version": 1,
             "id": "552284ca1503a10d73de88071c48314b",
             "mnemonic_ux": false,
             "name": "Wallet 2",
             "supported_txs": [
               "pay",
               "keyreg"
             ]
           }
          }
          )
       */
    }

    public function list(){
       $output=$this->kmd->get("v1","wallets");
       return $output;
       /*
        Array
        (
           [code] => 200
           [response] => {
         "wallets": [
           {
             "driver_name": "sqlite",
             "driver_version": 1,
             "id": "4596a5cb20ccbedcec668762449363c1",
             "mnemonic_ux": false,
             "name": "Carteira 1",
             "supported_txs": [
               "pay",
               "keyreg"
             ]
           },
        */
    }



    public function info($token){
        $params['params']=array(
            "wallet_handle_token" => $token,
        );
         return $this->kmd->post("v1","wallet","info",$params);
         /*
         Array
            (
               [code] => 200
               [response] => {
                   "wallet_handle": {
                     "expires_seconds": 59,
                     "wallet": {
                       "driver_name": "sqlite",
                       "driver_version": 1,
                       "id": "4596a5cb20ccbedcec668762449363c1",
                       "mnemonic_ux": false,
                       "name": "Carteira 1",
                       "supported_txs": [
                         "pay",
                         "keyreg"
                 ]
               }
             }
            }
            )
         */
    }
    public function rename($new_name,$id,$password){
      $params['params']=array(
          "wallet_id" => $id,
          "wallet_name" => $new_name,
          "wallet_password" => $password,
      );
      return $this->kmd->post("v1","wallet","rename",$params);
      /*
            Array
            (
              [code] => 200
              [response] => {
            "wallet": {
              "driver_name": "sqlite",
              "driver_version": 1,
              "id": "4596a5cb20ccbedcec668762449363c1",
              "mnemonic_ux": false,
              "name": "Wallet 1",
              "supported_txs": [
                "pay",
                "keyreg"
              ]
            }
            }
            )
      */
    }

    public function key_generate($token){
      $params['params']=array(
          "display_mnemonic" => false,
          "wallet_handle_token" => $token
      );
      return $this->kmd->post("v1","key",$params);
      /*
        Array
        (
            [code] => 200
            [response] => {
          "address": "PL7BZ57KTKBVE2OFRNEJ4Z6VSYZPBH5T5SKS7L3O3IMYXIU4QCDAXJNRMM"
        }
        )
      */
    }

    public function key_delete($token,$address,$password){
      $params['params']=array(
          "address" => $address,
          "wallet_handle_token" => $token,
          "wallet_password" => $password
      );
      return $this->kmd->delete("v1","key",$params);
      /*
        Array
        (
          [code] => 200
          [response] => {}
        )
      */
    }

    public function key_list($token){
      $params['params']=array(
          "wallet_handle_token" => $token
      );
      return $this->kmd->post("v1","key","list",$params);
      /*
          Array
          (
            [code] => 200
            [response] => {
          "addresses": [
            "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4",
            "PL7BZ57KTKBVE2OFRNEJ4Z6VSYZPBH5T5SKS7L3O3IMYXIU4QCDAXJNRMM"
          ]
          }
          )
      */
    }

    public function key_balance($address){
       return $this->algod->get("v1","account",$address);
       /*
          Array
          (
             [code] => 200
             [response] => {"round":12592543,"address":"DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4","amount":192999,"pendingrewards":0,"amountwithoutpendingrewards":192999,"rewards":0,"status":"Offline"}

          )
       */
    }

    public function key_transaction_info($address,$txid){
        return $this->algod->get("v1","account",$address,"transaction",$txid);
    }


    public function send($token,$wallet_password,$from,$to,$amount,$note=""){

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

      $transaction=array(
              "txn" => array(
                      "fee" => $fee, //Fee
                      "fv" => $fv, //First Valid
                      "gen" => $this->genesis_id, // GenesisID
                      "gh" => $this->genesis_hash, //Genesis Hash
                      "lv" => $lv, //Last Valid
                      "note" => $note, //You note
                      "snd" => $from, //Sender
                      "type" => "pay", //Tx Type
                      "rcv" => $to, //Receiver
                      "amt" => $amount, //Amount
                  ),
      );




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
      /*
          Array
          (
            [code] => 200
            [response] => {"txId":"AOS5ODVPULLEUVPZ6FJVYUYXTRRP7C4I767B4O2AD2YV5AMNVCLA"}

          )
      */

    }

    public function json_print($json){
      $out=json_decode($json);
      $out=json_encode($out,JSON_PRETTY_PRINT);
      return $out;
    }


}
?>
