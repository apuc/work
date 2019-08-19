<?php

namespace frontend\modules\request\controllers;

use common\classes\Debug;
use common\models\Message;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\HttpException;

class MessageController extends MyActiveController
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
        $query=Message::find();
        if(isset($requestParams['type'])){
            if($requestParams['type']==='incoming'){
                $query->andWhere(['receiver_id'=>Yii::$app->user->id, 'deleted_by_receiver'=>0]);
            } else if($requestParams['type']==='outgoing'){
                $query->andWhere(['sender_id'=>Yii::$app->user->id, 'deleted_by_sender'=>0]);
            }
        }
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
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

    public function actionReadAllMessages(){
        if(!Yii::$app->request->isPost)
            throw new HttpException(404, 'Not found');
        if(Yii::$app->user->isGuest)
            throw new HttpException(403, 'Вы не авторизированы');
        $messages=Message::find()->where(['receiver_id'=>Yii::$app->user->id])->all();
        foreach ($messages as $message){
            $message->is_read=1;
            $message->save();
        }
        return 1;
    }
}
