<?php

use app\models\admin\Admin;

namespace app\controllers;

/**
 * Description of AdminController
 *
 * @author nestor
 */
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\admin\Admin;

class AdminController extends Controller{
    
      
    public function actionAdmin(){
        /*Подключение менюшки к админке layouts/admin/main.php*/
        $this->layout = '/admin';
         $room = array('класс1','класс2','класс3');
        
        
        $model = new Admin();
        
        return $this->render('admin',[
            'model'=>$model,
            'room' =>$room,
            'all'=> "усi",
        ]);
    }
    
    
}
