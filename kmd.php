<?php
require_once 'sdk/algorand.php';

$algorand_kmd = new Algorand("kmd","{kmd-token}","localhost",7833); //get the token key in data/kmd-{version}/kmd.token and port in data/kmd-{version}/kmd.net
$algorand_transactions = new Algorand_transactions;

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
    "wallet_name" => "wallet1",
    "wallet_password" => "tests",
    "wallet_driver_name" => "sqlite",
);
$return=$algorand_kmd->post("v1","wallet",$params);
*/

#Wallet List
//$return=$algorand_kmd->get("v1","wallets");

#Wallet Init
/*
$params['params']=array(
    "wallet_id" => "a735ea8218798325f7f5e5c24fad608b",
    "wallet_password" => "tests",
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
    "wallet_id" => "a735ea8218798325f7f5e5c24fad608b",
    "wallet_name" => "wallet2",
    "wallet_password" => "tests",
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
    "address" => "IPGDIZRKKXBRYUW5YTIXYYU6ER4PIS4DSKEZTYLKROZQTTMANWWYYQW3RI",
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "tests"
);
$return=$algorand_kmd->delete("v1","key",$params);
*/

#Export a key
/*
$params['params']=array(
    "address" => "2QAXTOHQJQH6I4FM6RWUIISXKFJ2QA4NVWELMIJ5XAKZB4N4XIEX7F5KPU",
    "wallet_password" => "tests",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);

$export=json_decode($return['response']);

print_r($export);

require_once 'sdk/algokey.php';
$algokey=new algokey;

$words=$algokey->privateKeyToWords($export->private_key);

print_r($words);
*/

#Import a key
/*
require_once 'sdk/algokey.php';

$algokey=new algokey;
$words="ripple trap smoke crop name donor sun actor wreck disease mushroom sweet because phrase involve sail umbrella control swing uncle card phrase human absent marble";
$words_array=explode(" ",$words);

$privatekey=$algokey->WordsToPrivateKey($words_array);

$params['params']=array(
    "private_key" => $privatekey,
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
    "transaction" => $algorand_transactions->encode(""),
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","multisig","sign",$params);
*/


#Sign a program for a multisig account
/*
$params['params']=array(
    "address" => "",
    "data" => $algorand_transactions->encode(""),
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
    "data" => $algorand_transactions->encode(""),
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","program","sign",$params);
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
