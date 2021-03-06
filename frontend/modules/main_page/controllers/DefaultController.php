<?php

namespace frontend\modules\main_page\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\Country;
use common\models\Employer;
use common\models\Professions;
use common\models\Region;
use common\models\Vacancy;
use Yii;
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
        $current_country = $country_slug?Country::find()->where(['slug'=>$country_slug])->one():null;
        if ($country_slug && !$current_country) {
            throw new NotFoundHttpException();
        }
        $this->layout = '@frontend/views/layouts/main-page-layout.php';

        $categories = Yii::$app->cache->getOrSet('main_page_categories', function () {
            return Category::find()->with(['vacancyCategories'])->select(['name', 'slug'])->limit(4)->all();
        });
        $professions = Yii::$app->cache->getOrSet('main_page_professions', function () {
            return Professions::find()->select(['title', 'slug'])->limit(4)->all();
        });
        if (!$current_country) {
            $cities = Yii::$app->cache->getOrSet('main_page_cities', function () {
                return City::find()->select(['id', 'name', 'slug'])->where(['status' => 1])->orderBy('priority ASC')->all();
            });
        } else {
            $cities = Yii::$app->cache->getOrSet("main_page_cities_$current_country->slug", function () use ($current_country) {
                return City::find()
                    ->select([
                        'id'=>City::tableName().'.id',
                        'name'=>City::tableName().'.name',
                        'slug'])
                    ->joinWith('region')
                    ->where([
                        City::tableName().'.status' => 1,
                        Region::tableName().'.country_id'=>$current_country->id
                    ])
                    ->orderBy('priority ASC')
                    ->all();
            });
        }
        $countries = Yii::$app->cache->getOrSet('main_page_countries', function () {
            return Country::find()->select(['id', 'name', 'slug'])->all();
        });
        $vacancies_day = Yii::$app->cache->getOrSet('main_page_vacancies_day', function () {
            return Vacancy::find()
                ->with(['employment_type', 'company', 'mainCategory', 'city0'])
                ->where(['status'=>Vacancy::STATUS_ACTIVE])
                ->andWhere(['>=', 'day_vacancy_until', time()])
                ->limit(10)
                ->orderBy('id DESC')
                ->all();
        },3600);
        $diff = 10 - count($vacancies_day);
        $vacancies = Yii::$app->cache->getOrSet('main_page_vacancies', function () use ($diff){
            return Vacancy::find()
                ->with(['employment_type', 'company', 'mainCategory', 'city0'])
                ->where(['status'=>Vacancy::STATUS_ACTIVE])
                ->andWhere(['<', 'day_vacancy_until', time()])
                ->limit($diff)
                ->orderBy('id DESC')
                ->all();
            }, 3600);
//        Debug::dd($vacancies);
        $vacancy_count = Yii::$app->cache->getOrSet('main_page_vacancy_count', function () {
            return Vacancy::find()->count();
        });
        $employer = \Yii::$app->user->isGuest?null:Employer::find()->select(['first_name', 'second_name'])->where(['user_id'=>\Yii::$app->user->id])->one();
        return $this->render('index', [
            'categories' => $categories,
            'professions' => $professions,
            'vacancies_day' => $vacancies_day,
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
        $country = Country::findOne(Yii::$app->request->post('country'));
        if(!$country) {
            Yii::$app->response->cookies->remove('country_id');
            Yii::$app->response->cookies->remove('country_slug');
        } else {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'country_id',
                'value' => $country->id
            ]));
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'country_slug',
                'value' => $country->slug
            ]));
        }
        return $country ? $country->slug : false;
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
        $country = Country::findOne(['slug'=>$country_slug]);
        $professions = Professions::find()
            ->filterWhere(['like', 'title', Yii::$app->request->get('search_text')])
            ->all();
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
