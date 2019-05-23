<?php
namespace frontend\widgets;

use yii\base\Widget;

class PersonalAreaHeader extends Widget
{
    public function run(){
        return $this->render('personal-area-header');
    }
}