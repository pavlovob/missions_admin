<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр записи';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="missions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->uid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Действительно удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uid',
            'mission_name',
            'mission_date',
            'description',
            [
              'attribute' => 'status',
              'value' => $model->stateName($model->status),
            ],
            'approve_post',
            'approve_fio',
            'url',
            'created',
            'changed',
        ],
    ]) ?>

</div>
