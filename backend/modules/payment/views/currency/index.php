<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\payment\models\FKCurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Валюты Free-Kassa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fkcurrency-index">
    <p>
        <?= Html::a('Создать валюту Free-Kassa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '5%'],
            ],
            'name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
