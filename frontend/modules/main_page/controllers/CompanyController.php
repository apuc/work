<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\Employer;
use common\models\Vacancy;
use yii\helpers\Url;
use yii\web\Controller;

class CompanyController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';
    public function actionIndex()
    {
        return $this->render('index');
    }
}
