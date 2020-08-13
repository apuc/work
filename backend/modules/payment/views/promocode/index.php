<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Промокоды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocode-index">
    <p>
        <?= Html::a('Создать промокод', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать несколько промокодов', ['create-multiple'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            ['attribute' => 'active_until', 'format' => ['date', 'php:d-m-Y']],
            ['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y']],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
