<?php


namespace frontend\controllers;


use common\models\Test;
use yii\web\Controller;

class PaymentController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionSuccess() {
        $test = new Test();
        $test->text = json_encode(\Yii::$app->request->post());
        $test->save();
    }

    public function actionFail() {
        $test = new Test();
        $test->text = json_encode(\Yii::$app->request->post());
        $test->save();
    }
    public function actionNotificate() {
        $test = new Test();
        $test->text = json_encode(\Yii::$app->request->post());
        $test->save();
    }
}