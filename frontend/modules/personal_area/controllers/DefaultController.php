<?php

namespace frontend\modules\personal_area\controllers;

use common\classes\Debug;
use common\models\Company;
use common\models\Message;
use common\models\Resume;
use common\models\Vacancy;
use yii\web\Controller;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if(!\Yii::$app->user->isGuest)
            return $this->renderFile('@frontend/web/vue/dist/index.html');
        return $this->redirect('/?tab=login');
    }
}
