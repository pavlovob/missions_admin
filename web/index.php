<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// -----------------  Константы ------------------
//роли пользователей
define ('USERTYPE_ADMIN', 1);     //Администратор
define ('USERTYPE_ASSIGNER', 2);  //Кураторы
define ('USERTYPE_EXECUTER', 3);  //Исполнителиcd
define ('USERTYPE_BLOCKED', 4);   //Пользователь заблокирован
//статус поручений
define ('STATE_ASSIGN', 1001);    //поручения открыты для редактирования
define ('STATE_REPORT', 1002);    //поручения открыты для редактирования
define ('STATE_CLOSED', 1003);     //закрыты
define ('STATE_DELETED', 1004);   //удалены
//статус пунктов поручений
define ('STATE_INWORK', 1011);  //Назначены, в работе. по умолчанию устанавливается в БД при создании
define ('STATE_DONE', 1012);    //Выполнены (устанавливается куратором)
//------------------ конец определений

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();
