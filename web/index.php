<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// -----------------  Константы ------------------
//статус поручений
define ('STATE_OPEN', 1001);    //поручения открыты для редактирования
define ('STATE_CLOSE', 1002);   //закрыты
define ('STATE_DELETED', 1003); //удалены
//статус пунктов поручений
define ('STATE_INWORK', 1011);  //Назначены, в работе. по умолчанию устанавливается в БД при создании
define ('STATE_DONE', 1012);    //Выполнены (устанавливается куратором)
//роли пользователей
define ('USERTYPE_ADMIN', 1);     //Администратор
define ('USERTYPE_ASSIGNER', 2);  //Кураторы
define ('USERTYPE_EXECUTER', 3);  //Исполнителиcd
define ('USERTYPE_BLOCKED', 4);   //Пользователь заблокирован


//------------------ конец определений

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();
