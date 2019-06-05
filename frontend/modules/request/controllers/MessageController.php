<?php

namespace frontend\modules\request\controllers;

use common\models\Message;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\HttpException;

class MessageController extends ActiveController
{
    public $modelClass = 'common\models\Message';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        return $behaviors;
    }

    public function prepareDataProvider()
    {
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => Message::find()->where(['sender_id' => Yii::$app->user->id])->orWhere(['receiver_id'=>Yii::$app->user->id]),
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }
    /**
     * @param string $action
     * @param Message $model
     * @param array $params
     * @throws HttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if($action != 'index'){
            if(Yii::$app->user->isGuest)
                throw new HttpException(403, 'Вы не авторизированы');
            if($model->receiver_id != Yii::$app->user->id && $model->sender_id != Yii::$app->user->id)
                throw new HttpException(403, 'Отказано в доступе');
        }
    }

}
