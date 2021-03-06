<?php

namespace frontend\modules\request\controllers;

use common\models\Update;
use common\models\UpdateUser;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class UpdateController extends ActiveController
{
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => function(){
                return Yii::createObject([
                    'class' => ActiveDataProvider::className(),
                    'query' => Update::find()->orderBy('id DESC'),
                    'pagination' => [],
                    'sort' => [],
                ]);
            }
        ];
        return $actions;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    public function actionReadAll() {
        $updates = Update::find()->column();
        foreach ($updates as $update) {
            $updateUser = new UpdateUser();
            $updateUser->user_id = Yii::$app->user->id;
            $updateUser->update_id = $update;
            $updateUser->save();
        }
        return true;
    }

    public $modelClass = 'common\models\Update';
}
