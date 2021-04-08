<?php
require_once 'sdk/algorand.php';

$algorand_indexer = new Algorand_indexer('',"localhost",8980);

$algorand_indexer->debug(1);
//algorand->setSSL('/home/felipe/certificate.cert'); //Optional

#Just uncomment to try all avaliable functions

#Get health, Returns 200 if healthy.
$return=$algorand_indexer->get("health");

#Search for accounts.
/*
$query=http_build_query(array(
    //"application-id" => 0, //integer
    //"asset-id" => 0, //integer
    //"auth-addr" => "", //string
    //"currency-greater-than" => 0, //integer
    //"currency-less-than" => 0, //integer
    "limit" => 100, //integer
    //"next" => "", //string - previous return {next-token}
    //"round" => 0, //integer
));
$return=$algorand_indexer->get("v2","accounts?".$query);
*/

#Lookup account information.
//$return=$algorand_indexer->get("v2","accounts","{account-id}");
//$return=$algorand_indexer->get("v2","accounts","2MSH4KOT47B4ROHGROVV4AXBLKD4GYY47SX45UIGMOYMG4D4AZUG3WUFXA");

#Lookup account transactions.
/*
$query=http_build_query(array(
    //"application-id" => 0, //integer
    "asset-id" => 0, //integer
    "after-time" => "", //string (date-time)
    "before-time" => "", //string (date-time)
    "currency-greater-than" => 0, //integer
    "currency-less-than" => 0, //integer
    "limit" => 100, //integer
    //"max-round" => 0, //integer
    //"min-round" => 0, //integer
    //"next" => "", //string - previous return {next-token}
    "note-prefix" => "", //string
    "rekey-to" => false, //boolean
    //"round" => "", //integer
    "sig-type" => "sig", //enum (sig, msig, lsig)
    "tx-type" => "pay", //enum (pay, keyreg, acfg, axfer, afrz, appl)
    "txid" => "", //string
));

//$return=$algorand_indexer->get("v2","accounts","{account-id}","transactions?".$query);
//$return=$algorand_indexer->get("v2","accounts","NJCLL5UPIZKXTHQ42M52B72DSO3PATJ2DEQOZQXJMWFMZPDLGUYV3PBJ5Q","transactions?".$query);
*/

#Search for applications
/*
$query=http_build_query(array(
    "application-id" => 0, //integer
    "limit" => 100, //integer
    //"next" => "", //string - previous return {next-token}
));
$return=$algorand_indexer->get("v2","applications?".$query);
*/

#Lookup application.
//$return=$algorand_indexer->get("v2","applications","{application-id}");

#Search for assets.
/*
$query=http_build_query(array(
    //"asset-id" => 0, //integer
    //"creator" => 0, //integer
    "limit" => 100, //integer
    //"name" => "", //string
    //"next" => "", //string - previous return {next-token}
    //"unit" => "", //string
));
$return=$algorand_indexer->get("v2","assets?".$query);
*/

#Lookup asset information.
//$return=$algorand_indexer->get("v2","assets","5");
//$return=$algorand_indexer->get("v2","assets","312769");

#Lookup the list of accounts who hold this asset
/*
$query=http_build_query(array(
    //"currency-greater-than" => 0, //integer
    //"currency-less-than" => 0, //integer
    "limit" => 100, //integer
    //"next" => "", //string - previous return {next-token}
    //"round" => "", //integer
));
$return=$algorand_indexer->get("v2","assets","{asset-id}","balances?".$query);
*/

#Lookup the list of accounts who hold this asset
/*
$query=http_build_query(array(
    "address" => "", //string
    "address-role" => "", //enum (sender, receiver, freeze-target)
    "after-time" => "", //string (date-time)
    "before-time" => "", //string (date-time)
    "currency-greater-than" => 0, //integer
    //"currency-less-than" => 0 //integer
    "exclude-close-to" => false, //boolean
    "limit" => 100, //integer
    "max-round" => 0, //integer
    "min-round" => 0, //integer
    //"next" => "", //string - previous return {next-token}
    "note-prefix" => "", //string
    "rekey-to" => false, //boolean
    //"round" => "", //integer
    "sig-type" => "sig", //enum (sig, msig, lsig)
    "tx-type" => "pay", //enum (pay, keyreg, acfg, axfer, afrz, appl)
    "txid" => "", //string
));
$return=$algorand_indexer->get("v2","assets","{asset-id}","transactions".$query);
*/

#Lookup block.
//$return=$algorand_indexer->get("v2","blocks","{round-number}");
//$return=$algorand_indexer->get("v2","blocks","5876435");
                               
#Search for transactions.
/*
$query=http_build_query(array(
    //"address" => "NJCLL5UPIZKXTHQ42M52B72DSO3PATJ2DEQOZQXJMWFMZPDLGUYV3PBJ5Q", //string
    //"address-role" => "sender", //enum (sender, receiver, freeze-target)
    //"after-time" => "", //string (date-time)
    //"application-id" => 0, //integer
    //"asset-id" => 0, //integer
    //"before-time" => "", //string (date-time)
    //"currency-greater-than" => 0, //integer
    //"currency-less-than" => 0, //integer
    //"exclude-close-to" => "false", //boolean
    "limit" => "100", //integer
    //"min-round" => 2466647, //integer
    //"max-round" => 2566647, //integer
    //"next" => "", //string - previous return {next-token}
    //"note-prefix" => "", //string
    //"rekey-to" => false, //boolean
    //"round" => 2566247, //integer
    //"sig-type" => "sig", //enum (sig, msig, lsig)
    //"tx-type" => "pay", //enum (pay, keyreg, acfg, axfer, afrz, appl)
    //"txid" => "", //string
));

$return=$algorand_indexer->get("v2","transactions?".$query);
*/

#Lookup a single transaction.
//$return=$algorand_indexer->get("v2","transactions","3TRNCPXPTSVOYCHY3MJJPF5WKBJ5SL2XOUSAFMJWY4IS5MA75P3Q");


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

//For definitions:
//https://developer.algorand.org/docs/reference/rest-apis/indexer/

?>
