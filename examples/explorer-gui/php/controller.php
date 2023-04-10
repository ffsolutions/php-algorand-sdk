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
