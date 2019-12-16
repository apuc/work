<?php


namespace common\classes;


use Yii;

class MoneyFormat
{
    public static function getFormattedAmount($number){
        $number = (int)$number;
        $number = (string)$number;
        for ($i=strlen($number)-3; $i>0; $i-=3) {
            $number = substr($number, 0, $i).' '.substr($number, $i, strlen($number));
        }
        return $number;
    }
}