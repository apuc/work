<?php

use yii\web\Cookie;

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
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'class' => 'dektrium\user\Module',
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
            'controllerMap' => [
                'security' => [
                    'class' => \dektrium\user\controllers\SecurityController::className(),
                    'on ' . \dektrium\user\controllers\SecurityController::EVENT_AFTER_LOGIN => function ($e) {
                        $cookie = Yii::createObject([
                            'class' => 'yii\web\Cookie',
                            'name' => 'key',
                            'value' => Yii::$app->user->identity->getAuthKey(),
                            'expire' => time() + 7*86400,
                            'httpOnly' => false
                        ]);
                        Yii::$app->getResponse()->getCookies()->add($cookie);
                    },
                    'on ' . \dektrium\user\controllers\SecurityController::EVENT_BEFORE_LOGOUT => function ($e) {
                        Yii::$app->getResponse()->getCookies()->remove('key');
                        $user = \dektrium\user\models\User::findIdentity(Yii::$app->user->id);
                        $user->auth_key=Yii::$app->security->generateRandomString();
                        $user->save();
                    },
                ],
            ],
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
        'vacancy' => [
            'class' => 'frontend\modules\vacancy\Vacancy',
        ],
        'resume' => [
            'class' => 'frontend\modules\resume\Resume',
        ],
    ],
    'components' => [
//        'request' => [
//            'csrfParam' => '_csrf-frontend',
//        ],
        'user' => [
            //'class' => 'app\components\User',
            'identityClass' => 'common\models\base\User',
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
                'resume/view/<id>' => 'resume/default/view',
                'vacancy/view/<id>' => 'vacancy/default/view',
                'vacancy/search' => 'vacancy/default/search',
                'resume/search' => 'resume/default/search',
                'personal-area/<action>' => 'personal_area/default/index',
                'personal-area/<action>/<id>' => 'personal_area/default/index',
                'personal-area' => 'personal_area/default/index',
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
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/languages',
                ],
            ],
        ],
    ],
    'params' => $params,
];
