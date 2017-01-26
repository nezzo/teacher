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
       
    });
    
    $('.add_group').click(function(){
        $('.window_add_user').css('display','none');
        $('.window_add_group').css('display','block');
    });
    
    //добавляем новые строки в Клиенте
    $('.add_user_button').click(function(e){
        //что бы по клику страница не перезагружалась
           e.preventDefault();
           
           var price = $('#client-price_first').html();
            $('.tab_client tbody').append('<tr id='+id+'><td>\n\
            <div class="form-group"><input type="text" class="form-control name_student"></div></td>\n\
            <td><select class="form-control select_price select_add">'+price+'</select></td>\n\
            <td><div class="form-group">\n\
            <input type="text" class="form-control pruxid pruxid_add"></div></td></tr>');
           
     });
     
     //Добавляем в базу студент у которого нету группы
     $('.add_user_button_window').click(function(e){
         e.preventDefault();
         var name_student = $('#client-namestudent').val();
         
         if(name_student){
            $('.window_add_user').css('display','none'); 
           // alert("Студент добавлен в базу");
         }else{
             alert("Ошибка. Не все поля заполены!");
         }
         
         $.ajax({
           url : '/addstudent',
               type : 'POST',
               dataType:'text',
               data :{
                name_student:name_student
            },
             success:function(data){
                 console.log(data);
                 
             },
             error:function (xhr, ajaxOptions, thrownError){
                console.log(thrownError); //выводим ошибку
            }   
         });
         
         
     });
     
     
    //Actionv Controller ajaxsave
    
});



