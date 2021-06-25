<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Assigners */

$this->title = 'Новая запись';
$this->params['breadcrumbs'][] = ['label' => 'Кураторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assigners-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
