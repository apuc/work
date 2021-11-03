<?php

namespace frontend\services;

use common\models\User;
use frontend\modules\request\models\UserDeviceToken;
use Yii;
use yii\base\Exception;

class TokenService
{
    /**
     * @throws Exception
     *
     * Вызывается при логине для регенерации токенов под девайс
     */
    public function generateNewTokens(User $user, string $device_id)
    {
        $token = UserDeviceToken::findOne(['user_id' => $user->id, 'device_id' => $device_id]);

        if(!isset($token)){
            $token = new UserDeviceToken();
            $token->user_id = $user->getId();
            $token->device_id = $device_id;
        }

        $token->access_token = Yii::$app->getSecurity()->generateRandomString();
        $token->access_token_expiration_time = time() + 86400; //плюс сутки
        $token->refresh_token = Yii::$app->getSecurity()->generateRandomString();
        $token->access_token_expiration_time = time() + 30 * 86400; //плюс месяц
        $token->save();
    }
}