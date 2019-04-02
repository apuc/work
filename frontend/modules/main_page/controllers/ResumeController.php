<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Resume;
use yii\web\Controller;

class ResumeController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Resume::find()->where(['id'=>$id])->one();
        //Debug::dd($model);
        return $this->render('view', [
            'model' => $model
        ]);
    }
}
