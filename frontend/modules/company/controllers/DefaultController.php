<?php

namespace frontend\modules\company\controllers;

use common\models\Company;
use common\models\Views;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Company::findOne($id);
        if(!$model)
            throw new NotFoundHttpException();
        $view = new Views();
        $view->subject_type = 'Company';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
        return $this->render('view', [
            'model' => $model
        ]);
    }
}
