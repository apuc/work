<?php

namespace frontend\modules\request\models;

use common\models\base\WorkActiveRecord;
use common\models\User;
use DateTimeInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $device_id unique
 * @property string $access_token unique | Токен доступа
 * @property int $access_token_expiration_time timestamp | Срок действительности токена доступа
 * @property string $refresh_token unique | Токен обновления для токена доступа
 * @property int $refresh_token_expiration_time timestamp | Срок действительности токена обновления
 *
 * @property User $user Владелец токена
 **/
class UserDeviceToken extends WorkActiveRecord
{

    //TODO
    public function rules(): array
    {
        return parent::rules();
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'user_device_token';
    }

    public function extraFields(): array
    {
        return ['user'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Пользователь',
            'device_id' => 'Идентификатор девайса',
            'access_token' => 'Токен доступа',
            'access_token_expiration_time' => 'Срок действительности токена доступа',
            'refresh_token' => 'Токен обновления для токена доступа',
            'refresh_token_expiration_time' => 'Срок действительности токена обновления'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'id']);
    }

    public static function findByAccessTokenAndDeviceId($access_token, $device_id)
    {
        return UserDeviceToken::findOne(['access_token' => $access_token, 'device_id' => $device_id]);
    }
}