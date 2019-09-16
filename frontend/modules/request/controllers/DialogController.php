<?php

namespace frontend\modules\request\controllers;

use common\models\Dialog;
use common\models\DialogUser;
use common\models\Message;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class DialogController extends MyActiveController
{
    public $modelClass = 'common\models\Dialog';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function actionCreate(){
        if(Yii::$app->user->isGuest)
            throw new HttpException(400, 'Пользователь не авторизирован');
        $params = Yii::$app->getRequest()->getBodyParams();
        if($params['user_ids']){
            $dialog = new Dialog();
            $dialog->save();
            foreach ($params['user_ids'] as $id){
                if(User::findOne($id)){
                    $dialog_user = new DialogUser();
                    $dialog_user->user_id=$id;
                    $dialog_user->dialog_id=$dialog->id;
                    $dialog_user->save();
                }
            }
        }
        return true;
    }

    public function prepareDataProvider()
    {
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $query=Dialog::find()->joinWith(['users'])->where(['user.id'=>Yii::$app->user->id]);
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
}
