<?php
include("../../../sdk/algorand.php");
include("wallet.class.php");

$algod_token="4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7";
$algod_host="localhost";
$algod_port=53898;
$kmd_token="dcb406527f3ded8464dbd56e6ea001b9b17882cfcf8194c17069bb22816307ad";
$kmd_host="localhost";
$kmd_port=7833;

$wallet=new Wallet;
$wallet->kmd_init($kmd_token,$kmd_host,$kmd_port);
$algod = new Algorand("algod",$algod_token,$algod_host,$algod_port);
$algorand_transactions = new Algorand_transactions;


$action=$_POST['action'];
$wallet_id=$_POST['wallet_id'];
$wallet_password=$_POST['wallet_password'];
$wallet_name=$_POST['wallet_name'];
$key_id=$_POST['key_id'];
$transaction_id=$_POST['transaction_id'];
$to=$_POST['to'];
$amount=$_POST['amount'];
$note=$_POST['note'];

switch ($action) {
  case 'list':
        $return=$wallet->list();
        echo $return['response'];
        exit();
       break;

  case 'create':
          $return=$wallet->create($wallet_name,$wallet_password);
          echo $wallet->json_print($return['response']);
          exit();
       break;

  case 'rename':
          $return=$wallet->rename($wallet_name,$wallet_id,$wallet_password);
          echo $wallet->json_print($return['response']);
          exit();
        break;

  case 'info':
          $wallet_token=$wallet->token($wallet_id,$wallet_password);
          $return=$wallet->info($wallet_token);
          echo $wallet->json_print($return['response']);
          exit();
        break;

  case 'transaction_info':
          $return=$wallet->key_transaction_info($key_id,$transaction_id);
          echo $wallet->json_print($return['response']);
          exit();
      break;

  case 'key_balance':
          $return=$algod->get("v2","accounts",$key_id);
          echo $wallet->json_print($return['response']);
          exit();
      break;

  case 'key_delete':
          $wallet_token=$wallet->token($wallet_id,$wallet_password);
          $return=$wallet->key_delete($wallet_token,$key_id,$wallet_password);
          echo $wallet->json_print($return['response']);
          exit();
      break;

  case 'key_generate':
          $wallet_token=$wallet->token($wallet_id,$wallet_password);
          $return=$wallet->key_generate($wallet_token);
          echo $wallet->json_print($return['response']);
          exit();
        break;

  case 'list_keys':
          $wallet_token=$wallet->token($wallet_id,$wallet_password);
          $return=$wallet->key_list($wallet_token);
          echo $wallet->json_print($return['response']);
          exit();
      break;

  case 'send':
        

        #Get parameters for constructing a new transaction
        $param_return=$algod->get("v2","transactions","params");

        if($param_return['code']==200){
          $transaction_param=json_decode($param_return['response']);
        }else{
          return $param_return;
        }

        $fee=$transaction_param->{'min-fee'};
        $fv=$transaction_param->{'last-round'};
        $genesis_id=$transaction_param->{'genesis-id'};
        $genesis_hash=$transaction_param->{'genesis-hash'};
        $lv=$fv+1000;

        $transaction=array(
                "txn" => array(
                        "fee" => $fee, //Fee
                        "fv" => $fv, //First Valid
                        "gen" => $genesis_id, // GenesisID
                        "gh" => $genesis_hash, //Genesis Hash
                        "lv" => $lv, //Last Valid
                        "note" => $note, //You note
                        "snd" => $key_id, //Sender
                        "type" => "pay", //Tx Type
                        "rcv" => $to, //Receiver
                        "amt" => $amount, //Amount
                    ),
        );

        $transaction=$algorand_transactions->encode($transaction);

        //Sign Transaction
        $wallet_token=$wallet->token($wallet_id,$wallet_password);
        $txn_signed=$wallet->sign($wallet_token,$wallet_password,$transaction);

        #Broadcasts a raw transaction to the network.
        $params['transaction']=$txn_signed;
        $return=$algod->post("v2","transactions",$params);
        
        
        if($return['response']){
            echo $wallet->json_print($return['response']);
        }
        if($return['message']){
            echo $wallet->json_print($return['message']);
        }

        /*
          Array
          (
            [code] => 200
            [response] => {"txId":"AOS5ODVPULLEUVPZ6FJVYUYXTRRP7C4I767B4O2AD2YV5AMNVCLA"}

          )
        */


        
        exit();
     break;
}
?>
