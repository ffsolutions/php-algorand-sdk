
## Overview

This solution describes how to use and create a Algorand Blockchain Explorer Application (WebApp GUI) with the new PHP Algorand SDK (native).

We use the Algorand Indexer service.

PHP is a popular general-purpose scripting language that is especially suited to web development.

![Algorand Explorer PHP GUI](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/examples/explorer-gui/preview.png)

# Features

-   Addresses Explorer
-   Transactions Explorer
-   Blocks Explorer
-   Asset Explorer
-   Addresses Explorer
-   Applications Explorer

New features can be easily created with the PHP Algorand SDK

# Requirements

-   PHP 7.2 and above.
-   Built-in libcurl support.
-   PHP Algorand SDK
-   JQuery (any version)
-   Algorand node (algod and indexer services running)
-   Postgres database

Complete PHP Algorand SDK references and examples at:  [https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk)

# Vídeo Tutorial
![Algorand Explorer PHP GUI](https://img.youtube.com/vi/b__DhRzAex0/maxresdefault.jpg "Algorand Explorer PHP GUI")
https://www.youtube.com/watch?v=b__DhRzAex0

# Installing the Algorand Indexer

For more details: https://developer.algorand.org/docs/run-a-node/setup/indexer/

# 1- Organize your Project

Create a file structure like the image below:  
![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/examples/explorer-gui/file-structure.png)

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
<title>Algorand Explorer PHP</title>
</head>

<body>
    <main id="explorer">
          <h1>Algorand Explorer PHP</h1>
          <div id="top">
              <div id="search">
                  <input id="keyword" type="text" value="" placeholder="Address, TX ID, Block, Asset ID, or leave blank to list">

                  <input type="button" id="reload-buttom" value="<- Back | Reload">

                  Type
                  <select id="type">
                      <option value="address">Address</option>
                      <option value="txid">Transaction</option>
                      <option value="block">Block</option>
                      <option value="asset">Asset</option>
                      <option value="application">Application</option>
                  </select>

                  Round
                  <input id="minround" type="number" value="" placeholder="Block">

                  Max Round
                  <input id="maxround" type="number" value="" placeholder="Block">

                  Limit
                  <input id="limit" type="number" value="100">

                  <input type="button" id="search-buttom" value="Search">


              </div>
              <div id="results">

              </div>
          </div>

          <div id="left">
              <h2>Latest Transactions</h2>
              <div id="transactions">

              </div>
          </div>
          <div id="right">
              <h2>Latest Blocks</h2>
              <div id="blocks">

              </div>
          </div>
          <div id="bottom">
            <h2>Output</h2>
            <textarea id="explorer_output"></textarea>
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

#explorer{
  position: relative;
  width: 95%;
  margin-left: auto;
  margin-right: auto;
  overflow: hidden;
  clear: both;
  float: none;
}
#top{
  float: node;
  width: 100%;
  text-align: center;
}
#left{
  float: left;
  width: 50%;
}
#right{
  float: right;
  width: 50%;
}
#bottom{
  float: none;
  width: 100%;
  clear: both;
}
#explorer h1{
  font-family: fantasy;
  font-size: 38px;
  text-align: center;
  margin-bottom: 0px;
}

#explorer h2{
  font-family: fantasy;
  font-size: 28px;
  text-align: left;
  font-family: cursive;
}

#top textarea{
  width: 100%;
  height: 250px;
}

#keyword{
  width: 100% !important;
  margin-bottom: 10px;
}
#explorer_output{
  width: 100%;
  height: 170px;
}
#limit, #minround, #maxround{
  width: 80px;
}

#results{
  font-family: Arial;
  overflow: hidden;
  clear: both;
}
#results ul{
  padding: 0px;
}
#results ul li{
  list-style: none;
  border: 1px solid #CCC;
  width: calc(50% - 2px);
  float: left;
}
#results .full{
  width: calc(100% - 2px);
}
#results ul li h5{
  font-size: 16px;
  text-align: left;
  margin-left: 20px;
  margin-bottom: 10px;
  font-weight: normal;
  margin: 10px;
}
#results ul li p{
  margin: 10px;
}
#transactions, #blocks{
  font-size: 11px;
  font-family: Arial;
}
#transactions ul, #blocks ul{
  padding: 0px;
  border-top: 1px solid #CCC;
  display: flex;
  flex-wrap: wrap-reverse;
}
#blocks ul{
  flex-wrap: wrap;
}
#transactions ul li, #blocks ul li{
  list-style: none;
  padding: 10px;
  border-bottom: 1px solid #CCC;
  width: 100%;
}
#transactions ul li p, #blocks ul li p{
  margin: 0px;
}

#reload-buttom{
  float: left;
}

```

# 3- Create the Interface Scripts

Include the code below in the  **js/main.js**  file:

### JS/MAIN.JS

```js
$(document).ready(function(){

      explorer = new Explorer();
      explorer.health();
      explorer.latest_transactions();
      explorer.latest_blocks();

      $("#search-buttom").click(function(){
          explorer.search();
      });

      $("#reload-buttom").click(function(){
          window.location.reload();
      });

});


class Explorer {

      url="php/controller.php";

      health() {
        $.post(this.url, {
              action: "health",
            }).done(function( data ) {
              $("#explorer_output").val(data);
        });
      }

      search() {
        if($("#keyword").val()==""){ //List
          switch ($("#type").val()) {
            case 'address':
                $.post(this.url, {
                    action: "addresses",
                    limit: $("#limit").val(),
                  }).done(function( data ) {
                    $("#right").css("display","");
                    $("#left").css("width","50%");
                    $("#right h2").html("Addresses");
                    $("#blocks").html(data);
                  });
              break;

              case 'block':
                  $.post(this.url, {
                      action: "blocks",
                      limit: $("#limit").val(),
                      minround: $("#minround").val(),
                    }).done(function( data ) {
                      $("#right").css("display","");
                      $("#left").css("width","50%");
                      $("#right h2").html("Blocks");
                      $("#blocks").html(data);
                    });
                break;

                case 'application':
                    $.post(this.url, {
                        action: "applications",
                        limit: $("#limit").val(),
                      }).done(function( data ) {
                        $("#right").css("display","");
                        $("#left").css("width","50%");
                        $("#right h2").html("Applications");
                        $("#blocks").html(data);
                      });
                  break;

                  case 'asset':
                      $.post(this.url, {
                          action: "assets",
                          limit: $("#limit").val(),
                        }).done(function( data ) {
                          $("#right").css("display","");
                          $("#left").css("width","50%");
                          $("#right h2").html("Assets");
                          $("#blocks").html(data);
                        });
                    break;

              default:
                $("#right").css("display","none");
                $("#left").css("width","100%");
          }
        }else{ //
          $.post(this.url, { //Search
                action: "search",
                limit: $("#limit").val(),
                type: $("#type").val(),
                keyword: $("#keyword").val(),
                minround: $("#minround").val(),
                maxround: $("#maxround").val(),
              }).done(function( data ) {
                $("#right").css("display","none");
                $("#left").css("width","100%");
                $("#results").html(data);
          });
        }

        this.transactions();

      }

      transactions() {
        $.post(this.url, {
              action: "transactions",
              limit: $("#limit").val(),
              type: $("#type").val(),
              keyword: $("#keyword").val(),
              minround: $("#minround").val(),
              maxround: $("#maxround").val(),
            }).done(function( data ) {
              $("#transactions").html(data);
        });
      }

      latest_transactions() {
        $.post(this.url, {
              action: "latest_transactions",
            }).done(function( data ) {
              $("#transactions").html(data);
        });
      }

      latest_blocks() {
        $.post(this.url, {
              action: "latest_blocks",
            }).done(function( data ) {
              $("#blocks").html(data);
        });
      }

      address(value) {
        $("#type").val("address");
        $("#keyword").val(value);
        this.search();
      }

      txid(value) {
        $("#type").val("txid");
        $("#keyword").val(value);
        this.search();
      }

      block(value) {
        $("#type").val("block");
        $("#keyword").val(value);
        this.search();
      }

      asset(value) {
        $("#type").val("asset");
        $("#keyword").val(value);
        this.search();
      }

      application(value) {
        $("#type").val("application");
        $("#keyword").val(value);
        this.search();
      }

}

```

Download  **js/jquery.min.js**  at:  [https://jquery.com/download/](https://jquery.com/download/)

# 4- Creating the Explorer PHP Class and Application Controller

Include the code below in the  **php/explorer.class.php**  and  **php/controller.php**  files:

### PHP/EXPLORER.CLASS.PHP

```php
<?php
class Explorer{

    #Config
    protected $indexer_token="";
    protected $indexer_host="localhost";
    protected $indexer_port=8980;
    public $indexer;


    public function indexer_init(){
       $this->indexer=new Algorand_indexer($this->indexer_token,$this->indexer_host,$this->indexer_port);
    }

    public function health(){
       $return=$this->indexer->get("health");
       return $return;
    }

    public function address($address){
      $return=$this->indexer->get("v2","accounts",$address);
      return $return['response'];
    }

    public function transaction($id){
      $return=$this->indexer->get("v2","transactions",$id);
      return $return['response'];
    }

    public function block($id){
      $return=$this->indexer->get("v2","blocks",$id);
      return $return['response'];
    }

    public function asset($id){
      $return=$this->indexer->get("v2","assets",$id);
      return $return['response'];
    }

    public function application($id){
      $return=$this->indexer->get("v2","applications",$id);
      return $return['response'];
    }

    public function transactions($params){
      $query=http_build_query($params);
      $return=$this->indexer->get("v2","transactions?".$query);
      return $return['response'];
    }

    public function addresses($params){
      $query=http_build_query($params);
      $return=$this->indexer->get("v2","accounts?".$query);
      return $return['response'];
    }

    public function assets($params){
      $query=http_build_query($params);
      $return=$this->indexer->get("v2","assets?".$query);
      return $return['response'];
    }

    public function applications($params){
      $query=http_build_query($params);
      $return=$this->indexer->get("v2","applications?".$query);
      return $return['response'];
    }

    public function blocks($params){
      $return=$this->indexer->get("v2","blocks",$params['round']);
      return $return['response'];
    }

    public function json_print($json){
      $out=json_decode($json);
      $out=json_encode($out,JSON_PRETTY_PRINT);
      return $out;
    }

    public function format_address($json){
      $array=json_decode($json);
      $out='<ul>
          <li class="full"><h5>Address</h5><p><strong>'.$array->account->address.'</strong></p></li>
          <li><h5>Amount</h5><p><strong>'.$array->account->amount.'</strong></p></li>
          <li><h5>Round</h5><p><strong><a href="#" onClick="explorer.block(\''.$array->account->round.'\')">'.$array->account->round.'</a></strong></p></li>
          <li><h5>Status</h5><p><strong>'.$array->account->status.'</strong></p></li>
          <li><h5>Rewards</h5><p><strong>'.$array->account->rewards.'</strong></p></li>
      </ul>';
      return $out;
    }

    public function format_asset($json){
      $array=json_decode($json);
      $out='<ul>
          <li class="full"><h5>Name</h5><p><strong>'.$array->asset->params->name.' | ID: '.$array->asset->index.' | Unit: '.$array->asset->params->{"unit-name"}.'</strong></p></li>
          <li><h5>Total</h5><p><strong>'.$array->asset->params->total.'</strong></p></li>
          <li><h5>Decimals</h5><p><strong>'.$array->asset->params->decimals.'</strong></p></li>
          <li><h5>Creator</h5><p><strong><a href="#" onClick="explorer.address(\''.$array->asset->params->creator.'\')">'.$array->asset->params->creator.'</a></strong></p></li>
          <li><h5>Freeze</h5><p><strong><a href="#" onClick="explorer.address(\''.$array->asset->params->freeze.'\')">'.$array->asset->params->freeze.'</a></strong></p></li>
          <li><h5>Manager</h5><p><strong><a href="#" onClick="explorer.address(\''.$array->asset->params->manager.'\')">'.$array->asset->params->manager.'</a></strong></p></li>
          <li><h5>Reserve</h5><p><strong><a href="#" onClick="explorer.address(\''.$array->asset->params->reserve.'\')">'.$array->asset->params->reserve.'</a></strong></p></li>
      </ul>';
      return $out;
    }

    public function format_application($json){
      $array=json_decode($json);
      $out='<ul>
          <li class="full"><h5>Address</h5><p><strong>'.$array->application->address.'</strong></p></li>
          <li><h5>Amount</h5><p><strong>'.$array->application->amount.'</strong></p></li>
          <li><h5>Round</h5><p><strong><a href="#" onClick="explorer.block(\''.$array->account->round.'\')">'.$array->account->round.'</a></strong></p></li>
          <li><h5>Status</h5><p><strong>'.$array->application->status.'</strong></p></li>
          <li><h5>Rewards</h5><p><strong>'.$array->application->rewards.'</strong></p></li>
      </ul>';
      return $out;
    }

    public function format_transaction($json){
      $array=json_decode($json);

      switch ($array->transaction->{"tx-type"}) {
        case 'pay':
            $to=$array->transaction->{"payment-transaction"}->receiver;
            $amount=$array->transaction->{"payment-transaction"}->amount;
            $type=$array->transaction->{"tx-type"};
          break;
        default:
            $to=$array->transaction->receiver;
            $amount=$array->transaction->amount;
            $type=$array->transaction->{"tx-type"};
          break;
      }
      $out='<ul>
          <li class="full"><h5>ID</h5><p><strong>'.$array->transaction->id.'</strong></p></li>
          <li><h5>From</h5><p><strong><a href="#" onClick="explorer.address(\''.$array->transaction->sender.'\')">'.$array->transaction->sender.'</a></strong></p></li>
          <li><h5>To</h5><p><strong><a href="#" onClick="explorer.address(\''.$to.'\')">'.$to.'</a></strong></p></li>
          <li><h5>Amount</h5><p><strong>'.$amount.'</strong></p></li>
          <li><h5>Fee</h5><p><strong>'.$array->transaction->fee.'</strong></p></li>
          <li><h5>Type</h5><p><strong>'.$type.'</strong></p></li>
          <li><h5>Confirmed Round</h5><p><strong><a href="#" onClick="explorer.block(\''.$array->transaction->{"confirmed-round"}.'\')">'.$array->transaction->{"confirmed-round"}.'</a></strong></p></li>
      </ul>';
      return $out;
    }

    public function format_block($json){
      $array=json_decode($json);
      $out='<ul>
          <li class="full"><h5>Round</h5><p><strong>'.$array->round.'</strong></p></li>
          <li><h5>Rewards Residue</h5><p><strong>'.$array->rewards->{"rewards-residue"}.'</strong></p></li>
          <li><h5>Transactions</h5><p><strong>'.count($array->transactions).'</strong></p></li>
          <li><h5>Timestamp</h5><p><strong>'.date("m/d/Y H:i:s",$array->timestamp).'</strong></p></li>
          <li><h5>Txn Counter</h5><p><strong>'.$array->{"txn-counter"}.'</strong></p></li>
      </ul>';
      return $out;
    }

    public function format_transactions($json){
      $array=json_decode($json);
      $transactions=$array->transactions;
      $out='<ul>';
      $total=count($transactions);
      for($x=0;$x<$total;$x++){

        switch ($transactions[$x]->{"tx-type"}) {
          case 'pay':
              $to=$transactions[$x]->{"payment-transaction"}->receiver;
              $amount=$transactions[$x]->{"payment-transaction"}->amount;
              $type=$transactions[$x]->{"tx-type"};
            break;
          default:
              $to=$transactions[$x]->receiver;
              $amount=$transactions[$x]->amount;
              $type=$transactions[$x]->{"tx-type"};
            break;
        }

        $out.='<li>
        <p>ID: <strong><a href="#" onClick="explorer.txid(\''.$transactions[$x]->id.'\')">'.$transactions[$x]->id.'</a></strong></p>
        <p>From: <strong><a href="#" onClick="explorer.address(\''.$transactions[$x]->sender.'\')">'.$transactions[$x]->sender.'</a></strong></p>
        <p>To: <strong><a href="#" onClick="explorer.address(\''.$to.'\')">'.$to.'</a></strong></p>
        <p>Type: <strong>'.$type.'</strong> Amount: <strong>'.$amount.'</strong> Fee: <strong>'.$transactions[$x]->fee.'</strong> Round Time: <strong>'.date("m/d/Y H:i:s",$transactions[$x]->{"round-time"}).'</strong></p>
        </li>';
      }
      $out.='</ul>';
      return $out;
    }

    public function format_addresses($json){
      $array=json_decode($json);
      $accounts=$array->accounts;
      $out='<ul>';
      $total=count($accounts);
      for($x=0;$x<$total;$x++){

        $out.='<li>
        <p>Address: <strong><a href="#" onClick="explorer.address(\''.$accounts[$x]->address.'\')">'.$accounts[$x]->address.'</a></strong></p>
        <p>Round: <strong><a href="#" onClick="explorer.block(\''.$accounts[$x]->round.'\')">'.$accounts[$x]->round.'</a></strong></p>
        <p>Rewards: <strong>'.$accounts[$x]->rewards.'</strong></p>
        <p>Status: <strong>'.$accounts[$x]->status.'</strong></p>
        </li>';
      }
      $out.='</ul>';
      return $out;
    }

    public function format_assets($json){
      $array=json_decode($json);
      $assets=$array->assets;
      $out='<ul>';
      $total=count($assets);
      for($x=0;$x<$total;$x++){

        $out.='<li>
        <p>Name: <strong><a href="#" onClick="explorer.asset(\''.$assets[$x]->index.'\')">'.$assets[$x]->params->name." | ID: ".$assets[$x]->index.' | Unit: '.$assets[$x]->params->{"unit-name"}.'</a></strong></p>
        <p>Created at Round: <strong><a href="#" onClick="explorer.block(\''.$assets[$x]->{"created-at-round"}.'\')">'.$assets[$x]->{"created-at-round"}.'</a></strong></p>
        <p>Creator: <strong><a href="#" onClick="explorer.address(\''.$assets[$x]->params->creator.'\')">'.$assets[$x]->params->creator.'</a></strong></p>
        <p>Total: <strong>'.$assets[$x]->params->total.'</strong></p>
        </li>';
      }
      $out.='</ul>';
      return $out;
    }

    public function format_applications($json){
      $array=json_decode($json);
      $applications=$array->applications;
      $out='<ul>';
      $total=count($applications);
      for($x=0;$x<$total;$x++){

        $out.='<li>
        <p>ID: <strong><a href="#" onClick="explorer.application(\''.$applications[$x]->id.'\')">'.$applications[$x]->id.'</a></strong></p>
        <p>Created at Round: <strong><a href="#" onClick="explorer.block(\''.$applications[$x]->{"created-at-round"}.'\')">'.$applications[$x]->{"created-at-round"}.'</a></strong></p>
        <p>Creator: <strong><a href="#" onClick="explorer.address(\''.$applications[$x]->params->creator.'\')">'.$applications[$x]->params->creator.'</a></strong></p>
        <p>Deleted: <strong>'.$applications[$x]->deleted.'</strong></p>
        </li>';
      }
      $out.='</ul>';
      return $out;
    }

    public function format_blocks($json){
      $block=json_decode($json);
      $total=count($block->transactions);

        $out.='<li>
        <p>Round: <strong><a href="#" onClick="explorer.block(\''.$block->round.'\')">'.$block->round.'</a></strong></p>
        <p>Transactions: <strong>'.$total.'</strong></p>
        <p>Txn Counter: <strong>'.$block->{"txn-counter"}.'</strong></p>
        <p>Timestamp: <strong>'.date("m/d/Y H:i:s",$block->timestamp).'</strong></p>
        </li>';

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
include("explorer.class.php");
$explorer=new Explorer;
$explorer->indexer_init();


$action=$_POST['action'];
$type=$_POST['type'];
$limit=$_POST['limit'];
$keyword=$_POST['keyword'];
$minround=$_POST['minround'];
$maxround=$_POST['maxround'];


switch ($action) {
  case 'health':
        $return=$explorer->health();
        echo $explorer->json_print($return['response']);
        exit();
       break;

  case "search":
        switch ($type) {
            case "address":
              echo $explorer->format_address($explorer->address($keyword));
              exit();
            break;

            case "txid":
              echo $explorer->format_transaction($explorer->transaction($keyword));
              exit();
            break;

            case "block":
              echo $explorer->format_block($explorer->block($keyword));
              exit();
            break;

            case "asset":
              echo $explorer->format_asset($explorer->asset($keyword));
              exit();
            break;

            case "application":
              echo $explorer->format_application($explorer->application($keyword));
              exit();
            break;
        }
        exit();
      break;

  case "transactions":
        $params=array();

        if(!empty($limit)){ $params['limit']=$limit; }
        if(!empty($keyword) AND $type=="application"){ $params['application-id']=$keyword; }
        if(!empty($keyword) AND $type=="asset"){ $params['asset-id']=$keyword; }
        if($type=="block"){
          if(!empty($keyword)){ $params['round']=$keyword; }
        }else{
          if($minround!="" AND $maxround==""){

            $params['round']=$minround;
          }else{
            if(!empty($minround)){ $params['min-round']=$minround; }
            if(!empty($maxround)){ $params['max-round']=$maxround; }
          }
        }
        if(!empty($keyword) AND $type=="txid"){ $params['txid']=$keyword; }
        if(!empty($keyword) AND $type=="address"){ $params['address']=$keyword; }

        echo $explorer->format_transactions($explorer->transactions($params));
        exit();
      break;

  case "addresses":
        $params=array();
        if(!empty($limit)){ $params['limit']=$limit; }
        echo $explorer->format_addresses($explorer->addresses($params));
        exit();
      break;

  case "blocks":
        if($minround==0){
          $return=$explorer->indexer->get("health");
          $return=json_decode($return['response']);
          $round=$return->round;
        }else{
          $round=$minround;
        }
        echo '<ul>';
        $params=array();
        if($limit==0){
          $limit=100;
        }
        for($x=0;$x<$limit;$x++){
          $params['round']=$round-$x;
          echo $explorer->format_blocks($explorer->blocks($params));
        }
        echo '</ul>';
        exit();
      break;

  case "assets":
        $params=array();
        if(!empty($limit)){ $params['limit']=$limit; }
        echo $explorer->format_assets($explorer->assets($params));
        exit();
      break;

  case "applications":
        $params=array();
        if(!empty($limit)){ $params['limit']=$limit; }
        echo $explorer->format_applications($explorer->applications($params));
        exit();
      break;

  case "latest_transactions":
        //Get the current block
        $return=$explorer->indexer->get("health");
        $return=json_decode($return['response']);
        $round=$return->round;

        $params=array();
        $params['max-round']=$round;
        $params['min-round']=$round-1000;
        $params['limit']=10;
        echo $explorer->format_transactions($explorer->transactions($params));
        exit();
        break;

  case "latest_blocks":
        //Get the current block
        $return=$explorer->indexer->get("health");
        $return=json_decode($return['response']);
        $round=$return->round;
        echo '<ul>';
        $params=array();
        $limit=10;
        for($x=0;$x<$limit;$x++){
          $params['round']=$round-$x;
          echo $explorer->format_blocks($explorer->blocks($params));
        }

        echo '</ul>';
        exit();
      break;
}
?>

```
# 5- Configuring your Application

Edit the file  **php/explorer.class.php**  and change adding your indexer configuration.
```php
#Config
protected $indexer_token="";
protected $indexer_host="localhost";
protected $indexer_port=8980;
```

# 6- Starting the Algorand Indexer service

Start the Algorand Indexer service with the command below
```
./algorand-indexer daemon -P "host=127.0.0.1 port=5432 user={user} password={password} dbname=algorand sslmode=disable"  --no-algod
```

# 7- Running the Application

Open the  **index.html**  file in your browser to get started.

# Conclusion

This is just an example of the many possibilities available using the PHP SDK , other functions are available in the GitHub repository.  
Make sure to see the readme for instructions on setup and running the Algorand indexer and PHP SDK at GitHub ([https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk))

## License

MIT license.

([https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE](https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE)).
