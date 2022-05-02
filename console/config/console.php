<?php
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['report', 'gii'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],
    ],
    'modules' => [
        'report' => [
            'class' => \console\modules\report\ReportModule::class,
            'storagePath' => '@storage',
            'dbComponent' => 'db',
        ],
        'gii' => [
            'class' => \yii\gii\Module::class,
        ],
    ],
];