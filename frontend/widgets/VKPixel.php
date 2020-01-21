<?php
namespace frontend\widgets;

use yii\base\Widget;

class VKPixel extends Widget
{
    public function run()
    {
        return $this->render('vk_pixel');
    }
}