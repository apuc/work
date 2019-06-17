<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 12.06.19
 * Time: 12:28
 */

namespace frontend\modules\msg\controllers;

use frontend\modules\msg\actions\CGApiAction;
use frontend\modules\msg\components\CGMessages;

class ApiController extends \yii\web\Controller
{
    public function init()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actions()
    {
        return [
            'p-m' => [
                'class' => CGApiAction::className()
            ]
        ];
    }

    public function actionAllUsers()
    {
        $result = CGMessages::getCurrentUsers(\Yii::$app->user->id);

        return $result;
    }


}