<?php

use common\models\Education;
use common\models\Resume;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\education\models\EducationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Образование';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать образование', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'resume_id',
                'format'    => 'text',
                'value' => function($model)
                {
                    return Resume::findOne($model->resume_id)->title;
                },
                'filter'    => \kartik\select2\Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'resume_id',
                        'data' => \yii\helpers\ArrayHelper::map(Resume::find()->asArray()->all(),'id', 'title'),
                        'options' => ['placeholder' => 'Select a state ...','class' => 'form-control'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
            ],
            'name',
            'faculty',
            'year_from',
            'year_to',
            'academic_degree',
            'specialization',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->status){
                        case Education::STATUS_INACTIVE: return 'Не активен';
                    }
                    return 'Активен';
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'status', [
                    Education::STATUS_ACTIVE => 'Активен',
                    Education::STATUS_INACTIVE => 'Не активен',
                ], [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
