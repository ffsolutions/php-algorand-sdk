<?php

namespace App\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class AlgodController extends BaseController
{
	public function index()
	{
		  $algorand = new algod('4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7',"localhost",53898);
      $algorand->debug(1);

      #Get the status
      $return=$algorand->get("v2","status");

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
