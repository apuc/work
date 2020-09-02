<?php

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;

use common\models\City;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cities\models\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="cities-index">
    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        'name',
        [
            'attribute' => 'prepositional',
            'visible' => false
        ],
        [
            'attribute'=>'image',
            'format'=>'html',
            'value' => function($model){
                return Html::img($model->image, ['height'=>'150px']);
            },
            'visible' => false
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
        'slug',
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return \common\models\City::getStatusName($model->status);
            },
            'filter'    => Html::activeDropDownList( $searchModel, 'status',
                City::getStatusList(),
                [ 'class' => 'form-control', 'prompt' => '' ] ),
        ],
        [
            'attribute' => 'meta_title',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'meta_description',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'header',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'bottom_text',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_meta_title',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_meta_description',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_header',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_bottom_text',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'class'=>'kartik\grid\ActionColumn',
            'dropdown'=>false,
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
            'deleteOptions' => [
                'title' => 'Скрыть'
            ]
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
                    Html::button('Скрыть выбранные <i class="fa fa-trash"></i>', [
                        'type' => 'button',
                        'title' => 'Скрыть выбранные',
                        'class' => 'btn btn-danger',
                        'id' => 'grid-delete-button',
                        'disabled' => true,
                        'data-url' => '/secure/cities/cities/batch-delete'
                    ]) .
                    Html::button('Восстановить выбранные', [
                        'type' => 'button',
                        'title' => 'Восстановить выбранные',
                        'class' => 'btn btn-info',
                        'id' => 'grid-restore-button',
                        'disabled' => true,
                        'data-url' => '/secure/cities/cities/batch-restore'
                    ]) .
                    Html::a('<i class="fa fa-plus"></i>', ['/cities/cities/create'], ['title'=>'Добавить', 'class'=>'btn btn-success']) .
                    Html::a('<i class="fa fa-repeat"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Сбросить фильтры'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{export}',
            ]
        ],
        'options'=>['id'=>'dynagrid-cities']
    ]);
    ?>
</div>
