<?php

use common\models\Company;
use kartik\dynagrid\DynaGrid;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\payment\models\FKPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платежи Free-Kassa';
$this->params['breadcrumbs'][] = $this->title;
$this->params['exclude_breadcrumbs'][] = true;
?>
<div class="fkpayment-index">
    <?php
    $columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        'amount',
        'operation_number',
        [
            'attribute' => 'company_id',
            'format' => 'html',
            'value' => function($model) {
                if ($model->company) {
                    return Html::a($model->company->name?:$model->company->contact_person, ['/company/company/view', 'id'=>$model->company->id]);
                }
                return null;
            },
            'filter'    => \kartik\select2\Select2::widget(
                [
                    'model' => $searchModel,
                    'attribute' => 'company_id',
                    'data' => \yii\helpers\ArrayHelper::map(Company::find()->asArray()->all(),'id', 'name'),
                    'options' => ['placeholder' => 'Выберите компанию ...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )
        ],
        'email:email',
        'phone',
        [
            'attribute' => 'currency_id',
            'value' => function($model) {
                return $model->currency?$model->currency->name:null;
            },
            'filter'    => \kartik\select2\Select2::widget(
                [
                    'model' => $searchModel,
                    'attribute' => 'currency_id',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\FKCurrency::find()->all(),'id', 'name'),
                    'options' => ['placeholder' => 'Выберите валюту ...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )
        ],
        'sign',
        [
            'class'=>'kartik\grid\ActionColumn',
            'dropdown'=>false,
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
            'template' => '{view}',
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
