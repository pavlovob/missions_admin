<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="assigners-form">

  <?php  $form = ActiveForm::begin([
    'id'=>'project-form',
    'layout' => 'horizontal',
  ]);
  ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ordernumber')->textInput() ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 2, 'cols' => 5])?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
