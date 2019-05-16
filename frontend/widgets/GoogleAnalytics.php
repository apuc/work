<?php
namespace frontend\widgets;

use dektrium\user\models\LoginForm;
use dektrium\user\models\RegistrationForm;
use yii\base\Widget;

class GoogleAnalytics extends Widget
{
    public function run()
    {
        return $this->render('google_analytics');
    }
}