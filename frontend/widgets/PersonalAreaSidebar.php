<?php
namespace frontend\widgets;

use yii\base\Widget;

class PersonalAreaSidebar extends Widget
{
    public function run(){
        return $this->render('personal-area-sidebar');
    }
}