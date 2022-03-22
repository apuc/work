<?php

namespace frontend\modules\request\controllers;

use frontend\services\TokenService;
use yii\rest\Controller;
use Yii;
use frontend\services\ApplicationService;

class ApplicationController extends Controller
{
    /** @var ApplicationService */
    private $applicationService;
    private $tokenService;

    protected function verbs()
    {
        return [
            'login' => ['POST'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->applicationService = new ApplicationService();
        $this->tokenService = new TokenService();
    }


    public function actionLogin()
    {
        $username = Yii::$app->request->getBodyParam('login');
        $password = Yii::$app->request->getBodyParam('password');
        $device_id = Yii::$app->request->getBodyParam('device_id');

        if (isset($device_id) && $this->applicationService->login($username, $password)) {
            $usedDeviceToken = $this->tokenService->generateNewTokens($this->applicationService->user, $device_id);

            return $this->asJson([
                'access_token' => $usedDeviceToken->access_token,
                'access_token_expiration_time' => $usedDeviceToken->access_token_expiration_time,
                'refresh_token' => $usedDeviceToken->refresh_token,
                'refresh_token_expiration_time' => $usedDeviceToken->refresh_token_expiration_time
            ]);
        } else {
            return $this->asJson([
                'status' => 'authentication failed',
            ])->setStatusCode(401);
        }
    }
}