<?php
use yii\helpers\Html;

$this->title = 'ИС "Поручения"';
?>
<div class="site-index">

    <div class="jumbotron">
        <img src= <?= Yii::$app->params['org_logo_file']?>  height="45" width="250">
      <!-- <img src="tn.png"  height="45" width="250"> -->
        <h2>ИС "Поручения"</h2>
        <!-- <p class="lead">Выберите соответствующий пункт меню для работы.</p> -->

        <?= (!Yii::$app->user->isGuest) ? Html::tag('p',Html::encode('Выберите соответствующий пункт меню для работы'),['class' => 'lead']) : Html::tag('p',Html::encode('Для начала работы выполните вход в систему'),['class' => 'lead'])?>
        <!-- <p> -->
        <?= (Yii::$app->user->isGuest) ? Html::a(Html::encode('Вход'),['site/login'],['class' => 'btn btn-lg btn-success']) : ''?>
        <!-- </p> -->

        <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
    </div>

</div>
