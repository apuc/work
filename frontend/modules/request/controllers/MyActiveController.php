<?php

namespace frontend\modules\request\controllers;


use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\HttpException;

class MyActiveController extends ActiveController
{
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
            'query' => $this->modelClass::find()->where(['owner'=>Yii::$app->user->id]),
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }

    /**
     * Запрос, проверяющий, принадлежит ли сущность текущему пользователю
     */
    public function actionCheckIsMine(){
        if(Yii::$app->user->isGuest)
            return false;
        $id=Yii::$app->request->get('id');
        if(!$model = $this->modelClass::findOne($id)){
            return false;
        }
        if(!$model->hasAttribute('owner'))
            return false;
        if($model->owner == Yii::$app->user->id)
            return true;
        else return false;


    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] =  [
            'class' => Cors::className(),
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

    /**
     * @param string $action
     * @param ActiveRecord $model
     * @param array $params
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if($action === 'update' || $action === 'delete'){
            if(Yii::$app->user->isGuest)
                throw new HttpException(403, 'Вы не авторизированы');
            if(!$model->hasAttribute('owner'))
                throw new HttpException(403, 'У вас нет прав для редактирования этой записи');
            if($model->owner != Yii::$app->user->id)
                throw new HttpException(403, 'У вас нет прав для редактирования этой записи');
        }
    }
}