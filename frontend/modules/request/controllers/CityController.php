<?php

namespace frontend\modules\request\controllers;

use common\models\Category;
use common\models\City;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class CityController extends MyActiveController
{
    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => function(){
                return new ActiveDataProvider([
                    'query' => City::find()->where(['status'=>City::TYPE_SHOWN]),
                    'pagination' => [
                        'pageSize' =>-1,
                    ],
                    'sort' => []
                ]);
            }
        ];

        return $actions;
    }

    public $modelClass = 'common\models\City';
}
