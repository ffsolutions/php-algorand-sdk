<?php

namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;


class KmdController extends Controller
{

    public function index()
    {

      $algorand_kmd = new kmd('{kmd-token}',"localhost",7833);
      $algorand_kmd->debug(1);

      #Get Versions
      $return=$algorand_kmd->get("versions");

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
