<?php

namespace common\repositories;

use common\models\Views;
use Yii;
use yii\db\ActiveRecord;

class ViewRepository extends Repository
{
    public static function addView(ActiveRecord $model) {
        $className = substr(strrchr($model::className(), "\\"), 1);
        $view = new Views();
        $view->subject_type = $className;
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
    }
}