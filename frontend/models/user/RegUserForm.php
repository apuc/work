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