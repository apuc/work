<?php
namespace frontend\widgets;

use dektrium\user\models\LoginForm;
use dektrium\user\models\RegistrationForm;
use yii\base\Widget;

class Modals extends Widget
{
    public function run(){
        $login_form = \Yii::createObject(LoginForm::className());
        $registration_form = \Yii::createObject(RegistrationForm::className());
        return $this->render('modals', [
            'login_form' => $login_form,
            'registration_form' => $registration_form
        ]);
    }
}