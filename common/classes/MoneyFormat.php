<?php


namespace common\classes;


use Yii;

class MoneyFormat
{
    public static function getFormattedAmount($number){
        $str = Yii::$app->formatter->asCurrency($number);
        $result = substr($str, 0, strlen($str)-3);
        $result = substr($result, 4, strlen($result));
        return $result;
    }
}