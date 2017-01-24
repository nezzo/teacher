<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models;

use Yii;
use yii\base\Model;



/**
 * Description of Client
 *
 * @author nestor
 */
class Client extends Model {
   public $radio = 1;// устанавливаем по дефолту Уроки radioButton
   public $teacher;
   public $classRoom;
   public $dates;
   public $student;
   public $nameStudent;
   public $price;
   public $pruxid;
   public $inform;
   public $group;
   
   
   //выводи все цены что есть 
   public function allPrice(){
          $rows = (new \yii\db\Query())
            ->select(['id','price'])
            ->from('price')
            ->all();

        return $rows;
    }
    
   
   
    
}
