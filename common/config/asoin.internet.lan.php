<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.31.5;dbname=asoin',
            'username' => 'userAsoin',
            'password' => '!QA2ws#ED4rf%TG',
            'charset' => 'utf8',
            'tablePrefix'=>'asoin_',
//            'enableSchemaCache' => true,
            // Имя компонента кэш используется для хранения информации о схеме
//            'schemaCache' => 'cache',
            // Продолжительность кэша схемы
//            'schemaCacheDuration' => 86400,
            // 24 часа в секундакх
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
