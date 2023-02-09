<?php

use yii\db\Connection;

$host = getenv('MYSQL_HOST', 'db');
$database = getenv('MYSQL_DATABASE', 'book');
$user = getenv('MYSQL_USER', 'ubook');
$password = getenv('MYSQL_PASSWORD', 'k8Usdw342fsdflkjsDO');

return [
    'class' => Connection::class,
    'dsn' => "mysql:host={$host};dbname={$database}",
    'username' => $user,
    'password' => $password,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
