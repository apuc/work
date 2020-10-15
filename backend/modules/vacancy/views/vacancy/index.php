<?php

use common\models\Category;
use common\models\City;
use common\models\Company;
use common\models\Employer;
use common\models\EmploymentType;
use common\models\Vacancy;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\vacancy\models\VacancySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="vacancy-index">
    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        [
            'attribute' => 'company_id',
            'format'    => 'html',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'value' => function($model)
            {
                $company=Company::findOne($model->company_id);
                if($company->name)
                    return '<a href="'.\yii\helpers\Url::to(['/company/company/view', 'id' => $company->id]).'">'.$company->name.'</a>';
                else
                    return '<a href="'.\yii\helpers\Url::to(['/company/company/view', 'id' => $company->id]).'">'.$company->contact_person.'</a>';
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
        [
            'attribute' => 'post',
            'contentOptions' => ['style' => 'white-space: normal;'],
        ],
        [
            'attribute' => 'responsibilities',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'format' => 'raw',
            'value' => function ($model) {
                return \yii\helpers\StringHelper::truncate($model->responsibilities, 100, '...');
            },
            'visible' => false
        ],
        [
            'attribute' => 'employment_type.name',
            'format' => 'raw',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'filter'    => Html::activeDropDownList( $searchModel, 'employment_type_id',
                \yii\helpers\ArrayHelper::map(EmploymentType::find()->asArray()->all(),'id', 'name'),
                [ 'class' => 'form-control', 'prompt' => '' ] ),
            'visible' => false
        ],
        [
            'attribute' => 'min_salary',
            'visible' => false
        ],
        [
            'attribute' => 'max_salary',
            'visible' => false
        ],
        [
            'attribute' => 'qualification_requirements',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'city0.name',
            'label' => 'Город',
            'filter'    => Html::activeDropDownList( $searchModel, 'city_id',
                \yii\helpers\ArrayHelper::map(City::find()->where(['status'=>1])->all(),'id', 'name'),
                [ 'class' => 'form-control', 'prompt' => '' ] ),
        ],
        [
            'attribute' => 'work_experience',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'description',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'education',
            'visible' => false
        ],
        [
            'label' => 'Категории',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'value' => function($model) {
                $result=$model->mainCategory?$model->mainCategory->name:'';
                foreach ($model->category as $category)
                    $result.=", $category->name";
                return $result;
            },
            'filter'    => Select2::widget(
                [
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => ArrayHelper::map(Category::find()->asArray()->all(),'id', 'name'),
                    'options' => ['placeholder' => 'Select a state ...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            ),
        ],
        [
            'attribute' => 'working_conditions',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
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
        [
            'attribute' => 'publisher_id',
            'format' => 'html',
            'value' => function ($model) {
                if($model->publisher)
                    return '<a href="'.\yii\helpers\Url::to(['/employer/employer/view', 'id'=>$model->publisher->employer->id]).'">'.$model->publisher->employer->first_name.'</a>';
                return null;
            },
            'filter'    => Select2::widget(
                [
                    'model' => $searchModel,
                    'attribute' => 'publisher_id',
                    'data' => \yii\helpers\ArrayHelper::map(Employer::find()->asArray()->all(),'user_id', 'first_name'),
                    'options' => ['placeholder' => 'Select a state ...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            ),
            'visible' => false
        ],
        [
            'class'=>'kartik\grid\ActionColumn',
            'dropdown'=>false,
            'order'=>DynaGrid::ORDER_FIX_RIGHT
        ],
        ['class'=>'kartik\grid\CheckboxColumn', 'order'=>DynaGrid::ORDER_FIX_RIGHT],
    ];

    echo DynaGrid::widget([
        'columns'=>$columns,
        'storage'=>DynaGrid::TYPE_SESSION,
        'theme'=>'panel-info',
        'showPersonalize'=>true,
        'gridOptions'=>[
            'dataProvider'=>$dataProvider,
            'filterModel'=>$searchModel,
            'floatHeader'=>true,
            'pjax'=>true,
            'responsiveWrap'=>false,
            'floatHeaderOptions' => [
                'scrollingTop' => '0',
            ],
            'panel'=> [
                'heading'=>Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                        'class' => 'breadcrumb',
                        'style' => 'float:none; position:initial'
                    ]
                ])
            ],
            'toolbar' =>  [
                ['content'=>
                    Html::button('Удалить выбранные <i class="fa fa-trash"></i>', [
                        'type' => 'button',
                        'title' => 'Удалить все',
                        'class' => 'btn btn-danger',
                        'id' => 'grid-delete-button',
                        'disabled' => true,
                        'data-url' => '/secure/vacancy/vacancy/batch-delete'
                    ]) .
                    Html::a('<i class="fa fa-plus"></i>', ['/vacancy/vacancy/create'], ['title'=>'Добавить', 'class'=>'btn btn-success']) .
                    Html::a('<i class="fa fa-repeat"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Сбросить фильтры'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{export}',
            ]
        ],
        'options'=>['id'=>'dynagrid-professions']
    ]);
    ?>
</div>
