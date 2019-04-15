<?php

namespace frontend\modules\request\controllers;


use common\models\Company;
use Yii;

class CompanyController extends MyActiveController
{
    public $modelClass = 'common\models\Company';

    /**
     * @return void|\yii\db\ActiveQuery
     */
    public function myQuery(){
        return Company::find()->where(['user_id' => Yii::$app->user->id]);
    }
}
