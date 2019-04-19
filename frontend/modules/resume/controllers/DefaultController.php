<?php

namespace frontend\modules\resume\controllers;

use common\models\Resume;
use yii\web\Controller;

/**
 * Default controller for the `resume` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Resume::find()->where(['id'=>$id])->one();
        return $this->render('view', [
            'model' => $model
        ]);
    }
}
