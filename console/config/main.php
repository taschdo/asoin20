<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=192.168.31.5;dbname=asoin',
//            'username' => 'userAsoin',
//            'password' => '!QA2ws#ED4rf%TG',
//            'charset' => 'utf8',
//            'tablePrefix' => 'asoin_',
//            'enableSchemaCache' => true,
            // Имя компонента кэш используется для хранения информации о схеме
//            'schemaCache' => 'cache',
            // Продолжительность кэша схемы
//            'schemaCacheDuration' => 86400,
            // 24 часа в секундакх
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
