<?php

namespace App\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class Home extends BaseController
{
	public function index()
	{
		echo "Access: /algod, /kmd or /indexer";
	}

}
