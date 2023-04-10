<?php
require_once 'sdk/algokey.php';
require_once 'sdk/algorand.php';
$algokey=new algokey;
$algorand_transactions = new Algorand_transactions;


//Generate New Key/Account/Address
/*
$key=$algokey->generate();
print_r($key);
echo "Words to string: ".implode(" ",$key['words'])."\n";
*/

//Words to Private Key and Public Key (Array)
/*
$words=explode(" ","connect produce defense output sibling idea oil siege decline dentist faint electric method notice style cook unlock rice confirm host tone test vehicle able keen"); //2OEZACD77WSR5C2HFEHO2BYHQEATOGFIUW3REGKOGNPPNYPPLROHDU2CQE
$privateKey=$algokey->WordsToPrivateKey($words); //Array
$privateKey_decoded=base64_decode($privateKey);
$publicKey=$algokey->publicKeyFromPrivateKey($privateKey);
$publicKey_decoded=$algokey->publicKeyFromPrivateKey($privateKey,false);
echo "Private Key: ".$privateKey."\n";
echo "Private Key decoded: ".$privateKey_decoded."\n";
echo "Public Key B32: ".$publicKey."\n";
echo "Public Key decoded: ".$publicKey_decoded."\n";
*/

//Private Key to Words
/*
$privateKey="eenqctbZ48E5E8jHoc6jdhTGW/q6L3BP7l3gJnJ+P17TiZAIf/2lHotHKQ7tBweBATcYqKW3EhlOM1724e9cXA==";
$return_words=$algokey->privateKeyToWords($privateKey);
print_r($return_words);
echo "Words: ".implode(" ",$return_words)."\n";
*/


#Sign Transaction with Algokey PHP
/*
$transaction=array(
        "txn" => array(
                "type" => "pay", //Tx Type
                "fee" => 1000, //Fee
                "fv" => 28237321, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=", //Genesis Hash
                "lv" => 28238321, //Last Valid
                "note" => "", //You note
                "snd" => "2QAXTOHQJQH6I4FM6RWUIISXKFJ2QA4NVWELMIJ5XAKZB4N4XIEX7F5KPU", //Sender
                "rcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Receiver
                "amt" => 1003, //Amount
            ),
);

$transaction_raw=$algorand_transactions->encode($transaction);
$signature=$algokey->sign($transaction_raw,$privateKey);

#Broadcasts a raw transaction to the network.
$transaction_raw_signed=$algorand_transactions->encode($transaction,true,$signature);

$algorand = new Algorand("algod","4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7","localhost",53898);
$params['transaction']=$transaction_raw_signed;
print_r($params);
$return=$algorand->post("v2","transactions",$params);
print_r($return);
*/

?>