<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
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

    public function actionSelectCity()
    {
        $value = \Yii::$app->request->post('city');
        \Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'city',
            'value' => $value
        ]));
        return $value;
    }

    public function actionCity()
    {
        $cities_dnr = City::find()->where(['status'=> City::TYPE_SHOWN, 'region_id'=>21])->all();
        $cities_lug = City::find()->where(['status'=> City::TYPE_SHOWN, 'region_id'=>19])->all();
        $this->layout = '@frontend/views/layouts/main-layout.php';
        return $this->render('cities', [
            'cities_dnr' => $cities_dnr,
            'cities_lug' => $cities_lug
        ]);
    }
}
