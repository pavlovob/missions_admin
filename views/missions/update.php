<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Missions */

$this->title = 'Редактироавние: ' . $model->mission_name;
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mission_name, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="missions-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model'   => $model,
        'states'  => $states,
    ]) ?>

</div>
