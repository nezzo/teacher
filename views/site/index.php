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
      <div class="col-md-3"> 
       <div class="row">
            <?= $form->field($model, 'nameStudent1')->textInput(['style'=>'width:60%;'])->label("Iм'я")?>
       </div>
       </div>
       <div class="price"> 
       <div class="col-md-3">
        <div class="row">
           <?=$form->field($model, 'price1')->dropDownList($room,['prompt'=>'Выбрать'])->label("Вартiсть") ?>
           <?=$form->field($model, 'price2')->dropDownList($room,['prompt'=>'Выбрать'])->label(" ") ?>
      </div>
       </div>    
       </div>
       <div class="col-md-6">           
        <div class="row">
           <div class="col-md-6">
            <?= $form->field($model, 'pruxid1')->textInput(['style'=>'width:60%;'])->label("Прихiд")?>
          </div>
         <?= Html::submitButton('Додати нового', ['class' => 'btn btn-primary save_button', 'name' => 'save-button']) ?>

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