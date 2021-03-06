Instructions to add the PHP Algorand SDK (Developer Docs):

Page: https://developer.algorand.org/docs/build-apps/connect/

2. Connect to Node
Create an algod client

PHP code:

require_once 'sdk/algorand.php';
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);

Check node status
PHP code:

$return=$algorand->get("v2","status");


Check suggested transaction parameters
PHP code:

$return=$algorand->get("v2","transactions","params");


Page: https://developer.algorand.org/docs/build-apps/hello_world/

Create an account
Generate a public/private key pair
PHP Code:

require_once 'sdk/algorand.php';
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => "{wallet_handle_token}"
);
$return=$algorand_kmd->post("v1","key",$params);
print_r($return);


Connect your client
require_once 'sdk/algorand.php';
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

Check your balance
PHP Code:

$return=$algorand->get("v1","account","{address}");


Construct the transaction
$return=$algorand->get("v2","transactions","params");


Sign the transaction
PHP Code:

require_once 'sdk/algorand.php';
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);
$params['params']=array(
    "public_key" => array(''),
    "transaction" => "",
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","transaction","sign",$params);

Submit the transaction
PHP Code:

require_once 'sdk/algorand.php';
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['file']="t1.stxn";
$return=$algorand->post("v2","transactions",$params);


Wait for confirmation
PHP code:
require_once 'sdk/algorand.php';
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$return=$algorand->get("v2","transactions","pending","?format=json&max=2");


Read the transaction from the blockchain
PHP Code:
require_once 'sdk/algorand.php';
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$return=$algorand->get("v1","account","{address}","transaction","{txid}");


Page: https://developer.algorand.org/docs/features/accounts/create/

Create a wallet and generate an account
PHP Code:

require_once 'sdk/algorand.php';
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);
$params['params']=array(
    "wallet_name" => "{name}",
    "wallet_password" => "testes",
    "wallet_driver_name" => "sqlite",
);
$return=$algorand_kmd->post("v1","wallet",$params);
print_r($return);_

$params['params']=array(
    "wallet_id" => "4596a5cb20ccbedcec668762449363c1",
    "wallet_password" => "testes",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
print_r($return);_


Recover wallet and regenerate account
PHP Code:

$params['params']=array(
    "private_key" => "eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w==",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","import",$params);


Export an account
PHP Code:

$params['params']=array(
    "address" => "XI56XZXQ64QD7IO5UBRC2RBZP6TQHP5WEILLFMBTKPXRKK7343R3KZAWNQ",
    "wallet_password" => "testes",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);


Import an account
PHP Code:
$params['params']=array(
    "private_key" => "eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w==",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","import",$params);


How to generate a standalone account
PHP Code:

$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);


Multisignature
How to generate a multisignature account
PHP Code:
$params['params']=array(
    "multisig_version" => "1",
    "pks" => array('eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w=='),
    "threshold" => 1,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","import",$params);


Page: https://developer.algorand.org/docs/features/transactions/signatures/

Multisignatures
PHP Code:

//Create
$params['params']=array(
    "multisig_version" => "1",
    "pks" => array('eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w=='),
    "threshold" => 1,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","import",$params);


//Sigining
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


//Sending
$params['file']="t1.stxn";
$return=$algorand->post("v2","transactions",$params);
