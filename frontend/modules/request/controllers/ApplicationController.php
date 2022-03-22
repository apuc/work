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
            'refresh-token' => ['POST']
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
            $userDeviceToken = $this->tokenService->generateNewTokens($this->applicationService->user, $device_id);

            return $this->asJson([
                'access_token' => $userDeviceToken->access_token,
                'access_token_expiration_time' => $userDeviceToken->access_token_expiration_time,
                'refresh_token' => $userDeviceToken->refresh_token,
                'refresh_token_expiration_time' => $userDeviceToken->refresh_token_expiration_time
            ]);
        } else {
            return $this->asJson([
                'status' => 'authentication failed',
            ])->setStatusCode(401);
        }
    }

    public function actionRefreshToken(){
        $username = Yii::$app->request->getBodyParam('username');
        $refreshToken = Yii::$app->request->getBodyParam('refresh_token');
        $device_id = Yii::$app->request->getBodyParam('device_id');

        if($token = $this->tokenService->regenerateAccessToken($username, $device_id, $refreshToken)){
            return $this->asJson([
                'access_token' => $token->access_token,
                'access_token_expiration_time' => $token->access_token_expiration_time,
            ]);
        } else {
            return $this->asJson([
                'message' => implode('.', $this->tokenService->errors)
            ])->setStatusCode(401);
        }
    }
}