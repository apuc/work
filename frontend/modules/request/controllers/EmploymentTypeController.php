<?php

namespace frontend\modules\request\controllers;

use common\models\EmploymentType;
use yii\data\ActiveDataProvider;

class EmploymentTypeController extends MyActiveController
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
                    'query' => EmploymentType::find(),
                    'pagination' => [
                        'pageSize' =>-1,
                    ],
                    'sort' => []
                ]);
            }
        ];

        return $actions;
    }
    public $modelClass = 'common\models\EmploymentType';
}
