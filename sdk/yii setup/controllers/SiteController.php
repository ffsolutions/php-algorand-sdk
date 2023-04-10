<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\Algorand\algorand;
use app\Algorand\transactions;
use app\Algorand\b32;
use app\Algorand\msgpack;
use app\Algorand\algokey;


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

        $algorand = new Algorand("algod","4820e6e45f339e0026eaa2b74c2aa7d8735cbcb2db0cf0444fb492892e1c09b7","localhost",53898);
        $algorand->debug(1);

        #Gets the current node status.
        //$return=$algorand->get("v2","status");

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

        $algorand_kmd = new Algorand("kmd","dcb406527f3ded8464dbd56e6ea001b9b17882cfcf8194c17069bb22816307ad","localhost",7833);
        $algorand_kmd->debug(1);

        #Get Versions
        //$return=$algorand_kmd->get("versions");


        #See all Algorand SDK Functions at: https://github.com/ffsolutions/php-algorand-sdk

        $return=$algorand_kmd->get("v1","wallets");

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

        $algorand_indexer = new Algorand("indexer","{indexer-token}","localhost",8980);
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
