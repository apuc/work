<?php


namespace frontend\controllers;


use yii\web\Controller;

class PaymentController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionSuccess() {
        echo 123;
    }
}