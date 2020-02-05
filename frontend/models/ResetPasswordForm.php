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
            [['password1', 'password2', 'code'],'required'],
            [['password1', 'password2', 'code'], 'string', 'min' => 6],
            ['password1', 'compare', 'compareAttribute' => 'password2'],
        ];
    }
}
