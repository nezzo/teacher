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
   public $nameStudent;
   public $price;
   public $pruxid;
   public $inform;
   public $groups;//список групп
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
    
    
    //делаем поиск по имени и возвращаем id если есть такой препод
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
    
    //делаем поиск по имени и возвращаем id если есть такая группа
   public function SeacrhNameGroup($name){
          $rows = (new \yii\db\Query())
            ->select(['id'])
            ->from('group_stud')
            ->where(['name_group' => $name])       
            ->all();

        return $rows;
    }
    
    
    //добавляем группу в базу
    public function NewGroup($name){
         $save = Yii::$app->db->createCommand()
            ->insert('group_stud', [
                'name_group'=> $name
             ])->execute();

        return $save;
    }
    
    //Вывод всех аудиторий
    public function Classroom(){
        $rows = (new \yii\db\Query())
            ->select(['id','name_room'])
            ->from('class_room')
            ->all();

        return $rows;
    }
    
    //Вывод всех групп
    public function Allgroup(){
        $rows = (new \yii\db\Query())
            ->select(['id','name_group'])
            ->from('group_stud')
            ->all();

        return $rows;
    }
    
    //Выводим тип урока 
    public function Alltypelessons(){
        $rows = (new \yii\db\Query())
            ->select(['id','name_type'])
            ->from('type_lesson')
            ->all();

        return $rows;
    }
    
    
    #TODO  тут ошибка 500   больше всего не верно сложен запрос или же из-за 
    #того что нету данных, нужно проверить в phpmyadmin что нам выведит 
    #там + сможем сложить правильный запрос. Дальше в success нужно 
    #сгенерить  append  правильный строки таблицы с данными и 
    #добавить куда нибудь класс с id  строки что бы можно было 
    #UPDATE если данной строки не будет то будем INSERT делать.
    #+ записи в тетрадки нужно просмотреть, что нужно сделать еще.
    #Iнше  тут нужно тоже все подготовить и после все протестить и залить на хост
    #что бы клиент проклацал. и еще напротив каждой строки поставить Х (удалить строку при нажатии как в isyms)
    
            
    //По id  группы получаем все данные из таблицы journal
    public function Infojournal($group_id){
        $rows = (new \yii\db\Query())
            ->select(['id','student.student', 'price.price', 'pruxid'])
            ->from('journal')
            ->join('INNER JOIN', 'student', 'journal.student = student.id')
            ->join('INNER JOIN', 'price', 'journal.price = price.id')    
            ->where(['group_id' => $group_id])
            ->all();

        return $rows;
    }
    
    
    
   
   
    
}
