<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'title',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\News::find()->asArray()->all(), 'title',
                        'title'),
                    'options' => ['placeholder' => 'Выберите новость...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            'description:ntext',
//            [
//                'attribute' => 'content',
//            ],
            /*'country_id',*/
            [
                'attribute' => 'country_id',
                'value' => function ($model) {
                    return $model->country->name;
                },
                'filter' => false,
            ],
            'meta_title',
            'meta_description',
            'meta_header',
            'slug',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\News::getStatusName($model->status);
                },
                'filter' => \common\models\News::getStatusList(),
            ],
            [
                'attribute' => 'dt_create',
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dt_create',
                    'type' => DatePicker::TYPE_INPUT,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите дату'],
                ]),
            ],
            [
                'attribute' => 'dt_public',
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dt_public',
                    'type' => DatePicker::TYPE_INPUT,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите дату'],
                ]),
            ],
            //'dt_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
