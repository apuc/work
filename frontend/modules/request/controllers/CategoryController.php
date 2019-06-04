<?php

namespace frontend\modules\request\controllers;

use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class CategoryController extends MyActiveController
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
                    'query' => Category::find(),
                    'pagination' => [
                        'pageSizeLimit' =>-1,
                    ],
                    'sort' => []
                ]);
            }
        ];

        return $actions;
    }

    public $modelClass = 'common\models\Category';
}
