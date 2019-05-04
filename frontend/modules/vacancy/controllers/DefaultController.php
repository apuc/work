<?php

namespace frontend\modules\vacancy\controllers;

use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\EmploymentType;
use common\models\Resume;
use common\models\Vacancy;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/main-layout.php';

    public function actionView($id)
    {
        $model = Vacancy::findOne($id);
        $model->views++;
        $model->save();
        return $this->render('view', [
            'model' => $model
        ]);
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

        $vacancies_query = Vacancy::find();
        if($params['experience_ids']) {
            $vacancies_query->andWhere(['work_experience' => $params['experience_ids']]);
        }
        if($params['category_ids']) {
            $vacancies_query->joinWith(['category']);
            $vacancies_query->andWhere(['category.id' => $params['category_ids']]);
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
                'pageSize' => 2
            ]
        ]);
        return $this->render('search', [
            'cities' => $cities,
            'min_salary' => $params['min_salary'],
            'max_salary' => $params['max_salary'],
            'category_ids' => $params['category_ids'],
            'employment_type_ids' => $params['employment_type_ids'],
            'experience_ids' => $params['experience_ids'],
            'search_text' => $params['search_text'],
            'city' => $params['city'],
            'vacancies' => $vacancies,
            'categories' => $categories,
            'employment_types' => $employment_types,
        ]);
    }
}
