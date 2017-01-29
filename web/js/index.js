/* global e */
// @TODO функция по удалению строк  в группе. Нужно подставить еще одно значение в 
// таблие (поле) Х для удаления что бы на против каждой строки шел крестик для 
// удаления и в нем в этом крестике хранился параметр id  строки в базе и при 
// клике  этот параметр по ajax  передавался на контроллер ну а дальше на 
// модель по удалению с базы строки по id

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
                     $('#client-teacher').val(" ");
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
                        
                          $('.tab_client tbody').append('<tr id="tr_'+id[s]+'">\n\
                          <td><div class="form-group name_table"><p>'+name[s]+'</p></div></td>\n\
                          </tr>');
                           
                          $('.tab_client tbody #tr_'+id[s]+'').append(select_price);
                          $('.tab_client tbody #tr_'+id[s]+'').append(pruxid_obj);

                          $('[data-price-id="'+id_price[s]+'"] option[value="'+id_price[s]+'"]').prop('selected', true);
                        ++s;
                        });
                        
                        
                        
                        $('.save_button').click(function(){
                            /* создать условие if(id - массив который прилетает с базы) если  
                             * он не пустой то мы запускаем цикл  for (id.lenght) и в это время
                             * подставляем в каждую строку id="tr_id[i]" и так собераем данные и заносим 
                             * в массив после выходим с цикла и передаем все с помощью ajax  в контроллер
                             * где после в модель и вводим данные в базу (UPDATE под id) 
                             * var id = document.getElementsByClassName('table_two').item(0).getElementsByTagName('tr').length - 1
                             * var rows_table = document.getElementsByClassName('table_two').item(0).getElementsByTagName('tr').length - 1;
                             *строку которую добавляем при кнопке добавить пишем класс tr_'id' ну а дальше запускаем цикл
                             * по rows_table.lenght и так же подставляем данные и заносим с помощью ajax в контроллер а потом и в 
                             * модель но уже INSERT  косяк токо что условие сработает раз если есть ид то апдейтит
                             * если нету то INSERT нужно как то запустить что бы сначала проверило и апдейтило а
                             * потом если нету id  то class  и  insert
                             * 
                             * 
                             * 
                             */
                            
                            //делаем проверку на id  записи если тру то UPDATE в базе
                            if(id.length>0){
                               
                               var mas_id = [];
                               
                               for (var index = 0; index<id.length; index++){
                                var id_id = id[index];
                                var date_now = new Date();
                                //получаем дату и время в тайне от пользователя
                                var date_time = date_now.getFullYear()+'-'+date_now.getMonth()+1+'-'+date_now.getDate()+' '+date_now.getHours()+':'+date_now.getMinutes();
                                var radio = $("#client-radio input[type='radio']:checked").val();
                                var teacher = $('#client-teacher').val();
                                var classroom = $('#client-classroom option:selected').val();
                                var client_date = $('#client-dates').val();   
                                var name = $('.tab_client tbody #tr_'+id[index]+' .name_table').text(); 
                                var sel_id = $('.tab_client tbody #tr_'+id[index]+' .select_add option:selected').val();    
                                var pruxid_id = $('.tab_client tbody #tr_'+id[index]+' .pruxid_add').val();      
                                var comment = $('#client-inform').val();    
                                    
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
                                     console.log(data);
                                     
                                    },
                                    error:function (xhr, ajaxOptions, thrownError){
                                        console.log(thrownError); //выводим ошибку
                                    }
                                });
                                
                                
                            }
                            
                            
                            //делаем проверку на id class записи если тру то INSERT в базе
                           // if(id_class){
                                
                           // }
                            
                            
                            
                        });
                        
                    }
                },
               error:function (xhr, ajaxOptions, thrownError){
                  console.log(thrownError); //выводим ошибку
              }   
             });
           }
          
       });
       
       $('.save_button').click(function(e){
           e.preventDefault();
           //получаем тип урок или iнше
           
           
           //сравниваем если это Урок то собираем все данные 
           //в этой вкладке и отправляем на сервер
           if(radio == 1){
            var date_now = new Date();
             //получаем дату и время в тайне от пользователя
            var date_time = date_now.getFullYear()+'-'+date_now.getMonth()+1+'-'+date_now.getDate()+' '+date_now.getHours()+':'+date_now.getMinutes();
            var radio = $("#client-radio input[type='radio']:checked").val();
            var teacher = $('#client-teacher').val();
            var classroom = $('#client-classroom').val();
            var client_date = $('#client-dates').val();
            
            var client_group = $('#client-groups').val();
            
            var comment = $('#client-inform').val();
            
            var a = $('.select_add').val();
            
            
            console.log(a);
            }
           
       });
       
       //по выбору типа меняем страницу
       $('input:radio').change(function(){
              //Уроки      
           if (this.value == 1) {
              $('.icon_add').css('display','block');
              $('.css_pruxid').css('display','none');
              $('.css_poyasn').css('display','none');
              $('.field-client-inform').css('display','block');
              $('.post_post').css('display','none');
              $('.save_button').css('display','block');
              $('.field-client-groups').css('display','block');
              
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
                        console.log(data);
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
       
       
    
    
     
     
    
});



