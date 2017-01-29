<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Client;
use yii\helpers\ArrayHelper;

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
        
        $roomClass = $client->Classroom();
        
        $allgroup = $client->Allgroup();
        
        $lessonstype = $client->Alltypelessons();
        
        $allprice = $client->allPrice();
        
        //вместо цикла foreach формируем для дроплиста данные
        $room = ArrayHelper::map($roomClass, 'id', 'name_room');
       
        //выводим вместо цикла все  группы
        $group = ArrayHelper::map($allgroup, 'id', 'name_group');
        
        //выводим вместо цикла все типы уроков
        $type = ArrayHelper::map($lessonstype, 'id', 'name_type');
        
        //выводим вместо циклас все цены
        $price = ArrayHelper::map($allprice, 'id_price', 'price_stud');
        
        
       
        return $this->render('index',[
            'model'=> $client,
            'room' => $room,
            'stud' => $stud,
            'group'=> $group,
            'type' => $type,
            'price' => $price
        ]);
    }

    //добавляем нового студента (студент без группы) и выводоим сообщение добавлен или нет,если 
    //такой студент уже существует выводим предупредительное сообщение
    
    public function actionAddstudent(){
                    
         if(Yii::$app->request->isAjax){
             $name_student = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->SeacrhNameStudent($name_student["name_student"]);
             $search_name = "";
             
             if(isset($name) && !empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
               
             if(isset($search_name) && !empty($search_name)){
                 return [
                    'name' => "Ошибка, данный студент есть в базе!",
                  ]; 
             }elseif(isset($name_student["name_student"]) && !empty($name_student["name_student"])){
                 $new_name = $client->NewUser($name_student["name_student"]);
                   
                 if(isset($new_name) && !empty($new_name)){
                    return [
                    'name' => "Cтудент добавлен!",
                  ];  
                 }else{
                    return [
                    'name' => "Ошибка!",
                  ]; 
                 }
                 
             }else{
                return [
                    'name' => "Ошибка!",
                  ];  
             }
         }
    }
    
    //Добавляем группу в базу
    public function actionAddgroup(){
        if(Yii::$app->request->isAjax){
             $name_group = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->SeacrhNameGroup($name_group["name_group"]);
             $search_name = "";
             
             if(isset($name) && !empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
             
             if(isset($search_name) && !empty($search_name)){
                 return [
                    'name' => "Ошибка, данная группа есть в базе!",
                  ]; 
             }elseif(isset($name_group["name_group"]) && !empty($name_group["name_group"])){
                 $new_name = $client->NewGroup($name_group["name_group"]);
                   
                 if(isset($new_name) && !empty($new_name)){
                    return [
                    'name' => "Группа добавлена!",
                  ];  
                 }else{
                    return [
                    'name' => "Ошибка!",
                  ]; 
                 }
                 
             }else{
                return [
                    'name' => "Ошибка!",
                  ];  
             }
             
             
             
        }
    }
    
    //Проверяем существует ли такой препод
    public function actionAllteacher(){
        if(Yii::$app->request->isAjax){
             $name_teacher = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->allTeacher($name_teacher["teacher"]);
             $search_name = "";
             
           if(isset($name) && !empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
             
        if(!isset($search_name) || empty($search_name)){
                 return [
                    'name' => "Помилка! Викладач не iснує",
                  ]; 
             }
             
        }
    }
    
    //выводим клиенту данные о записи в journal
    public function actionGetinfogroup(){
        if(Yii::$app->request->isAjax){
             $info = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             
              if(isset($info) && !empty($info)){
                 $group = $client->Infojournal($info["group_id"]);
                 $price_select  = $client->allPrice();
                 
                 if(isset($group) && !empty($group)){
                     return [
                    'price_select' => $price_select,   
                    'group' => $group,
                  ];
                 }
                 
             }
             
        }
    }
    
    public function actionInshi(){
         if(Yii::$app->request->isAjax){
             $info = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
         
             if(isset($info) && !empty($info)){
                 if(isset($info["teacher"]) && !empty($info["teacher"])){
                     $teacher_id = $client->allTeacher($info["teacher"]);
                   
                 $inshi_data = $client->Inshiinsert($info['date_time'],$info['type_less'],$teacher_id[0]['id'], $info['classroom'],$info['client_date'],$info['client_pruxid'],$info['client_poyasn']);  
                 
                 return [
                    'answer' => $inshi_data   
                    
                  ];
                  
                 }
                 
                
             }
             
          }
        }
        
        
        //принимаем и обрабатываем данные с ajax и заносим в базу Update Journal
        public function actionUpdateinfojournal(){
            if(Yii::$app->request->isAjax){
             $info = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             
             if(isset($info["mas_id"]) && !empty($info["mas_id"])){

                 
                 #@TODO нихера не работает цикл все данные прилетают запустить его не могу нужно спросить 
                 #будет в yii2  канале что за херня они должны знать 
                 for ($i = 0; $i<=count($info["mas_id"]); ++$i){
                     for($z=0; $z<$i; ++$z){
                         $answer =  $info["mas_id"][$z][$i];
                     }
                     
                     
                      
                     
                    }
                    
                     return [
                    'answer' => var_dump($answer)  
                    
                  ];
                    
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
