/* global e */
//@TODO нужно настроить правильно работу ajax и передать good  на метод и получить всю цену и 
//придобавлении  новых строк в таблице выводить свой дропбокс со своими ид
// (который генерит время) после собрать все данные и отправить на контроллера  что бы записало в 
// базу  надо еще придумать как умно записать в базу в разные таблицы. и при выборе группы что бы так 
// же  срабатывал ajax по change   и подтягивал всех студентов с группы. Записывать в базу 
// студентов (в группу) можно по кнопке добавить  ввели имя, цену, приход и нажали добавить,
//  запись отправится в базу и добавиться внизу сразу новая строка которое можно не заполнять
//   или же не так, а просто взять привязать отправку кнопке Видправить, что бы уже все данные сразу
//    записались и не мучиться
 
$(document).ready(function(){
    var date = new Date();
    var id = date.getTime();

    $('.add_user').click(function(){
        $('.window_add_user').css('display','block');
        $('.window_add_group').css('display','none');
        alert();
       
    });
    
    $('.add_group').click(function(){
        $('.window_add_user').css('display','none');
        $('.window_add_group').css('display','block');
    });
    
    
    $('.add_user_button').click(function(e){
        //что бы по клику страница не перезагружалась
           e.preventDefault();


            $.ajax({
              url: '<?php echo Yii::$app->request->baseUrl. /SiteController/priceall ?>',
               type : 'POST',
               dataType:'text',
               data :{
                good: "good"
            },
             success:function(data){
                 //$(".tr_"+id+" .na_edinitsu").text(data);
                 console.log(data);
                 
             },
             error:function (xhr, ajaxOptions, thrownError){
                console.log(thrownError); //выводим ошибку
            }
              
           });
           
        /*
        $('.table_two tbody').append('<tr id="tr_'+id+'"><td>\n\
        <div class="form-group"><input type="text" class="form-control name_student"></div></td>\n\
        \n\
         </tr>');
        */ 
        
        
    });
    
    
    
    
    
    
    
    
    
    
});



