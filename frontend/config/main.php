<?php

use dektrium\user\models\Token;
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
                    },
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_CONFIRM => function () {
                        \common\classes\Debug::dd(123);
                        $cookie = Yii::createObject([
                            'class' => 'yii\web\Cookie',
                            'name' => 'key',
                            'value' => Yii::$app->user->identity->getAuthKey(),
                            'expire' => time() + 7*86400,
                            'httpOnly' => false
                        ]);
                        Yii::$app->getResponse()->getCookies()->add($cookie);
                    },
                    'on ' . \dektrium\user\controllers\SecurityController::EVENT_AFTER_AUTHENTICATE=> /**
                     * @param \dektrium\user\events\AuthEvent $e
                     */
                        function ($e) {
                        if ($e->account->user === null) {
                            return;
                        }
                        if(!\common\models\Employer::find()->where(['user_id'=>Yii::$app->user->id])->one()){
                            $employer = new \common\models\Employer();
                            $employer->user_id=Yii::$app->user->id;
                            $employer->first_name=$e->client->getUserAttributes()['first_name'];
                            $employer->second_name=$e->client->getUserAttributes()['last_name'];
                            if(isset($e->client->getUserAttributes()['bdate']))
                                $employer->birth_date=date('Y-m-d', strtotime($e->client->getUserAttributes()['bdate']));
                            $employer->save();
                            Yii::$app->mailer->viewPath='@common/mail';
                            $token = Token::findOne(['user_id'=>Yii::$app->user->id]);
                            Yii::$app->mailer->compose('registration_notification', ['employer'=>$employer, 'user'=>Yii::$app->user->identity, 'token'=>null])
                                ->setFrom('noreply@rabota.today')
                                ->setTo(Yii::$app->user->identity->email)
                                ->setSubject('Спасибо за регистрацию')
                                ->send();
                        }
                            $cookie = Yii::createObject([
                                'class' => 'yii\web\Cookie',
                                'name' => 'key',
                                'value' => Yii::$app->user->identity->getAuthKey(),
                                'expire' => time() + 7*86400,
                                'httpOnly' => false
                            ]);
                            Yii::$app->getResponse()->getCookies()->add($cookie);
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
        'dialog' => [
            //'basePath' => '@vendor/apuc/yii2-msg-module/controllers',
            'class' => 'apuc\msg_module\Module',
        ],
        'vacancy' => [
            'class' => 'frontend\modules\vacancy\Vacancy',
        ],
        'resume' => [
            'class' => 'frontend\modules\resume\Resume',
        ],
        'msg' => [
            'class' => 'frontend\modules\msg\Msg',
        ],
//        'news' => [
//            'class' => 'eugenekei\news\Module',
//        ],
        'news' => [
            'class' => 'frontend\modules\news\News',
        ],
        'company' => [
            'class' => 'frontend\modules\company\Company',
        ],
    ],
    'components' => [
//        'request' => [
//            'csrfParam' => '_csrf-frontend',
//        ],
        'mymessages' => [
            //Обязательно
            'class' => 'vision\messages\components\MyMessages',
            //не обязательно
            //класс модели пользователей
            //по-умолчанию \Yii::$app->user->identityClass
            'modelUser' => 'frontend\models\user\UserDec',
            //имя контроллера где разместили action
            'nameController' => '/msg/default',
            //не обязательно
            //имя поля в таблице пользователей которое будет использоваться в качестве имени
            //по-умолчанию username
            'attributeNameUser' => 'username',
            //не обязательно
            //можно указать роли и/или id пользователей которые будут видны в списке контактов всем кто не подпадает
            //в эту выборку, при этом указанные пользователи будут и смогут писать всем зарегестрированным пользователям
            'admins' => [],
            //не обязательно
            //включение возможности дублировать сообщение на email
            //для работы данной функции в проектк должна быть реализована отправка почты штатными средствами фреймворка
            'enableEmail' => true,
            //задаем функцию для возврата адреса почты
            //в качестве аргумента передается объект модели пользователя
            'getEmail' => function ($user_model) {
                return $user_model->email;
            },
            //задаем функцию для возврата лого пользователей в списке контактов (для виджета cloud)
            //в качестве аргумента передается id пользователя
            'getLogo' => function ($user_id) {
                return '\img\ghgsd.jpg';
            },
            //указываем шаблоны сообщений, в них будет передаваться сообщение $message
            'templateEmail' => [
                'html' => 'private-message-text',
                'text' => 'private-message-html'
            ],
            //тема письма
            'subject' => 'Private message'
        ],
        'user' => [
            //'class' => 'app\components\User',
            'identityClass' => 'common\models\User',
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
                '/employer' => 'main_page/company/index',
                'resume/view/<id>' => 'resume/default/view',
                'vacancy/view/<id>' => 'vacancy/default/view',
                'company/view/<id>' => 'company/default/view',
                'msg' => 'msg/default/index',
                'vacancy/default/send-message' => 'vacancy/default/send-message',
                'vacancy/default/click-phone'=>'vacancy/default/click-phone',
                'resume/default/click-phone'=>'resume/default/click-phone',
                'company/default/click-phone'=>'company/default/click-phone',
                'vacancy' => 'vacancy/default/search',
                'vacancy/<first_query_param>' => 'vacancy/default/search',
                'vacancy/<first_query_param>/<second_query_param>' => 'vacancy/default/search',
                'resume/default/send-message' => 'resume/default/send-message',
                'resume' => 'resume/default/search',
                'resume/<first_query_param>' => 'resume/default/search',
                'resume/<first_query_param>/<second_query_param>' => 'resume/default/search',
                'personal-area/<action>' => 'personal_area/default/index',
                'personal-area/<action>/<id>' => 'personal_area/default/index',
                'personal-area' => 'personal_area/default/index',
                'cities' => 'main_page/default/city',
                'sitemap.xml' => 'sitemap/index',
                'vacancy_<number:\d+>.xml'=>'sitemap/vacancy',
                'resume_<number:\d+>.xml'=>'sitemap/resume',
                'company_<number:\d+>.xml'=>'sitemap/company',
                'city_<number:\d+>.xml'=>'sitemap/city',
                'category_<number:\d+>.xml'=>'sitemap/category',
                'profession_<number:\d+>.xml'=>'sitemap/profession',
                'vacancy/click-phone'=>'vacancy/default/click-phone',
                'city_with_category_<number:\d+>.xml'=>'sitemap/city-with-category',
                'city_with_profession_<number:\d+>.xml'=>'sitemap/city-with-profession',
                'confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'registration/confirm',
                'news/view/<id:\d+>' => 'news/default/view',
                ['class' => 'yii\rest\UrlRule', 'controller' =>
                    [
                        'request/category',
                        'request/company',
                        'request/dialog',
                        'request/dialog-message',
                        'request/dialog-user',
                        'request/education',
                        'request/employer',
                        'request/employment-type',
                        'request/experience',
                        'request/resume',
                        'request/schedule',
                        'request/skill',
                        'request/vacancy',
                        'request/views',
                        'request/city',
                        'dialog/dialog-message',
                        'dialog/dialog',
                        'dialog/dialog-user',
                    ],
                    'pluralize'=>false],

            ],
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/languages',
                ],
            ],
        ],
//        'assetManager' => [
//            'appendTimestamp' => true,
//            'bundles' => [
//
//                /*'yii\bootstrap\BootstrapPluginAsset' => [
//                'js'=>[]
//                ],*/
//                'yii\bootstrap\BootstrapAsset' => [
//                    'css' => [],
//                ],
//            ],
//        ],
    ],
    'params' => $params,
];
