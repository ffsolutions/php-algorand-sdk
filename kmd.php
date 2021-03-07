<?php
#References
#https://developer.algorand.org/docs/reference/rest-apis/kmd/

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

#Sign a multisig transaction {Under construction}
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
    "transaction" => "", // Pattern : "^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==\|[A-Za-z0-9+/]{3}=)?$"
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","multisig","sign",$params);
*/


#Sign a program for a multisig account  {Under construction}
/*
$params['params']=array(
    "address" => "",
    "data" => "", //Pattern : "^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==\|[A-Za-z0-9+/]{3}=)?$"
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


#Sign program  {Under construction}
/*
$params['params']=array(
    "address" => "",
    "data" => "", //Pattern : "^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==\|[A-Za-z0-9+/]{3}=)?$"
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","program","sign",$params);
*/

#Tip, use algod $return=$algorand->get("v2","transactions","params"); to get parameters for constructing a new transaction

#Sign a transaction, for details: https://developer.algorand.org/docs/features/transactions  {Coming soon with a simplified version}
/*
$transaction=array(
        "txn" => array(
                "amt" => 1000, //Amount
                "fee" => 1000, //Fee
                "fv" => 12435315, //FirstValid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //GenesisHash
                "lv" => 12437315, //LastValid
                "note" => "Test", //You note
                "rcv" => "XEVVHLG63NUNHSSXAKFPSUOUILJ7C22AFDTTEU2IPDBYERS2FFY5U6YCLM", //Receiver
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "type" => "pay" //TxType
            ),
);
$params['params']=array(
   //public_key = array(''), //Opcional
   "transaction" => $algorand_kmd->txn_encode($transaction),  //Pattern : "^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==\|[A-Za-z0-9+/]{3}=)?$"
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","transaction","sign",$params);
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
