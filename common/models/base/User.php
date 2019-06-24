<?php


namespace common\models\base;



class User extends \dektrium\user\models\User
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

}