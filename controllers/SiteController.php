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
        
        //назначаем имена для радио баттонов по выбору что отображать
        $group_student = array(3=>"Група(и)", 4=>"Студент(и)");
        
        
       
        return $this->render('index',[
            'model'=> $client,
            'room' => $room,
            'stud' => $stud,
            'group'=> $group,
            'type' => $type,
            'price' => $price,
            'group_student'=>$group_student,
        ]);
    }

    //добавляем нового студента (студент без группы) и выводоим сообщение добавлен или нет,если 
    //такой студент уже существует выводим предупредительное сообщение и привязываем к преподу
    
    public function actionAddstudent(){
                    
         if(Yii::$app->request->isAjax){
             $name_student = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->SeacrhNameStudent($name_student["name_student"]);
             $teacher_name = $client->allTeacher($name_student["name_teacher"]);
             $search_name = "";
             $teacher_id = "";
             
             if(!empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
             
             if(!empty($teacher_name)){
             foreach($teacher_name as $id){
                 $teacher_id = $id['id'];
             }
             }
             
             
               
             if(!empty($search_name)){
                 return [
                    'name' => "Ошибка, данный студент есть в базе!",
                  ]; 
             }elseif(!empty($name_student["name_student"]) && !empty($teacher_id)){
                 $new_name = $client->NewUser($name_student["name_student"],$teacher_id);
                   
                 if(!empty($new_name)){
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
    
    //Добавляем группу в базу и привязываем к преподу
    public function actionAddgroup(){
        if(Yii::$app->request->isAjax){
             $name_group = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->SeacrhNameGroup($name_group["name_group"]);
             $teacher_name = $client->allTeacher($name_group["name_teacher"]);
             $teacher_id = "";
             $search_name = "";
             
             if(!empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
             if(!empty($teacher_name)){
             foreach($teacher_name as $id){
                 $teacher_id = $id['id'];
             }
             }
             
             
             if(!empty($search_name)){
                 return [
                    'name' => "Ошибка, данная группа есть в базе!",
                  ]; 
             }elseif(!empty($name_group["name_group"]) && !empty($teacher_id)){
                 $new_name = $client->NewGroup($name_group["name_group"],$teacher_id);
                   
                 if(!empty($new_name)){
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
    
    
    //Проверяем существует ли такой студент
    public function actionSearchstudent(){
        if(Yii::$app->request->isAjax){
             $name_student = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             $name = $client->SeacrhNameStudent($name_student["student"]);
              
             
                if(!empty($name)){
                         return [
                            'name' => "Помилка! Студент не iснує",
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
                for ($i = 0; $i<count($info["mas_id"]); $i++){
                         $answers =  $info["mas_id"][$i];
                         
                      $update_data = $client->Updatejournal($answers);    
                         
                  }
                    return [
                    'answer' =>  $update_data
                    
                  ];
                    
                }
            }
        }
        
        //принимаем значения те что без ид и записываем в базу
        public function actionInsertinfojournal(){
            if(Yii::$app->request->isAjax){
             $info = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             
            if(!empty($info["mas_class"])){
                
                for ($i = 0; $i<count($info["mas_class"]); $i++){
                    
                      $answers =  $info["mas_class"][$i];
                         
                      $insert_data = $client->Insertjournal($answers);    
                         
                  }
                    return [
                    'answer' => $insert_data
                    
                  ];
                    
                }
             
             
            }
            
        }
        
        //по ajax получаем имя препода и возвращаем список групп
        public function actionSelectgroup(){
            if(Yii::$app->request->isAjax){
             $name_teacher = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             
             $name = $client->allTeacher($name_teacher["teacher_id"]);
             $search_name = "";
             
           if(!empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
             
             if(!empty($search_name)){
                 $group_list = $client->getGroupNameForTeacher($search_name);
                 
                 return [
                    'answer' => $group_list
                    
                  ];
             }
             
             
             
            }
        }
        
        //по ajax получаем имя препода и возвращаем список студентов
        public function actionSelectstudent(){
            if(Yii::$app->request->isAjax){
             $name_teacher = Yii::$app->request->post();
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $client = new Client();
             
             $name = $client->allTeacher($name_teacher["teacher_id"]);
             $search_name = "";
             
           if(!empty($name)){
             foreach($name as $nam){
                 $search_name = $nam['id'];
             }
             }
             
             if(!empty($search_name)){
                 $student_list = $client->getStudentNameForTeacher($search_name);
                 
                 return [
                    'answer' => $student_list
                    
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
