<?php

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;

use common\models\City;
use yii\grid\GridView;
use yii\helpers\Html; ?>
<div class="cities-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить город', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'name',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\City::find()->asArray()->all(), 'name',
                        'name'),
                    'options' => ['placeholder' => 'Выберите город...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute'=>'image',
                'format'=>'html',
                'value' => function($model){
                    return Html::img($model->image, ['height'=>'150px']);
                }
            ],
            [
                'attribute' => 'region_id',
                'value' => function ($model) {
                    return $model->region->name;
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'region_id',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Region::find()->asArray()->all(), 'id',
                        'name'),
                    'options' => ['placeholder' => 'Выберите регион...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\City::getStatusName($model->status);
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => City::getStatusList(),
                    'options' => ['placeholder' => 'Выберите статус...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            'latitude',
            'longitude',
            'slug',
            'meta_title',
            'meta_description',
            'header',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
