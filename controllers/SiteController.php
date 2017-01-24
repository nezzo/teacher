<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Client;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * Создаем главную страницу клиента 
     *
     * @return string
     */
    public function actionIndex()
    {
        $client = new Client();
        
        //для дропдаун листа пока что фича
        $item = array('класс1','класс2','класс3');
        $stud = array('Вася','Петя','Витя');
        
       
        return $this->render('index',[
            'model'=> $client,
            'room' => $item,
            'stud' => $stud
        ]);
    }

    
    public function actionPriceall(){
         if(Yii::$app->request->isAjax){
             $price = $data = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             
                return [
                    'price' => $client->allPrice,
                    
                ];
                
            }

    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}
