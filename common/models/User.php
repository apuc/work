<?php
namespace common\models;

use yii\web\IdentityInterface;

class User extends \dektrium\user\models\User implements IdentityInterface
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public function fields()
    {
        return ['id', 'email'];
    }

    public function extraFields()
    {
        return ['employer'];
    }

    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['user_id'=>'id']);
    }
}
