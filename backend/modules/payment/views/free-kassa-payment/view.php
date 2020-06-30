<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FKPayment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Платежи Free-Kassa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fkpayment-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить информацию об оплате?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'amount',
            'operation_number',
            [
                'attribute' => 'company_id',
                'value' => function($model) {
                    return $model->company?$model->company->name:null;
                },
            ],
            'email:email',
            'phone',
            [
                'attribute'=>'currency.name',
                'label'=>$model->attributeLabels()['currency_id']
            ],
            'sign',
        ],
    ]) ?>

</div>
