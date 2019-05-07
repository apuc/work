<?php

namespace frontend\modules\resume\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\EmploymentType;
use common\models\Message;
use common\models\Resume;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `resume` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Resume::find()->where(['id'=>$id])->one();
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionSendMessage(){
        $post = \Yii::$app->request->post();
        if($resume = Resume::findOne($post['resume_id'])){
            $message = new Message();
            $message->text = $post['message'];
            $message->sender_id = \Yii::$app->user->id;
            $message->subject = 'Resume';
            $message->subject_id = $resume->id;
            $message->receiver_id = $resume->employer->user_id;
            $message->save();
        }
        return $this->goBack();

    }

    public function actionSearch()
    {
        $params = [
            'category_ids' => json_decode(\Yii::$app->request->get('category_ids')),
            'employment_type_ids' => json_decode(\Yii::$app->request->get('employment_type_ids')),
            'experience_ids' => json_decode(\Yii::$app->request->get('experience_ids')),
            'min_salary' => \Yii::$app->request->get('min_salary'),
            'max_salary' => \Yii::$app->request->get('max_salary'),
            'search_text' => \Yii::$app->request->get('search_text'),
            'city' => \Yii::$app->request->get('city'),
        ];
        $categories = Category::find()->all();
        $employment_types = EmploymentType::find()->all();
        $cities = City::find()->all();

        $resume_query = Resume::find();
        if($params['experience_ids']){
            if(!in_array(0,$params['experience_ids'])){
                $array = [];
                foreach ($params['experience_ids'] as $experience_id){
                    $array[] = $experience_id-1;
                }
                if(in_array(3,$params['experience_ids'])) {
                    $resume_query->andWhere(['years_of_exp' => $array]);
                } else {
                    $resume_query->andWhere(['years_of_exp' => $array]);
                }
            }
        }
        if($params['category_ids']) {
            $resume_query->joinWith(['category']);
            $resume_query->andWhere(['category.id' => $params['category_ids']]);
        }
        if($params['employment_type_ids']) {
            $resume_query->joinWith(['employment_type']);
            $resume_query->andWhere(['employment_type.id' => $params['employment_type_ids']]);
        }
        if($params['min_salary']){
            $resume_query->andWhere(['>=', 'max_salary', $params['min_salary']]);
        }
        if($params['max_salary']){
            $resume_query->andWhere(['<=', 'min_salary', $params['max_salary']]);
        }
        if($params['search_text']){
            $resume_query->andWhere(['like', 'title', $params['search_text']]);
        }
        if($params['city']){
            $resume_query->andWhere(['like', 'city', $params['city']]);
        }

        $resumes = new ActiveDataProvider([
            'query' => $resume_query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('search', [
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
            'city' => $params['city'],
        ]);
    }
}
