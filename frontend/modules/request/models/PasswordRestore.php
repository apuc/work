<?php

namespace frontend\modules\request\models;

use common\models\base\WorkActiveRecord;
use Yii;
use yii\base\Model;
use yii\behaviors\SluggableBehavior;

/**
 * @property string $old_password
 * @property string $new_password_1
 * @property string $new_password_2
 */
class PasswordRestore extends Model
{
    public $old_password;
    public $new_password_1;
    public $new_password_2;

    public function attributes()
    {
        return ['old_password','new_password_1','new_password_2'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['old_password', 'new_password_1', 'new_password_2'], 'string', 'max' => 25, 'message' => 'Пароль не может быть длиннее 25 символов'],
            [['old_password', 'new_password_1', 'new_password_2'], 'string', 'min' => 6, 'message' => 'Пароль не может быть короче 6 символоыв'],
            [['old_password', 'new_password_1', 'new_password_2'], 'required', 'message' => 'Не все поля заполнены'],
            ['new_password_2', 'compare', 'compareAttribute' => 'new_password_1', 'message' => 'Пароли не совпадают'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'old_password' => 'Старый пароль',
            'new_password_1' => 'Новый пароль',
            'new_password_2' => 'Новый пароль',
        ];
    }
}
