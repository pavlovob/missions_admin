<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Missions */

$this->title = 'Редактироавние: ' . $model->mission_name;
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="missions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'   => $model,
        'states'  => $states,
    ]) ?>

</div>
