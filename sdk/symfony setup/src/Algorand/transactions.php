<?php
namespace App\Algorand;

use App\Algorand\b32;
use App\Algorand\msgpack;
use App\Algorand\algokey;

class Algorand_transactions{
    
    public function encode($transaction,$opt_msgpack=false,$signature=""){

        $msgpack=new msgpack;

        $out=$transaction;
        ksort($out['txn']);


        if(!empty($out['txn']['fee'])) { $out['txn']['fee']=intval($out['txn']['fee']); }
        if(!empty($out['txn']['fv'])) { $out['txn']['fv']=intval($out['txn']['fv']); }
        if(!empty($out['txn']['gen'])) { $out['txn']['gen']=strval($out['txn']['gen']); }
        if(!empty($out['txn']['gh'])) { $out['txn']['gh']=strval($out['txn']['gh']); }
        if(!empty($out['txn']['grp'])) { $out['txn']['grp']=strval($out['txn']['grp']); }
        if(!empty($out['txn']['lv'])) { $out['txn']['lv']=intval($out['txn']['lv']); }

        if(!empty($out['txn']['note'])) { $out['txn']['note']=$msgpack->pBin(utf8_encode(strval($out['txn']['note']))); }

        if(!empty($out['txn']['gp'])) { $out['txn']['gp']=strval($out['txn']['gp']); }
        if(!empty($out['txn']['rekey'])) { $out['txn']['rekey']=b32::decode($out['txn']['rekey']); }
        if(!empty($out['txn']['type'])) { $out['txn']['type']=strval($out['txn']['type']); }
        if(!empty($out['txn']['rcv'])) { $out['txn']['rcv']=strval($out['txn']['rcv']); }
        if(!empty($out['txn']['amt'])) { $out['txn']['amt']=intval($out['txn']['amt']); }
        if(!empty($out['txn']['aamt'])) { $out['txn']['aamt']=intval($out['txn']['aamt']); }
        if(!empty($out['txn']['close'])) { $out['txn']['close']=strval($out['txn']['close']); }
        if(!empty($out['txn']['xaid'])) { $out['txn']['xaid']=intval($out['txn']['xaid']); }
        if(!empty($out['txn']['apid'])) { $out['txn']['apid']=intval($out['txn']['apid']); }
        if(!empty($out['txn']['faid'])) { $out['txn']['faid']=intval($out['txn']['faid']); }
        if(!empty($out['txn']['caid'])) { $out['txn']['caid']=intval($out['txn']['caid']); }

        if(!empty($out['txn']['gh'])) { $out['txn']['gh']=base64_decode($out['txn']['gh']); }
        if(!empty($out['txn']['snd'])) { $out['txn']['snd']=b32::decode($out['txn']['snd']); }
        if(!empty($out['txn']['rcv'])) { $out['txn']['rcv']=b32::decode($out['txn']['rcv']); }
        if(!empty($out['txn']['close'])) { $out['txn']['close']=b32::decode($out['txn']['close']); }
        if(!empty($out['txn']['aclose'])) { $out['txn']['aclose']=b32::decode($out['txn']['aclose']); }
        if(!empty($out['txn']['selkey'])) { $out['txn']['selkey']=b32::decode($out['txn']['selkey']); }
        if(!empty($out['txn']['votekey'])) { $out['txn']['votekey']=b32::decode($out['txn']['votekey']); }
        if(!empty($out['txn']['arcv'])) { $out['txn']['arcv']=b32::decode($out['txn']['arcv']); }
        if(!empty($out['txn']['asnd'])) { $out['txn']['asnd']=b32::decode($out['txn']['asnd']); }
        if(!empty($out['txn']['fadd'])) { $out['txn']['fadd']=b32::decode($out['txn']['fadd']); }
        if(!empty($out['txn']['apat'])) { $out['txn']['apat']=b32::decode($out['txn']['apat']); }
        if(!empty($out['txn']['apap'])) { $out['txn']['apap']=b32::decode($out['txn']['apap']); }
        if(!empty($out['txn']['apsu'])) { $out['txn']['apsu']=b32::decode($out['txn']['apsu']); }
        if(!empty($out['txn']['apfa'])) { $out['txn']['apfa']=b32::decode($out['txn']['apfa']); }
        if(!empty($out['txn']['apas'])) { $out['txn']['apas']=b32::decode($out['txn']['apas']); }

        if(!empty($out['txn']['apar']['am'])) { $out['txn']['apar']['am']=b32::decode($out['txn']['apar']['am']); }
        if(!empty($out['txn']['apar']['c'])) { $out['txn']['apar']['c']=b32::decode($out['txn']['apar']['c']); }
        if(!empty($out['txn']['apar']['f'])) { $out['txn']['apar']['f']=b32::decode($out['txn']['apar']['f']); }
        if(!empty($out['txn']['apar']['m'])) { $out['txn']['apar']['m']=b32::decode($out['txn']['apar']['m']); }
        if(!empty($out['txn']['apar']['r'])) { $out['txn']['apar']['r']=b32::decode($out['txn']['apar']['r']); }
        if(!empty($out['txn']['apar']['dc'])) { $out['txn']['apar']['dc']=intval($out['txn']['apar']['dc']); }
        if(!empty($out['txn']['apar']['t'])) { $out['txn']['apar']['t']=intval($out['txn']['apar']['t']); }

        if($signature!=""){
            $out=array(
                "sig" => $signature,
                "txn" => $out['txn'],
            );
            $out=$msgpack->p($out);
        }else{
            $out=$msgpack->p($out['txn']);
        }

        $out=bin2hex($out);
        $out=hex2bin($out);
        
        if($opt_msgpack==false){
            $out=base64_encode($out);
        }
        return $out;
    }

    public function pk_encode($array){
        $out=$array;
        $out=b32::decode($out);
        $out=base64_encode($out);
        return $out;
    }

    public function groupid($transactions){

       $msgpack=new msgpack;
       $txn="";
       $total=count($transactions);
       $txids=array();
       for($x=0; $x<$total; $x++){
          $raw_txn=$this->encode($transactions[$x],true);
          $raw_txn=hash('sha512/256',"TX".$raw_txn,true);
          $txids[$x]=$raw_txn;
       }

        $group_list=array(
            'txlist' => $txids,
        );

        $encoded=$msgpack->p($group_list);
        $gid = hash('sha512/256',"TG".$encoded,true);

        return $gid;
    }
    
}
?>
