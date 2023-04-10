<?php

namespace App\Http\Controllers;

use App\Algorand\algorand;
use App\Algorand\transactions;
use App\Algorand\algokey;
use App\Algorand\b32;
use App\Algorand\msgpack;

class IndexerController extends Controller
{

    public function index()
    {

      $algorand_indexer = new Algorand("indexer","{indexer-token}","localhost",8980);
      $algorand_indexer->debug(1);

      #Get health, Returns 200 if healthy.
      $return=$algorand_indexer->get("health");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      #Full response with debug (json response)
      if(!empty($return)){
          print_r($return);
      }
      #Only response array
      if(!empty($return['response'])){
          print_r(json_decode($return['response']));
      }
      #Only erros messages  array
      if(!empty($return['message'])){
          print_r(json_decode($return['message']));
      }

    }
}
