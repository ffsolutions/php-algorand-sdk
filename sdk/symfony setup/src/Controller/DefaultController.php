<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
      $out="Access: /algod, /kmd or /indexer";
      $response = new Response($out);

      return $response;
    }

    /**
     * @Route("/algod", name="AlgorandAlgod")
     */
    public function AlgorandAlgod(): Response
    {

      $algorand = new algod('4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7',"localhost",53898);
      $algorand->debug(1);

      #Gets the current node status.
      $return=$algorand->get("v2","status");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      $output="";

      #Full response with debug (json response)
      if(!empty($return)){
        $output.=print_r($return, true);
      }
      if(!empty($return['response'])){
        $output.=print_r(json_decode($return['response']), true);
      }
      if(!empty($return['message'])){
        $output.=print_r(json_decode($return['message']), true);
      }
      $response = new Response($output);

      return $response;
    }

    /**
     * @Route("/kmd", name="AlgorandKmd")
     */
    public function AlgorandKmd(): Response
    {

      $algorand_kmd = new kmd('dcb406527f3ded8464dbd56e6ea001b9b17882cfcf8194c17069bb22816307ad',"localhost",7833);
      $algorand_kmd->debug(1);

      #Gets the current node status.
      $return=$algorand_kmd->get("versions");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      $output="";

      #Full response with debug (json response)
      if(!empty($return)){
        $output.=print_r($return, true);
      }
      if(!empty($return['response'])){
        $output.=print_r(json_decode($return['response']), true);
      }
      if(!empty($return['message'])){
        $output.=print_r(json_decode($return['message']), true);
      }
      $response = new Response($output);

      return $response;

    }

    /**
     * @Route("/indexer", name="AlgorandIndexer")
     */
    public function AlgorandIndexer(): Response
    {

      $algorand_indexer = new indexer('',"localhost",8980);
      $algorand_indexer->debug(1);

      #Get health, Returns 200 if healthy.
      $return=$algorand_indexer->get("health");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      $output="xxxx";

      #Full response with debug (json response)
      if(!empty($return)){
        $output.=print_r($return, true);
      }
      if(!empty($return['response'])){
        $output.=print_r(json_decode($return['response']), true);
      }
      if(!empty($return['message'])){
        $output.=print_r(json_decode($return['message']), true);
      }
      $response = new Response($output);

      return $response;

    }


}
