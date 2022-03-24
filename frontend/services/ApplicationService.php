<?php

namespace frontend\services;

use common\models\User;
use dektrium\user\helpers\Password;
use frontend\modules\request\models\UserDeviceToken;
use Yii;
use yii\db\ActiveQuery;

/**
 * Сервис отвечает за базовые действия в приложении, аутентификацию
 *
 * @author Alex Korona
 */
class ApplicationService
{
    /** @var User */
    public $user = null;

    /**
     * Логинит юзера, возвращает true при успехе, false при неудаче.
     * Сохраняет в себя user, даже если он null.
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($username, $password): bool
    {
        $this->user = User::findOne(['username' => $username]);

        if(
            isset($this->user) &&
            Password::validate($password, $this->user->password_hash)
        ){
            Yii::$app->user->login($this->user);
            return true;
        }

        return false;
    }

    /**
     * @param $access_token
     * @return User|ActiveQuery|null
     */
    public function loginByAccessToken($access_token)
    {
        $token = UserDeviceToken::findOne($access_token);
        if($token){
            $this->user = $token->getUser();
            Yii::$app->user->login($this->user);
        }

        return $this->user;
    }
}