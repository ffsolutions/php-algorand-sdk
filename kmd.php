<?php
require_once 'sdk/algorand.php';

$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64212); //get the token key in data/kmd-{version}/kmd.token and port in data/kmd-{version}/kmd.net


$algorand_kmd->debug(1);
//algorand->setSSL('/home/felipe/certificate.cert'); //Optional

#Just uncomment to try all avaliable functions

#Get Versions
$return=$algorand_kmd->get("versions");

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

#Sign a transaction, for details and other types: https://developer.algorand.org/docs/features/transactions

#Payment Transaction
/*
$transaction=array(
        "txn" => array(
                "fee" => 1000, //Fee
                "fv" => 12581127, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "lv" => 12582127, //Last Valid
                "note" => "Testes", //You note
              //  "gp" => "", //Group
              //  "lx" => "", //Lease
              //  "rekey" => "", //Rekey To
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "type" => "pay", //Tx Type
                "rcv" => "IYVZLDFIF6KUMSDFVIKHPBT3FI5QVZJKJ6BPFSGIJDUJGUUASKNRA4HUHU", //Receiver
                "amt" => 1000, //Amount
              //  "close" => "", //Close Remainder To
            ),
);

$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

*/

#Broadcasts a raw transaction to the network from /v1/transaction/sign.
/*
$algorand = new Algorand_algod('4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
*/

#Full response with debug (json response)
print_r($return);
#Only response array
print_r(json_decode($return['response']));
#Only erros messages  array
print_r(json_decode($return['message']));

//For definitions:
//https://developer.algorand.org/docs/reference/rest-apis/kmd/#generatekeyrequest
?>
