<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password1;
    public $password2;
    public $code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password1', 'password2', 'code'],'required', 'message' => 'Необходимо заполнить поле'],
            [['password1', 'password2', 'code'], 'string', 'min' => 6, 'message' => 'Поле не может содержать менее 6 символов'],
            ['password2', 'compare', 'compareAttribute' => 'password1', 'message' => 'Пароли не совпадают'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password1' => 'пароль',
            'password2' => 'пароль',
        ];
    }
}
