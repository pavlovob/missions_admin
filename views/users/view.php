<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Пользователь: '.$model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить. Уверены?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Сменить пароль', ['pwdchange', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uid',
            'login',
            'username',
            [
              'attribute' => 'usertype',
              'value' => $model->userTypeName($model->usertype),
            ],
            [
              'attribute' => 'assignerid',
              'value' => ($model->assigner !== null) ? $model->assigner->name : "",
            ],
            [
              'attribute' => 'executerid',
              'value' => ($model->executer !== null) ? $model->executer->name : "",
            ],
            'created',
            'changed',
        ],
    ]) ?>

</div>
