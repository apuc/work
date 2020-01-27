<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\category\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            [
                'attribute'=>'image',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->image, ['height'=>'150px']);
                }
            ],
            [
                'attribute' => 'slug',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            [
                'attribute' => 'meta_title',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            [
                'attribute' => 'meta_description',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->meta_description, 100, '...');
                },
            ],
            [
                'attribute' => 'header',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            [
                'attribute' => 'meta_title_with_city',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            [
                'attribute' => 'meta_description_with_city',
                'contentOptions' => ['style' => 'white-space: normal;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->meta_description_with_city, 100, '...');
                },
            ],
            [
                'attribute' => 'header_with_city',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            [
                'attribute' => 'bottom_text',
                'format' => 'text',
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
