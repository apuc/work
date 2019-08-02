<?php
namespace console\controllers;

use common\models\City;
use yii\console\Controller;

class StatusCityController extends Controller
{
    public function actionIndex()
    {
        $cities = City::find()->all();
        foreach ($cities as $city) {
            $city->status = 0;
            $city->save();
        }
    }
}