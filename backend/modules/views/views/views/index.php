<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\views\models\ViewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Просмотры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="views-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'subject_type',
//                'value' => function ($model) {
//                    return \common\models\Views::getCompany($model->company_id)->name;
//                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'subject_type',
                    'data' => \common\models\Views::getSubjectType(),
                    'options' => ['placeholder' => 'Выберите тип...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'subject_id',
                'value' => function ($model) {
                    return \common\models\Views::getSubject($model->subject_type, $model->subject_id);
                },
            ],
            [
                'attribute' => 'viewer_id',
                'value' => function ($model) {
                    return \common\models\Views::getViewer($model->viewer_id)['username'];
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'viewer_id',
                    'data' => \common\models\Views::getAllUsers(),
                    'options' => ['placeholder' => 'Выберите просмотревшего...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'dt_view',
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dt_view',
                    'type' => DatePicker::TYPE_INPUT,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите дату'],
                ]),
            ],


            //'options:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
