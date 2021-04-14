<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Запись с кодом '.$model->UID;
$this->params['breadcrumbs'][] = ['label' => 'История', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-view">
  <div class="w3-row w3-tiny">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'UID',
            'USERNAME',
            'DESCRIPTION',
            'RECORDCONTENT',
            'ACTIONDATETIME',
        ],
    ]) ?>
    </div>

</div>
