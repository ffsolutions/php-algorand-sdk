## Overview

This solution describes how to use the new PHP Algorand SDK with the most used PHP Frameworks.

A **PHP framework** is a platform for creating **PHP** web applications. It contains libraries with pre-packaged functions and classes and, more often than not, elements for software design pattern realization.
Also, the library functions and classes follow standard web development practices and are well-tested.

# Frameworks Compatibility

This SDK was developed to support several PHP Frameworks, in this solution, we will show you how to install and configure the frameworks:

-   **Codeigniter**
-   **Laravel**
-   **Lumen**
-   **Symfony**
-   **Yii**

The procedure is similar for other frameworks. In the **sdk** folder you will find the setup suggestions.

# Requirements

-   PHP 7.3 and above.
-   Built-in libcurl support.
-   PHP Algorand SDK
-   Algorand node (algod, kmd and indexer services running)

Complete PHP Algorand SDK references and examples at:  [https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk)

# Vídeo Tutorial
![How to Use with PHP Frameworks](https://img.youtube.com/vi/gaUSnZZIH7o/maxresdefault.jpg "How to Use with PHP Frameworks")
https://www.youtube.com/watch?v=gaUSnZZIH7o



# Quick start

After cloning the repository, you need to include the `php-algorand-sdk` in your project :
```php
use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;
```

Create a new object from the classes:
```php
#Algod
$algorand = new algod('{algod-token}',"localhost",53898);

#Kmd
$algorand_kmd = new kmd('{kmd-token}',"localhost",64988);

#indexer
$algorand_indexer = new indexer('{algorand-indexer-token}',"localhost",8089);
```

# Codeigniter

![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/How%20to%20Use%20with%20PHP%20Frameworks/images/codeigniter%20file%20structure.png)

 1. Copy the ***Algorand*** directory from ***sdk/_namespace_based***, to ***app*** directory.
 2. Create the controller ***app/Controllers/AlgodController.php*** and add the code:
```php
<?php

namespace App\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class AlgodController extends BaseController
{
	public function index()
	{
		  $algorand = new algod('{algod-token}',"localhost",53898);
      $algorand->debug(1);

      #Get the status
      $return=$algorand->get("v2","status");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

	}

}
```
 3. Create the controller ***app/Controllers/KmdController.php*** and add the code:
```php
<?php
namespace App\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class KmdController extends BaseController
{
	public function index()
	{
		  $algorand_kmd = new kmd('{kmd-token}',"localhost",7833);
      $algorand_kmd->debug(1);

			#Get Versions
			$return=$algorand_kmd->get("versions");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

	}

}
```

4. Create the controller ***app/Controllers/IndexerController.php*** and add the code:
```php
<?php
namespace App\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class IndexerController extends BaseController
{
	public function index()
	{
		  $algorand_indexer = new indexer('',"localhost",8980);
      $algorand_indexer->debug(1);

	  #Get Versions
	  $return=$algorand_indexer->get("health");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

	}

}
```
5. Edit the ***app/Config/Routes.php***  file to configure the routes:
```php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/algod', 'AlgodController::index');
$routes->get('/kmd', 'KmdController::index');
$routes->get('/indexer', 'IndexerController::index');
```


# Laravel

![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/How%20to%20Use%20with%20PHP%20Frameworks/images/laravel%20file%20structure.png)

 1. Copy the ***Algorand*** directory from ***sdk/_namespace_based***, to ***app*** directory.
 2. Create the controller ***app/Http/Controllers/AlgodController.php*** and add the code:
```php
<?php
namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class AlgodController extends Controller
{

    public function index()
    {

      $algorand = new algod('{algod-token}',"localhost",53898);
      $algorand->debug(1);

      #Get the versions
      $return=$algorand->get("v2","status");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

    }
}

```
 3. Create the controller ***app/Http/Controllers/KmdController.php*** and add the code:
```php
<?php
namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class KmdController extends Controller
{

    public function index()
    {

      $algorand_kmd = new kmd('{kmd-token}',"localhost",7833);
      $algorand_kmd->debug(1);

      #Get Versions
      $return=$algorand_kmd->get("versions");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

    }
}

```

4. Create the controller ***app/Http/Controllers/IndexerController.php*** and add the code:
```php
<?php
namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class IndexerController extends Controller
{

    public function index()
    {

      $algorand_indexer = new indexer('',"localhost",8980);
      $algorand_indexer->debug(1);

      #Get health, Returns 200 if healthy.
      $return=$algorand_indexer->get("health");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

    }
}

```
5. Edit the ***app/routes/web.php***  file to configure the routes:
```php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/algod', [AlgodController::class, 'index']);
Route::get('/kmd', [KmdController::class, 'index']);
Route::get('/indexer', [IndexerController::class, 'index']);

Route::get('/', function () {
    echo "Access: /algod, /kmd or /indexer";
});
```

# Lumen

![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/How%20to%20Use%20with%20PHP%20Frameworks/images/lumen%20file%20structure.png)

 1. Copy the ***Algorand*** directory from ***sdk/_namespace_based***, to ***app*** directory.
 3. Create the controller ***app/Http/Controllers/AlgodController.php*** and add the code:
```php
<?php
namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class AlgodController extends Controller
{

    public function index()
    {

      $algorand = new algod('{algod-token}',"localhost",53898);
      $algorand->debug(1);

      #Get the versions
      $return=$algorand->get("v2","status");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

    }
}
```
 3. Create the controller ***app/Http/Controllers/KmdController.php*** and add the code:
```php
<?php
namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class KmdController extends Controller
{

    public function index()
    {

      $algorand_kmd = new kmd('{kmd-token}',"localhost",7833);
      $algorand_kmd->debug(1);

      #Get Versions
      $return=$algorand_kmd->get("versions");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

    }
}

```

4. Create the controller ***app/Http/Controllers/IndexerController.php*** and add the code:
```php
<?php
namespace App\Http\Controllers;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class IndexerController extends Controller
{

    public function index()
    {

      $algorand_indexer = new indexer('',"localhost",8980);
      $algorand_indexer->debug(1);

      #Get health, Returns 200 if healthy.
      $return=$algorand_indexer->get("health");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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

    }
}
```
5. Edit the ***app/routes/web.php***  file to configure the routes:
```php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\AlgodController;
use App\Http\Controllers\KmdController;
use App\Http\Controllers\IndexerController;

$router->get('/algod', 'AlgodController@index');
$router->get('/kmd', 'KmdController@index');
$router->get('/indexer', 'IndexerController@index');

#Simple Native Method Setup
$router->get('/', function () {
    echo "Access: /algod, /kmd or /indexer";
});
```

# Symfony

![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/How%20to%20Use%20with%20PHP%20Frameworks/images/symfony.png)

 1. Copy the ***Algorand*** directory from ***sdk/_namespace_based***, to ***src*** directory.
 2. Create the controller ***src/Controller/DefaultController.php*** and add the code:
```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Algorand\algod;
use App\Algorand\kmd;
use App\Algorand\indexer;
use App\Algorand\b32;
use App\Algorand\msgpack;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
      $out="Access: /algod, /kmd or /indexer";
      $response = new Response($out);

      return $response;
    }

    /**
     * @Route("/algod", name="AlgorandAlgod")
     */
    public function AlgorandAlgod(): Response
    {

      $algorand = new algod('{algod-token}',"localhost",53898);
      $algorand->debug(1);

      #Gets the current node status.
      $return=$algorand->get("v2","status");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      $output="";

      #Full response with debug (json response)
      if(!empty($return)){
        $output.=print_r($return, true);
      }
      if(!empty($return['response'])){
        $output.=print_r(json_decode($return['response']), true);
      }
      if(!empty($return['message'])){
        $output.=print_r(json_decode($return['message']), true);
      }
      $response = new Response($output);

      return $response;
    }

    /**
     * @Route("/kmd", name="AlgorandKmd")
     */
    public function AlgorandKmd(): Response
    {

      $algorand_kmd = new kmd('{kmd-token}',"localhost",7833);
      $algorand_kmd->debug(1);

      #Gets the current node status.
      $return=$algorand_kmd->get("versions");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      $output="";

      #Full response with debug (json response)
      if(!empty($return)){
        $output.=print_r($return, true);
      }
      if(!empty($return['response'])){
        $output.=print_r(json_decode($return['response']), true);
      }
      if(!empty($return['message'])){
        $output.=print_r(json_decode($return['message']), true);
      }
      $response = new Response($output);

      return $response;

    }

    /**
     * @Route("/indexer", name="AlgorandIndexer")
     */
    public function AlgorandIndexer(): Response
    {

      $algorand_indexer = new indexer('',"localhost",8980);
      $algorand_indexer->debug(1);

      #Get health, Returns 200 if healthy.
      $return=$algorand_indexer->get("health");

      #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

      $output="";

      #Full response with debug (json response)
      if(!empty($return)){
        $output.=print_r($return, true);
      }
      if(!empty($return['response'])){
        $output.=print_r(json_decode($return['response']), true);
      }
      if(!empty($return['message'])){
        $output.=print_r(json_decode($return['message']), true);
      }
      $response = new Response($output);

      return $response;

    }

}
```
3. Edit the ***src/config/routes.yaml***  file to configure the routes:
```php
index:
    path: /
    controller: App\Controller\DefaultController::index
```

# Yii

![File Structure](https://raw.githubusercontent.com/ffsolutions/php-algorand-sdk/main/How%20to%20Use%20with%20PHP%20Frameworks/images/yii%20file%20structure.png)

 1. Copy the ***Algorand*** directory from ***sdk/_namespace_based***, to ***yii*** directory.
 2. Create the controller ***controllers/SiteController.php*** and add the code:
```php
<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\Algorand\algod;
use app\Algorand\kmd;
use app\Algorand\indexer;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        echo "Access: ?r=site/algod, ?r=site/kmd or ?r=site/indexer";
    }


    /**
     * Displays Algod page.
     *
     * @return string
     */
    public function actionAlgod()
    {

        $algorand = new algod('{algod-token}',"localhost",53898);
        $algorand->debug(1);

        #Gets the current node status.
        $return=$algorand->get("v2","status");

        #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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
    }

    /**
     * Displays Kmd page.
     *
     * @return string
     */
    public function actionKmd()
    {

        $algorand_kmd = new kmd('{kmd-token}',"localhost",7833);
        $algorand_kmd->debug(1);

        #Get Versions
        $return=$algorand_kmd->get("versions");

        #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

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
    }

    /**
     * Displays Indexer page.
     *
     * @return string
     */
    public function actionIndexer()
    {

        $algorand_indexer = new indexer('',"localhost",8980);
        $algorand_indexer->debug(1);

        #Get health, Returns 200 if healthy.
        $return=$algorand_indexer->get("health");

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
    }

}

```

# Conclusion

This is just an example of the many possibilities available using the Algorand PHP SDK , other functions are available in the GitHub repository.  
Make sure to see the readme for instructions on setup and running the Algorand node and PHP SDK at GitHub ([https://github.com/ffsolutions/php-algorand-sdk](https://github.com/ffsolutions/php-algorand-sdk))

## License

MIT license.

([https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE](https://github.com/ffsolutions/php-algorand-sdk/blob/master/LICENSE)).
