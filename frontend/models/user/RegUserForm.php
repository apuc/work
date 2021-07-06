<?php
/**
 * Created by PhpStorm.
 * User: Офис
 * Date: 04.05.2016
 * Time: 13:12
 */

namespace frontend\models\user;



use dektrium\user\models\RegistrationForm;
use dektrium\user\models\User;
use Yii;

class RegUserForm extends RegistrationForm
{

    public $reCaptcha;
    /**
     * @var string
     */
    public $status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['fieldRequired'] = ['status', 'required'];
        $rules['fieldLength']   = ['status', 'integer'];
        $rules['fieldRequired'] = ['reCaptcha', \himiklab\yii2\recaptcha\ReCaptchaValidator2::className(), 'uncheckedMessage' => 'Пожалуйста подтвердите что вы не робот.'];
        return $rules;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['status'] = \Yii::t('user', 'Статус');
        return $labels;
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }



        return true;
    }

}