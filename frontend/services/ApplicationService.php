<?php

namespace frontend\services;

use common\models\User;
use dektrium\user\helpers\Password;
use Yii;

class ApplicationService
{
    /** @var User */
    public $user;

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
        $this->user = User::find()->where(['username' => $username])->one();

        if(isset($this->user) && Password::validate($password, $this->user->password_hash)){
            Yii::$app->user->login($this->user);
            return true;
        }

        return false;
    }
}