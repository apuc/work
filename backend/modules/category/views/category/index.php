<?php

use kartik\dynagrid\DynaGrid;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\category\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="category-index">

    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        [
            'attribute' => 'name',
            'format' => 'text',
            'contentOptions' => ['style' => 'white-space: normal;']
        ],
        [
            'attribute' => 'slug',
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
            'attribute'=>'icon',
            'format'=>'html',
            'value' => function($model){
                return Html::img($model->icon, ['height'=>'150px']);
            }
        ],
        [
            'class'=>'kartik\grid\ActionColumn',
            'dropdown'=>false,
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
            'template' => '{view} {update}',
        ],
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
                    Html::a('<i class="fa fa-plus"></i>', ['/category/category/create'], ['title'=>'Добавить', 'class'=>'btn btn-success']) .
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
