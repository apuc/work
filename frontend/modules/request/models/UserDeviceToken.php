<?php

namespace frontend\modules\request\models;

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
 **/
class UserDeviceToken extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_device_token';
    }
}