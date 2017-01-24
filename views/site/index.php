<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="col-md-12">
    <div class="row">
        <div class="radio_button">
            <?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'radio')->inline()->radioList(['lesson' => 'Уроки', 'other' => 'Iнше'])->label(false) ?>
<?= $form->field($model, 'teacher')->textInput(['style'=>'width:15%;'])->label("Вчитель") ?> 
<?=$form->field($model, 'classRoom')->dropDownList($room,['prompt'=>'Выбрать'])->label("Аудиторiя") ?>
<?= $form->field($model, 'dates')->textInput(['style'=>'width:15%;'])->label("Дата i час") ?>
<?=$form->field($model, 'student')->dropDownList($stud,['prompt'=>'Выбрать'])->label("Студент(и)") ?> 
                 
      <div class='window_add_user'>
            <?= $form->field($model, 'nameStudent')->textInput(['style'=>'width:100%;'])->label("Новий студент")?>
            <?= Html::submitButton('Додати нового', ['class' => 'add_user btn btn-primary save_button', 'name' => 'save-button']) ?>

      </div>
            <div class="col-md-3">
        <div class="row">
            <div class='name_student'>
            <?= $form->field($model, 'nameStudent')->textInput(['style'=>'width:60%;'])->label("Iм'я")?>
            </div>    
       </div>
       </div>
       <div class="price"> 
       <div class="col-md-3">
           <div class="icon_add">
                <div class="add_user">
                    <img src='../image/user_add.png' />
                </div>
               <div class='add_group'>
                   <img src='../image/new-group.png' />
               </div>
            </div> 
         <div class="row">
           <?=$form->field($model, 'price1')->dropDownList($room,['prompt'=>'Выбрать'])->label("Вартiсть") ?>
           <?=$form->field($model, 'price2')->dropDownList($room,['prompt'=>'Выбрать'])->label(" ") ?>
      </div>
       </div>    
       </div>
       <div class="col-md-6">           
        <div class="row">
           <div class='right_size'>
           <div class="col-md-6">
            <div class='pruxid_student'>   
            <?= $form->field($model, 'pruxid')->textInput(['style'=>'width:60%;'])->label("Прихiд")?>
            </div>
         </div>
         <?= Html::submitButton('Додати нового', ['class' => 'add_user_button btn btn-primary save_button', 'name' => 'save-button']) ?>
         </div>
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