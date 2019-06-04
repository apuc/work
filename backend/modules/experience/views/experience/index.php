<?php

use common\models\Experience;
use common\models\Resume;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\experience\models\ExperienceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опыт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experience-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать опыт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'resume_id',
                'format'    => 'html',
                'value' => function($model)
                {
                    $resume = Resume::findOne($model->resume_id);
                    return '<a href="'.\yii\helpers\Url::to(['/resume/resume/view', 'id' => $resume->id]).'">'.$resume->title.'</a>';
                },
                'filter'    => Select2::widget(
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
            'post',
            [
                'attribute' => 'responsibility',
                'contentOptions' => ['style' => 'width:400px; white-space: normal;'],
                'value' => function ($model) {
                    return nl2br(\yii\helpers\StringHelper::truncate($model->responsibility, 100, '...'));
                },
            ],
            [
                'attribute' => 'month_from',
                'value' => function ($model) {
                    /** @var Experience $model */
                    if($model->month_from>0&&$model->month_from<13)
                        return Experience::$months[$model->month_from];
                    return null;
                }
            ],
            'year_from',
            [
                'attribute' => 'month_to',
                'value' => function ($model) {
                    /** @var Experience $model */
                    if($model->month_to>0&&$model->month_to<13)
                        return Experience::$months[$model->month_to];
                    return null;
                }
            ],
            'year_to',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->status){
                        case Experience::STATUS_INACTIVE: return 'Не активен';
                    }
                    return 'Активен';
                },
                'filter'    => Html::activeDropDownList( $searchModel, 'status', [
                    Experience::STATUS_ACTIVE => 'Активен',
                    Experience::STATUS_INACTIVE => 'Не активен',
                ], [ 'class' => 'form-control', 'prompt' => '' ] ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
