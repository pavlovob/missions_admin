<?php
namespace app\models;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use app\models\User;
use app\models\Workers;
use yii\helpers\ArrayHelper;
?>

<div class="w3-row">
  <!-- <div class="w3-third w3-container">
  </div> -->
  <!-- <div class="w3-third w3-container w3-small"> -->
    <div class="w3-row w3-small">
    <?php  $form = ActiveForm::begin(['layout' => 'horizontal']);?>

      <?= ($pwd == 0) ? $form->field($model, 'login')->textInput(['autofocus' => true]):null ?>
      <?= ($pwd == 0) ? $form->field($model, 'username')->textInput():null ?>
      <?= ($model->isNewRecord || $pwd == 1) ? $form->field($model, 'password')->passwordInput():null ?>
      <?= ($model->isNewRecord || $pwd == 1) ?  $form->field($model, 'password_check')->passwordInput():null ?>
      <?= ($pwd == 0) ? $form->field($model, 'usertype')->dropdownList($usertypes,['prompt'=>'Выберите тип пользователя...']):null ?>
      <?= ($pwd == 0) ? $form->field($model, 'assignerid')->dropdownList($assigners,['id'=>'uid','prompt'=>'Выберите куратора...']):null ?>
      <?= ($pwd == 0) ? $form->field($model, 'executerid')->dropdownList($executers,['id'=>'uid','prompt'=>'Выберите исполнителя...']):null ?>
      <div class="form-group">
        <!--<?= Html::submitButton('Записать', ['class' => 'btn btn-primary']) ?>-->
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
    <div class="w3-third w3-container">
    </div>
  </div>
