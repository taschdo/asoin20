<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'ru-RU',
    'name'=>'АС ОИН',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'class' => 'yii\rbac\PhpManager',
//            'defaultRoles' => ['junior','user','moderator','administrator','developer'], //здесь прописываем роли
            // junior-субъект ТО
            // user-УИ
            // moderator-АРМ26,28,30
            //administrator-повседневка,АРМ27
            //developer-разработчик
            //зададим куда будут сохраняться наши файлы конфигураций RBAC
//            'itemFile' => '@common/components/rbac/items.php',
//            'assignmentFile' => '@common/components/rbac/assignments.php',
//            'ruleFile' => '@common/components/rbac/rules.php'
        ],
    ],
];
