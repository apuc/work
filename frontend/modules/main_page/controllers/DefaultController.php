<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\Employer;
use common\models\Vacancy;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `main_page` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-page-layout.php';

    public function actionIndex()
    {
        $categories = Category::find()->limit(18)->all();
        $vacancies = Vacancy::find()->with(['employment_type', 'category', 'company'])->where(['status'=>Vacancy::STATUS_ACTIVE])->limit(10)->orderBy('id DESC')->all();
        $employer = \Yii::$app->user->isGuest?null:Employer::find()->where(['user_id'=>\Yii::$app->user->id])->one();
        return $this->render('index', [
            'categories' => $categories,
            'vacancies' => $vacancies,
            'employer' => $employer
        ]);
    }

    public function actionSearch()
    {
        if(\Yii::$app->request->post('search_type') === 'vacancy'){
            $url = '/vacancy/search';
            if(\Yii::$app->request->post('search_text'))
                $url .= '/' . \Yii::$app->request->post('search_text');
            return $this->redirect($url);
        }
        else if(\Yii::$app->request->post('search_type') === 'resume'){
            $url = '/resume/search';
            if(\Yii::$app->request->post('search_text'))
                $url .= '/' . \Yii::$app->request->post('search_text');
            return $this->redirect($url);
        }
        else{
            return $this->redirect ('/');
        }
    }
}
