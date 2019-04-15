<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 25.03.2019
 * Time: 14:23
 */

namespace frontend\modules\request\controllers;


use common\models\Employer;
use common\models\Resume;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\HttpException;

class MyActiveController extends ActiveController
{
    /**
     * Метод, описывающий логику запроса, для получения сущностей, принадлежащих текущему пользователю
     */
    public function myQuery(){
        return $this->modelClass::find();
    }

    /**
     * Запрос, показывающий сущности, принадлежащие пользователю
     * @return object
     * @throws HttpException
     * @throws InvalidConfigException
     */
    public function actionMyIndex(){
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $this->myQuery(),
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }

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