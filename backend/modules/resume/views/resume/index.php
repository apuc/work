<?php

use common\models\Employer;
use common\models\EmploymentType;
use common\models\Resume;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\resume\models\ResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Резюме';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать резюме', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'employer_id',
                'format'    => 'text',
                'value' => function($model)
                {
                    return Employer::findOne($model->employer_id)->first_name;
                },
                'filter'    => \kartik\select2\Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'employer_id',
                        'data' => \yii\helpers\ArrayHelper::map(Employer::find()->asArray()->all(),'id', 'first_name'),
                        'options' => ['placeholder' => 'Select a state ...','class' => 'form-control'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
            ],
            'title',
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    return mb_substr($model->description, 0, 100) . '...';
                },
            ],
            [
                'label' => 'Виды занятости',
                'attribute' => 'employment_type',
                'format' => 'raw',
                'value' => function ($model) {
                    $multiple_res = '';
                    foreach($model->employment_type as $type){
                        $multiple_res .= ($multiple_res?', ':'').$type->name;
                    }
                    return $multiple_res;
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'employment_type_id',
                    \yii\helpers\ArrayHelper::map(EmploymentType::find()->asArray()->all(),'id', 'name'),
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
            [
                'label' => 'Умения',
                'attribute' => 'skill',
                'format' => 'raw',
                'value' => function ($model) {
                    $multiple_res = '';
                    foreach($model->skill as $skill){
                        $multiple_res .= ($multiple_res?', ':'').$skill->name;
                    }
                    return $multiple_res;
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'skill_id',
                    \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->asArray()->all(),'id', 'name'),
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],
            [
                'label' => 'Категории',
                'attribute' => 'category',
                'format' => 'raw',
                'value' => function ($model) {
                    $multiple_res = '';
                    foreach($model->category as $category){
                        $multiple_res .= ($multiple_res?', ':'').$category->name;
                    }
                    return $multiple_res;
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'category_id',
                    \yii\helpers\ArrayHelper::map(\common\models\Category::find()->asArray()->all(),'id', 'name'),
                    [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],


            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->status){
                        case Resume::STATUS_INACTIVE: return 'Не активно';
                    }
                    return 'Активно';
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'status', [
                    Resume::STATUS_ACTIVE => 'Активно',
                    Resume::STATUS_INACTIVE => 'Не активно',
                ], [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
