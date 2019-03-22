<?php

namespace frontend\modules\main_page\controllers;

use yii\web\Controller;

class ResumeController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView()
    {
        return $this->render('index');
    }
}
