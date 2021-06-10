<?php

use yii\helpers\Html;

$this->title = 'Новые поручения ';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missions-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'states'  => $states,
    ]) ?>

</div>
