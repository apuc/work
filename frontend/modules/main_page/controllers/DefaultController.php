<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\Country;
use common\models\Employer;
use common\models\Professions;
use common\models\Vacancy;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `main_page` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionIndex($country_slug=false)
    {
        if($country = Country::findOne(Yii::$app->request->cookies['country'])) {
            if($country->slug !== $country_slug)
                return $this->redirect('/'.$country->slug);
        }
        else if ($country_slug!==false)
            return $this->redirect('/');
        $current_country = $country_slug?Country::find()->where(['slug'=>$country_slug])->one():null;
        if($country_slug && !$current_country)
            throw new NotFoundHttpException();
        $this->layout = '@frontend/views/layouts/main-page-layout.php';
        if (!$categories = Yii::$app->cache->get("main_page_categories")) {
            $categories = Category::find()->with(['vacancyCategories'])->select(['name', 'slug'])->limit(4)->all();
            Yii::$app->cache->set("main_page_categories", $categories, 3600);
        }
        if (!$professions = Yii::$app->cache->get("main_page_professions")) {
            $professions = Professions::find()->select(['title', 'slug'])->limit(4)->all();
            Yii::$app->cache->set("main_page_professions", $professions, 3600);
        }
        if (!$cities = Yii::$app->cache->get("main_page_cities")) {
            $cities = City::find()->select(['id', 'name', 'slug'])->where(['status' => 1])->orderBy('priority ASC')->all();
            Yii::$app->cache->set("main_page_cities", $cities, 3600);
        }
        if (!$countries = Yii::$app->cache->get("main_page_countries")) {
            $countries = Country::find()->select(['id', 'name'])->all();
            Yii::$app->cache->set("main_page_cities", $cities, 3600);
        }
        if (!$vacancies = Yii::$app->cache->get("main_page_vacancies")) {
            $vacancies = Vacancy::find()->with(['employment_type', 'category', 'company', 'mainCategory', 'city0', 'views0'])->where(['status'=>Vacancy::STATUS_ACTIVE])->limit(10)->orderBy('id DESC')->all();
            Yii::$app->cache->set("main_page_vacancies", $vacancies, 3600);
        }
        if (!$vacancy_count = Yii::$app->cache->get("main_page_vacancy_count")) {
            $vacancy_count = Vacancy::find()->count();
            Yii::$app->cache->set("main_page_vacancy_count", $vacancy_count, 3600);
        }
        $employer = \Yii::$app->user->isGuest?null:Employer::find()->select(['first_name', 'second_name'])->where(['user_id'=>\Yii::$app->user->id])->one();
        return $this->render('index', [
            'categories' => $categories,
            'professions' => $professions,
            'vacancies' => $vacancies,
            'employer' => $employer,
            'cities' => $cities,
            'countries' => $countries,
            'vacancy_count' => $vacancy_count,
            'current_country' => $current_country
        ]);
    }

    public function actionSelectCountry()
    {
        $value = \Yii::$app->request->post('country');
        \Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'country',
            'value' => $value
        ]));
        return $value;
    }

    public function actionCity()
    {
        $cities_dnr = City::find()->where(['status'=> City::TYPE_SHOWN, 'region_id'=>21])->all();
        $cities_lug = City::find()->where(['status'=> City::TYPE_SHOWN, 'region_id'=>19])->all();
        return $this->render('cities', [
            'cities_dnr' => $cities_dnr,
            'cities_lug' => $cities_lug
        ]);
    }

    public function actionProfessions($country_slug = null)
    {
        $professions = Professions::find();
        $country = Country::findOne(['slug'=>$country_slug]);
        if($search_text = Yii::$app->request->get('search_text'))
            $professions->where(['like', 'title', $search_text]);
        $professions = $professions->all();
        return $this->render('professions', [
            'professions' => $professions,
            'country' => $country
        ]);
    }

    public function actionHelp()
    {
        return $this->render('help');
    }
}
