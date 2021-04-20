<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Inifile */

$this->title = 'Просмотр записи';
// $this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inifile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'uid',
          'login',
          'username',
          'computername',
          'info',

    ]]) ?>




    <?php
    // foreach($info['os'] as $key => $value) {
    //   echo $key," - ",$value, '<br>';
    // }
    //var_dump($info);
    ?>

    <h4><?= Html::encode("Подробно (информация появится при корректном декодировании поля ИНФО): ") ?></h4>

    <?php

    if ($info !== null){
      echo  DetailView::widget([
              'model' => $info,
              'attributes' => [
                  "os_caption",
                  "os_status",
                  "os_installdate",
                  "os_buildnumber",
                  "os_version",
                  "pc_serial",
                  "net_adapter_1",
                  "net_adapter_2",
                  "net_adapter_3",
                  "net_adapter_4",
                  "net_adapter_5",
                  "disk_drive_1",
                  "disk_drive_2",
                  "disk_drive_3",
                  "disk_drive_4",
                  "disk_drive_5",
                  "printer_1",
                  "printer_2",
                  "printer_3",
                  "printer_4",
                  "printer_5",
                  "user_login",
                  "user_name",
                  "user_logontype",
          ]]);
    }


    ?>


</div>
