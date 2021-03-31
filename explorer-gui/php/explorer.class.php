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
