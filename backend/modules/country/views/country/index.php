<?php

use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\country\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страны';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="country-index">
    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        'name',
        'slug',
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
            'attribute' => 'search_page_title',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'search_page_header',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'search_page_description',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'news_meta_title',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'news_meta_description',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'news_meta_header',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'news_about',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'main_page_text',
            'format' => 'html',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'main_page_mobile_text',
            'format' => 'html',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'main_page_background_image',
            'format' => ['image',['width'=>'150']]
        ],
        [
            'attribute' => 'main_page_emblem',
            'format' => ['image',['width'=>'150']]
        ],
        [
            'class'=>'kartik\grid\ActionColumn',
            'dropdown'=>false,
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
            'template' => '{view} {update}',
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
                    Html::a('<i class="fa fa-plus"></i>', ['/country/country/create'], ['title'=>'Добавить', 'class'=>'btn btn-success']) .
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
