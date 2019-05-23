<?php
namespace frontend\widgets;

use yii\base\Widget;

class PersonalAreaFooter extends Widget
{
    public function run(){
        return $this->render('personal-area-footer');
    }
}