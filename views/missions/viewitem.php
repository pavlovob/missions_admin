<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр записи';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['indexitems','id'=>$model->missionuid]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="missionitem-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Редактировать', ['updateitem', 'id' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['deleteitem', 'id' => $model->uid], [
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
            'num_pp',
            'deadline',
            'task',
            'executer_name',
            // [
            //   'attribute' => 'status',
            //   'value' => $model->stateName($model->status),
            // ],
            // 'approve_post',
            // 'approve_fio',
            // 'url',
            'created',
            'changed',
        ],
    ]) ?>

</div>
