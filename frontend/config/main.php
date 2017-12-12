<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app',
////                    '@app/modules' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//                ],
//            ],
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login'=>'site/login',


//                'ololo'=>'site/go-event',
//                'register'=>'user/registration/register',
//                'resend'=>'user/registration/resend',
//                'confirm'=>'user/registration/confirm',
//                'login'=>'user/security/login',
//                'logout'=>'user/security/logout',
//                'request'=>'user/recovery/request',
//                'reset'=>'user/recovery/reset',
//                'profile/account'=>'user/settings/account',
//                'profile/networks'=>'user/settings/networks',
//                'connect'=>'user/registration/connect',
//                'profile'=>'profile/default/index',
//                'profile/settings'=>'profile/default/settings',
////                'profile/account'=>'profile/default/settings',
//                'profile/event'=>'profile/event/index',
//                'profile/service'=>'profile/service/index',
//                'profile/organization'=>'profile/organization/index',
//                'profile/thematic-group'=>'profile/thematic-group/index',
//                'profile/friend'=>'profile/friend/index',
//                'profile/message'=>'profile/message/index',
//                'profile/auction'=>'profile/auction/index',
                '<action>' => 'site/<action>',
            ],
        ],
    ],
    'params' => $params,
];
