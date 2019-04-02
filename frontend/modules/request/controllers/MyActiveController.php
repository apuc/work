<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 25.03.2019
 * Time: 14:23
 */

namespace frontend\modules\request\controllers;


use yii\rest\ActiveController;

class MyActiveController extends ActiveController
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] =  [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                // restrict access to domains:
                'Origin'                           => ['*'],
                'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Request-Headers' => ['Origin', 'Content-Type', 'Accept', 'Authorization'],
                'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                'Access-Control-Allow-Origin' => ['*']
            ],
        ];
        return $behaviors;
    }
}