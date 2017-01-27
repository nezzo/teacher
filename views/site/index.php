<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="col-md-12">
    <div class="row">
        <div class="radio_button">
            <?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'radio')->inline()->radioList($type)->label(false) ?>
<?= $form->field($model, 'teacher')->textInput(['style'=>'width:15%;'])->label("Вчитель") ?> 
<?=$form->field($model, 'classRoom')->dropDownList($room,['prompt'=>'Выбрать'])->label("Аудиторiя") ?>
<?= $form->field($model, 'dates')->textInput(['style'=>'width:15%;'])->label("Дата i час (2000-01-20 16:30)") ?>
<?=$form->field($model, 'groups')->dropDownList($group,['prompt'=>'Выбрать'])->label("Студент(и)") ?> 
     <div class='window_add_user'>
            <?= $form->field($model, 'nameStudent')->textInput(['style'=>'width:100%;'])->label("Новий студент")?>
            <?= Html::submitButton('додати', ['class' => 'add_user_button_window btn btn-primary', 'name' => 'save-button']) ?>

      </div>
      <div class='window_add_group'>
            <?= $form->field($model, 'group')->textInput(['style'=>'width:100%;'])->label("Додати групу. Наприклад 16:00 Нина Ивановна")?>
            <?= Html::submitButton('додати', ['class' => 'group_user_button_window btn btn-primary', 'name' => 'save-button']) ?>

      </div>      
            <div class="icon_add">
                <div class="add_user">
                    <img src='../image/user_add.png' />
                </div>
               <div class='add_group'>
                   <img src='../image/new-group.png' />
               </div>
            </div> 
      
            <div class="tab_client">
                <table>
                <thead>
                    <th>Iм'я</th>
                    <th>
                     <?=$form->field($model, 'price_first')->dropDownList($price,['prompt'=>'Выбрать','class' => 'form-control select_price'])->label("Вартiсть") ?>
                    </th>
                    <th>Прихiд</th>
                </thead>
                <tbody>
                 <?php #TODO здесь будет начинаться цикл по выводу данных при выборе 
                 #группы <tr id=tr_$id> для каждой строки задаем id  для обновления в базе или 
                 #инсерта если такого ид нету, что бы получить id  нужно заюзать
                 # jquery и получить данные тега tr и это будет ключем по заносу в базу
                 # данных если записей нету то вывести простое поле для 
                 # ввода?>
                    
                 </tbody>
                 </table>
                <div class="button_table">  
              <?= Html::submitButton('Додати нового', ['class' => 'add_user_button btn btn-primary', 'name' => 'save-button']) ?>
                </div>
           </div>   
                     
            
            
           <div class="col-md-12">
               <?= $form->field($model, 'inform')->textInput(['style'=>'width:600px;'])->label("Додаткова iнформацiя") ?>
           </div> 
            <div class="col-md-12" style="margin-bottom:40px;">
             <?= Html::submitButton('Вiдправити', ['class' => 'btn btn-primary save_button', 'name' => 'post']) ?>
            </div> 
       
            
                
    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>