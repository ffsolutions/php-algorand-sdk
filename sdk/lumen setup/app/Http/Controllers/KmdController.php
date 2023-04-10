<?php

namespace App\Http\Controllers;

use App\Algorand\algorand;
use App\Algorand\transactions;
use App\Algorand\algokey;
use App\Algorand\b32;
use App\Algorand\msgpack;


class KmdController extends Controller
{

    public function index()
    {

      $algorand_kmd = new Algorand("kmd","dcb406527f3ded8464dbd56e6ea001b9b17882cfcf8194c17069bb22816307ad","localhost",7833);
      $algorand_kmd->debug(1);

      #Get Versions
      //$return=$algorand_kmd->get("versions");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk


      #Wallet List
	  $return=$algorand_kmd->get("v1","wallets");
	  

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
