
## Overview

This solution describes how to use and create a Wallet Application (WebApp GUI) with the new PHP Algorand SDK (native).

We use the Algorand Node’s KMD service for key management.

PHP is a popular general-purpose scripting language that is especially suited to web development.

![Algorand Wallet PHP GUI](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/examples/wallet-gui/preview.png)

# Features

-   Create Wallet
-   Get Wallet Info
-   Rename Wallet
-   Load Wallet Accounts
-   Create Account
-   Delete Account
-   Get Account Balance
-   Receive Funds
-   Send Funds
-   Get Transaction Info

New features can be easily created with the PHP Algorand SDK

# Requirements

-   PHP 7.2 and above.
-   Built-in libcurl support.
-   PHP Algorand SDK
-   JQuery (any version)
-   Algorand node (algod and kmd services running)

Complete PHP Algorand SDK references and examples at:  [https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk)

# Vídeo Tutorial
![Algorand Wallet PHP GUI](https://img.youtube.com/vi/Ju1f5MrwJKA/maxresdefault.jpg "Algorand Wallet PHP GUI")
https://www.youtube.com/watch?v=Ju1f5MrwJKA

# 1- Organize your Project

Create a file structure like the image below:  
![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/examples/wallet-gui/file-structure.png)

# 2- Create the Graphical Interface

Include the code below in the  **index.html**  and  **css/main.css**  files:

### INDEX.HTML

```html
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
<title>Algorand Wallet PHP</title>
</head>

<body>
    <main id="wallet">
          <h1>Algorand Wallet PHP</h1>
          <div id="left">
              <h2>Wallets</h2>
              <select id="wallets" multiple>

              </select>
              <br><br>
              <input type="password" id="wallet_password" placeholder="password">
              <input type="text" id="wallet_name" placeholder="wallet name">

              <br>
              <br>
              <input type="button" id="wallet_info" value="Info">
              <input type="button" id="wallet_create" value="Create">
              <input type="button" id="wallet_rename" value="Rename">
              <input type="button" id="wallet_load_keys" value="Load Keys">

              <h2>Keys</h2>

              <select id="keys" multiple>

              </select>
              <input type="text" id="transaction_id" value="" placeholder="Transaction ID"> <input type="button" id="transaction_info" value="Get Info">
              <br><br>
              <input type="button" id="key_generate" value="Generate">
              <input type="button" id="key_balance" value="Balance">
              <input type="button" id="key_delete" value="Delete">
              <input type="button" id="key_copy" value="Copy Key">
          </div>
          <div id="right">
              <h2>Send</h2>
              To<br>
              <input type="text" id="to" placeholder="Key">
              <br><br>
              Note<br>
              <input type="text" id="note" placeholder="Note">
              <br><br>
              Amount<br>
              <input type="number" id="amount" placeholder="microAlgos"> <input type="button" id="send" value="Send">
              <h2>Output</h2>
              <textarea id="wallet_output"></textarea>
              <input type="text" id="tmp" value="">
          </div>
    </main>
</body>
</html>
```

### CSS/MAIN.CSS

```css
body{
  background-color: #FFFFFF;
  font-size: 16px;

}
#wallet{
  position: relative;
  width: 95%;
  margin-left: auto;
  margin-right: auto;
  overflow: hidden;
  clear: both;
  float: none;
}
#wallet #left{
  float: left;
  width: 50%;
}
#wallet #right{
  float: right;
  width: 50%;
}
#wallet h1{
  font-family: fantasy;
  font-size: 38px;
  text-align: center;
  margin-bottom: 0px;
}

#wallet h2{
  font-family: fantasy;
  font-size: 28px;
  text-align: left;
  font-family: cursive;
}

#wallet select{
  width: 90%;
  height: 120px;
}

#wallet #left input[type=text], #wallet #left input[type=password]{
  width: 45%;
}

#wallet #right textarea{
  width: 100%;
  height: 250px;
}

#wallet #right input[type=text]{
  width: 100%;
}

#transaction_id{
  width: 80% !important;
}
```

# 3- Create the Interface Scripts

Include the code below in the  **js/main.js**  file:

### JS/MAIN.JS

```js
$(document).ready(function(){

      wallet = new Wallet();
      wallet.list();

      $("#wallet_load_keys").click(function(){
        var id_wallet=$("#wallets").val();
          wallet.list_keys();
      });

      $("#key_copy").click(function(){
        $("#tmp").val($("#keys option:selected").val());
        $("#tmp").focus();
        $("#tmp").select();
        document.execCommand('copy');
      });

      $("#wallet_create").click(function(){
          wallet.create();
      });

      $("#wallet_rename").click(function(){
          wallet.rename();
      });

      $("#wallet_info").click(function(){
          wallet.info();
      });

      $("#transaction_info").click(function(){
          wallet.transaction_info();
      });

      $("#key_generate").click(function(){
          wallet.key_generate();
      });

      $("#key_balance").click(function(){
          wallet.key_balance();
      });

      $("#send").click(function(){
          wallet.send();
      });


      $("#key_delete").click(function(){
        var r = confirm("Are you sure you want to remove this key?");
          if (r == true) {
            wallet.key_delete();
          }
      });

});


class Wallet {

      url="php/controller.php";

      list() {
        $.post(this.url, {
              action: "list",
            }).done(function( data ) {
              var obj = $.parseJSON(data);
              $("#wallets").html("");
              $.each(obj.wallets, function(index,itemx) {
                    $("#wallets").append('<option value="' + itemx.id + '">' + itemx.name + '</option>');
          		});
        });
      }

      create() {
        $.post(this.url, {
              action: "create",
              wallet_name: $("#wallet_name").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list();
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      rename() {
        $.post(this.url, {
              action: "rename",
              wallet_id: $("#wallets option:selected").val(),
              wallet_name: $("#wallet_name").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list();
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      info() {
        $.post(this.url, {
              action: "info",
              wallet_id: $("#wallets option:selected").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      transaction_info() {
        $.post(this.url, {
              action: "transaction_info",
              key_id: $("#keys option:selected").val(),
              transaction_id: $("#transaction_id").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      key_generate() {
        $.post(this.url, {
              action: "key_generate",
              wallet_password: $("#wallet_password").val(),
              wallet_id: $("#wallets option:selected").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list_keys();
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      key_balance() {
        $.post(this.url, {
              action: "key_balance",
              key_id: $("#keys option:selected").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      key_delete() {
        $.post(this.url, {
              action: "key_delete",
              wallet_id: $("#wallets option:selected").val(),
              key_id: $("#keys option:selected").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list_keys();
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      list_keys() {
        $.post(this.url, {
              action: "list_keys",
              wallet_id: $("#wallets option:selected").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {

              var obj = $.parseJSON(data);
              console.log(obj);
              $("#keys").html("");
              $.each(obj.addresses, function(index,itemx) {
                  $("#keys").append('<option value="' + itemx + '">' + itemx + '</option>');
        			});

        });
      }

        send() {
          $.post(this.url, {

                action: "send",
                wallet_id: $("#wallets option:selected").val(),
                key_id: $("#keys option:selected").val(),
                wallet_password: $("#wallet_password").val(),
                to: $("#to").val(),
                amount: $("#amount").val(),
                note: $("#note").val(),

              }).done(function( data ) {
                $("#wallet_output").val(data);
                var obj = $.parseJSON(data);
                console.log(obj);
          });
        }


}
```

Download  **js/jquery.min.js**  at:  [https://jquery.com/download/](https://jquery.com/download/)

# 4- Creating the Wallet PHP Class and Application Controller

Include the code below in the  **php/wallet.class.php**  and  **php/controller.php**  files:

### PHP/WALLET.CLASS.PHP

```php
<?php
class Wallet{

    #Config
    protected $algod_token="";
    protected $algod_host="localhost";
    protected $algod_port=53898;
    protected $kmd_token="";
    protected $kmd_host="localhost";
    protected $kmd_port=7833;
    protected $genesis_hash="YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=";
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

```

### PHP/CONTROLLER.PHP

At line 2, change to the sdk path, If you downloaded the example from github, you don’t need to do anything.

```php
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

```

# 5- Configuring your Application

Edit the file  **php/wallet.class.php**  and change adding your node configuration.
```php
#Config
protected $algod_token="{ALGOD_TOKEN}";
protected $algod_host="{YOUR_HOST}";
protected $algod_port=53898;
protected $kmd_token="{KMD_TOKEN}";
protected $kmd_host="{YOUR_HOST}";
protected $kmd_port=7833;
protected $genesis_hash="YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=";
protected $genesis_id="mainnet-v1.0";`
```

# 6- Running the Application

Open the  **index.html**  file in your browser and Create a Wallet to get started.  
Make sure you have selected a wallet (and entered the password) before listing the keys. Select a key with a balance before sending funds.

# Conclusion

This is just an example of the many possibilities available using the PHP SDK , other functions are available in the GitHub repository.  
Make sure to see the readme for instructions on setup and running the Algorand node and PHP SDK at GitHub ([https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk))

## License

MIT license.

([https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE](https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE)).
