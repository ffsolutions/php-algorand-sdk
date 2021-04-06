## Relationship with Developer Docs Portal
https://developer.algorand.org/docs/

### Page: https://developer.algorand.org/docs/build-apps/connect/
#### Create an algod client
```php
include('sdk/algorand.php');
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
```

#### Check node status
```php
$return=$algorand->get("v2","status");
```

#### Check suggested transaction parameters
```php
$return=$algorand->get("v2","transactions","params");
```

### Page: https://developer.algorand.org/docs/build-apps/hello_world/
#### Generate a public/private key pair
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

#Generate Account
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
print_r($return);

#Export a key
$params['params']=array(
    "address" => $response->address,
    "wallet_password" => "{wallet_password}",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);
print_r($return);
```

#### Connect your client
```php
include('sdk/algorand.php');
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
```

#### Check your balance
```php
$return=$algorand->get("v1","account","{address}");
```

#### Construct the transaction
```php
$transaction=array(
        "txn" => array(
                "fee" => 1000, //Fee
                "fv" => 12581127, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "lv" => 12582127, //Last Valid
                "note" => "", //Your note
                "snd" => "{sender-address}", //Sender
                "type" => "pay", //Tx Type
                "rcv" => "{receive-address}", //Receiver
                "amt" => 1000, //Amount
            ),
);
```

#### Sign the transaction
```php
#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => ""
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);
```

#### Submit the transaction
```php
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
```

#### Wait for confirmation
```php
$return=$algorand->get("v2","transactions","pending","{txid}","?format=json");
```

#### Read the transaction from the blockchain
```php
$return=$algorand->get("v1","account","{address}","transaction","{txid}");
```

### Page: https://developer.algorand.org/docs/features/accounts/create/
#### Create a wallet and generate an account
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Create a wallet
$params['params']=array(
    "wallet_name" => "",
    "wallet_password" => "",
    "wallet_driver_name" => "sqlite",
);
$return=$algorand_kmd->post("v1","wallet",$params);
print_r($return);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

#Generate a account
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
print_r($return);
```

#### Recover wallet and regenerate account
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Recover a wallet
$params['params']=array(
	"master_derivation_key" => "{master-key}",
    "wallet_name" => "",
    "wallet_password" => "",
    "wallet_driver_name" => "sqlite",
);
$return=$algorand_kmd->post("v1","wallet",$params);
print_r($return);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

#Regenerate a account
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
print_r($return);
```

#### Export an account
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

#Export an account
$params['params']=array(
    "address" => "{address}",
    "wallet_password" => "",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);
```

#### How to generate a standalone account
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

#Regenerate a key
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
print_r($return);

#Export a key
$params['params']=array(
    "address" => $response->address,
    "wallet_password" => "",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);
```

#### How to generate a multisignature account
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

$params['params']=array( "display_mnemonic" => false, "wallet_handle_token" => $wallet_handle_token );

#Account 1
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
$account1=$response->address;

#Account 2
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
$account2=$response->address;

#Account 3
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
$account3=$response->address;

#Create Multisig Account
$params['params']=array(
    "multisig_version" => "1",
    "pks" => array($account1,$account2,$account3),
    "threshold" => 1,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","import",$params);
$response=json_encode($return['response']);

#Export a key
$params['params']=array(
    "address" => $response->address,
    "wallet_password" => "",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);
print_r($return);
```

### Page: https://developer.algorand.org/docs/features/transactions/signatures/
#### Multisignatures
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

$params['params']=array( "display_mnemonic" => false, "wallet_handle_token" => $wallet_handle_token );

#Account 1
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
$account1=$response->address;

#Account 2
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
$account2=$response->address;

#Account 3
$return=$algorand_kmd->post("v1","key",$params);
$response=json_encode($return['response']);
$account3=$response->address;

#Create Multisig Account
$params['params']=array(
    "multisig_version" => "1",
    "pks" => array($account1,$account2,$account3),
    "threshold" => 1,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","import",$params);
$response=json_encode($return['response']);

#Create a Transaction
$transaction=array(
        "txn" => array(
                "fee" => 1000, //Fee
                "fv" => 12581127, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "lv" => 12582127, //Last Valid
                "note" => "", //Your note
                "snd" => "{sender-address}", //Sender
                "type" => "pay", //Tx Type
                "rcv" => "{receive-address}", //Receiver
                "amt" => 1000, //Amount
            ),
);

#Sign Transaction
$params['params']=array(
    "public_key" => array($account1,$account2,$account3),
    "transaction" => $algorand_kmd->txn_encode($transaction),
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => ""
);
$return=$algorand_kmd->post("v1","multisig","sign",$params);
print_r($return);
```

### Page: https://developer.algorand.org/docs/features/transactions/offline_transactions/
#### Unsigned Transaction File Operations
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);
$transaction=array(
        "txn" => array(
                "fee" => 1000, //Fee
                "fv" => 12581127, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "lv" => 12582127, //Last Valid
                "note" => "", //Your note
                "snd" => "{sender-address}", //Sender
                "type" => "pay", //Tx Type
                "rcv" => "{receive-address}", //Receiver
                "amt" => 1000, //Amount
            ),
);
$txn=$algorand_kmd->txn_encode($transaction);
$fp = fopen('transactions/unsigned.txn', 'w');  
fwrite($fp, $txn);  
fclose($fp);

#Read and sign transaction
#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

$transaction_file=file_get_contents("transactions/unsigned.txn");
$params['params']=array(
   "transaction" => $transaction_file,
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => ""
);
$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Send signed transaction to node
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
print_r($return);
```

#### Signed Transaction File Operations
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);
$transaction=array(
        "txn" => array(
                "fee" => 1000, //Fee
                "fv" => 12581127, //First Valid
                "gen" => "mainnet-v1.0", // GenesisID
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "lv" => 12582127, //Last Valid
                "note" => "", //Your note
                "snd" => "{sender-address}", //Sender
                "type" => "pay", //Tx Type
                "rcv" => "{receive-address}", //Receiver
                "amt" => 1000, //Amount
            ),
);

#Sign transaction and write to file
#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;

$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => ""
);
$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);
$fp = fopen('transactions/signed.txn', 'w');  
fwrite($fp, $txn);  
fclose($fp);

#Send signed transaction to node
$params['file']="transactions/signed.stxn";
$return=$algorand->post("v2","transactions",$params);
print_r($return);
```

### Page: https://developer.algorand.org/docs/features/asa/
#### Creating an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
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

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Modifying an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "caid" => 185553584,
                "apar" => array( //AssetParams
                        "c" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ClawbackAddr
                        "f" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //FreezeAddr
                        "m" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ManagerAddr
                        "r" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //ReserveAddr
                    ),

            ),
);

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Receiving an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
$transaction=array(
        "txn" => array(
                "type" => "axfer", //Tx Type
                "arcv" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //AssetReceiver
                "snd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //Sender
                "fee" => 1000, //Fee
                "fv" => 13028464, //First Valid
                "lv" => 13028564, //Last Valid
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "xaid" => 185553584, //XferAsset ID
            ),
);

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Transferring an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
$transaction=array(
        "txn" => array(
                "aamt" => 100,
                "type" => "axfer", //Tx Type
                "arcv" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //AssetReceiver
                "snd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //Sender
                "fee" => 1000, //Fee
                "fv" => 13028982, //First Valid
                "lv" => 13029982, //Last Valid
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "xaid" => 185553584, //XferAsset ID
            ),
);

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Freezing an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
$transaction=array(
        "txn" => array(
                "afrz" => false,
                "type" => "afrz", //Tx Type
                "fadd" => "DOVA6TULHNY2DCS65LVT5QYLWZGM7WC2GISPRGNDWDUH3KUX56ZLQJW3AY", //FreezeAccount
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13029982, //First Valid
                "lv" => 13023082, //Last Valid
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "faid" => 185553584, //FreezeAsset
            ),
);

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Revoking an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
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
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "xaid" => 185553584, //XferAsset ID
            ),
);

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Destroying an Asset
```php
include('sdk/algorand.php');
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988);

#Wallet Init
$params['params']=array(
    "wallet_id" => "",
    "wallet_password" => "",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
$transaction=array(
        "txn" => array(
                "type" => "acfg", //Tx Type
                "snd" => "DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4", //Sender
                "fee" => 1000, //Fee
                "fv" => 13027977, //First Valid
                "lv" => 13028977, //Last Valid
                "gh" => "YBQ4JWH4DW655UWXMBF6IVUOH5WQIGMHVQ333ZFWEC22WOJERLPQ=", //Genesis Hash
                "caid" => 185553584, //ConfigAsset ID
            ),
);

#Sign Transaction
$params['params']=array(
   "transaction" => $algorand_kmd->txn_encode($transaction),
   "wallet_handle_token" => $wallet_handle_token,
   "wallet_password" => "testes"
);

$return=$algorand_kmd->post("v1","transaction","sign",$params);
$r=json_decode($return['response']);
$txn=base64_decode($r->signed_transaction);

#Broadcasts a raw transaction to the network.
$algorand = new Algorand_algod('{algod-token}',"localhost",53898);
$params['transaction']=$txn;
$return=$algorand->post("v2","transactions",$params);
$txId=$return['response']->txId;
echo "txId: $txId";
```

#### Retrieve Asset Information
```php
include('sdk/algorand.php');  
$algorand  =  new  Algorand_algod('{algod-token}',"localhost",53898);
$return=$algorand->get("v2","assets","{asset-id}");
```
