<?php

namespace frontend\modules\request\controllers;

use common\models\Skill;
use yii\data\ActiveDataProvider;

class SkillController extends MyActiveController
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
                    'query' => Skill::find(),
                    'pagination' => [
                        'pageSizeLimit' =>-1,
                    ],
                    'sort' => []
                ]);
            }
        ];

        return $actions;
    }
    public $modelClass = 'common\models\Skill';
}
