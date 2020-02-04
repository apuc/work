<?php

namespace frontend\modules\vacancy\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\EmploymentType;
use common\models\Message;
use common\models\Resume;
use common\models\Skill;
use common\models\User;
use common\models\Vacancy;
use common\models\Views;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public $background_image;
    public $background_emblem;

    public function actionView($id)
    {
        /** @var Vacancy $model */
        $model = Vacancy::find()->where(['id'=>$id, 'status'=>Vacancy::STATUS_ACTIVE])->one();
        if(!$model)
            throw new HttpException(404, 'Not found');
        $last_vacancies = Vacancy::find()->where(['status' => Vacancy::STATUS_ACTIVE])->andWhere(['!=', Vacancy::tableName().'.id', $model->id])->orderBy('update_time DESC')->limit(2);
        if($model->category){
            $last_vacancies->joinWith('category')->andWhere(['category.id'=>ArrayHelper::getColumn($model->category, 'id')]);
        }
        if($model->city_id){
            $last_vacancies->andWhere(['city_id'=>$model->city_id]);
        }
        $last_vacancies = $last_vacancies->all();
        $referer_category = false;
        if(Yii::$app->request->get('referer_category'))
            $referer_category = Category::findOne(Yii::$app->request->get('referer_category'));
        $view = new Views();
        $view->subject_type = 'Vacancy';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = time();
        $view->save();
        return $this->render('view', [
            'model' => $model,
            'last_vacancies' => $last_vacancies,
            'view' => $view,
            'referer_category' => $referer_category
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

    public function actionSearch()
    {
        $params = [
            'category_ids' => json_decode(\Yii::$app->request->get('category_ids')),
            'employment_type_ids' => json_decode(\Yii::$app->request->get('employment_type_ids')),
            'experience_ids' => json_decode(\Yii::$app->request->get('experience_ids')),
            'tags_id' => json_decode(\Yii::$app->request->get('tags_id')),
            'min_salary' => \Yii::$app->request->get('min_salary'),
            'max_salary' => \Yii::$app->request->get('max_salary'),
            'search_text' => \Yii::$app->request->get('search_text')
        ];
        $first_query_param = Yii::$app->request->get('first_query_param');
        $second_query_param = Yii::$app->request->get('second_query_param');
        $current_category = false;
        $current_city = false;
        if($second_query_param) {
            if($current_city = City::findOne(['slug'=>$first_query_param])) {
                $this->background_image = $current_city->image;
            }
            if($current_category = Category::findOne(['slug'=>$second_query_param])) {
                $this->background_emblem = $current_category->image;
                $params['category_ids']=[$current_category->id];
            }
        } else if ($first_query_param) {
            if($current_city = City::findOne(['slug'=>$first_query_param])) {
                $this->background_image = $current_city->image;
            } else if ($current_category = Category::findOne(['slug'=>$first_query_param])) {
                $this->background_emblem = $current_category->image;
                $params['category_ids']=[$current_category->id];
            }
        }
        if(!$current_city && Yii::$app->request->get('city_disable')!=1)
            $current_city = City::findOne(Yii::$app->request->cookies['city']);
        $tags = Skill::find()->all();
        $categories = Category::find()->all();
        $employment_types = EmploymentType::find()->all();
        $cities = City::find()->where(['status' => 1])->all();

        $vacancies_query = Vacancy::find()
            ->with(['category', 'company'])
            ->where(['status' => Vacancy::STATUS_ACTIVE])
            ->orderBy('update_time DESC')
            ->joinWith(['category', 'skill', 'employment_type'])
            ->andFilterWhere([
                'category.id' => $params['category_ids'],
                'skill.id' => $params['tags_id'],
                'employment_type.id' => $params['employment_type_ids'],

            ])
            ->andFilterWhere(['>=', 'max_salary', $params['min_salary']])
            ->andFilterWhere(['<=', 'min_salary', $params['max_salary']]);
        if($current_city)
            $vacancies_query->andFilterWhere(['like', 'city_id', $current_city->id]);
        if($params['search_text']){
            if($params['search_text'][0]===':')
            {
                switch (substr($params['search_text'], 1)){
                    case 'hot':
                        $vacancies_query->andWhere(['hot'=>1]);
                        break;
                }
            }
        }
        if ($params['experience_ids']) {
            if (!in_array(0, $params['experience_ids'])) {
                $or = ['or'];
                foreach ($params['experience_ids'] as $experience_id) {
                    $or[] = ['<=', 'work_experience', $experience_id];
                }
                $vacancies_query->andWhere($or);
            }
        }
        if ($params['search_text'] && $params['search_text'][0]!=':') {
            $vacancies_query->joinWith(['skill']);
            $vacancies_query->andWhere(['or',
                ['like', 'post', $params['search_text']],
                ['like', 'responsibilities', $params['search_text']],
                ['like', 'qualification_requirements', $params['search_text']],
                ['like', 'working_conditions', $params['search_text']],
                ['like', 'working_conditions', $params['search_text']],
                ['like', Skill::tableName().'.name', $params['search_text']]
            ]);
        }
        $get = $_GET;
        unset($get['first_query_param'], $get['second_query_param']);
        $vacancies = new ActiveDataProvider([
            'query' => $vacancies_query,
            'pagination' => [
                'defaultPageSize' => 10,
                'params' => $get,
                'route' => Yii::$app->request->getPathInfo()
            ]
        ]);
        return $this->render('search', [
            'cities' => $cities,
            'tags' => $tags,
            'min_salary' => $params['min_salary'],
            'max_salary' => $params['max_salary'],
            'category_ids' => $params['category_ids'],
            'employment_type_ids' => $params['employment_type_ids'],
            'experience_ids' => $params['experience_ids'],
            'search_text' => $params['search_text'],
            'city' => $current_city,
            'tags_id' => $params['tags_id'],
            'vacancies' => $vacancies,
            'categories' => $categories,
            'employment_types' => $employment_types,
            'current_category' => $current_category,
        ]);
    }
}
