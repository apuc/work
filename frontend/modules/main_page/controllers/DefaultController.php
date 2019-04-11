<?php

namespace frontend\modules\main_page\controllers;

use common\models\Category;
use common\models\Vacancy;
use dektrium\user\models\LoginForm;
use yii\web\Controller;

/**
 * Default controller for the `main_page` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-page-layout.php';

    public function actionIndex()
    {
        $categories = Category::find()->all();
        $vacancies = Vacancy::find()->limit(10)->orderBy('id DESC')->all();
        return $this->render('index', [
            'model' => $model,
            'categories' => $categories,
            'vacancies' => $vacancies
        ]);
    }
}
