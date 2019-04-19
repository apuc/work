<?php

namespace frontend\modules\personal_area\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if(!\Yii::$app->user->isGuest)
            return $this->renderFile('@frontend/web/vue/dist/index.html');
        return $this->redirect('/');
    }
}
