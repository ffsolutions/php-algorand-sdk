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
          $return=$wallet->key_balance($key_id);
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
        $wallet_token=$wallet->token($wallet_id,$wallet_password);

        $return=$wallet->send($wallet_token,$wallet_password,$key_id,$to,$amount,$note);

        echo $wallet->json_print($return['response']);

        exit();
     break;
}
?>
