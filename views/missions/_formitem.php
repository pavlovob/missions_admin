<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use app\assets\AppAsset;

?>
<div class="missionitems-form">
  <div class="w3-container w3-tiny">


    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
    <?= $form->field($model, 'executeruid')->dropdownList($executers,[
      'id'=>'_executersdropdown',
      'prompt'=>'Выберите испонителя',
      'onchange'=>'$.post("'.Yii::$app->urlManager->createUrl(['executers/getname','id'=>'']).'"+$(this).val() , function( data ){
        $("#_executername").val(data);}
      );',
      ])?>
      <?= $form->field($model, 'executer_name')->textInput(['maxlength' => true,'id'=>'_executername']) ?>      
      <!-- <?= $form->field($model, 'num_pp')->textInput(['maxlength' => true]) ?> -->
      <?= $form->field($model, 'task')->textarea(['rows' => 5, 'cols' => 5])?>

      <?= $form->field($model, 'assigner_name')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'deadline')->textarea(['rows' => 2,'cols' => 1])?>

      <div class="form-group">
        <!-- <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?> -->
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>


    </div>
  </div>
