<?php
include("../../../sdk/algorand.php");
include("wallet.class.php");
$wallet=new Wallet;
$wallet->algod_init();
$wallet->kmd_init();


$action=$_POST['action'];
$wallet_id=$_POST['wallet_id'];
$wallet_password=$_POST['wallet_password'];
$wallet_name=$_POST['wallet_name'];
$key_id=$_POST['key_id'];
$asset_id=$_POST['asset_id'];
$transaction_id=$_POST['transaction_id'];
$transaction_type=$_POST['transaction_type'];
$clawback=$_POST['clawback'];
$to=$_POST['to'];
$amount=$_POST['amount'];
$note=$_POST['note'];
$asset_name=$_POST['asset_name'];
$unit_name=$_POST['unit_name'];
$decimals=$_POST['decimals'];
$total=$_POST['total'];
$url=$_POST['url'];
$clawback_address=$_POST['clawback_address'];
$freeze_address=$_POST['freeze_address'];
$reserve_address=$_POST['reserve_address'];
$manager_address=$_POST['manager_address'];
$meta_data_hash=$_POST['meta_data_hash'];
$asset_note=$_POST['asset_note'];


switch ($action) {
  case 'list':
        $return=$wallet->list();
        echo $return['response'];
        exit();
       break;

  case 'transaction_info':
          $return=$wallet->key_transaction_info($key_id,$transaction_id);
          echo $wallet->json_print($return['response']);
          exit();
      break;

  case 'key_balance':
          $return=$wallet->key_balance($key_id);
          echo $wallet->json_print($return['response']);
          exit();
      break;

  case 'list_keys':
          $wallet_token=$wallet->token($wallet_id,$wallet_password);
          $return=$wallet->key_list($wallet_token);
          echo $wallet->json_print($return['response']);
          exit();
      break;
        
  case 'list_assets':
          $return=$wallet->asset_list($key_id);
          echo $wallet->json_print($return);
          exit();
      break;
        
  case 'asset_info':
          $return=$wallet->asset_info($asset_id);
          echo $wallet->json_print($return['response']);
          exit();
      break;

   case 'asset_optin':
        $wallet_token=$wallet->token($wallet_id,$wallet_password);
        
        $transaction=array(
            "txn" => array(
                "type" => "axfer", //Tx Type
                "arcv" => $key_id, //AssetReceiver
                "xaid" => $asset_id, //XferAsset ID
            ),
        );
        
        $return=$wallet->send($wallet_token,$wallet_password,$key_id,$transaction);
       
        if($return['response']){
            echo $wallet->json_print($return['response']);
        }
        if($return['message']){
            echo $wallet->json_print($return['message']);
        }

        exit();       
        
  case 'send':
        if($transaction_type=="send"){
            if($asset_id=="-1"){ //ALGO
                $transaction=array(
                    "txn" => array(
                            "type" => "pay", //Tx Type
                            "note" => $note, //You note
                            "snd" => $key_id, //Sender
                            "rcv" => $to, //Receiver
                            "amt" => $amount, //Amount
                            "note" => $note, //You note
                        ),
                );
            }else{ //ASA
                if(!empty($clawback)){ //Clawback Transaction
                     $transaction=array(
                            "txn" => array(
                                    "type" => "axfer", //Tx Type
                                    "arcv" => $to, //AssetReceiver
                                    "asnd" => $key_id, //AssetSender
                                    "snd" => $clawback, //Sender
                                    "note" => $note, //You note
                                    "aamt" => $amount, //Amount
                                    "xaid" => $asset_id, //XferAsset ID
                                ),
                    );
                }else{ //Asset Default Transaction
                    $transaction=array(
                            "txn" => array(
                                    "type" => "axfer", //Tx Type
                                    "arcv" => $to, //AssetReceiver
                                    "snd" => $key_id, //Sender
                                    "note" => $note, //You note
                                    "aamt" => $amount, //Amount
                                    "xaid" => $asset_id, //XferAsset ID
                                ),
                    );
                }
            }
        }else if($transaction_type=="create_asa"){
            
            $transaction=array(
                "txn" => array(
                        "type" => "acfg", //Tx Type
                        "snd" => $key_id, //Sender
                        "apar" => array( //AssetParams
                                "an" => $asset_name, //AssetName
                                "au" => $url, //URL
                                "c" => $clawback_address, //ClawbackAddr
                                "dc" => $decimals, //Decimals
                                "f" => $freeze_address, //FreezeAddr
                                "m" => $manager_address, //ManagerAddr
                                "r" => $reserve_address, //ReserveAddr
                                "t" => $total, //Total
                                "un" => $unit_name, //UnitName
                            ),

                    ),
            );
            
        }else if($transaction_type=="create_nft"){
            $asset_note=str_replace("\n","",$asset_note);
            $asset_note=str_replace("\r","",$asset_note);
            $transaction=array(
                "txn" => array(
                        "type" => "acfg", //Tx Type
                        "snd" => $key_id, //Sender
                        "note" => $asset_note, //NFT json config
                        "apar" => array( //AssetParams
                                "am" => $meta_data_hash, //MetaDataHash
                                "an" => $asset_name, //AssetName
                                "au" => $url, //URL
                                "c" => $clawback_address, //ClawbackAddr
                                "dc" => 0, //Decimals
                                "f" => $freeze_address, //FreezeAddr
                                "m" => $manager_address, //ManagerAddr
                                "r" => $reserve_address, //ReserveAddr
                                "t" => 1, //Total
                                "un" => $unit_name, //UnitName
                            ),

                    ),
            );
            
        }else if($transaction_type=="reconfigure"){
            
            $transaction=array(
                    "txn" => array(
                            "type" => "acfg", //Tx Type
                            "snd" => $key_id, //Sender
                            "caid" => $asset_id,
                            "apar" => array( //AssetParams
                                    "c" => $clawback_address, //ClawbackAddr
                                    "f" => $freeze_address, //FreezeAddr
                                    "m" => $manager_address, //ManagerAddr
                                    "r" => $reserve_address, //ReserveAddr
                                ),

                        ),
            );
            
        }else if($transaction_type=="destroy"){
            
            $transaction=array(
                    "txn" => array(
                            "type" => "acfg", //Tx Type
                            "snd" => $key_id, //Sender
                            "caid" => $asset_id, //ConfigAsset ID
                        ),
            );
            
        }else if($transaction_type=="freeze"){
            $transaction=array(
                    "txn" => array(
                            "afrz" => true,
                            "type" => "afrz", //Tx Type
                            "fadd" => $freeze_address, //FreezeAccount
                            "snd" => $key_id, //Sender
                            "faid" => $asset_id, //FreezeAsset
                        ),
            );
            
        }else if($transaction_type=="unfreeze"){
            $transaction=array(
                    "txn" => array(
                            "afrz" => false,
                            "type" => "afrz", //Tx Type
                            "fadd" => $freeze_address, //FreezeAccount
                            "snd" => $key_id, //Sender
                            "faid" => $asset_id, //FreezeAsset
                        ),
            );
            
        }
        
        //echo $wallet->json_print(json_encode($transaction)); exit();
        
        $wallet_token=$wallet->token($wallet_id,$wallet_password);
        
        $return=$wallet->send($wallet_token,$wallet_password,$from,$transaction);
        
        if($return['response']){
            echo $wallet->json_print($return['response']);
        }
        if($return['message']){
            echo $wallet->json_print($return['message']);
        }

        exit();
     break;
        
    case "meta_hash":
        $json=json_decode($asset_note);
        if($json->url){
            $file_content=file_get_contents($json->url);
            $hash=strtoupper(hash('sha256',$file_content));
            echo $hash;
        }else{
            echo "Json error";   
        }
        exit();
        break;
}
?>
