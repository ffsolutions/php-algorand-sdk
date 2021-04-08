<?php

namespace App\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class KmdController extends BaseController
{
	public function index()
	{
		  $algorand_kmd = new kmd('dcb406527f3ded8464dbd56e6ea001b9b17882cfcf8194c17069bb22816307ad',"localhost",7833);
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
