<?php

namespace frontend\modules\request\controllers;

use common\classes\Debug;
use common\models\Dialog;
use common\models\DialogMessage;
use common\models\DialogUser;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class DialogMessageController extends MyActiveController
{
    public $modelClass = 'common\models\DialogMessage';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['create'], $actions['delete'], $actions['update']);
        return $actions;
    }

    public function actionSendMessage(){
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $params = Yii::$app->request->post();
        if(isset($params['user_id'])){
            if(User::findOne($params['user_id'])){
                $check = DialogUser::find()->select(['dialog_id'])->where(['user_id'=>[$params['user_id'], Yii::$app->user->id]])->having(['count(user_id)'=>2])->groupBy(['dialog_id'])->one();
                $message = new DialogMessage();
                if($check){
                    $message->dialog_id=$check->dialog_id;
                } else {
                    $dialog = new Dialog();
                    $dialog->save();
                    $message->dialog_id=$dialog->id;
                }
                $message->text=$params['text'];
                $message->save();
            }
        } else if (isset($params['dialog_id'])) {
            if(Dialog::findOne($params['dialog_id'])){
                $message = new DialogMessage();
                $message->text=$params['text'];
                $message->dialog_id=$params['dialog_id'];
                $message->save();
            }
            else throw new HttpException(201, 'Такого диалога не существует');
        }
    }

    public function prepareDataProvider()
    {
        if(Yii::$app->user->isGuest)
            throw new HttpException(201, 'Пользователь не авторизирован');
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $query=DialogMessage::find()->joinWith(['dialog.users'])->where(['user.id'=>Yii::$app->user->id, DialogMessage::tableName().'.status'=>1]);
        if(isset($requestParams['dialog_id']))
            $query->andFilterWhere([DialogMessage::tableName().'.dialog_id'=>$requestParams['dialog_id']]);
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
