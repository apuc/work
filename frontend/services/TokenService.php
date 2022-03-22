<?php

namespace frontend\services;

use common\models\User;
use frontend\modules\request\models\UserDeviceToken;
use Yii;
use yii\base\Exception;

class TokenService
{
    const ACCESS_TOKEN_EXPIRE_TIME = 86400; // день
    const REFRESH_TOKEN_EXPIRE_TIME = 2592000; // 30 дней
    const ACCESS_TOKEN_LENGTH = 1024; // в символах
    const REFRESH_TOKEN_LENGTH = 256; // в символах


    /**
     * @param User $user
     * @param string $device_id
     * @throws Exception
     */
    public function generateNewTokens(User $user, string $device_id): UserDeviceToken
    {
        $token = UserDeviceToken::findOne(['user_id' => $user->id, 'device_id' => $device_id]);

        if (!isset($token)) {
            $token = new UserDeviceToken();
            $token->user_id = $user->getId();
            $token->device_id = $device_id;
        }
        $this->generateAccessToken($token);
        $this->generateRefreshToken($token);
        $token->save();

        return $token;
    }

    /**
     * @param User $user
     * @param string $device_id
     * @param string $refresh_token
     * @return false|UserDeviceToken|null
     * @throws Exception
     */
    public function regenerateAccessToken(User $user, string $device_id, string $refresh_token)
    {
        $token = UserDeviceToken::findOne(['user_id' => $user->id, 'device_id' => $device_id]);

        if (!isset($token)) {
            if ($refresh_token === $token->refresh_token) {
                $this->generateAccessToken($token);
                $token->save();

                return $token;
            }

            return false; //todo log: "trying to get access token with wrong refresh token"
        }

        return false; //todo log?
    }

    /**
     * @param UserDeviceToken $token
     * @throws Exception
     */
    private function generateAccessToken(UserDeviceToken $token)
    {
        $token->access_token = Yii::$app->getSecurity()->generateRandomString(self::ACCESS_TOKEN_LENGTH);
        $token->access_token_expiration_time = time() + self::ACCESS_TOKEN_EXPIRE_TIME;
    }

    /**
     * @param UserDeviceToken $token
     * @throws Exception
     */
    private function generateRefreshToken(UserDeviceToken $token)
    {
        $token->refresh_token = Yii::$app->getSecurity()->generateRandomString(self::REFRESH_TOKEN_LENGTH);
        $token->refresh_token_expiration_time = time() + self::REFRESH_TOKEN_EXPIRE_TIME;
    }
}