# PHP Algorand SDK (REST APIs algod, kmd and indexer)

All files in this directory will show you about the best pratices that you should do when implementing  **php-algorand-sdk** into your project.


## Requirements
- PHP 5.3 and above.
- Built-in libcurl support.


## Quick start

For running this example, you need to install `php-algorand-sdk` library before, and start the node.
```
$ git clone https://github.com/ffsolutions/php-algorand-sdk
$ ./goal node start -d data
$ ./goal kmd start -d data
$ ./algorand-indexer daemon -h -d data
```


After cloning the repository, you need to include the `php-algorand-sdk`:
```php
require_once 'sdk/algorand.php';
```


For use the **algod**:
```php
$algorand = new Algorand_algod('{algod-token}',"localhost",53898); //get the token key in data/algod.token
$return=$algorand->get("v2","status");
print_r($return);
```
(see all avaliable functions in **algod.php**)


For use the **kmd**:
```php
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988); //get the token key in data/kmd-{version}/kmd.token
$return=$algorand_kmd->get("versions");
print_r($return);
```
(see all avaliable functions in **kmd.php**)


For use the **indexer**: 
```php
$algorand_indexer = new Algorand_indexer('{algorand-indexer-token}',"localhost",8089);
$return=$algorand_indexer->get("health");
print_r($return);
```
(see all avaliable functions in **indexer.php**)


## Complete Guide (Coming soon video)

### Node setup (macOS and Linux)
Verified on macOS Big Sur 11.2.2 and Ubuntu 20.04

For other cases, follow the instructions in Algorand's [developer resources](https://developer.algorand.org/docs/run-a-node/setup/install/) to install a node on your computer.

### Steps:
- 1- Installing Algorand Node
- 2- Installing and Using the **PHP Algorand SDK**


### For macOS only, for Linux skip this step.
#### Intall Homebrew (https://brew.sh/)

Paste that in a macOS Terminal or Linux shell prompt. The script explains what it will do and then pauses before it does it.
```
$ /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
$ brew install wget
$ brew install htop
```


### For macOS and Linux:
Create a temporary folder to hold the install package and files:
```
$ mkdir ~/node
$ cd ~/node
```


Download the updater script:
```
$ wget https://raw.githubusercontent.com/algorand/go-algorand-doc/master/downloads/installers/update.sh
```


Ensure that your system knows it's an executable file:
```
$ chmod +x update.sh
```


Run the installer from within your node directory:
```
$ ./update.sh -i -c stable -p ~/node -d ~/node/data -n
```


For Apple Silicon (Mac M1) users: 
```
$ arch -x86_64 ./update.sh -i -c stable -p ~/node -d ~/node/data -n
```


Create and change the config.json
```
$ cp data/config.json.example data/config.json
$ chmod 777 data/config.json
$ cp data/kmd-v0.5/kmd_config.json.example data/kmd-v{version}/kmd_config.json
$ chmod 777 data/kmd-v{version}/kmd_config.json
$ vim data/config.json AND vim data/kmd-v{version}/kmd_config.json
```


Change the line, press I to enable edition, make changes, press ESC and type :w + [enter], :q + [enter] to finish.
```
"EndpointAddress": "127.0.0.1:0",  
to
"EndpointAddress": "127.0.0.1:53898",
```


Start Node: 
```
./goal node start -d data
./goal kmd start -d data
./algorand-indexer daemon -h -d data
```


To see if the node is running:
```
$ htop
```
Press F10 to close the htop



### Sync Node Network using Fast Catchup
Fast Catchup is a new feature and will rapidly update a node using catchpoint snapshots. A new command on goal node is now available for catchup. The entire process should sync a node in minutes rather than hours or days. 


### Get the catchpoint
```
$ wget -qO- https://algorand-catchpoints.s3.us-east-2.amazonaws.com/channel/mainnet/latest.catchpoint
```


Use the sync point captured above and paste into the catchup option
```
./goal node catchup 12400000#ZHHAYEVVUXHMDVIRFUFQLI7DUUMJAEDCJN7WPG6OD4DRBBIWK5UA -d data
```


Node Status: 
``
./goal node status -d data
``
Results should show 5 Catchpoint status lines for Catchpoint, total accounts, accounts processed, total blocks , downloaded blocks. 
Notice that the 5 Catchpoint status lines will disappear when completed, and then only a few more minutes are needed so sync from that point to the current block. ***Once there is a Sync Time of 0, the node is synced and if fully usable***.
```
Last committed block: 11494
Sync Time: 58.1s
Catchpoint: 12400000#ZHHAYEVVUXHMDVIRFUFQLI7DUUMJAEDCJN7WPG6OD4DRBBIWK5UA
Catchpoint total accounts: 9133629
Catchpoint accounts processed: 7786496
Catchpoint accounts verified: 0
Genesis ID: mainnet-v1.0
Genesis hash: wGHE2Pwdvd7S12BL5FaOP20EGYesN73ktiC1qzkkit8=
```


## Installing and Using the Algorand PHP SDK
Get the node tokens and address:
```
$ cat data/algod.token
$ cat data/kmd-{version}/kmd.token
$ cat data/kmd-{version}/kmd.net
```


Clone Git Hub Project
```
$ git clone https://github.com/ffsolutions/php-algorand-sdk.git
```


After cloning the repository, you need to include the `php-algorand-sdk`:
```php
require_once 'sdk/algorand.php';
```


## For use the **algod**: 
Start the SDK
```php
$algorand = new Algorand_algod('{algod-token}',"localhost",53898); //get the token key in data/algod.token
```

### Get the versions
```php
$return=$algorand->get("versions");
```


### Gets the current node status.
```php
$return=$algorand->get("v2","status");
```


### Gets the node status after waiting for the given round.
```php
$return=$algorand->get("v2","status","wait-for-block-after",12385949);
```


### Gets the genesis information.
```php
$return=$algorand->get("genesis");
```


### Returns 200 (OK) if healthy.
```php
$return=$algorand->get("health");
```


### Return metrics about algod functioning.
```php
$return=$algorand->get("metrics");
```


### Gets the current swagger spec.
```php
$return=$algorand->get("swagger.json");
```


### Check your balance.
```php
$return=$algorand->get("v1","account","{address}");
```


### Get health, Returns 200 if healthy.
```php
$return=$algorand_indexer->get("health");
```


### Return metrics about algod functioning.
```php
$return=$algorand->get("metrics");
```


### Get a specific confirmed transaction.
```php
$return=$algorand->get("v1","account","{address}","transaction","{txid}");
```


### Get a list of unconfirmed transactions currently in the transaction pool by address.
```php
$return=$algorand->get("v1","account","{address}","transactions","pending");
```


### Get account information.
```php
$return=$algorand->get("v2","accounts","{address}","?format=json"); //?format=json or msgpack (opcional, default json)
```


### Get a list of unconfirmed transactions currently in the transaction pool by address.
```php
$return=$algorand->get("v2","accounts","{address}","transactions","pending","?format=json&max=2");
```


### Get application information.
```php
$return=$algorand->get("v2","applications","{application-id}");
```


### Get asses.
```php
$return=$algorand->get("v1","assets");
```


### Get asset information.
```php
$return=$algorand->get("v2","assets","{asset-id}");
```


### Get the block for the given round.
```php
$return=$algorand->get("v1","block",12424111);
```


### Get the block for the given round.
```php
$return=$algorand->get("v2","blocks",12385287);
```


### Starts a catchpoint catchup. For the last catchpoint access: https:```
algorand-catchpoints.s3.us-east-2.amazonaws.com/channel/mainnet/latest.catchpoint
```php
$return=$algorand->post("v2","catchup","{catchpoint}");
```


### Aborts a catchpoint catchup.
```php
$return=$algorand->delete("v2","catchup","{catchpoint}");
```


### Get the current supply reported by the ledger.
```php
$return=$algorand->get("v2","ledger","supply");
```


### Generate (or renew) and register participation keys on the node for a given account address.
```php
$params['params'] = array(
                        "fee"=>1000,
                        "key-dilution" => 10000,
                        "no-wait" => false,
                        "round-last-valid" => 22149901
                    );

$return=$algorand->post("v2","register-participation-keys","{address}",$params);
```


### Special management endpoint to shutdown the node. Optionally provide a timeout parameter to indicate that the node should begin shutting down after a number of seconds.
```php
$params['params']=array("timeout" => 0);
$return=$algorand->post("v2","shutdown", $params);
```


### Compile TEAL source code to binary, produce its hash
```php
$params['body']="";
$return=$algorand->post("v2","teal","compile",$params);
```


### Provide debugging information for a transaction (or group).
```php
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
```


### Get the suggested fee
```php
$return=$algorand->get("v1","transactions","fee");
```


### Get an information of a single transaction.
```php
$return=$algorand->get("v1","transaction","{txid}"); //start the algorand-indexer to run
```


### Broadcasts a raw transaction to the network.
Generate and Sign the transaction:
```
$ ./goal clerk send -a 1000 -f DI65FPLNUXOJJR47FDTIB5TNNIA5G4EZFA44RZMRBE7AA4D453OYD2JCW4 -t IYVZLDFIF6KUMSDFVIKHPBT3FI5QVZJKJ6BPFSGIJDUJGUUASKNRA4HUHU -d data -o transactions/tran.txn
$ ./goal clerk sign --infile="trans/tran.txn" --outfile="trans/tran.stxn" -d data
```

```php
$params['file']="t1.stxn";
$return=$algorand->post("v2","transactions",$params);
```


### Get parameters for constructing a new transaction
```php
$return=$algorand->get("v2","transactions","params");
```


### Get a list of unconfirmed transactions currently in the transaction pool.
```php
$return=$algorand->get("v2","transactions","pending","?format=json&max=2");
```


### Get a specific pending transaction.
```php
$return=$algorand->get("v2","transactions","pending","{txid}","?format=json");
```


For more details: https://developer.algorand.org/docs/reference/rest-apis/algod/v2/

## For use the **kmd**:
Start the SDK
```php
$algorand_kmd = new Algorand_kmd('{kmd-token}',"localhost",64988); //get the token key in data/kmd-{version}/kmd.token
```

#### Get Versions
```php
$return=$algorand_kmd->get("versions");
```

#### Get swagger.json
```php
$return=$algorand_kmd->get("swagger.json");
```

#### Create Wallet
```php
$params['params']=array(
    "wallet_name" => "Carteira1",
    "wallet_password" => "testes",
    "wallet_driver_name" => "sqlite",
);
$return=$algorand_kmd->post("v1","wallet",$params);
```

#### Wallet List
```php
$return=$algorand_kmd->get("v1","wallets");
```

#### Wallet Init
```php
$params['params']=array(
    "wallet_id" => "4596a5cb20ccbedcec668762449363c1",
    "wallet_password" => "testes",
);
$return=$algorand_kmd->post("v1","wallet","init",$params);
$return_array=json_decode($return['response']);
$wallet_handle_token=$return_array->wallet_handle_token;
```


#### Wallet Info
```php
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token,
);
$return=$algorand_kmd->post("v1","wallet","info",$params);
```


#### Wallet Rename
```php
$params['params']=array(
    "wallet_id" => "4596a5cb20ccbedcec668762449363c1",
    "wallet_name" => "Carteira 1",
    "wallet_password" => "testes",
);
$return=$algorand_kmd->post("v1","wallet","rename",$params);
```


#### Wallet Handle Token Release
```php
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token,
);
$return=$algorand_kmd->post("v1","wallet","release",$params);
```


#### Wallet Handle Token Renew
```php
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token,
);
$return=$algorand_kmd->post("v1","wallet","renew",$params);
```


#### Generate a key
```php
$params['params']=array(
    "display_mnemonic" => false,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key",$params);
```


#### Delete a key
```php
$params['params']=array(
    "address" => "HNVCPPGOW2SC2YVDVDICU3YNONSTEFLXDXREHJR2YBEKDC2Z3IUZSC6YGI",
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->delete("v1","key",$params);
```


#### Export a key
```php
$params['params']=array(
    "address" => "XI56XZXQ64QD7IO5UBRC2RBZP6TQHP5WEILLFMBTKPXRKK7343R3KZAWNQ",
    "wallet_password" => "testes",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","export",$params);
```


#### Import a key
```php
$params['params']=array(
    "private_key" => "eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w==",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","import",$params);
```


#### List keys in wallet
```php
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","key","list",$params);
```


#### Master Key export
```php
$params['params']=array(
    "wallet_password" => "testes",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","master-key","export",$params);
```


#### Delete a multisig
```php
$params['params']=array(
    "address" => "HNVCPPGOW2SC2YVDVDICU3YNONSTEFLXDXREHJR2YBEKDC2Z3IUZSC6YGI",
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->delete("v1","multisig",$params);
```


#### Export a multisig
```php
$params['params']=array(
    "address" => "E6VH3C5XX57PT7LSZBETCJJRJRPZPSWAY5TEB7AWGEAQAWLCSM66TRULT4",
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","export",$params);
```


#### Import a multisig
```php
$params['params']=array(
    "multisig_version" => "1",
    "pks" => array('eGTs9KCLHSUcf2JUIUV7EIkjH2dQQX3AyeGUDZ7MfM26O+vm8PcgP6HdoGItRDl/pwO/tiIWsrAzU+8VK/vm4w=='),
    "threshold" => 1,
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","import",$params);
```


#### List multisig in wallet
```php
$params['params']=array(
    "wallet_handle_token" => $wallet_handle_token
);
$return=$algorand_kmd->post("v1","multisig","list",$params);
```


#### Sign a multisig transaction {Under construction}
```php
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
```


#### Sign a program for a multisig account {Under construction}
```php
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
```


#### Sign program {Under construction}
```php
$params['params']=array(
    "address" => "",
    "data" => "", //Pattern : "^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==\|[A-Za-z0-9+/]{3}=)?$"
    "wallet_handle_token" => $wallet_handle_token,
    "wallet_password" => "testes"
);
$return=$algorand_kmd->post("v1","program","sign",$params);
```


#### Sign a transaction {Under construction}
```php
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
```


For more details: https://developer.algorand.org/docs/reference/rest-apis/kmd/


## For use the **indexer**: 
Start the SDK
```php
$algorand_indexer = new Algorand_indexer('{algorand-indexer-token}',"localhost",8089);
```


#### Get health, Returns 200 if healthy.
```php
$return=$algorand_indexer->get("health");
```


#### Search for accounts.
```php
$query=http_build_query(array(
    "application-id" => 0, //integer
    "asset-id" => 0, //integer
    "auth-addr" => "", //string
    "currency-greater-than" => 0, //integer
    "currency-less-than" => 0, //integer
    "limit" => 0, //integer
    "next" => "", //string
    "round" => 0, //integer
));
$return=$algorand_indexer->get("v2","accounts","?".$query);
```


#### Lookup account information.
```php
$return=$algorand_indexer->get("v2","accounts","{account-id}");
```


#### Lookup account transactions.
```php
$return=$algorand_indexer->get("v2","accounts","{account-id}","transactions");
```


#### Search for applications
```php
$query=http_build_query(array(
    "application-id" => 0, //integer
    "limit" => 0, //integer
    "next" => 0, //string
));
$return=$algorand_indexer->get("v2","applications","?".$query);
```


#### Lookup application.
```php
$return=$algorand_indexer->get("v2","applications","{application-id}");
```


#### Search for assets.
```php
$query=http_build_query(array(
    "asset-id" => 0, //integer
    "creator" => "", //integer
    "limit" => 0, //integer
    "name" => "", //string
    "next" => "", //string
    "unit" => "", //string
));
$return=$algorand_indexer->get("v2","assets","?".$query);
```


#### Lookup asset information.
```php
$return=$algorand_indexer->get("v2","assets","{asset-id}");
```


#### Lookup the list of accounts who hold this asset
```php
$query=http_build_query(array(
    "currency-greater-than" => 0, //integer
    "currency-less-than" => 0, //integer
    "limit" => 0, //integer
    "next" => "", //string
    "round" => 0, //string
));
$return=$algorand_indexer->get("v2","assets","{asset-id}","balances","?".$query);
```


#### Lookup the list of accounts who hold this asset
```php
$query=http_build_query(array(
    "address" => "", //string
    "address-role" => "", //enum (sender, receiver, freeze-target)
    "after-time" => "", //string (date-time)
    "before-time" => "", //string (date-time)
    "currency-greater-than" => 0, //integer
    "currency-less-than" => 0, //integer
    "exclude-close-to" => false, //boolean
    "limit" => 0, //integer
    "max-round" => 0, //integer
    "min-round" => 0, //integer
    "next" => "", //string
    "note-prefix" => "", //string
    "rekey-to" => false, //boolean
    "round" => 0, //integer
    "sig-type" => "", //enum (sig, msig, lsig)
    "tx-type" => "", //enum (pay, keyreg, acfg, axfer, afrz, appl)
    "txid" => "", //string
));
$return=$algorand_indexer->get("v2","assets","{asset-id}","transactions","?".$query);
```


#### Lookup block.
```php
$return=$algorand_indexer->get("v2","blocks","{round-number}");
```


#### Search for transactions.
```php
$query=http_build_query(array(
    "address" => "", //string
    "address-role" => "", //enum (sender, receiver, freeze-target)
    "after-time" => "", //string (date-time)
    "application-id" => 0, //integer
    "asset-id" => 0, //integer
    "before-time" => "", //string (date-time)
    "currency-greater-than" => 0, //integer
    "currency-less-than" => 0, //integer
    "exclude-close-to" => false, //boolean
    "limit" => 0, //integer
    "max-round" => 0, //integer
    "min-round" => 0, //integer
    "next" => "", //string
    "note-prefix" => "", //string
    "rekey-to" => false, //boolean
    "round" => 0, //integer
    "sig-type" => 0, //enum (sig, msig, lsig)
    "tx-type" => 0, //enum (pay, keyreg, acfg, axfer, afrz, appl)
    "txid" => "", //string
));
$return=$algorand_indexer->get("v2","transactions","?".$query);
```


#### Lookup a single transaction.
```php
$return=$algorand_indexer->get("v2","transactions","{txid}");
```


For more details: https://developer.algorand.org/docs/reference/rest-apis/indexer/



## Print the results
Full response with debug (json response)
```php
print_r($return);
```

Only response array
```php
print_r(json_decode($return['response']));
```

Only erros messages  array
```php
print_r(json_decode($return['message']));
```


## Configurations
To enable Debug
```php
$algorand->debug(1);
```

To enable SSL
```php
$algorand->setSSL('/home/felipe/certificate.cert');
```

## License
php-algorand-sdk is licensed under a MIT license. See the [LICENSE](https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE) file for details.


## Donate
If you would like to donate to help maintain our online participation node, this and future projects, this is our ALGO (Algorand) Wallet: **IYVZLDFIF6KUMSDFVIKHPBT3FI5QVZJKJ6BPFSGIJDUJGUUASKNRA4HUHU**
