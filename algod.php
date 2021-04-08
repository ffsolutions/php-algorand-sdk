<?php
require_once 'sdk/algorand.php';

$algorand = new Algorand_algod('{algod-token}',"localhost",53898); //get the token key in data/algod.token

$algorand->debug(1);

//algorand->setSSL('/home/felipe/certificate.cert'); //Optional

#Just uncomment to try all avaliable functions

#Get the versions
//$return=$algorand->get("versions");

#Gets the current node status.
$return=$algorand->get("v2","status");

#Gets the node status after waiting for the given round.
//$return=$algorand->get("v2","status","wait-for-block-after",12385949);

#Gets the genesis information.
//$return=$algorand->get("genesis");

#Returns 200 (OK) if healthy.
//$return=$algorand->get("health");

#Return metrics about algod functioning.
//$return=$algorand->get("metrics");

#Gets the current swagger spec.
//$return=$algorand->get("swagger.json");

#Check your balance.
//$return=$algorand->get("v1","account","{address}");

#Get health, Returns 200 if healthy.
//$return=$algorand_indexer->get("health");

#Return metrics about algod functioning.
//$return=$algorand->get("metrics");

#Get a specific confirmed transaction.
//$return=$algorand->get("v1","account","{address}","transaction","{txid}");

#Get a list of unconfirmed transactions currently in the transaction pool by address.
//$return=$algorand->get("v1","account","{address}","transactions","pending");

#Get account information.
//$return=$algorand->get("v2","accounts","{address}","?format=json"); //?format=json or msgpack (opcional, default json)

#Get a list of unconfirmed transactions currently in the transaction pool by address.
//$return=$algorand->get("v2","accounts","{address}","transactions","pending","?format=json&max=2");

#Get application information.
//$return=$algorand->get("v2","applications","{application-id}");

#Get asset.
//$return=$algorand->get("v1","assets");

#Get asset information.
//$return=$algorand->get("v2","assets","{asset-id}");

#Get the block for the given round.
//$return=$algorand->get("v1","block",12424111);

#Get the block for the given round.
//$return=$algorand->get("v2","blocks",12385287);

#Starts a catchpoint catchup. For the last catchpoint access: https://algorand-catchpoints.s3.us-east-2.amazonaws.com/channel/mainnet/latest.catchpoint
//$return=$algorand->post("v2","catchup","{catchpoint}");

#Aborts a catchpoint catchup.
//$return=$algorand->delete("v2","catchup","{catchpoint}");

#Get the current supply reported by the ledger.
//$return=$algorand->get("v2","ledger","supply");

#Generate (or renew) and register participation keys on the node for a given account address.
/*
$params['params'] = array(
                        "fee"=>1000,
                        "key-dilution" => 10000,
                        "no-wait" => false,
                        "round-last-valid" => 22149901
                    );

$return=$algorand->post("v2","register-participation-keys","{address}",$params);
*/

#Special management endpoint to shutdown the node. Optionally provide a timeout parameter to indicate that the node should begin shutting down after a number of seconds.
/*
$params['params']=array("timeout" => 0);
$return=$algorand->post("v2","shutdown", $params);
*/

#Compile TEAL source code to binary, produce its hash
/*
$params['body']="";
$return=$algorand->post("v2","teal","compile",$params);
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

#Get the suggested fee
//$return=$algorand->get("v1","transactions","fee");

#Get an information of a single transaction.
//$return=$algorand->get("v1","transaction","{txid}"); //start the algorand-indexer to run

#Broadcasts a raw transaction to the network.
#Generate and Sign the transaction:
#./goal clerk send -a 1000 -f DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4 -t IYVZLDFIF6KUMSDFVIKHPBT3FI5QVZJKJ6BPFSGIJDUJGUUASKNRA4HUHU -d data -o transactions/tran.txn
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
