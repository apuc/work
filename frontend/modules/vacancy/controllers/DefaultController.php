<?php

namespace frontend\modules\vacancy\controllers;

use common\classes\Debug;
use common\models\Category;
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
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionSearch()
    {
        $per_page = 20;

        $params = [
            'category_ids' => json_decode(\Yii::$app->request->get('category_ids')),
            'employment_type_ids' => json_decode(\Yii::$app->request->get('employment_type_ids')),
            'experience_ids' => json_decode(\Yii::$app->request->get('experience_ids')),
            'min_salary' => \Yii::$app->request->get('min_salary'),
            'max_salary' => \Yii::$app->request->get('max_salary'),
            'text' => \Yii::$app->request->get('text'),
            'page' => \Yii::$app->request->get('page'),
        ];
        $categories = Category::find()->all();
        $employment_types = EmploymentType::find()->all();

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
        if($params['text']){
            $vacancies_query->andWhere(['like', 'post', $params['text']]);
        }
        $vacancies_query->orderBy('created_at DESC');
        $vacancies = new ActiveDataProvider([
            'query' => $vacancies_query,
            'pagination' => [
                'pageSize' => 2
            ]
        ]);
        //$vacancies_query->all();
        return $this->render('search', [
            'min_salary' => $params['min_salary'],
            'max_salary' => $params['max_salary'],
            'category_ids' => $params['category_ids'],
            'employment_type_ids' => $params['employment_type_ids'],
            'experience_ids' => $params['experience_ids'],
            'search_text' => $params['text'],
            'vacancies' => $vacancies,
            'categories' => $categories,
            'employment_types' => $employment_types,
        ]);
    }
}
