/* global e */
$(document).ready(function(){

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
           
           //генерируем ид для каждой строки что бы было удобно разобрать
           var id = document.getElementsByClassName('tab_client').item(0).getElementsByTagName('tr').length - 1;
   
        //что бы кнопка "додаты нового" была рядом с новой строкой в таблице
        $('.button_table').css('bottom','50px');
        
            //получаем все значения первого select (родительского)
            var price = $('#client-price_first').html();
            
            //по клику добавляем новые строки таблицы
            $('.tab_client tbody').append('<tr class="tr_'+id+'"><td>\n\
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
         } 
         
         $.ajax({
           url : '/addstudent',
               type : 'POST',
               dataType:'text',
               data :{
                name_student:name_student
            },
             success:function(data){
                 var answer = JSON.parse(data);
                 alert(answer['name']);
                 
             },
             error:function (xhr, ajaxOptions, thrownError){
                console.log(thrownError); //выводим ошибку
            }   
         });
    });
    
    //Добавляем в базу группу
     $('.group_user_button_window').click(function(e){
         e.preventDefault();
         var name_group = $('#client-group').val();
         var text_group = "Група-";
         
          if(name_group){
            $('.window_add_group').css('display','none'); 
         } 
         
         $.ajax({
           url : '/addgroup',
               type : 'POST',
               dataType:'text',
               data :{
                name_group: text_group+name_group
            },
             success:function(data){
                 var answer = JSON.parse(data);
                 alert(answer['name']);
                 
             },
             error:function (xhr, ajaxOptions, thrownError){
                console.log(thrownError); //выводим ошибку
            }   
         });
           
    });
    
    
    
        //проверяем существует ли такой препод (по имени проверка)
        $('#client-teacher').change(function(){
           var teacher = $('#client-teacher').val(); 
           
           if(teacher){
                $.ajax({
             url : '/allteacher',
                 type : 'POST',
                 dataType:'text',
                 data :{
                  teacher:teacher
              },
               success:function(data){
                   if(data){
                     var answer = JSON.parse(data);
                     alert(answer['name']);  
                   }
                  
                   

               },
               error:function (xhr, ajaxOptions, thrownError){
                  console.log(thrownError); //выводим ошибку
              }   
             }); 
           }
           
        });
        
        
        //функция по выбору всех селекектов равняясь на родителя
        $('#client-price_first').change(function(){
            var parent_select = $('#client-price_first').val();
            
            $(".select_price [value='"+parent_select+"']").attr("selected", "selected");
            
        });
    
    
    //по ид выбранной группы выводим все данные
       $('#client-groups').change(function(){
           var group_id = $('#client-groups').val();
           
           if(group_id){
               $.ajax({
             url : '/getinfogroup',
                 type : 'POST',
                 dataType:'text',
                 data :{
                  group_id:group_id
              },
               success:function(data){
                   alert(111);
                   
                   if(data){
                     var answer = JSON.parse(data);
                     alert(answer['name']);  
                   }
                  
                   

               },
               error:function (xhr, ajaxOptions, thrownError){
                  console.log(thrownError); //выводим ошибку
              }   
             });
           }
          
       });
    
    
     
     
    
});



