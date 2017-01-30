/* global e */
// @TODO функция по удалению строк  в группе. Нужно подставить еще одно значение в 
// таблие (поле) Х для удаления что бы на против каждой строки шел крестик для 
// удаления и в нем в этом крестике хранился параметр id  строки в базе и при 
// клике  этот параметр по ajax  передавался на контроллер ну а дальше на 
// модель по удалению с базы строки по id

$(document).ready(function(){
    
    //делаем поля не активными пока не будет выбран преподаватель
    $('#client-classroom').prop("disabled",true);
    $('#client-dates').prop("disabled",true);
    $('#client-type_group input').prop("disabled",true);
    $('#client-pruxid').prop("disabled",true);
    $('#client-poyasn').prop("disabled",true);
    $('.post_post').prop("disabled",true);
    
    
    
    
    
    
   
   
   //устанавливаем плагин от jquery календарь и время
   $.datetimepicker.setLocale('ru');
		$( "#client-dates" ).datetimepicker({
			format:'Y-m-d H:i',
		 });
   
    
    
    
    

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
           var id = document.getElementsByClassName('tab_client').item(0).getElementsByClassName('table_two').length;
   
        //что бы кнопка "додаты нового" была рядом с новой строкой в таблице
        $('.button_table').css('bottom','50px');
        
            //получаем все значения первого select (родительского)
            var price = $('#client-price_first').html();
            
            //по клику добавляем новые строки таблицы
            $('.tab_client tbody').append('<tr class="table_two tr_'+id+'"><td>\n\
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
                 location.reload();
                 
                 
             },
             error:function (xhr, ajaxOptions, thrownError){
                console.log(thrownError); //выводим ошибку
            }   
         });
           
    });
    
    
    //проверяем существует ли такой студент (по имени проверка)
    /*
        $('.name_student').change(function(){
            
            alert(11);
           var student = $('.name_student').val(); 
           
           if(teacher){
                $.ajax({
             url : '/allteacher',
                 type : 'POST',
                 dataType:'text',
                 data :{
                  student:student
              },
               success:function(data){
                   if(data){
                     var answer = JSON.parse(data);
                     alert(answer['name']); 
                     $('.name_student').val(" ");
                   }
                  
                   

               },
               error:function (xhr, ajaxOptions, thrownError){
                  console.log(thrownError); //выводим ошибку
              }   
             }); 
           }
           
        });
        */
        
    
    
    
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
                   //проверка если в ответ от сервера приходит текст то препода нету и мы удаляем текст
                   if(data){
                     var answer = JSON.parse(data);
                     alert(answer['name']); 
                     $('#client-teacher').val(" ");
                     //делаем поля не активными пока не будет выбран преподаватель
                        $('#client-classroom').prop("disabled",true);
                        $('#client-dates').prop("disabled",true);
                        $('#client-type_group input').prop("disabled",true);
                        $('.field-client-inform').css('display','none');
                        $('.save_button').css('display','none');
                        $('.field-client-groups').css('display','none');
                        $('.field-client-students').css('display','none');
                        $('.add_user').css('display','none');
                        $('.add_group').css('display','none');
                        $('#client-type_group input').prop('checked', false);
                        $('#client-pruxid').prop("disabled",true);
                        $('#client-poyasn').prop("disabled",true);
                        $('.post_post').prop("disabled",true);
                        $('.tab_client').css('display','none');
                        
                   }else{
                       //когда такой препод есть то делаем активные поля для заполнения
                       $('#client-classroom').prop("disabled",false);
                        $('#client-dates').prop("disabled",false);
                        $('#client-groups').prop("disabled",false);
                        $('#client-inform').prop("disabled",false);
                        $('.save_button').prop("disabled",false);
                        $('#client-type_group input').prop("disabled",false);
                        $('#client-pruxid').prop("disabled",false);
                        $('#client-poyasn').prop("disabled",false);
                        $('.post_post').prop("disabled",false);
                        
                        
   
                   }
                  
                   

               },
               error:function (xhr, ajaxOptions, thrownError){
                  console.log(thrownError); //выводим ошибку
              }   
             }); 
             
              //если поле пустое то блокируем все остальные
           }else{
               //делаем поля не активными пока не будет выбран преподаватель
                        $('#client-classroom').prop("disabled",true);
                        $('#client-dates').prop("disabled",true);
                        $('#client-type_group input').prop("disabled",true);
                        $('.field-client-inform').css('display','none');
                        $('.save_button').css('display','none');
                        $('.field-client-groups').css('display','none');
                        $('.field-client-students').css('display','none');
                        $('.add_user').css('display','none');
                        $('.add_group').css('display','none');
                        $('#client-type_group input').prop('checked', false);
                        $('#client-pruxid').prop("disabled",true);
                        $('#client-poyasn').prop("disabled",true);
                        $('.post_post').prop("disabled",true);
                        $('.tab_client').css('display','none');
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
            
            //по селекту удаляем старые записи что были выведены в селекте
            $('.tab_client tbody tr').remove();
           
           
           //при открывания селекта "Студенты" делаем видимый блок для добавления новых студентов
           $('.tab_client').css('display','block');
           
           if(group_id){
               $.ajax({
             url : '/getinfogroup',
                 type : 'POST',
                 dataType:'text',
                 data :{
                  group_id:group_id
              },
               success:function(data){
                   
                   
                   if(data){
                     var answer = JSON.parse(data);
                     
                     var price = $('#client-price_first').html();
                     
                     
                     var id_price = [];
                     var id = [];
                     var name = [];
                     var pruxid = [];
                     var price_name = [];
                     
                     for (var i = 0; i<answer['group'].length; i++){
                         id_price[i] = answer['group'][i]['id_price'];
                         id[i] = answer['group'][i]['id'];
                         name[i] = answer['group'][i]['student_name'];
                         pruxid[i] = answer['group'][i]['pruxid'];
                         price_name[i] = answer['group'][i]['price_stud'];
                         
                     }
                     
                      //подставляем прайс под ид с базы что бы показывало в селекте нужные нам цены
                     var s = 0;
                        $.each(id_price, function(index, item){ 
                        
                        select_price = $('<td><select class="form-control select_price  select_add" data-price-id="'+id_price[s]+'">'+price+'</select></td>');
                        pruxid_obj = $('<td><div class="form-group"><input type="text" class="form-control pruxid pruxid_add" value="'+pruxid[s]+'"></div></td>'); 
                        
                          $('.tab_client tbody').append('<tr id="tr_'+id[s]+'" class="table_one">\n\
                          <td><div class="form-group name_table"><p>'+name[s]+'</p></div></td>\n\
                          </tr>');
                           
                          $('.tab_client tbody #tr_'+id[s]+'').append(select_price);
                          $('.tab_client tbody #tr_'+id[s]+'').append(pruxid_obj);

                          $('[data-price-id="'+id_price[s]+'"] option[value="'+id_price[s]+'"]').prop('selected', true);
                        ++s;
                        });
                        
                        
                        
                        $('.save_button').click(function(e){
                            e.preventDefault();
                          
                            var radio = $("#client-radio input[type='radio']:checked").val();
                            var teacher = $('#client-teacher').val();
                            var classroom = $('#client-classroom option:selected').val();
                            var client_date = $('#client-dates').val(); 
                            var comment = $('#client-inform').val();
                            var date_now = new Date();
                            //получаем дату и время в тайне от пользователя
                            var date_time = date_now.getFullYear()+'-'+date_now.getMonth()+1+'-'+date_now.getDate()+' '+date_now.getHours()+':'+date_now.getMinutes();
                            var client_group = $('#client-groups option:selected').val(); 
                            
                             //делаем проверку на id  записи если тру то UPDATE в базе
                            if(id.length>0){
                               
                               var mas_id = [];
                               
                               for (var index = 0; index<id.length; index++){
                                var id_id = id[index];
                                var name = $('.tab_client tbody #tr_'+id[index]+' .name_table').text(); 
                                var sel_id = $('.tab_client tbody #tr_'+id[index]+' .select_add option:selected').val();    
                                var pruxid_id = $('.tab_client tbody #tr_'+id[index]+' .pruxid_add').val();      
                                    
                                mas_id[index] = [id_id,date_time,radio,teacher,classroom,client_date,name,sel_id,pruxid_id,comment];     
                               
                                }
                               
                                 $.ajax({
                                    url : '/updateinfojournal',
                                    type : 'POST',
                                    dataType:'text',
                                    data :{
                                        mas_id:mas_id
                                    },
                                    success:function(data){
                                     if(data){
                                            alert("Данi  оновлено!");
                                         

                                        }
                                     
                                    },
                                    error:function (xhr, ajaxOptions, thrownError){
                                        console.log(thrownError); //выводим ошибку
                                    }
                                });
                                
                                
                            }
                            
                         });
                        
                    }
                },
               error:function (xhr, ajaxOptions, thrownError){
                  console.log(thrownError); //выводим ошибку
              }   
             });
           }
           
           
           //если таблица пустая (journal) то заносим отдельно
           $('.save_button').click(function(e){
                e.preventDefault();
               //получаем количество строк добавленых вручную (таблица студентов в группе)
                           var rows_table = document.getElementsByClassName('tab_client').item(0).getElementsByClassName('table_two').length;
                              
                            
                            //делаем проверку на id class записи если тру то INSERT в базе
                           if(rows_table>0){
                                var radio = $("#client-radio input[type='radio']:checked").val();
                                var teacher = $('#client-teacher').val();
                                var classroom = $('#client-classroom option:selected').val();
                                var client_date = $('#client-dates').val(); 
                                var comment = $('#client-inform').val();
                                var date_now = new Date();
                                //получаем дату и время в тайне от пользователя
                                var date_time = date_now.getFullYear()+'-'+date_now.getMonth()+1+'-'+date_now.getDate()+' '+date_now.getHours()+':'+date_now.getMinutes();
                                var client_group = $('#client-groups option:selected').val(); 
                               
                               var mas_class = [];
                               
                               for (var index = 0; index<rows_table; index++){
                                var name = $('.tab_client tbody .tr_'+index+' .name_student').val(); 
                                var sel_id = $('.tab_client tbody .tr_'+index+' .select_add option:selected').val();    
                                var pruxid_id = $('.tab_client tbody .tr_'+index+' .pruxid_add').val();      
                                   
                                 mas_class[index] = [date_time,radio,teacher,classroom,client_date,name,client_group,sel_id,pruxid_id,comment];   
                                    
                               }
                               
                               $.ajax({
                                    url : '/insertinfojournal',
                                    type : 'POST',
                                    dataType:'text',
                                    data :{
                                        mas_class:mas_class
                                    },
                                    success:function(data){
                                        if(data){
                                          alert("Данi  записано!");
                                          location.reload();

                                        }
                                    },
                                    error:function (xhr, ajaxOptions, thrownError){
                                        console.log(thrownError); //выводим ошибку
                                    }
                                });
                               
                               
                                 
                            }
                });
          
       });
      
       
       //по выбору типа меняем страницу и когда выбрано iншi можем отправлять в базу
       $('#client-radio input:radio').change(function(){
              //Уроки      
           if (this.value == 1) {
              $('.icon_add').css('display','block');
              $('.css_pruxid').css('display','none');
              $('.css_poyasn').css('display','none');
              $('.post_post').css('display','none');
              $('.field-client-groups').css('display','none');
              $('.field-client-type_group').css('display','block');
              $('.field-client-students').css('display','none');
              $('#client-type_group input').prop('checked', false);
              $('.add_user').css('display','none');
              $('.add_group').css('display','none');

              
             }//Iнше
            else if (this.value == 2) {
              $('.icon_add').css('display','none');
              $('.tab_client').css('display','none');
              $('.css_pruxid').css('display','block');
              $('.css_poyasn').css('display','block');
              $('.field-client-inform').css('display','none');
              $('.post_post').css('display','block');
              $('.save_button').css('display','none');
              $('.field-client-groups').css('display','none');
              $('.field-client-type_group').css('display','none');
              $('.field-client-students').css('display','none');
              
              
              
              
              //по клику отправляем в journal iншi
              $('.post_post').click(function(e){
              e.preventDefault();    
                  
              var date_now = new Date();    
              var date_time = date_now.getFullYear()+'-'+date_now.getMonth()+1+'-'+date_now.getDate()+' '+date_now.getHours()+':'+date_now.getMinutes();
              var teacher = $('#client-teacher').val(); 
              var type_less = 2;  
              var classroom = $('#client-classroom').val();
              var client_date = $('#client-dates').val();
              var client_pruxid = $('#client-pruxid').val(); 
              var client_poyasn = $('#client-poyasn').val();
              
              
              if(teacher != " " && client_date != " "){
                  $.ajax({
                    url : '/inshi',
                    type : 'POST',
                    dataType:'text',
                    data :{
                     date_time:date_time,
                     type_less:type_less,
                     teacher:teacher,
                     classroom:classroom,
                     client_date:client_date,
                     client_pruxid:client_pruxid,
                     client_poyasn:client_poyasn
                     
                 },
                  success:function(data){
                        if(data){
                           alert("Добавлено");
                         location.reload();  
                         }
                  },
                  error:function (xhr, ajaxOptions, thrownError){
                     console.log(thrownError); //выводим ошибку
                 }

                });
                  
              }else{
                  alert("Помилка! Не всi поля заповненi");
              }
              
              });
              
           }
       });
       
       
       //в зависимости от выбраной кнопки (Группа или студент) выводим данный контент
       $('#client-type_group input:radio').change(function(){
           
           if(this.value==3){
            $('.field-client-groups').css('display','block');
            $('.add_group').css('display','block');
            $('.field-client-students').css('display','none');
            $('.add_user').css('display','none');
            $('.field-client-inform').css('display','block');
            $('.save_button').css('display','block');
            
  
              
           }else if(this.value==4){
               $('.field-client-groups').css('display','none');
               $('.add_group').css('display','none');
               $('.field-client-students').css('display','block');
               $('.add_user').css('display','block');
               $('.field-client-inform').css('display','block');
               $('.save_button').css('display','block');
              
           }
           
         });
       
       
       
    
    
     
     
    
});



