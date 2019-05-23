<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\Vacancy;
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
            'categories' => $categories,
            'vacancies' => $vacancies
        ]);
    }

    public function actionSearch()
    {
        //Debug::dd(\Yii::$app->request->post());
        if(\Yii::$app->request->post('search_type') === 'vacancy'){
            return $this->redirect('/vacancy/search?search_text='.\Yii::$app->request->post('search_text'));
        }
        else if(\Yii::$app->request->post('search_type') === 'resume'){
            return $this->redirect('/resume/search?search_text='.\Yii::$app->request->post('search_text'));
        }
        else{
            return $this->redirect ('/');
        }
    }
}
