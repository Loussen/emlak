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
    'homeUrl' => '',
	'timeZone' => 'Asia/Baku',
    'components' => [
		'mobileDetect' => [
			'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
		],
        'session' => [
            'name' => 'PHPFRONTSESSID',
            'savePath' => __DIR__ . '/../tmp',
        ],
        'request' => [
            'baseUrl' => '',
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
				[
					// redirect
                    'pattern' => '/<name:.*?>-s<id:\d+>',
                    'route' => 'elanlar/redirect',
                    'suffix' => '.html'
                ],
				[
                    'pattern' => '/elan/<link:.*?>',
                    'route' => 'query/index',
                ],
				[
                    'pattern' => '/elans/<link:.*?>',
                    'route' => 'seo-manual/index',
                ],
                [
                    'pattern' => '/<id:\d+>-<name:.*?>',
                    'route' => 'elanlar/view',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => 'yasayis-kompleksleri/<id:\d+>-<name:.*?>',
                    'route' => 'yasayis-kompleksleri/view',
                    'suffix' => '.html'
                ],
                '/site' => '/',
                '/elanlar' => 'elanlar',
                '/yasayis-kompleksleri' => 'yasayis-kompleksleri',
                '/haqqimizda' => 'haqqimizda',
                '/sifarisler' => 'sifarisler',
                '/xeberler' => 'xeberler',
                '/emlakcilar' => 'emlakcilar',
                '/xidmetler' => 'xidmetler',
                '/elaqe' => 'elaqe',
                '/profil' => 'profil',
                '/elan-ver' => 'elan-ver',
                '/reklam' => 'reklam',
                '/partnyorlar' => 'partnyorlar',
//                '/mail' => 'mail',
                '/<login:[\w\-]+>' => 'emlakcilar/view',
					'emlakcilar/marks_select' => 'emlakcilar/marks_select',
                'emlakcilar/<login:[\w\-]+>' => 'emlakcilar/view',
                '<controller:[\w\-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w\-]+>/<id:\d+>/<slug:[\w\-]+>' => '<controller>/view',
                '<controller:[\w\-]+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[\w\-]+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            /*
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
                'path'=>'/yii2/',  // correct path for the frontend app.
            ]
            */
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
    ],
    'params' => $params,
];
