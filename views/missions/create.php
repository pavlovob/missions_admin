<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Missions */

$this->title = 'Новые поручения на месяц';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'months'  => $months,
    ]) ?>

</div>
