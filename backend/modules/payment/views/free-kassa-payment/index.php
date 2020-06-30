<?php

use common\models\Company;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\payment\models\FKPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платежи Free-Kassa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fkpayment-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'amount',
            'operation_number',
            [
                'attribute' => 'company_id',
                'value' => function($model) {
                    return $model->company?$model->company->name:null;
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
