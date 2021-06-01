<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Assigners */

$this->title = 'Create Assigners';
$this->params['breadcrumbs'][] = ['label' => 'Assigners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assigners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
