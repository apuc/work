<?php

namespace frontend\modules\resume\controllers;

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
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UrlManager;

/**
 * Default controller for the `resume` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public $background_image;
    public $background_emblem;

    public function actionView($id)
    {
        $model = Resume::findOne($id);
        $view = new Views();
        $view->subject_type = 'Resume';
        $view->subject_id = $model->id;
        $view->viewer_id = Yii::$app->user->id;
        $view->dt_view = strtotime(date("Y-m-d H:i:s"));
        $view->save();
        $model->views++;
        $model->save();
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionSendMessage(){
        $post = Yii::$app->request->post();
        /** @var Resume $resume */
        $resume = Resume::findOne($post['resume_resume_id']);
        $vacancy = Vacancy::findOne($post['resume_vacancy_id']);
        if($resume && $vacancy ){
            $message = new Message();
            $message->text = $post['resume_message'];
            $message->sender_id = Yii::$app->user->id;
            $message->subject = 'Resume';
            $message->subject_id = $resume->id;
            $message->receiver_id = $resume->owner;
            $message->subject_from = 'Vacancy';
            $message->subject_from_id = $post['resume_vacancy_id'];
            $message->save();
            Yii::$app->mailer->compose('resume_like', ['resume'=>$resume, 'vacancy'=>$vacancy, 'text'=>$message->text])
                ->setFrom('noreply@rabota.today')
                ->setTo(User::findOne($resume->owner)->email)
                ->setSubject('Ответ на ваше резюме '. $resume->title.'.')
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
            'min_salary' => Yii::$app->request->get('min_salary'),
            'max_salary' => Yii::$app->request->get('max_salary'),
            'search_text' => Yii::$app->request->get('search_text')
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

        $resume_query = Resume::find()
            ->with(['employer', 'employment_type'])
            ->joinWith(['category', 'skills', 'employment_type'])
            ->where([Resume::tableName().'.status' => Resume::STATUS_ACTIVE])
            ->groupBy('id')
            ->orderBy('id DESC')
            ->andFilterWhere([
                'category.id' => $params['category_ids'],
                'skill.id' => $params['tags_id'],
                'employment_type.id' => $params['employment_type_ids']
            ]);
        $resume_query->andFilterWhere(['>=', 'max_salary', $params['min_salary']]);
        $resume_query->andFilterWhere(['<=', 'min_salary', $params['max_salary']]);
        if($current_city)
            $resume_query->andFilterWhere(['like', 'city', $current_city->name]);
        if($params['search_text']){
            if($params['search_text'][0]===':')
            {
                switch (substr($params['search_text'], 1)){
                    case 'hot':
                        $resume_query->andWhere(['hot'=>1]);
                        break;
                }
            }
        }
        if($params['experience_ids']) {
            if(!in_array(0,$params['experience_ids'])) {
                $tmp_exp_ids = [];
                foreach ($params['experience_ids'] as $value){
                    $tmp_exp_ids[] = $value-1;
                }
                $or = ['or'];
                foreach ($tmp_exp_ids as $experience_id){
                    $or[] = ['>=', 'years_of_exp', $experience_id];
                }
                $resume_query->andWhere($or);
            }
        }
        if($params['search_text'] && $params['search_text'][0]!=':'){
            $resume_query->joinWith(['skills', 'experience', 'education']);
            $resume_query->andWhere(['or',
                ['like', 'title', $params['search_text']],
                ['like', 'city', $params['search_text']],
                ['like', 'description', $params['search_text']],
                ['like', Skill::tableName().'.name', $params['search_text']],
                ['like', 'experience.name', $params['search_text']],
                ['like', 'experience.post', $params['search_text']],
                ['like', 'experience.responsibility', $params['search_text']],
                ['like', 'education.name', $params['search_text']],
                ['like', 'education.faculty', $params['search_text']],
                ['like', 'education.academic_degree', $params['search_text']],
                ['like', 'education.specialization', $params['search_text']],
            ]);
        }
        $get = $_GET;
        unset($get['first_query_param'], $get['second_query_param']);
        $resumes = new ActiveDataProvider([
            'query' => $resume_query,
            'pagination' => [
                'defaultPageSize' => 10,
                'params' => $get,
                'route' => Yii::$app->request->getPathInfo()
            ]
        ]);

        return $this->render('search', [
            'tags' => $tags,
            'cities' => $cities,
            'resumes' => $resumes,
            'categories' => $categories,
            'employment_types' => $employment_types,
            'min_salary' => $params['min_salary'],
            'max_salary' => $params['max_salary'],
            'category_ids' => $params['category_ids'],
            'employment_type_ids' => $params['employment_type_ids'],
            'experience_ids' => $params['experience_ids'],
            'search_text' => $params['search_text'],
            'city' => $current_city,
            'tags_id' => $params['tags_id'],
            'current_category' => $current_category,
        ]);
    }
}
