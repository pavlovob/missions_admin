<?php
// ***************************************************************************
// Rename this file to db.php and fill the appropriate fileds with your owns!!!
// ***************************************************************************
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=yourMySQLServerAddress:port;dbname=your_DB_name',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8', //may leave as is

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
