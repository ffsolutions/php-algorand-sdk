<?php
require_once 'sdk/algorand.php';

$algorand = new Algorand("algod",'{algod-token}',"localhost",53898); //get the token key in data/algod.token
//$algorand = new Algorand("algod","{pure-stake-token}","mainnet-algorand.api.purestake.io/ps2",0,true); //true for External PureStake 

$algorand->debug(1);

//algorand->setSSL('/home/felipe/certificate.cert'); //Optional

#Just uncomment to try all avaliable functions

#Get the versions
//$return=$algorand->get("versions");

#Gets the current node status.
//$return=$algorand->get("v2","status");

#Gets the node status after waiting for the given round.
//$return=$algorand->get("v2","status","wait-for-block-after",{block});

#Gets the genesis information.
//$return=$algorand->get("genesis");

#Returns 200 (OK) if healthy.
//$return=$algorand->get("health");

#Return metrics about algod functioning.
//$return=$algorand->get("metrics");

#Gets the current swagger spec.
//$return=$algorand->get("swagger.json");

#Get account information and balances.
//$return=$algorand->get("v2","accounts","{address}","?exclude=none&?format=json"); //?exclude=none or all. When set to all will exclude asset holdings, &format=json or msgpack (opcional, default json)

#Get account information about a given app.
//$return=$algorand->get("v2","accounts","{address}","applications","{application-id}");

#Get account information about a given asset.
//$return=$algorand->get("v2","accounts","{address}","assets","{asset-id}");

#Get a list of unconfirmed transactions currently in the transaction pool by address.
//$return=$algorand->get("v2","accounts","{address}","transactions","pending","?format=json&max=2");

#Get application information.
//$return=$algorand->get("v2","applications","{application-id}");

#Get box information for a given application.
//$return=$algorand->get("v2","applications","{application-id}","box","?name=");

#Get all box names for a given application.
//$return=$algorand->get("v2","applications","{application-id}","boxes","?max=");

#Get asset information.
//$return=$algorand->get("v2","assets","{asset-id}");

#Get the block for the given round.
//$return=$algorand->get("v2","blocks","{block}");

#Get the block hash for the block on the given round.
//$return=$algorand->get("v2","blocks","{block}","hash");

#Gets a proof for a given light block header inside a state proof commitment
//$return=$algorand->get("v2","blocks","{block}","lightheader","proof");

#Get a proof for a transaction in a block.
//$return=$algorand->get("v2","blocks","{round}","transactions","{txid}","proof");

#Starts a catchpoint catchup. For the last catchpoint access: https://algorand-catchpoints.s3.us-east-2.amazonaws.com/channel/mainnet/latest.catchpoint
//$return=$algorand->post("v2","catchup","{catchpoint}");

#Aborts a catchpoint catchup.
//$return=$algorand->delete("v2","catchup","{catchpoint}");

#Get a LedgerStateDelta object for a given round
//$return=$algorand->get("v2","deltas","{round}");

#Get the current supply reported by the ledger.
//$return=$algorand->get("v2","ledger","supply");

#Returns the minimum sync round the ledger is keeping in cache.
//$return=$algorand->get("v2","ledger","sync");

#Removes minimum sync round restriction from the ledger.
//$return=$algorand->delete("v2","ledger","sync");

#Given a round, tells the ledger to keep that round in its cache.
//$return=$algorand->post("v2","ledger","sync","{round}");

#Add a participation key to the node
/*
$params['body']="{participationkey}";
$return=$algorand->post("v2","participation",$params);
*/

#Return a list of participation keys
//$return=$algorand->get("v2","participation");

#Append state proof keys to a participation key
/*
$params['body']="{keymap}";
$return=$algorand->post("v2","participation","{participation-id}",$params);
*/

#Get participation key info given a participation ID
//$return=$algorand->get("v2","participation","{participation-id}");


#Delete a given participation key by ID
//$return=$algorand->delete("v2","participation","{participation-id}");


#Special management endpoint to shutdown the node. Optionally provide a timeout parameter to indicate that the node should begin shutting down after a number of seconds.
/*
$params['params']=array("timeout" => 0);
$return=$algorand->post("v2","shutdown", $params);
*/


#Get a state proof that covers a given round
//$return=$algorand->get("v2","stateproofs","{round}");


#Compile TEAL source code to binary, produce its hash
/*
$params['body']="";
$return=$algorand->post("v2","teal","compile",$params);
*/

#Disassemble program bytes into the TEAL source code.
/*
$params['body']="";
$return=$algorand->post("v2","teal","disassemble",$params);
*/


#Provide debugging information for a transaction (or group).
/*
$params['$params']=array(
                        "accounts" => array(), //Account
                        "apps" => array(), //Application
                        "latest-timestamp" => 0, //integer
                        "protocol-version" => "", //string
                        "round" => 0, //integer
                        "sources" => array(), //DryrunSource
                        "txns" => "", //string (json) > array
                   );
$return=$algorand->post("v2","teal","dryrun",$params);
*/


#Broadcasts a raw transaction to the network.
#Generate and Sign the transaction with cli or this sdk:
//CLI sample
#./goal clerk send -a 1000 -f {address_from} -t {address_to} -d data -o transactions/tran.txn
#./goal clerk sign --infile="trans/tran.txn" --outfile="trans/tran.stxn" -d data


//$params['file']="transactions/tran.stxn";
/*
$params['transaction']="";
$return=$algorand->post("v2","transactions",$params);
*/

#Get parameters for constructing a new transaction
//$return=$algorand->get("v2","transactions","params");

#Get a list of unconfirmed transactions currently in the transaction pool.
//$return=$algorand->get("v2","transactions","pending","?format=json&max=2");

#Get a specific pending transaction.
//$return=$algorand->get("v2","transactions","pending","{txid}","?format=json");


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
//https://developer.algorand.org/docs/reference/rest-apis/algod/v2/#definitions
?>
