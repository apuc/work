<?php

use common\models\SpecFilters;
use common\models\Vacancy;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\spec_filters\models\SpecFiltersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Специальные фильтры';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="spec_filters-index">
    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        'name',
        'slug',
        [
            'attribute' => 'field_name',
            'value' => function($model) {
                return (new Vacancy())->attributeLabels()[$model->field_name];
            },
            'filter'    => Html::activeDropDownList( $searchModel, 'field_name',
                (new Vacancy())->attributeLabels(),
                [ 'class' => 'form-control', 'prompt' => '' ] ),
        ],
        [
            'attribute'=>'sign',
            'filter'    => Html::activeDropDownList( $searchModel, 'sign',
                SpecFilters::$signs,
                [ 'class' => 'form-control', 'prompt' => '' ] ),
        ],
        'value',
        [
            'attribute'=>'dynamic',
            'value'=>function($model){
                return $model->dynamic==1?"Да":"Нет";
            },
            'filter'    => Html::activeDropDownList( $searchModel, 'dynamic',
                ['Нет', 'Да'],
                [ 'class' => 'form-control', 'prompt' => '' ] ),
        ],
        [
            'attribute'=>'status',
            'value'=>function($model){
                return $model->status==1?"Включен":"Отключен";
            },
            'filter'    => Html::activeDropDownList( $searchModel, 'status',
                ['Отключен', 'Включен'],
                [ 'class' => 'form-control', 'prompt' => '' ] ),
        ],
        [
            'attribute'=>'icon',
            'format'=>'html',
            'value' => function($model){
                return Html::img($model->icon, ['height'=>'75px']);
            }
        ],
        'color',
        [
            'class'=>'kartik\grid\ActionColumn',
            'dropdown'=>false,
            'order'=>DynaGrid::ORDER_FIX_RIGHT
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
                    Html::button('Удалить выбранные <i class="fa fa-trash"></i>', [
                        'type' => 'button',
                        'title' => 'Удалить все',
                        'class' => 'btn btn-danger',
                        'id' => 'grid-delete-button',
                        'disabled' => true,
                        'data-url' => '/secure/spec-filters/spec-filters/batch-delete'
                    ]) .
                    Html::a('<i class="fa fa-plus"></i>', ['/spec-filters/spec-filters/create'], ['title'=>'Добавить', 'class'=>'btn btn-success']) .
                    Html::a('<i class="fa fa-repeat"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Сбросить фильтры'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{export}',
            ]
        ],
        'options'=>['id'=>'dynagrid-1']
    ]);
    ?>
</div>
