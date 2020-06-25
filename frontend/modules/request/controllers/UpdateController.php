<?php

namespace frontend\modules\request\controllers;

use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class UpdateController extends MyActiveController
{
    public $modelClass = 'common\models\Update';


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->query = $this->modelClass::find()->orderBy('id DESC');
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
}
