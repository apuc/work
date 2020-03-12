<?php

namespace frontend\modules\request\controllers;

use common\models\Action;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\rest\Controller;

class ActionController extends Controller
{
    public function actions()
    {
        return [];
    }

    public function actionIndex() {
        $action = Action::find()
            ->where([
                'type' => Yii::$app->request->get('type'),
                'subject' => Yii::$app->request->get('subject'),
                'subject_id' => Yii::$app->request->get('subject_id')
            ])
            ->one();
        if($action)
            return $action->count;
        else
            return null;
    }

    public $modelClass = 'common\models\Action';
}
