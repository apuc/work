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
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $last_vacancies=Vacancy::find()->where(['status'=>Vacancy::STATUS_ACTIVE])->orderBy('id DESC')->limit(2)->all();
        $model = Vacancy::findOne($id);
        $model->views++;
        $model->save();
        return $this->render('view', [
            'model' => $model,
            'last_vacancies' => $last_vacancies
        ]);
    }

    public function actionSendMessage(){
        $post = Yii::$app->request->post();
        $resume = Resume::findOne($post['vacancy_resume_id']);
        $vacancy = Vacancy::findOne($post['vacancy_vacancy_id']);
        if($resume && $vacancy ){
            $message = new Message();
            $message->text = $post['vacancy_message'];
            $message->sender_id = Yii::$app->user->id;
            $message->subject = 'Vacancy';
            $message->subject_id = $vacancy->id;
            $message->receiver_id = $vacancy->owner;
            $message->subject_from = 'Resume';
            $message->subject_from_id = $post['vacancy_resume_id'];
            $message->save();
            Yii::$app->mailer->compose('vacancy_like', ['resume'=>$resume, 'vacancy'=>$vacancy, 'text'=>$message->text])
                ->setFrom('noreply@rabota.today')
                ->setTo(User::findOne($vacancy->owner)->email)
                ->setSubject('Ответ на вашу вакансию '. $vacancy->post.'.')
                ->send();
        }
        $url = explode('?', Yii::$app->request->referrer)[0];
        $url.='?message=Ваше сообщение успешно отправлено';
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
            'search_text' => \Yii::$app->request->get('search_text'),
            'city' => \Yii::$app->request->get('city'),
        ];
        $categories = Category::find()->all();
        $employment_types = EmploymentType::find()->all();
        $cities = City::find()->where(['status' => 1])->all();
        $tags = Skill::find()->all();

        $vacancies_query = Vacancy::find()->with(['category', 'company'])->where(['status'=>Vacancy::STATUS_ACTIVE])->orderBy('id DESC');
        if($params['experience_ids']) {
            if(!in_array(0,$params['experience_ids'])) {
                $or = ['or'];
                foreach ($params['experience_ids'] as $experience_id){
                    $or[] = ['<=', 'work_experience', $experience_id];
                }
                $vacancies_query->andWhere($or);
            }
        }
        if($params['category_ids']) {
            $vacancies_query->joinWith(['category']);
            $vacancies_query->andWhere(['category.id' => $params['category_ids']]);
        }
        if($params['tags_id']) {
            $vacancies_query->joinWith(['skill']);
            $vacancies_query->andWhere(['skill.id' => $params['tags_id']]);
        }
        if($params['employment_type_ids']) {
            $vacancies_query->joinWith(['employment_type']);
            $vacancies_query->andWhere(['employment_type.id' => $params['employment_type_ids']]);
        }

        if($params['min_salary']){
            $vacancies_query->andWhere(['>=', 'max_salary', $params['min_salary']]);
        }
        if($params['max_salary']){
            $vacancies_query->andWhere(['<=', 'min_salary', $params['max_salary']]);
        }
        if($params['search_text']){
            $vacancies_query->andWhere(['like', 'post', $params['search_text']]);
        }
        if($params['city']){
            $vacancies_query->andWhere(['like', 'city', $params['city']]);
        }
        $vacancies_query->orderBy('created_at DESC');
        $vacancies = new ActiveDataProvider([
            'query' => $vacancies_query,
            'pagination' => [
                'pageSize' => 10
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
            'city' => $params['city'],
            'tags_id' => $params['tags_id'],
            'vacancies' => $vacancies,
            'categories' => $categories,
            'employment_types' => $employment_types,
        ]);
    }
}
