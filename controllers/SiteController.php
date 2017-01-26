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

    //добавляем нового студента (студент без группы) и выводоим сообщение добавлен или нет,если 
    //такой студент уже существует выводим предупредительное сообщение
    
    public function actionAddstudent(){
                    
         if(Yii::$app->request->isAjax){
             $name_student = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->SeacrhNameStudent($name_student);
             $search_name = "";
             
             if(isset($name) && !empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
                         
             
             #@TODO почему то в NewUser выбрасывает ошибку 500 в моделе косяк, что то так с insert
              if(isset($search_name) && !empty($search_name)){
                 return [
                    'name' => "Ошибка, данный студент есть в базе!",
                  ]; 
             }else{
                 $new_name = $client->NewUser($name_student);
                 
                 return [
                    'name' => $new_name//"Cтудент добавлен!",
                  ]; 
                 /*
                 if(isset($new_name) && !empty($new_name)){
                    return [
                    'name' => "Cтудент добавлен!",
                  ];  
                 }else{
                    return [
                    'name' => "Ошибка!",
                  ]; 
                 }
                 */
             }
             
             
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
