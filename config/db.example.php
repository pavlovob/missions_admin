<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=yourMySQLServerAddr:port;dbname=your_DB_name',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8', //may leave as is

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
