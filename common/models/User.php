<?php
namespace common\models;

use yii\web\IdentityInterface;

class User extends \dektrium\user\models\User implements IdentityInterface
{
    public $loginUrl = '/';

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
        return ['employer', 'unreadMessages'];
    }

    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['user_id'=>'id']);
    }

    public function getUnreadMessages()
    {
        return Message::find()->where(['receiver_id'=>$this->id, 'deleted_by_receiver'=>0, 'is_read'=>0])->count();
    }
}
