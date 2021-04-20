<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Inifile */

$this->title = 'Create Inifile';
$this->params['breadcrumbs'][] = ['label' => 'Inifiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inifile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
