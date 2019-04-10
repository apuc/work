<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'aliases' => [
        '@dektrium/user' => '@vendor/dektrium/yii2-user'
    ],
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'class' => 'dektrium\user\Module',
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
        ],
        'personal_area' => [
            'class' => 'frontend\modules\personal_area\PersonalArea',
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'request' => [
            'class' => 'frontend\modules\request\Request',
        ],
        'main_page' => [
            'class' => 'frontend\modules\main_page\MainPage',
        ],
    ],
    'components' => [
//        'request' => [
//            'csrfParam' => '_csrf-frontend',
//        ],
        'user' => [
            //'class' => 'app\components\User',
            'identityClass' => 'dektrium\user\models\User',
        ],
//        'security' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
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
        'request' => [
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
            //'class' => 'frontend\components\LangRequest',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'about' => 'site/about',
                '/' => 'main_page/default/index',
                'resume/view/<id>' => 'main_page/resume/view',
                'vacancy/view/<id>' => 'main_page/vacancy/view',
                'personal-area/<action>' => 'personal_area/personal-area/index',
                ['class' => 'yii\rest\UrlRule', 'controller' =>
                    [
                        'request/category',
                        'request/company',
                        'request/education',
                        'request/employer',
                        'request/employment-type',
                        'request/experience',
                        'request/resume',
                        'request/schedule',
                        'request/skill',
                        'request/vacancy',
                    ],
                    'pluralize'=>false],

            ],
        ],
        'formatter' => [

            'locale' => 'ru-RU'
        ],
    ],
    'params' => $params,
];
