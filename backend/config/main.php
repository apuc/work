<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
//        'security' => [
//            // following line will restrict access to profile, recovery, registration and settings controllers from backend
//
//        ],
        'dynagrid'=> [
            'class'=>'\kartik\dynagrid\Module',
            'defaultPageSize'=>20,
        ],
        'gridview'=> [
            'class'=>'\kartik\grid\Module',
            // other module settings
        ],
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
        'cities' => [
            'class' => 'backend\modules\cities\Cities',
        ],
        'news' => [
            'class' => 'backend\modules\news\News',
        ],
        'tags' => [
            'class' => 'backend\modules\tags\Tags',
        ],
        'views' => [
            'class' => 'backend\modules\views\Views',
        ],
        'test' => [
            'class' => 'apuc\channels_webhook\modules\test\Test',
        ],
        'user' => [
            'class'  => 'dektrium\user\Module',
            'admins' => ['test', 'millenion94@gmail.com', 'kirill.bouko@gmail.com', 'test@test.test'],
            'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
        'professions' => [
            'class' => 'backend\modules\professions\Professions',
        ],
        'meta-data' => [
            'class' => 'backend\modules\meta_data\MetaData',
        ],'spec-filters' => [
            'class' => 'backend\modules\spec_filters\SpecFilters',
        ],
        'country' => [
            'class' => 'backend\modules\country\Country',
        ],
        'banner' => [
            'class' => 'backend\modules\banner\Banner',
        ],
        'payment' => [
            'class' => 'backend\modules\payment\Payment',
        ],
        'update' => [
            'class' => 'backend\modules\update\Update',
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
                'user/admin/update' => 'site/users',
                '/' => '/statistics/index'
            ],
        ],
    ],
    'params' => $params,
];
