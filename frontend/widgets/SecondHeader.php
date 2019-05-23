<?php
namespace frontend\widgets;

use yii\base\Widget;

class SecondHeader extends Widget
{
    public function run(){
        return $this->render('second-header');
    }
}