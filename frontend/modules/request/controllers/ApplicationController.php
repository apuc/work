<?php

namespace frontend\modules\request\controllers;

use common\classes\Debug;
use dektrium\user\models\Token;
use frontend\modules\request\models\UserDeviceToken;
use frontend\services\TokenService;
use yii\rest\Controller;
use Yii;
use frontend\services\ApplicationService;

class ApplicationController extends Controller
{
    /** @var ApplicationService */
    private $applicationService;

    public function init()
    {
        parent::init();
        $this->applicationService = new ApplicationService();
    }


    public function actionLogin()
    {
        $token = UserDeviceToken::findOne(['user_id' => 7000000]);
        var_dump($token);die;

//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

        $username = Yii::$app->request->getBodyParam('login');
        $password = Yii::$app->request->getBodyParam('password');

        if ($this->applicationService->login($username, $password)) {
            return [
                'access_token' => Yii::$app->user->identity->getAuthKey(),
                'token_type' => 'Bearer',
                'expires_in' => 'TODO', //TODO изменить после реализации обновления токена
            ];
        } else {
            return [
                'status' => 'authentication failed',
                'errors' => ''
            ];
        }
    }
}