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
   public $price_first; //это цена самой первой Вартости по которой регулируются все осталные 
   
   //выводи все цены что есть 
   public function allPrice(){
          $rows = (new \yii\db\Query())
            ->select(['id','price_stud'])
            ->from('price')
            ->all();

        return $rows;
    }
    
    
    //делаем поиск по имени и возвращаем id если есть тако препод
   public function allTeacher($name){
          $rows = (new \yii\db\Query())
            ->select(['id'])
            ->from('teacher')
            ->where(['name_teacher' => $name])       
            ->all();

        return $rows;
    }
    
     //делаем поиск по имени и возвращаем id если есть такой студент
   public function SeacrhNameStudent($name){
          $rows = (new \yii\db\Query())
            ->select(['id'])
            ->from('student')
            ->where(['student_name' => $name])       
            ->all();

        return $rows;
    }
    
    //добавляем студента в базу(без группы==0)
    public function NewUser($name){
         $save = Yii::$app->db->createCommand()
            ->insert('student', [
                'student_name'=> $name,
                'group_id' => 0,
             ])->execute();

        return $save;
    }
    
    
   
   
    
}
