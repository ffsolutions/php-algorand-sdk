
## Overview

This solution describes how to use and create a Algorand Asset Manager Application (WebApp GUI) with the new PHP Algorand SDK (native).

Algorand Node's KMD service was used for key management.

PHP is a popular general-purpose scripting language that is especially suited to web development.

![Algorand Asset Manager PHP GUI](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/examples/asset-manager-gui/preview.png)

# Features

-   Load Wallet Accounts
-   Create Asset (ASA and NFT)
-   Delete Asset
-   Reconfigure Asset
-   Destroy Asset
-   Freeze Asset
-   Unfreeze Asset
-   Get Account Balance
-   Get Asset Info
-   Receive Assets
-   Send Assets
-   Get Transaction Info

# Requirements

-   PHP 7.2 and above.
-   Built-in libcurl support.
-   PHP Algorand SDK
-   JQuery (any version)
-   Algorand node (algod and kmd services running)

Complete PHP Algorand SDK references and examples at:  [https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk)

# Demo Video
![Algorand Asset Manager PHP GUI](https://img.youtube.com/vi/MM7Xm93fcKE/maxresdefault.jpg "Algorand Asset Manager PHP GUI")
https://www.youtube.com/watch?v=MM7Xm93fcKE

# 1- Organize your Project

Create a file structure like the image below:  
![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/examples/asset-manager-gui/file-structure.png)

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
<title>Algorand Asset Manager PHP</title>
</head>

<body>
    <main id="wallet">
          <h1>Algorand Asset Manager PHP</h1>
          <div id="left">
              <h2>Wallets</h2>
              <select id="wallets">

              </select>

              <input type="password" id="wallet_password" placeholder="password">
              <input type="button" id="wallet_load_keys" value="Load Keys">
              &nbsp; &nbsp;

              <a href="../wallet-gui">Wallet / Key Manager</a>

              <br>
              <h2>Keys / From</h2>
              <select id="keys" multiple>

              </select>

              <br>
              <input type="button" id="key_copy" value="Copy Key">
              <input type="button" id="key_balance" value="Balance">
              <input type="button" id="key_load_assets" value="Load Assets">

               <h2 id="asset_title">Assets</h2>
              <input type="text" id="asset_id" placeholder="Asset ID"> <input type="button" id="asset_optin" value="Opt-in">
              <select id="assets" multiple>

              </select>
              <input type="text" id="transaction_id" value="" placeholder="Transaction ID"> <input type="button" id="transaction_info" value="Get Info">
              <br><br>
              <input type="button" id="asset_info" value="Info">
              <input type="button" id="asset_send" value="Send">
              <input type="button" id="asset_create" value="Create ASA">
              <input type="button" id="asset_create_nft" value="Create NFT">
              <input type="button" id="asset_reconfigure" value="Reconfigure">
              <input type="button" id="asset_destroy" value="Destroy">
              <input type="button" id="asset_freeze" value="Freeze">
              <input type="button" id="asset_unfreeze" value="Unfreeze">

          </div>
          <div id="right">
              <div id="asset_box_send" >
                  <h2>Send</h2>
                  To<br>
                  <input type="text" id="to" placeholder="Key">
                  <br>
                  Note<br>
                  <input type="text" id="note" placeholder="Note">
                  <br>
                  Clawback<br>
                  <input type="text" id="clawback" placeholder="Clawback Address (Optional)">
                  Amount<br>
                  <input type="number" id="amount" placeholder="micro"> <input type="button" id="send" value="Send">
              </div>
              <div id="asset_box_studio" style="display: none;">
                  <h2>Create Asset</h2>
                  <span>Asset Name<br>
                  <input type="text" id="asset_name" placeholder=""></span>
                  <span>Unit Name<br>
                  <input type="text" id="unit_name" placeholder=""></span> <span>Decimals <input type="number" id="decimals" placeholder="micro"></span> <span>Total <input type="number" id="total" placeholder="micro"></span>
                  <br>
                  <span>URL<br>
                  <input type="text" id="url" placeholder=""></span>
                  <span>Clawback Address<br>
                  <input type="text" id="clawback_address" placeholder=""></span>
                  <span>Freeze Address<br>
                  <input type="text" id="freeze_address" placeholder=""></span>
                  <span>Reserve Address<br>
                  <input type="text" id="reserve_address" placeholder=""></span>
                  <span>Manager Address<br>
                  <input type="text" id="manager_address" placeholder=""></span>
                  <p id="nft" style="display: none;">
                      Meta Data Hash <input type="button" id="meta_hash" value="Get Hash" title="Get Meta Data Hash from Note Json"><br>
                      <input type="text" id="meta_data_hash" placeholder="(Optional)">
                      Note<br>
                      <textarea id="asset_note">{
    "type": "image",
    "url": "http://site.com/image.jpg"   
}</textarea>
                  </p>

                  <p><input type="button" id="send_asset" value="Send"></p>
              </div>

              <h2>Output</h2>
              <textarea id="wallet_output"></textarea>
              <input type="text" id="tmp" value="">
              <input type="hidden" id="transaction_type" value="send">
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
a:link, a:visited{
  color: #003399;
  text-decoration: none;
}
a:hover{
  color: #0066cc;
  text-decoration: none;
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
    line-height: 25px;
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

#keys, #assets{
  width: 90%;
  height: 108px;
}

#wallet #left input[type=password]{
  width: 200px;
}

#wallet #right textarea{
  width: 100%;
  height: 150px;
}
#wallet #right select{
  width: 100%;
}

#wallet #right input[type=text]{
  width: 100%;
}

#unit_name{
    width: inherit !important;
}

#transaction_id{
  width: 80% !important;
}

#asset_title{
    margin-bottom: 0px;
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
          wallet.list_keys();
      });

      $("#key_copy").click(function(){
        $("#tmp").val($("#keys option:selected").val());
        $("#tmp").focus();
        $("#tmp").select();
        document.execCommand('copy');
      });

      $("#key_load_assets").click(function(){
          wallet.list_assets();
      });

      $("#keys").change(function(){
          wallet.list_assets();
      });

      $("#transaction_info").click(function(){
          wallet.transaction_info();
      });

      $("#key_balance").click(function(){
          wallet.key_balance();
      });

      $("#asset_info").click(function(){
          wallet.asset_info();
      });

      $("#asset_optin").click(function(){
          wallet.asset_optin();
      });

      $("#send, #send_asset").click(function(){
          wallet.send();
      });

      $("#asset_send").click(function(){
          $("#transaction_type").val("send");
          $("#asset_box_send").slideDown();
          $("#asset_box_studio").slideUp();
      });

      $("#asset_create").click(function(){
          $("#asset_box_studio h2").html("Create ASA");
          $("#transaction_type").val("create_asa");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown();
          $("#nft").slideUp();
      });
      $("#asset_create_nft").click(function(){
          $("#asset_box_studio h2").html("Create NFT");
          $("#transaction_type").val("create_nft");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown();
          $("#nft").slideDown();
          $("#asset_box_studio #decimals").parent().css("display","none");
          $("#asset_box_studio #total").parent().css("display","none");
      });
      $("#asset_reconfigure").click(function(){
          $("#asset_box_studio h2").html("Reconfigure Asset");
          $("#transaction_type").val("reconfigure");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
          });

          $("#nft").slideUp();
      });

      $("#asset_destroy").click(function(){
          $("#asset_box_studio h2").html("Destroy Asset");
          $("#transaction_type").val("destroy");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
              $("#asset_box_studio #clawback_address").parent().css("display","none");
              $("#asset_box_studio #freeze_address").parent().css("display","none");
              $("#asset_box_studio #reserve_address").parent().css("display","none");
              $("#asset_box_studio #manager_address").parent().css("display","none");
          });
          $("#nft").slideUp();
      });

      $("#asset_freeze").click(function(){
          $("#asset_box_studio h2").html("Freeze Account");
          $("#transaction_type").val("freeze");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
              $("#asset_box_studio #clawback_address").parent().css("display","none");
              $("#asset_box_studio #reserve_address").parent().css("display","none");
              $("#asset_box_studio #manager_address").parent().css("display","none");
          });
          $("#nft").slideUp();
      });

      $("#asset_unfreeze").click(function(){
          $("#asset_box_studio h2").html("Unfreeze Account");
          $("#transaction_type").val("unfreeze");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
              $("#asset_box_studio #clawback_address").parent().css("display","none");
              $("#asset_box_studio #reserve_address").parent().css("display","none");
              $("#asset_box_studio #manager_address").parent().css("display","none");
          });
          $("#nft").slideUp();
      });

      $("#meta_hash").click(function(){
          wallet.meta_hash();
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


     list_assets() {
        $.post(this.url, {
              action: "list_assets",
              wallet_id: $("#wallets option:selected").val(),
              wallet_password: $("#wallet_password").val(),
              key_id: $("#keys option:selected").val(),
            }).done(function( data ) {

              var obj = $.parseJSON(data);
              console.log(obj);
              $("#assets").html("");
              $.each(obj, function(index,itemx) {
                  $("#assets").append('<option value="' + index + '">' + itemx + '</option>');
              });

        });
      }

     asset_info() {
        $.post(this.url, {
              action: "asset_info",
              asset_id: $("#assets option:selected").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

     send() {

        var asset=$("#assets option:selected").val();
        if(asset ||  $("#transaction_type").val()=="create_asa" || $("#transaction_type").val()=="create_nft"){

          $.post(this.url, {
                action: "send",
                wallet_id: $("#wallets option:selected").val(),
                key_id: $("#keys option:selected").val(),
                wallet_password: $("#wallet_password").val(),
                transaction_type: $("#transaction_type").val(),
                asset_id: asset,
                clawback: $("#clawback").val(),
                to: $("#to").val(),
                amount: $("#amount").val(),
                note: $("#note").val(),
                asset_name: $("#asset_name").val(),
                unit_name: $("#unit_name").val(),
                decimals: $("#decimals").val(),
                total: $("#total").val(),
                url: $("#url").val(),
                clawback_address: $("#clawback_address").val(),
                freeze_address: $("#freeze_address").val(),
                reserve_address: $("#reserve_address").val(),
                manager_address: $("#manager_address").val(),
                meta_data_hash: $("#meta_data_hash").val(),
                asset_note: $("#asset_note").val(),

              }).done(function( data ) {
                $("#wallet_output").val(data);
                var obj = $.parseJSON(data);
                console.log(obj);
          });
        }else{
            alert("Select an Asset.");
        }
     }

      asset_optin() {
          $.post(this.url, {
                action: "asset_optin",
                wallet_id: $("#wallets option:selected").val(),
                key_id: $("#keys option:selected").val(),
                wallet_password: $("#wallet_password").val(),
                asset_id: $("#asset_id").val(),

              }).done(function( data ) {
                $("#wallet_output").val(data);
                var obj = $.parseJSON(data);
                console.log(obj);
          });
        }

     meta_hash() {
        $.post(this.url, {
              action: "meta_hash",
              asset_note: $("#asset_note").val(),
            }).done(function(data) {
              $("#meta_data_hash").val(data);
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

Open the  **index.html**  file in your browser and select a Wallet to get started.

Use Algorand Wallet PHP to create/manager your Wallets and Accounts if you haven't created yet (https://github.com/ffsolutions/php-algorand-sdk/tree/main/examples/wallet-gui).

Make sure you have selected a wallet (and entered the password) before listing the keys/accounts. Select a key with a ALGO funds before sending funds or create/manager the assets.

# Conclusion

This is just an example of the many possibilities available using the PHP SDK , other functions are available in the GitHub repository.  
Make sure to see the readme for instructions on setup and running the Algorand node and PHP SDK at GitHub ([https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk))

## License

MIT license.

([https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE](https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE)).
