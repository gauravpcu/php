<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=172.17.0.1;dbname=sp_benchmark_rd;port=3306',
    'username' => 'root',
    'password' => 'hybrent',
    'charset' => 'utf8',
    'tablePrefix' => 'yii_',
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
