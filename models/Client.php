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
   public $poyasn;
   public $price_first; //это цена самой первой Вартости по которой регулируются все осталные 
   
   //выводи все цены что есть 
   public function allPrice(){
          $rows = (new \yii\db\Query())
            ->select(['id_price','price_stud'])
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
            ->select(['journal.id','student.student_name', 'price.price_stud','price.id_price', 'pruxid'])
            ->from('journal')
            ->join('LEFT JOIN', 'student', 'student.id = journal.student_name')
            ->join('LEFT JOIN', 'price', 'journal.price_stud = price.id_price')    
            ->where(['name_group' => $group_id])
            ->all();

        return $rows;
    }
    
    /*Правильно сформулирован запрос на запрос по выводу по ид группы
     *  SELECT journal.id, `data_auto`, type_lesson.name_type,
     *  teacher.name_teacher,price.id_price, class_room.name_room,
     *  `date_and_time`, student.student_name, price.price_stud,
     *  `pruxid`, `comment` FROM `journal` LEFT JOIN `student`
     *  ON student.id = journal.student_name LEFT JOIN `class_room`
     *  ON class_room.id = journal.name_room LEFT JOIN `price` 
     *  ON price.id_price = journal.price_stud LEFT JOIN `teacher` 
     *  ON teacher.id = journal.name_teacher LEFT JOIN `type_lesson` 
     *  ON type_lesson.id = journal.name_type WHERE name_group = 16
     */
    
    
    //заносим данные с "iншi"
    public function Inshiinsert($date_time,$type_less,$teacher, $classroom,$client_date,$client_pruxid,$client_poyasn){
       
        $save = Yii::$app->db->createCommand()
            ->insert('journal', [
                'data_auto'=> $date_time,
                'name_type' => (int)$type_less,
                'name_teacher' => (int)$teacher,
                'name_room' => (int)$classroom,
                'date_and_time' => $client_date,
                'student_name' => 0,
                'name_group' => 0,
                'price_stud' => 0,
                'pruxid' => (int)$client_pruxid,
                'comment' => $client_poyasn,
              ])->execute();

        return $save;
     }
     
     //обновляем записи те что в journal таблице
     public function Updatejournal($update){
          
          
        // $s = "foreach($this->SeacrhNameStudent($update[6]) as $stud){echo $stud;}";
         /*
          $save = Yii::$app->db->createCommand()
            ->update('journal', [
                'data_auto' => $update[1],
                'name_type' => $update[2],
                'name_teacher' => 1,//$this->allTeacher($update[3]),
                'name_room' => $update[4],
                'date_and_time' => $update[5],
                'student_name' =>1,//$this->SeacrhNameStudent($update[6]),
                'price_stud' => $update[7],
                'pruxid' => $update[8],
                'comment' => $update[9]
            ], 'id=:id', array(':id'=> (int)$update[0]))
            ->execute(); 
          * 
          */
          
        
          
         
          return $update;
         
     }
   
   
    
}
