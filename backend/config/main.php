<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'layout'=>'admin',
    'defaultRoute' => 'site',
    'timeZone' => 'Asia/Baku',
    'language'=>'az',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'homeUrl' => '/emlak0050pro',
    'components' => [
        'session' => [
            'name' => 'PHPBACKSESSID',
            'savePath' => __DIR__ . '/../tmp',
        ],
        'request' => [
            'baseUrl' => '/emlak0050pro',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'send@emlak.az',
                'password' => 'yeni4292020emlak',
                'port' => '587',
                'encryption' => 'tls',
            ],

        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:[\w\-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w\-]+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[\w\-]+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
		/*
        'user' => [
            'identityClass' => 'backend\models\Admins',
            'enableAutoLogin' => false,
            
            //'identityCookie' => [
            //    'name' => '_backendUser', // unique for backend
            //    'path'=>'/emlak/admin',  // correct path for the backend app.
            //]
            
        ],
		*/
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
    ],
    'params' => $params,
];
