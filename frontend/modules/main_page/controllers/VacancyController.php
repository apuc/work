<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Resume;
use common\models\Vacancy;
use yii\web\Controller;

class VacancyController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Vacancy::find()->where(['id'=>$id])->one();
        return $this->render('view', [
            'model' => $model
        ]);
    }
}
