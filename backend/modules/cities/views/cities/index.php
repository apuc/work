<?php

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;

use yii\grid\GridView;
use yii\helpers\Html; ?>
<div class="cities-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить город', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'region_id',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\City::getStatusName($model->status);
                }
            ],
            'latitude',
            'longitude',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
