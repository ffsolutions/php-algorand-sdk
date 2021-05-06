<?php
require_once 'sdk/algorand.php';

$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64212); //get the token key in data/kmd-{version}/kmd.token and port in data/kmd-{version}/kmd.net


$algorand_kmd->debug(1);
//algorand->setSSL('/home/felipe/certificate.cert'); //Optional

#Just uncomment to try all avaliable functions

#Get Versions
//$return=$algorand_kmd->get("versions");

#swagger.json
#$return=$algorand_kmd->get("swagger.json");

#Create Wallet
/*
$params['params']=array(
    "wallet_name" => "{name}",
    "wallet_password" => "testes",
    "wallet_driver_name" => "sqlite",
);
$return=$algorand_kmd->post("v1","wallet",$params);
*/

#Wallet List
//$return=$algorand_kmd->get("v1","wallets");

#Wallet Init
/*
$params['params']=array(
    "wallet_id" => "4596a5cb20ccbedcec668762449363c1",
    "wallet_password" => "testes",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
*/

#Wallet Info
/*
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token,
);
$return=$algorand_kmd->post("v1","wallet","info",$params);
*/

#Wallet Rename
/*
$params['params']=array(
    "wallet_id" => "4596a5cb20ccbedcec668762449363c1",
    "wallet_name" => "Carteira 1",
    "wallet_password" => "testes",
);
$return=$algorand_kmd->post("v1","wallet","rename",$params);
*/
#Wallet Handle Token Release
/*
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token,
);
$return=$algorand_kmd->post("v1","wallet","release",$params);
*/

#Wallet Handle Token Renew
/*
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token,
);
$return=$algorand_kmd->post("v1","wallet","renew",$params);
*/

#Generate a key
/*
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
*/

#Delete a key
/*
$params['params']=array(
    "address" => "HNVCPPGOW2SC2YVDVDICU3YNONSTEFLXDXREHJR2YBEKDC2Z3IUZSC6YGI",
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->delete("v1","key",$params);
*/

#Export a key
/*
$params['params']=array(
    "address" => "XI56XZXQ64QD7IO5UBRC2RBZP6TQHP5WEILLFMBTKPXRKK7343R3KZAWNQ",
    "wallet_password" => "testes",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);
*/

#Import a key
/*
$params['params']=array(
    "private_key" => "eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w==",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","import",$params);
*/

#List keys in wallet
/*
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","list",$params);
*/

#Master Key export
/*
$params['params']=array(
    "wallet_password" => "testes",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","master-key","export",$params);
*/

#Delete a multisig
/*
$params['params']=array(
    "address" => "E6VH3C5XX57PT7LSZBETCJJRJRPZPSWAY5TEB7AWGEAQAWLCSM66TRULT4",
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->delete("v1","multisig",$params);
*/

#Export a multisig
/*
$params['params']=array(
    "address" => "E6VH3C5XX57PT7LSZBETCJJRJRPZPSWAY5TEB7AWGEAQAWLCSM66TRULT4",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","export",$params);
*/

#Import a multisig
/*
$params['params']=array(
    "multisig_version" => "1",
    "pks" => array('eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w=='),
    "threshold" => 1,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","import",$params);
*/

#List multisig in wallet
/*
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","list",$params);
*/

#Sign a multisig transaction
/*
$params['params']=array(
    "partial_multisig" => array(
                                "Subsigs" => array(
                                                    "Key" => array(),
                                                    "Sig" => array(),
                                ),
                                "Threshold" => 1,
                                "Version" => 1
                          ),
    "public_key" => array(''),
    "signer" => array(''),
    "transaction" => $algorand_kmd->txn_encode(""),
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","multisig","sign",$params);
*/


#Sign a program for a multisig account
/*
$params['params']=array(
    "address" => "",
    "data" => $algorand_kmd->txn_encode(""),
    "partial_multisig" => array(
                                "Subsigs" => array(
                                                    "Key" => array(),
                                                    "Sig" => array(),
                                ),
                                "Threshold" => 1,
                                "Version" => 1
                          ),
    "public_key" => array(''),
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","multisig","signprogram",$params);
*/


#Sign program

/*
$params['params']=array(
    "address" => "",
    "data" => $algorand_kmd->txn_encode(""),
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","program","sign",$params);
*/

#Tip, use algod $return=$algorand->get("v2","transactions","params"); to get parameters for constructing a new transaction



#Build and Sign a transaction, for details: https://developer.algorand.org/docs/features/transactions
# Types: 
# appl = ApplicationCallTx allows creating, deleting, and interacting with an application
# cert = CompactCertTx records a compact certificate
# keyreg = KeyRegistrationTx indicates a transaction that registers participation keys
# acfg = AssetConfigTx creates, re-configures, or destroys an asset
# axfer = AssetTransferTx transfers assets between accounts (optionally closing)
# afrz = AssetFreezeTx changes the freeze status of an asset
# pay = PaymentTx indicates a payment transaction

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
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "apar" => array( //AssetParams
                        //"am" => "", //MetaDataHash
                        "an" => "MyToken", //AssetName
                        "au" => "https://mytoken.site", //URL
                        "c" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ClawbackAddr
                        "dc" => 2, //Decimals
                        "f" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //FreezeAddr
                        "m" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ManagerAddr
                        "r" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ReserveAddr
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
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "caid" => 185553584,
                "apar" => array( //AssetParams
                        "c" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ClawbackAddr
                        "f" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //FreezeAddr
                        "m" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ManagerAddr
                        "r" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ReserveAddr
                    ),
                
            ),
);
*/

#Destroy an Asset 
/*
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
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
                "arcv" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //AssetReceiver
                "snd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //Sender
                "fee" => 1000, //Fee
                "fv" => 13028464, //First Valid
                "lv" => 13028564, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "xaid" => 185553584, //XferAsset ID
            ),
);
*/

#Revoke an Asset
/*
$transaction=array(
        "txn" => array(
                "aamt" => 100,
                "type" => "axfer", //Tx Type
                "arcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //AssetReceiver
                "asnd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //AssetSender
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
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
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
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
                "aamt" => 100,
                "type" => "axfer", //Tx Type
                "arcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //AssetReceiver
                "snd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //Sender
                "fee" => 1000, //Fee
                "fv" => 13028982, //First Valid
                "lv" => 13029982, //Last Valid
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "xaid" => 185553584, //XferAsset ID
            ),
);
*/

#Payment Transaction (ALGO)
/*
$transaction=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 13071869, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 13072869, //Last Valid
                "note" => "Testes", //You note
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "rcv" => "IYVZLDFIF6KUMSDFVIKHPBT3FI5QVZJKJ6BPFSGIJDUJGUUASKNRA4HUHU", //Receiver
                "amt" => 1000, //Amount
            ),
);
*/


#Sign Transaction
/*
$params['params']=array(
   //"public_key" => $algorand_kmd->pk_encode("DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4"), (Opcional)
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes",
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);
echo $txn;
*/

#Broadcasts a raw transaction to the network.
/*
$algorand = new Algorand_algod('4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
if(!empty($return['response']->txId)){
    $txId=$return['response']->txId;
    echo "txId: $txId";
}
*/

#Atomic Transaction
/*
//Transaction 1
$transactions=array();
$transactions[]=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 13089936, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 13090936, //Last Valid
                "note" => "Testes", //You note
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "rcv" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //Receiver
                "amt" => 1000, //Amount
            ),
);

//Transaction 2
$transactions[]=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 13089936, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 13090936, //Last Valid
                "note" => "Testes", //You note
                "snd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //Sender
                "rcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Receiver
                "amt" => 1000, //Amount
            ),
);

$groupid=$algorand_kmd->groupid($transactions);

#Assigns Group ID
$transactions[0]['txn']['grp']=$groupid;
$transactions[1]['txn']['grp']=$groupid;


#Sign Transaction 1
$txn="";
$params['params']=array(
   //"public_key" => $algorand_kmd->pk_encode("DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4"),
   "transaction" => $algorand_kmd->txn_encode($transactions[0]),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes",
);


$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn.=base64_decode($r->signed_transaction);


#Sign Transaction 2
$params['params']=array(
   //"public_key" => $algorand_kmd->pk_encode("DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY"),
   "transaction" => $algorand_kmd->txn_encode($transactions[1]),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes",
);
$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn.=base64_decode($r->signed_transaction);

echo $txn;


#Broadcasts a raw atomic transaction to the network.

$algorand = new Algorand_algod('4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
if(!empty($return['response']->txId)){
    $txId=$return['response']->txId;
    echo "txId: $txId";
}
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
