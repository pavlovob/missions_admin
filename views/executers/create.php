<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Executers */

$this->title = 'Новая запись';
$this->params['breadcrumbs'][] = ['label' => 'Исполнители', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="executers-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
