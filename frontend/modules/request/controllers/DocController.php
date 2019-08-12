<?php


namespace frontend\modules\request\controllers;


use yii\web\Controller;

class DocController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}