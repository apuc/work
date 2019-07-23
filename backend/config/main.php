<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
//        'security' => [
//            // following line will restrict access to profile, recovery, registration and settings controllers from backend
//
//        ],
        'company' => [
            'class' => 'backend\modules\company\Company',
        ],
        'employer' => [
            'class' => 'backend\modules\employer\Employer',
        ],
        'resume' => [
            'class' => 'backend\modules\resume\Resume',
        ],
        'vacancy' => [
            'class' => 'backend\modules\vacancy\Vacancy',
        ],
        'experience' => [
            'class' => 'backend\modules\experience\Experience',
        ],
        'education' => [
            'class' => 'backend\modules\education\Education',
        ],
        'schedule' => [
            'class' => 'backend\modules\schedule\Schedule',
        ],
        'skill' => [
            'class' => 'backend\modules\skill\Skill',
        ],
        'category' => [
            'class' => 'backend\modules\category\Category',
        ],
        'key_value' => [
            'class' => 'backend\modules\key_value\KeyValue',
        ],
        'mail_delivery' => [
            'class' => 'backend\modules\mail_delivery\MailDelivery',
        ],
        'user' => [
            'class'  => 'dektrium\user\Module',
            'admins' => ['test'],
            'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
    ],
    'components' => [
//        'request' => [
//            'csrfParam' => '_csrf-backend',
//        ],
//        'security' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.adm.tools',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'noreply@rabota.today',
                'password' => 'LX03yJjMei03',
                'port' => '2525', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@vendor/dektrium/user/views' => '@backend/views'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'baseUrl' => '/secure',
            //'class' => 'frontend\components\LangRequest',
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
