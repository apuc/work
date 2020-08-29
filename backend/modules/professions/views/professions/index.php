<?php

use kartik\dynagrid\DynaGrid;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\professions\models\ProfessionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Профессии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professions-index">

    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        'title',
        'slug',
        'genitive',
        [
            'header' => 'Статус',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{change}',
            'buttons' => [
                'change' => function ($url,$model) {
                if ($model->status == 1){
                    return Html::a('Скрыть', $url, ['class' => 'ajax-status', 'data-id' => $model->id, 'data-status' => '0']);
                }else{
                    return Html::a('Показать', $url, ['class' => 'ajax-status', 'data-id' => $model->id, 'data-status' => '1']);
                }
                },
            ],
        ],
        'instrumental',
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
            'showPageSummary'=>true,
            'floatHeader'=>true,
            'pjax'=>true,
            'responsiveWrap'=>false,
            'floatHeaderOptions' => [
                'scrollingTop' => '0',
            ],
            'panel'=> [
                'heading'=>'<h3 class="panel-title">Профессии</h3>'
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
                    Html::button('<i class="fa fa-plus"></i>', ['type'=>'button', 'title'=>'Добавить', 'class'=>'btn btn-success']) .
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
