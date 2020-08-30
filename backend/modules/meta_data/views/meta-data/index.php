<?php

use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\meta_data\models\MetaDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мета данные';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="meta-data-index">

    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        [
            'label' => 'Категория',
            'format' => 'html',
            'value' => function($model) {
                if($model->category)
                    return '<a href="/secure/category/category/view?id='.$model->category->id.'">'.$model->category->name.'</a>';
                return '';
            },
            'filter'    => Html::activeTextInput($searchModel, 'category_string'),
            'contentOptions' => ['style' => 'white-space: normal;'],
        ],
        [
            'label' => 'Профессия',
            'format' => 'html',
            'value' => function($model) {
                if($model->profession)
                    return '<a href="/secure/professions/professions/view?id='.$model->profession->id.'">'.$model->profession->title.'</a>';
                return '';
            },
            'filter'    => Html::activeTextInput($searchModel, 'profession_string'),
            'contentOptions' => ['style' => 'white-space: normal;'],
        ],
        [
            'attribute' => 'vacancy_meta_title',
            'contentOptions' => ['style' => 'white-space: normal;'],
        ],
        [
            'attribute' => 'vacancy_meta_description',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'vacancy_header',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'vacancy_meta_title_with_city',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'vacancy_meta_description_with_city',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'vacancy_header_with_city',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'vacancy_bottom_text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_meta_title',
            'contentOptions' => ['style' => 'white-space: normal;'],
        ],
        [
            'attribute' => 'resume_meta_description',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_header',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_meta_title_with_city',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_meta_description_with_city',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_header_with_city',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
        [
            'attribute' => 'resume_bottom_text',
            'contentOptions' => ['style' => 'white-space: normal;'],
            'visible' => false
        ],
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
                        'data-url' => '/secure/professions/professions/batch-delete'
                    ]) .
                    Html::a('<i class="fa fa-plus"></i>', ['/professions/professions/create'], ['title'=>'Добавить', 'class'=>'btn btn-success']) .
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
