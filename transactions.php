<?php
require_once 'sdk/algorand.php';
require_once 'sdk/algokey.php';

$algokey=new algokey;
$algorand_transactions = new Algorand_transactions;

#SIGN WITH ALGOKEY load the Private Key

$words=explode(" ","connect produce defense output sibling idea oil siege decline dentist faint electric method notice style cook unlock rice confirm host tone test vehicle able keen"); //2OEZACD77WSR5C2HFEHO2BYHQEATOGFIUW3REGKOGNPPNYPPLROHDU2CQE
$privateKey=$algokey->WordsToPrivateKey($words); //Array to load words


//OR

#SIGN WITH KMD start it
/*
$algorand_kmd = new Algorand("kmd","{kmd-token}","localhost",7833); //get the token key in data/kmd-{version}/kmd.token and port in data/kmd-{version}/kmd.net

#Wallet Init  //Only if you will use the KMD.
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "tests",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
*/



#Build and Sign a transaction, for details: https://developer.algorand.org/docs/features/transactions
# Types: 
# appl = ApplicationCallTx allows creating, deleting, and interacting with an application
# cert = CompactCertTx records a compact certificate
# keyreg = KeyRegistrationTx indicates a transaction that registers participation keys
# acfg = AssetConfigTx creates, re-configures, or destroys an asset
# axfer = AssetTransferTx transfers assets between accounts (optionally closing)
# afrz = AssetFreezeTx changes the freeze status of an asset
# pay = PaymentTx indicates a payment transaction

#Tip, use algod $return=$algorand->get("v2","transactions","params"); to get parameters for constructing a new transaction

#Build Transaction

#Application Call Transaction
/*
$transaction=array(
        "txn" => array(
                "type" => "appl", //Tx Type
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13029982, //First Valid
                "lv" => 13023082, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "apid" => "", //Application ID or empty if creating
                "apan" => "", //OnComplete
                "apat" => "", //Accounts
                "apap" => "", //Approval Program
                "apaa" => "", //App Arguments
                "apsu" => "", //Clear State Program
                "apfa" => "", //Foreign Apps
                "apas" => "", //Foreign Assets
                "apgs" => array( //GlobalStateSchema
                            "nui" => "", //Number Ints
                            "nbs" => "", //Number Byteslices
                        ), 
                "apls" => array( //LocalStateSchema
                            "nui" => "", //Number Ints
                            "nbs" => "", //Number Byteslices
                        ), 
            ),
);
*/

#Compact Certificate
/*
$transaction=array(
        "txn" => array(
                "type" => "cert", //Tx Type
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13029982, //First Valid
                "lv" => 13023082, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "certrnd" => "", //Round
                "certtype" => "", //CompactCertType
                "cert" => "", //Cert
            ),
);
*/

#Register account online
/*
$transaction=array(
        "txn" => array(
                "type" => "keyreg", //Tx Type
                "selkey" => "X84ReKTmp+yfgmMCbbokVqeFFFrKQeFZKEXG89SXwm4=", //SelectionPK
                "fee" => 1000, //Fee
                "fv" => 13009389, //First Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 13009489, //Last Valid
                "votefst" => 13009489, //VoteFirst
                "votelst" => 13009589, //VoteLast
                "votekd" => 1730, //VoteKeyDilution
                "votekey" => "eXq34wzh2UIxCZaI1leALKyAvSz/+XOe0wqdHagM+bw=",
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
            ),
);
*/

#Register account offline
/*
$transaction=array(
        "txn" => array(
                "type" => "keyreg", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 13009389, //First Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 13009489, //Last Valid
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
            ),
);
*/

#Close an Account
/*
$transaction=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "close" => "EW64GC6F24M7NDSC5R3ES4YUVE3ZXXNMARJHDCCCLIHZU6TBEOC7XRSBG4",
                "fee" => 1000, //Fee
                "fv" => 13009389, //First Valid
                "lv" => 13009489, //Last Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "note" => "Testes", //You note
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "rcv" => "EW64GC6F24M7NDSC5R3ES4YUVE3ZXXNMARJHDCCCLIHZU6TBEOC7XRSBG4", //Receiver
            ),
);
*/

#Create an Asset 
/*
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "fee" => 1000, //Fee
                "fv" => 27151271, //First Valid
                "lv" => 27152271, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "apar" => array( //AssetParams
                        //"am" => "", //MetaDataHash
                        "an" => "MyToken", //AssetName
                        "au" => "https://mytoken.site", //URL
                        "c" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //ClawbackAddr
                        "dc" => 2, //Decimals
                        "f" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //FreezeAddr
                        "m" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //ManagerAddr
                        "r" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //ReserveAddr
                        "t" => 100000000000, //Total
                        "un" => "MTK", //UnitName
                    ),
                
            ),
);
*/

#Reconfigure an Asset 
/*
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "caid" => 185553584,
                "apar" => array( //AssetParams
                        "c" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //ClawbackAddr
                        "f" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //FreezeAddr
                        "m" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //ManagerAddr
                        "r" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //ReserveAddr
                    ),
                
            ),
);
*/

#Destroy an Asset 
/*
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "caid" => 185553584, //ConfigAsset ID
            ),
);
*/

#Opt-in to an Asset
/*
$transaction=array(
        "txn" => array(
                "type" => "axfer", //Tx Type
                "arcv" => "2QAXTOHQJQH6I4FM6RWUIISXKFJ2QA4NVWELMIJ5XAKZB4N4XIEX7F5KPU", //AssetReceiver
                "snd" => "2QAXTOHQJQH6I4FM6RWUIISXKFJ2QA4NVWELMIJ5XAKZB4N4XIEX7F5KPU", //Sender
                "fee" => 1000, //Fee
                "fv" => 27151571, //First Valid
                "lv" => 27152571, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "xaid" => 1044612559, //XferAsset ID
            ),
);
*/

#Opt-out Asset
/*
$transaction=array(
        "txn" => array(
                "aamt" => 0, //Zero asset balance required
                "type" => "axfer", //Tx Type
                "snd" => "2QAXTOHQJQH6I4FM6RWUIISXKFJ2QA4NVWELMIJ5XAKZB4N4XIEX7F5KPU", //Sender Opt-out
                "arcv" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Asset Receiver Creator
                "aclose" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Asset Creator
                "fee" => 1000, //Fee
                "fv" => 27152745, //First Valid
                "lv" => 27153745, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "xaid" => 1044612559, //XferAsset ID
            ),
);
*/

#Revoke an Asset
/*
$transaction=array(
        "txn" => array(
                "aamt" => 100,
                "type" => "axfer", //Tx Type
                "arcv" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //AssetReceiver
                "asnd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //AssetSender
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "fee" => 1000, //Fee
                "fv" => 13028982, //First Valid
                "lv" => 13029982, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "xaid" => 185553584, //XferAsset ID
            ),
);
*/

#Freeze an Asset
/*
$transaction=array(
        "txn" => array(
                "afrz" => false,
                "type" => "afrz", //Tx Type
                "fadd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //FreezeAccount
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "fee" => 1000, //Fee
                "fv" => 13029982, //First Valid
                "lv" => 13023082, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "faid" => 185553584, //FreezeAsset
            ),
);
*/

#Transfer an Asset
/*
$transaction=array(
        "txn" => array(
                "aamt" => 300,
                "type" => "axfer", //Tx Type
                "arcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //AssetReceiver
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "fee" => 1000, //Fee
                "fv" => 27151386, //First Valid
                "lv" => 27152386, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "xaid" => 1044612559, //XferAsset ID
            ),
);
*/

#Payment Transaction (ALGO)
/*
$transaction=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 27151092, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 27152092, //Last Valid
                "note" => "Testes", //You note
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "rcv" => "IYVZLDFIF6KUMSDFVIKHPBT3FI5QVZJKJ6BPFSGIJDUJGUUASKNRA4HUHU", //Receiver
                "amt" => 1000, //Amount
            ),
);
*/


#Sign Transaction

//SIGN WITH ALGOKEY
/*
$transaction_raw=$algorand_transactions->encode($transaction);
$signature=$algokey->sign($transaction_raw,$privateKey);
$transaction_raw_signed=$algorand_transactions->encode($transaction,true,$signature);
*/

//SIGN WITH KMD
/*
$params['params']=array(
   //"public_key" => $algorand_transactions->pk_encode("DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4"), (Opcional)
   "transaction" => $algorand_transactions->encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "tests",
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$transaction_raw_signed=base64_decode($r->signed_transaction);
echo $transaction_raw_signed;
*/


#Broadcasts a raw transaction to the network.
/*
$algorand = new Algorand("algod","4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7","localhost",53898);
$params['transaction']=$transaction_raw_signed;
print_r($params);
$return=$algorand->post("v2","transactions",$params);
print_r($return);
*/


#Atomic Transaction
/*
$transactions=array();

//Transaction 1
$transactions[]=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 28259644, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 28260644, //Last Valid
                "note" => "Testes", //You note
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "rcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Receiver
                "amt" => 102, //Amount
            ),
);

//Transaction 2
$transactions[]=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 28259644, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 28260644, //Last Valid
                "note" => "Testes 2", //You note
                "snd" => "3DKZLYQJXSUAE7ZCFZN7ODZSOA6733PI5BFM4L7WI4S3K6KEVOOA6KDN2I", //Sender
                "rcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Receiver
                "amt" => 203, //Amount
            ),
);

//print_r($transactions);

$groupid=$algorand_transactions->groupid($transactions);

#Assigns Group ID
$transactions[0]['txn']['grp']=$groupid;
$transactions[1]['txn']['grp']=$groupid;
*/

//SIGN WITH ALGOKEY
/*
#Sign Transaction 1

$txn="";
$transaction_raw=$algorand_transactions->encode($transactions[0]);
$signature=$algokey->sign($transaction_raw,$privateKey);
$txn.=$algorand_transactions->encode($transactions[0],true,$signature);

#Sign Transaction 2
$transaction_raw=$algorand_transactions->encode($transactions[1]);
$signature=$algokey->sign($transaction_raw,$privateKey);
$txn.=$algorand_transactions->encode($transactions[1],true,$signature);

echo $txn;
*/

//OR

//SIGN WITH KMD

#Sign Transaction 1
/*
$txn="";
$params['params']=array(
   "transaction" => $algorand_transactions->encode($transactions[0]),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "tests",
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn.=base64_decode($r->signed_transaction);


#Sign Transaction 2
$params['params']=array(
   "transaction" => $algorand_transactions->encode($transactions[1]),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "tests",
);
$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn.=base64_decode($r->signed_transaction);

echo $txn;
*/



#Broadcasts a raw atomic transaction to the network.
/*
$algorand = new Algorand("algod","{algod-token}","localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
*/

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
//https://developer.algorand.org/docs/reference/rest-apis/kmd/
?>
