<?php

namespace frontend\modules\request\models;

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
 * @property DateTimeInterface $access_token_expiration_time Срок действительности токена доступа
 * @property string $refresh_token unique | Токен обновления для токена доступа
 * @property DateTimeInterface $refresh_token_expiration_time Срок действительности токена обновления
 *
 * @property User $user Владелец токена
 **/
class UserDeviceToken extends ActiveRecord
{

    //TODO
    public function rules()
    {
        $rules = parent::rules();

        return $rules;
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

    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'id']);
    }
}