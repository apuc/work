<?php
namespace common\helpers;

class StringHelper extends \yii\helpers\StringHelper
{

    public static function mb_ucfirst($str, $encoding = null)
    {
        return mb_strtoupper(mb_substr($str, 0, 1)).mb_substr($str, 1);
    }

}