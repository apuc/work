<?php

namespace frontend\modules\vacancy\controllers;

use common\classes\BannerService;
use common\classes\Debug;
use common\models\Action;
use common\models\Banner;
use common\models\BannerLocation;
use common\models\Category;
use common\models\City;
use common\models\Country;
use common\models\EmploymentType;
use common\models\Message;
use common\models\Professions;
use common\models\Region;
use common\models\Resume;
use common\models\Skill;
use common\models\User;
use common\models\Vacancy;
use common\models\Views;
use common\repositories\ViewRepository;
use frontend\modules\vacancy\classes\VacancySearch;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public $background_image;
    public $background_emblem;

    public function actionView($id)
    {
        /** @var Vacancy $model */
        $model = Vacancy::find()->where(['id'=>$id, 'status'=>Vacancy::STATUS_ACTIVE])->with('mainCategory')->one();
        if(!$model) {
            $model = Vacancy::find()->where(['id'=>$id, 'status'=>Vacancy::STATUS_INACTIVE])->one();
            if($model) {
                Yii::$app->response->setStatusCode(410);
                throw new HttpException(410, 'Вакансия удалена');
            } else
                throw new NotFoundHttpException();
        }
        $last_vacancies = Vacancy::find()
            ->select(['id', 'main_category_id', 'company_id', 'post', 'responsibilities'])
            ->where([
                'status' => Vacancy::STATUS_ACTIVE,
                'main_category_id' => $model->main_category_id
            ])
            ->andWhere(['!=', Vacancy::tableName().'.id', $model->id])
            ->andFilterWhere(['city_id'=>$model->city_id])
            ->orderBy('update_time DESC')
            ->with(['mainCategory', 'company'])
            ->limit(2)
            ->all();
        $referer_category = false;
        if(Yii::$app->request->get('referer_category'))
            $referer_category = Category::findOne(Yii::$app->request->get('referer_category'));
        ViewRepository::addView($model);
        return $this->render('view', [
            'model' => $model,
            'last_vacancies' => $last_vacancies,
            'referer_category' => $referer_category
        ]);
    }

    public function actionSearch()
    {
        $searchModel = new VacancySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        if($searchModel->current_city)
            $this->background_image = $searchModel->current_city->image;
        if($searchModel->current_category)
            $this->background_emblem = $searchModel->current_category->image;

        $canonical_rel = Yii::$app->request->hostInfo.'/vacancy'.($searchModel->first_query_param?('/'.$searchModel->first_query_param):'').($searchModel->second_query_param?('/'.$searchModel->second_query_param):'');

        $categories = Yii::$app->cache->getOrSet('search_page_categories', function () {
            return Category::find()->select(['id', 'name', 'slug'])->all();
        });

        $employment_types = Yii::$app->cache->getOrSet('search_page_employment_types', function () {
            return EmploymentType::find()->all();
        });

        $countries = Yii::$app->cache->getOrSet('search_page_countries', function () {
            return Country::find()->select(['id', 'name', 'slug'])->all();
        });

        $cities = null;
        if($searchModel->current_country) {
            $cities = Yii::$app->cache->getOrSet("search_page_cities_".$searchModel->current_country->name, function () use ($searchModel) {
                return City::find()->joinWith('region')->where([City::tableName().'.status' => 1, Region::tableName().'.country_id' => $searchModel->current_country->id])->orderBy('priority ASC')->all();
            });
        }

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cities' => $cities,
            'categories' => $categories,
            'employment_types' => $employment_types,
            'countries' => $countries,
            'canonical_rel' => $canonical_rel
        ]);
    }

    public function actionSendMessage()
    {
        $post = Yii::$app->request->post();
        $resume = Resume::findOne($post['vacancy_resume_id']);
        $vacancy = Vacancy::findOne($post['vacancy_vacancy_id']);
        if ($resume && $vacancy) {
            $message = new Message();
            $message->text = $post['vacancy_message'];
            $message->sender_id = Yii::$app->user->id;
            $message->subject = 'Vacancy';
            $message->subject_id = $vacancy->id;
            $message->receiver_id = $vacancy->owner;
            $message->subject_from = 'Resume';
            $message->subject_from_id = $post['vacancy_resume_id'];
            $message->save();
            Yii::$app->mailer->compose('vacancy_like',
                ['resume' => $resume, 'vacancy' => $vacancy, 'text' => $message->text])
                ->setFrom('noreply@rabota.today')
                ->setTo(User::findOne($vacancy->owner)->email)
                ->setSubject('Ответ на вашу вакансию ' . $vacancy->post . '.')
                ->send();
        }
        $url = explode('?', Yii::$app->request->referrer)[0];
        $url .= '?message=Ваше сообщение успешно отправлено';
        return $this->redirect($url);
    }

    public function actionClickPhone() {
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if(!$id = Yii::$app->request->post('id')) {
                throw new HttpException(404, 'Not Found');
            } else if (Vacancy::findOne(intval($id))){
                if($action = Action::find()->where(['type'=>'click_phone', 'subject'=>'vacancy', 'subject_id'=>$id])->one()) {
                    $action->count++;
                    $action->save();
                } else {
                    $action = new Action();
                    $action->type = 'click_phone';
                    $action->subject = 'vacancy';
                    $action->subject_id = $id;
                    $action->count = 1;
                    $action->save();
                }
            } else {
                throw new HttpException(404, 'Not Found');
            }
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function actionCities(){
        $country_slug = Yii::$app->request->get('slug');
        $country = Country::find()->where(['slug'=>$country_slug])->one();
        if($country)
            $cities = City::find()
                ->select([City::tableName().'.id', City::tableName().'.slug', City::tableName().'.name', 'region_id'])
                ->joinWith('region')
                ->where([City::tableName().'.status' => 1, Region::tableName().'.country_id' => $country->id])
                ->orderBy('priority ASC')
                ->all();
        else
            return false;
        return $this->renderAjax('city_select', [
            'cities' => $cities
        ]);
    }
}
