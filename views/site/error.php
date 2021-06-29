<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">


    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ошибка.
    </p>
    <p>
      Если вы уверенны, что данной ошибки быть не должно, обратитесь к администратору информационной системы.
    </p>

</div>
