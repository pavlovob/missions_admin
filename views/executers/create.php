<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Executers */

$this->title = 'Create Executers';
$this->params['breadcrumbs'][] = ['label' => 'Executers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="executers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
