<?php

namespace frontend\modules\company\controllers;

use yii\web\Controller;


class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView()
    {
        return $this->render('view');
    }
}
