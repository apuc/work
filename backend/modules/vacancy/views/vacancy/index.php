<?php

use common\models\Company;
use common\models\EmploymentType;
use common\models\Vacancy;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\vacancy\models\VacancySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать вакансию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'company_id',
                'format'    => 'html',
                'value' => function($model)
                {
                    $company=Company::findOne($model->company_id);
                    return '<a href="'.\yii\helpers\Url::to(['/company/company/view', 'id' => $company->id]).'">'.$company->name.'</a>';
                },
                'filter'    => \kartik\select2\Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'company_id',
                        'data' => \yii\helpers\ArrayHelper::map(Company::find()->asArray()->all(),'id', 'title'),
                        'options' => ['placeholder' => 'Select a state ...','class' => 'form-control'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
            ],
            'post',
            [
                'attribute' => 'responsibilities',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->responsibilities, 100, '...');
                },
            ],
            [
                'attribute' => 'employment_type_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return EmploymentType::findOne($model->employment_type_id)->name;
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'employment_type_id',
                    \yii\helpers\ArrayHelper::map(EmploymentType::find()->asArray()->all(),'id', 'name'),
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
            'views',
            'min_salary',
            'max_salary',
            [
                'attribute' => 'qualification_requirements',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            'work_experience',
            'education',
            [
                'attribute' => 'working_conditions',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            'video',
            'address',
            'home_number',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->status){
                        case Vacancy::STATUS_INACTIVE: return 'Не активна';
                    }
                    return 'Активна';
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'status', [
                    Vacancy::STATUS_ACTIVE => 'Активна',
                    Vacancy::STATUS_INACTIVE => 'Не активна',
                ], [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
