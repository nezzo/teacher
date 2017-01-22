<?php

#TODO тут надо будет поставить проверку по IP (есть какие 
#то избранные которые могут быть здесь + надо написать доступы логин 
#и пароль) и сессию заюзать
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

?>

<div class="admin_panel">
    <?php $form = ActiveForm::begin(); ?>
   <div class="col-md-12"> 
    <div class="admin_panel_time">
        <?php #TODO задать вопрос насчет времени это дроп лист или что (2 поля с временем и датой от и до)?>
    ДАТА  от и до
    </div>
   </div>
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="watch_post">
                <div class="droplist">
                    <?= Html::activeLabel($model, 'all', ['label' => '-усi']) ?>
                    <?=$form->field($model, 'type')->dropDownList($room,['prompt'=>'Выбрать'])->label("-по типу") ?>
                    <?=$form->field($model, 'teacher')->dropDownList($room,['prompt'=>'Выбрать'])->label("-по вчителю") ?>
                    <?=$form->field($model, 'clas')->dropDownList($room,['prompt'=>'Выбрать'])->label("-по аудиторiї") ?>
                    <?=$form->field($model, 'student')->dropDownList($room,['prompt'=>'Выбрать'])->label("-по студенту") ?>
                    <?=$form->field($model, 'group')->dropDownList($room,['prompt'=>'Выбрать'])->label("-по групi") ?>
                </div>    
            </div>
        </div>
        <div class="col-md-9">
            <?php #TODO тут нужно заюзать (разобраться) с GridView очень хорошо подходит для таблицы?>
            <div class="grid_table">ssss</div>
        </div>
    </div>
    <div class="col-md-12">
       <div class="col-md-3"> 
        <div class="title_left_block"><p>Дивитись iнше</p></div>
        <div class="left_block">
             <?= Html::activeLabel($model, 'all', ['label' => '-усi']) ?>
             <?= Html::activeLabel($model, 'all', ['label' => '-усi']) ?>
             <?= Html::activeLabel($model, 'all', ['label' => '-усi']) ?>
             <?= Html::activeLabel($model, 'all', ['label' => '-усi']) ?>
             <?= Html::activeLabel($model, 'all', ['label' => '-усi']) ?>
        </div>
       </div> 
    </div>
    <?php ActiveForm::end(); ?>
</div>
