<?php

use kartik\date\DatePicker;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="news-index">
    <?php
    $columns = [
        ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],
        [
            'attribute' => 'title',
            'contentOptions' => ['style' => 'white-space: normal;'],
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
        [
            'attribute' => 'description',
            'contentOptions' => ['style' => 'white-space: normal; max-width: 300px;'],
        ],
        [
            'attribute' => 'content',
            'format' => 'html',
            'contentOptions' => ['style' => 'white-space: normal; max-width: 300px;'],
            'visible' => false
        ],
        [
            'attribute' => 'country_id',
            'value' => function ($model) {
                if ($model->country) {
                    return $model->country->name;
                }
                return '';
            },
            'filter' => false
        ],
        [
            'attribute' => 'meta_title',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'meta_description',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'meta_header',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'slug',
            'contentOptions' => ['style' => 'white-space: normal; max-width: 300px;'],
        ],
        [
            'attribute' => 'status',
            'contentOptions' => ['style' => 'width: 119px;'],
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

        [
            'attribute' => 'views'
        ],

        [
            'attribute' => 'Комментариев',
            'value' => function ($model) {
                if ($model->getCountComments()) {
                    return $model->getCountComments();
                }
                return 0;
            },
        ],

        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'order' => DynaGrid::ORDER_FIX_RIGHT
        ],
        ['class' => 'kartik\grid\CheckboxColumn', 'order' => DynaGrid::ORDER_FIX_RIGHT],
    ];

    echo DynaGrid::widget([
        'columns' => $columns,
        'storage' => DynaGrid::TYPE_SESSION,
        'theme' => 'panel-info',
        'showPersonalize' => true,
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'floatHeader' => true,
            'pjax' => true,
            'responsiveWrap' => false,
            'floatHeaderOptions' => [
                'scrollingTop' => '0',
            ],
            'panel' => [
                'heading' => Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                        'class' => 'breadcrumb',
                        'style' => 'float:none; position:initial'
                    ]
                ])
            ],
            'toolbar' => [
                ['content' =>
                    Html::button('Удалить выбранные <i class="fa fa-trash"></i>', [
                        'type' => 'button',
                        'title' => 'Удалить все',
                        'class' => 'btn btn-danger',
                        'id' => 'grid-delete-button',
                        'disabled' => true,
                        'data-url' => '/secure/news/news/batch-delete'
                    ]) .
                    Html::a('<i class="fa fa-plus"></i>', ['/news/news/create'], ['title' => 'Добавить', 'class' => 'btn btn-success']) .
                    Html::a('<i class="fa fa-repeat"></i>', [''], ['data-pjax' => 0, 'class' => 'btn btn-outline-secondary', 'title' => 'Сбросить фильтры'])
                ],
                ['content' => '{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{export}',
            ]
        ],
        'options' => ['id' => 'dynagrid-news']
    ]);
    ?>
</div>
