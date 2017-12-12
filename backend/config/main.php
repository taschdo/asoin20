<?php
use developeruz\db_rbac\behaviors\AccessBehavior;
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'as AccessBehavior' => [
        'class' => AccessBehavior::className(),
        'protect' => [
            'site',
            'profile',
            'oksion',
            'monitoring-media',
            'subject',
            'base-media',
            'study',
        ],
        'rules' => [
            'site' =>
                [
                    [
                        'actions' => ['login', 'error'],
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['main','logout','error'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            'profile' =>
                [
                    [
                        'actions' => ['my'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
        ]
    ],
    'modules' => [
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'common\models\User',
                'accessRoles' => ['developer']
            ]
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ]
    ],
    'homeUrl' => '/admin/main',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/login',
                'profile' => 'profile/index',
                'my' => 'profile/my',
                'oksion' => 'oksion/index',
                'base-media' => 'base-media/index',
                'subject' => 'subject/index',
                'study' => 'study/index',
                'monitoring-media' => 'monitoring-media/index',
                '<action>' => 'site/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'formatter' => [
            'nullDisplay' => '&nbsp;',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte',
                ],
            ],
        ],

        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
